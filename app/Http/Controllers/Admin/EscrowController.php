<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Escrow;
use App\Models\GeneralSetting;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class EscrowController extends Controller
{
    public function index()
    {
        $segments       = request()->segments();
        $escrows        = $this->filterEscrows(end($segments));
        $pageTitle      = $this->pageTitle;
        $emptyMessage   = $this->emptyMessage;

        return view('admin.escrow.index', compact('pageTitle', 'escrows', 'emptyMessage'));
    }

    public function details($id)
    {
        $pageTitle    = 'Escrow Details';
        $escrow       = Escrow::with('conversation','conversation.messages','conversation.messages.sender','conversation.messages.admin')->findOrFail($id);
        $restAmount   = ($escrow->amount + $escrow->charge) - $escrow->paid_amount;
        $conversation = $escrow->conversation;
        $messages     = $conversation->messages;

        return view('admin.escrow.details',compact('pageTitle','escrow','restAmount','conversation','messages'));
    }

    public function milestone($id){
        $pageTitle = 'Escrow Milestone';
        $escrow = Escrow::findOrFail($id);
        $milestones = Milestone::where('escrow_id',$escrow->id)->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = 'No milestone found';

        return view('admin.escrow.milestones',compact('pageTitle','escrow','milestones','emptyMessage'));
    }

    public function replyMessage(Request $request){
        $validate = Validator::make($request->all(), [
            'conversation_id' => 'required',
            'message' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }
        $conversation = Conversation::where('status',1)->where('id', $request->conversation_id)->first();
        if (!$conversation) {
            return response()->json(['error'=>['Conversation not found']]);
        }

        $escrow = $conversation->escrow;
        if ($escrow->status != 8) {
            return response()->json(['error'=>['You couldn\'t attend to this conversation']]);
        }

        $message = new Message();
        $message->admin_id = auth()->guard('admin')->id();
        $message->conversation_id = $conversation->id;
        $message->message = $request->message;
        $message->save();

        return [
            'created_diff'=> $message->created_at->diffForHumans(),
            'created_time'=> $message->created_at->format('h:i A'),
            'message'=> $message->message,
            'file'=>$message->file??null,
            'file_type'=>$message->file?pathinfo(url('').'/uploads/'. $message->file , PATHINFO_EXTENSION):null
        ];
    }

    public function getMessage(Request $request){
        $validate = Validator::make($request->all(), [
            'conversation_id' => 'required',
        ]);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()]);
        }

        $conversation = Conversation::findOrFail($request->conversation_id);
        $messages = Message::where('conversation_id',$conversation->id)->with('sender','admin')->get();
        $escrow = $conversation->escrow;

        return view('admin.escrow.message',compact('messages','escrow'));
    }

    public function action(Request $request)
    {
        $request->validate([
            'escrow_id'    =>'required|integer|exists:escrows,id',
            'buyer_amount' =>'required|numeric|gte:0',
            'seller_amount'=>'required|numeric|gte:0',
            'status'       =>'required|integer|in:1,9',
        ]);

        $escrow         = Escrow::where('status', 8)->findOrFail($request->escrow_id);
        $charge         = $escrow->paid_amount - ($request->buyer_amount + $request->seller_amount);

        if ($charge < 0) {
            $notify[] = ['error','You can\'t transact greater than funded amount'];
            return back()->withNotify($notify);
        }

        $escrow->status = $request->status;
        $buyer          = $escrow->buyer;
        $seller         = $escrow->seller;
        $trx            = getTrx();
        $escrow->save();

        if ($request->buyer_amount > 0) {
            $buyer->balance            += $request->buyer_amount;
            $buyer->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $buyer->id;
            $transaction->amount       = $request->buyer_amount;
            $transaction->post_balance = $buyer->balance;
            $transaction->charge       = 0;
            $transaction->currency_sym = $escrow->currency_sym;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Admin has taken action to the escrow and send this amount to you';
            $transaction->trx          = $trx;
            $transaction->save();
        }

        if ($request->seller_amount > 0) {
            $seller->balance           += $request->seller_amount;
            $seller->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $seller->id;
            $transaction->amount       = $request->seller_amount;
            $transaction->post_balance = $seller->balance;
            $transaction->currency_sym = $escrow->currency_sym;

            $transaction->charge       = 0;
            $transaction->trx_type     = '+';
            $transaction->details      = 'Admin has taken action to the escrow and send this amount to you';
            $transaction->trx          = $trx;
            $transaction->save();
        }

        $general = GeneralSetting::first();

        $shortCodes = [
            'title'        => $escrow->title,
            'amount'       => showAmount($escrow->amount),
            'total_fund'   => showAmount($escrow->paid_amount),
            'seller_amount'=> showAmount($request->seller_amount),
            'buyer_amount' => showAmount($request->buyer_amount),
            'charge'       => showAmount($charge),
            'trx'          => $trx,
            'currency'     => $escrow->currency_sym,
        ];

        if ($buyer) {
            $shortCodes['post_balance'] = showAmount($buyer->balance);
            notify($buyer, 'ESCROW_ADMIN_ACTION', $shortCodes);
        }

        if ($seller) {
            $shortCodes['post_balance'] = showAmount($seller->balance);
            notify($buyer, 'ESCROW_ADMIN_ACTION', $shortCodes);
        }

        $conversation = $escrow->conversation;
        $conversation->status = 0;
        $conversation->save();

        $notify[] = ['success','Escrow action taken successfully'];
        return back()->withNotify($notify);
    }

    protected function filterEscrows($type)
    {
        $this->pageTitle    = ucwords(inputTitle(Str::snake($type))) . ' Escrows';

        $this->emptyMessage = 'No ' . $type . ' escrow found';
        $escrows = Escrow::query();

        if (request()->search) {
            $search = request()->search;
            $escrows = $escrows->where('title', 'like', "%$search%")->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like',"%$search%");
                    });
            $this->pageTitle    = "Search Result for '$search'";
        }

        if ($type != 'all') {
            $escrows = $escrows->$type();
        }

        return $escrows->latest()->with('seller','buyer','category')->paginate(getPaginate());
    }
}
