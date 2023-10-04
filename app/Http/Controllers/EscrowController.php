<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Escrow;
use App\Models\EscrowCharge;
use App\Models\GeneralSetting;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Storage;
use Str;
use Illuminate\Support\Facades\Validator;

class EscrowController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function index($type = null)
    {
       if (!empty($type)) {
        $pageTitle = Str::title($type)." Escrow";
       } else {
        $pageTitle = 'My Escrow';
       }
       
       

        $escrows = Escrow::where(function ($query) {
            $query->orWhere('buyer_id', auth()->id())
                ->orWhere('seller_id', auth()->id());
        })->with('seller', 'buyer');

        if ($type == 'accepted') {
            $escrows = $escrows->where('status', 2);
        }

        if ($type == 'not-accepted') {
            $escrows = $escrows->where('status', 0);
        }

        if ($type == 'completed') {
            $escrows = $escrows->where('status', 1);
        }

        if ($type == 'canceled') {
            $escrows = $escrows->where('status', 9);
        }

        if ($type == 'disputed') {
            $escrows = $escrows->where('status', 8);
        }

        $escrows = $escrows->orderBy('id', 'desc')->with('category')->paginate(getPaginate());
        $emptyMessage = 'Escrow not found';

        return view($this->activeTemplate . 'user.escrow.index', compact('pageTitle', 'escrows', 'emptyMessage'));
    }

    public function new()
    {
        $pageTitle = 'New Escrow';
        $categories = Category::where('status', 1)->get();

        return view($this->activeTemplate . 'user.escrow.new', compact('pageTitle', 'categories'));
    }

    public function submitInformation(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'type'    => 'required|in:1,2',
            'amount'     => 'required|numeric|gt:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $charge         = $this->getCharge($request->amount,$request->currency_sym);
        $data           = $request->except('_token');
        $data['charge'] = $charge;
        session()->put('escrow_info', $data);

        return redirect()->route('user.escrow.submit');
    }

    public function submitEscrow(Request $request)
    {
        // dd(session('escrow_info'));

        $escrowInfo = session('escrow_info');
        if (!$escrowInfo) {
            $notify[] = ['info', 'Please fill up this form first'];
            $notify[] = ['error', 'The session is invalid'];
            return redirect()->route('user.escrow.new')->withNotify($notify);
        }
        $pageTitle = 'Submit Escrow';
        return view($this->activeTemplate . 'user.escrow.submit', compact('pageTitle', 'escrowInfo'));
    }

    public function store(Request $request)
    {
        // dd(session('escrow_info'),$request->all());
        $this->validation($request);

        $escrowInfo     = session('escrow_info');
        $checkSession   = $this->checkSessionData($request->email, $escrowInfo);

        if ($checkSession['error']) {
            return back()->withNotify($checkSession['notify']);
        }

        $category_id  = $escrowInfo['category_id'];
        $user         = auth()->user();
        $toUser       = User::where('email', $request->email)->first();
        $amount       = $escrowInfo['amount'];

        $charge       = $this->getCharge($amount,$escrowInfo['currency_sym']);
        $sellerCharge = 0;
        $buyerCharge  = 0;

        if ($request->charge_payer == 1) {
            $sellerCharge = $charge;
        } elseif ($request->charge_payer == 2) {
            $buyerCharge  = $charge;
        } else {
            $sellerCharge = $charge / 2;
            $buyerCharge  = $charge / 2;
        }

        $escrow = new Escrow();

        if ($escrowInfo['type'] == 1) {
            $escrow->seller_id = $user->id;
            $escrow->buyer_id  = @$toUser->id ?? 0;
        } else {
            $escrow->buyer_id  = $user->id;
            $escrow->seller_id = @$toUser->id ?? 0;
        }

        $escrow->creator_id    = $user->id;
        $escrow->amount        = $amount;
        $escrow->charge_payer  = $request->charge_payer;
        $escrow->charge        = $charge;
        $escrow->buyer_charge  = $buyerCharge;
        $escrow->seller_charge = $sellerCharge;
        $escrow->currency_sym =  $escrowInfo['currency_sym'];
        $escrow->category_id   = $category_id;
        $escrow->title         = $request->title;
        $escrow->details       = $request->details;

        if (!$toUser) {
            $escrow->invitation_mail = $request->email;
        }

        if ($request->file) {
            // dd($request->file);
            $filename = Storage::disk('user')->putFile('', $request->file('file'));
            $escrow->file = $filename;
        }

        $escrow->save();
        if ($escrow->buyer_id = auth()->id()) {
            // $mailReceiver = $escrow->seller;
            $create = 'buyer';
        } else {
            // $mailReceiver = $escrow->buyer;
            $create = 'seller';
        }
        $conversation = new Conversation();
        $conversation->escrow_id = $escrow->id;
        $conversation->buyer_id = $escrow->buyer_id;
        $conversation->seller_id = $escrow->seller_id;
        $conversation->save();
        
        
        $message = 'Escrow created successfully';
        if (!$toUser) {
            $mailReceiver = (object)[
                'fullname' => $request->email,
                'username' => $request->email,
                'email' => $request->email
            ];
            notify($mailReceiver, 'ESCROW_CREATED', [
                'title' => $escrow->title,
                'amount' => showAmount($escrow->amount),
                'create' => $create,
                'total_fund' => showAmount($escrow->paid_amount),
                'currency' => $escrow->currency_sym,
            ]);
            notify($mailReceiver, 'INVITATION_LINK', [
                'link' => route('user.register'),
            ]);

            $message = 'Escrow created and invitation link sent successfully';
        } else {
            notify($toUser, 'ESCROW_CREATED', [
                'title' => $escrow->title,
                'amount' => showAmount($escrow->amount),
                'create' => $create,
                'total_fund' => showAmount($escrow->paid_amount),
                'currency' => $escrow->currency_sym,
            ]);
           
        }
        notify($user, 'ESCROW_CREATED', [
            'title' => $escrow->title,
            'amount' => showAmount($escrow->amount),
            'create' => $create,
            'total_fund' => showAmount($escrow->paid_amount),
            'currency' => $escrow->currency_sym,
        ]);
        
        session()->forget('escrow_info');
        $notify[] = ['success', $message];

        return redirect()->route('user.escrow.index')->withNotify($notify);
    }

    private function checkSessionData($email, $escrowInfo)
    {
        $user  = auth()->user();
        $error = false;
        $notify = [];

        if (!$escrowInfo) {
            $notify[] = ['info', 'Please fill up this form first'];
            $notify[] = ['error', 'The session is invalid'];
            $error = true;
        }

        if ($user->email == $email) {
            $error = true;
            $notify[] = ['error', 'You can not create escrow with your own'];
        }

        $category = Category::where('status', 1)->where('id', $escrowInfo['category_id'])->first();

        if (!$category) {
            $notify[] = ['error', 'Invalid escrow type'];
            $error = true;
        }

        return [
            'error'     => $error,
            'notify'    => $notify
        ];
    }

    private function validation($request)
    {
        $request->validate([
            'email'       => 'required|max:40',
            'title'       => 'required|max:255',
            'details'     => 'required',
            'charge_payer' => 'required|in:1,2,3',
        ]);
    }

    public function details($hash)
    {
        $pageTitle = 'Escrow Details';
        $id = decrypt($hash);

        $escrow = Escrow::where('id', $id)->where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->with('conversation', 'conversation.messages', 'conversation.messages.sender', 'conversation.messages.admin')->firstOrFail();

        $chargeAmount=0;
        if ($escrow->charge_payer == 1) {
            if ($escrow->seller_id == auth()->user()->id) {
                 $chargeAmount = $escrow->seller_charge;
            }
           
           
        } elseif ($escrow->charge_payer == 2) {
            if ($escrow->buyer_id == auth()->user()->id) {
                $chargeAmount = $escrow->buyer_charge;
           }
            // Buyer pays the charges
           
        } elseif ($escrow->charge_payer == 3) {
            // Split charges 50-50
            $chargeAmount = ($escrow->seller_charge + $escrow->buyer_charge) / 2;
        }

        $restAmount = ($escrow->amount + $chargeAmount) - $escrow->paid_amount;
        $conversation = $escrow->conversation;
        $messages = $conversation->messages;
// dd($escrow,$escrow->amount , $escrow->buyer_charge);
        return view($this->activeTemplate . 'user.escrow.details', compact('pageTitle', 'escrow', 'restAmount', 'conversation', 'messages'));
    }

    private function getCharge($amount,$currency_sym)
    {

        $general           = GeneralSetting::first();
        $percentCharge     = $general->percent_charge;
        $fixedCharge       = $general->fixed_charge;
        // $escrowCharge      = EscrowCharge::where('minimum', '<=', $amount)->where('maximum', '>=', $amount)->first();
        $escrowCharge      = EscrowCharge::where('currency_sym',$currency_sym)->first();

        if ($escrowCharge) {
            $percentCharge = $escrowCharge->percent_charge;
            $fixedCharge   = $escrowCharge->fixed_charge;
        }

        // $charge            = ($amount * $percentCharge) / 100 + $fixedCharge;
        $charge            = $escrowCharge->fixed_charge;
        // if ($charge > $general->charge_cap) {
        //     $charge        = $general->charge_cap;
        // }

        return $charge;
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'escrow_id' => 'required',
        ]);

        $escrow         = Escrow::where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->where('status', 0)->findOrFail(decrypt($request->escrow_id));
        $escrow->status = 9;
        $escrow->save();

        $amount         = $escrow->paid_amount;

        if ($escrow->buyer_id = auth()->id()) {
            $mailReceiver = $escrow->seller;
            $canceller    = 'buyer';
        } else {
            $mailReceiver = $escrow->buyer;
            $canceller    = 'seller';
        }

        if ($amount > 0) {
            $user = $escrow->buyer;
            $user->balance += $amount;

            $user->save();

            $userBalance_find = UserBalance::where('currency_sym', $escrow->currency_sym)->where('user_id', $user->id)->first();
            if ($userBalance_find) {
                $userBalance_find->balance += $amount;
                $userBalance_find->save();
            } else {
                $userBalance = new UserBalance();
                $userBalance->user_id = $user->id;
                $userBalance->balance += $amount;
                $userBalance->currency_sym = $escrow->currency_sym;
                $userBalance->save();
            }

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
            $transaction->currency_sym = $escrow->currency_sym;
            $transaction->details = 'Milestone amount refunded for cancelling the escrow';
            $transaction->trx = getTrx();
            $transaction->save();
        }

        $conversation = $escrow->conversation;
        $conversation->status = 0;
        $conversation->save();

        $general = GeneralSetting::first();

        if ($mailReceiver) {
            notify($mailReceiver, 'ESCROW_CANCELLED', [
                'title' => $escrow->title,
                'amount' => showAmount($escrow->amount),
                'canceller' => $canceller,
                'total_fund' => showAmount($amount),
                'currency' => $escrow->currency_sym,
            ]);
        }

        $notify[] = ['success', 'Escrow cancelled successfully'];
        return back()->withNotify($notify);
    }

    public function accept(Request $request)
    {
        $request->validate([
            'escrow_id' => 'required',
        ]);

        $escrow = Escrow::where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->where('creator_id', '!=', auth()->id())->where('status', 0)->findOrFail(decrypt($request->escrow_id));

        $escrow->status = 2;
        $escrow->save();

        if ($escrow->buyer_id = auth()->id()) {
            $mailReceiver = $escrow->seller;
            $accepter = 'buyer';
        } else {
            $mailReceiver = $escrow->buyer;
            $accepter = 'seller';
        }

        $general = GeneralSetting::first();

        notify($mailReceiver, 'ESCROW_ACCEPTED', [
            'title' => $escrow->title,
            'amount' => showAmount($escrow->amount),
            'accepter' => $accepter,
            'total_fund' => showAmount($escrow->paid_amount),
            'currency' => $escrow->currency_sym,
        ]);

        $notify[] = ['success', 'Escrow accepted successfully'];
        return back()->withNotify($notify);
    }

    public function dispatchEscrow(Request $request)
    {
        $request->validate([
            'escrow_id' => 'required',
        ]);

        $escrow = Escrow::where('buyer_id', auth()->user()->id)->where('status', 2)->findOrFail(decrypt($request->escrow_id));
        $escrow->status = 1;
        $escrow->save();

        $amount = $escrow->amount;
        $seller = $escrow->seller;
        $seller->balance += $amount;
        $seller->save();

        $userBalance_find = UserBalance::where('currency_sym', $escrow->currency_sym)->where('user_id', $seller->id)->first();
        if ($userBalance_find) {
            $userBalance_find->balance += $amount;
            $userBalance_find->save();
        } else {
            $userBalance = new UserBalance();
            $userBalance->user_id = $seller->id;
            $userBalance->balance += $amount;
            $userBalance->currency_sym = $escrow->currency_sym;
            $userBalance->save();
        }



        $trx = getTrx();
        $transaction = new Transaction();
        $transaction->user_id = $seller->id;
        $transaction->amount = $amount;
        $transaction->post_balance = $seller->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->currency_sym = $escrow->currency_sym;
        $transaction->details = 'Escrow payment withdrawals';
        $transaction->trx = $trx;
        $transaction->save();

        if ($escrow->seller_charge > 0) {
            $userBalance_find = UserBalance::where('currency_sym', $escrow->currency_sym)->where('user_id', $seller->id)->first();
            if ($userBalance_find) {
                $userBalance_find->balance -= $escrow->seller_charge;
                $userBalance_find->save();
            } 
            
            $seller->balance -= $escrow->seller_charge;
            $seller->save();

            $transaction = new Transaction();
            $transaction->user_id = $seller->id;
            $transaction->amount = $escrow->seller_charge;
            $transaction->post_balance = $seller->balance;
            $transaction->currency_sym = $escrow->currency_sym;
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Escrow charge pay';
            $transaction->trx = $trx;
            $transaction->save();
        }

        $general = GeneralSetting::first();

        notify($seller, 'ESCROW_PAYMENT_DISPATCHED', [
            'title' => $escrow->title,
            'amount' => showAmount($escrow->amount),
            'charge' => showAmount($escrow->charge),
            'seller_charge' => showAmount($escrow->seller_charge),
            'trx' => $trx,
            'post_balance' => showAmount($seller->balance),
            'currency' => $escrow->currency_sym,
        ]);

        $notify[] = ['success', 'Escrow payment dispatched successfully'];
        return back()->withNotify($notify);
    }

    public function dispute(Request $request)
    {
        $request->validate([
            'escrow_id' => 'required',
            'details' => 'required',
        ]);

        $escrow = Escrow::where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->where('status', 2)->findOrFail(decrypt($request->escrow_id));

        $escrow->status         = 8;
        $escrow->disputer_id    = auth()->id();
        $escrow->dispute_note   = $request->details;
        $escrow->save();

        $conversation           = $escrow->conversation;
        $conversation->is_group = 1;
        $conversation->save();

        if ($escrow->buyer_id   = auth()->id()) {
            $mailReceiver       = $escrow->seller;
            $disputer           = 'buyer';
        } else {
            $mailReceiver       = $escrow->buyer;
            $disputer           = 'seller';
        }

        $general  = GeneralSetting::first();

        notify($mailReceiver, 'ESCROW_DISPUTED', [
            'title'       => $escrow->title,
            'amount'      => showAmount($escrow->amount),
            'disputer'    => $disputer,
            'total_fund'  => showAmount($escrow->paid_amount),
            'dispute_note' => $request->details,
            'currency'    => $escrow->currency_sym,
        ]);

        $notify[] = ['success', 'Escrow disputed successfully'];
        return back()->withNotify($notify);
    }

    public function replyMessage(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()]);
        }

        $conversation = Conversation::where('id', $request->conversation_id)->where(function ($query) {
            $query->orWhere('buyer_id', auth()->id())->orWhere('seller_id', auth()->id());
        })->where('status', 1)->first();

        if (!$conversation) {
            return response()->json(['error' => ['Conversation not found']]);
        }

        $message = new Message();
        $message->sender_id = auth()->id();
        $message->conversation_id = $conversation->id;
        $message->message = $request->message;
        $message->save();
        if ($request['file']) {
            $fileData = $request['file'];


            // Store the file in the public disk with the generated filename
            $filename = Storage::disk('user')->putFile('', $fileData);
            $message->file = $filename;
            $message->save();
        }

        return [
            'created_diff' => $message->created_at->diffForHumans(),
            'created_time' => $message->created_at->format('h:i A'),
            'message' => $message->message,
            'file' => $message->file ?? null,
            'file_type' => $message->file ? pathinfo(url('') . '/uploads/' . $message->file, PATHINFO_EXTENSION) : null
        ];
    }

    public function getMessages(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()]);
        }

        $conversation = Conversation::where('id', $request->conversation_id)->where(function ($query) {
            $query->orWhere('buyer_id', auth()->id())->orWhere('seller_id', auth()->id());
        })->first();

        if (!$conversation) {
            return response()->json(['error' => ['Conversation not found']]);
        }
        $escrow = $conversation->escrow;
        $messages = Message::where('conversation_id', $conversation->id)->with('sender', 'admin')->get();

        return view($this->activeTemplate . 'user.escrow.message', compact('messages', 'escrow'));
    }

    public function milestones($hash)
    {
        $pageTitle    = 'Escrow Milestones';
        $id           = decrypt($hash);

        $escrow       = Escrow::where('id', $id)->where(function ($query) {
            $query->orWhere('buyer_id', auth()->id())
                ->orWhere('seller_id', auth()->id());
        })->firstOrFail();

        $milestones   = Milestone::where('escrow_id', $escrow->id)->orderBy('id', 'desc')->paginate(getPaginate());
        $restAmount      = ($escrow->amount + $escrow->charge) - $escrow->paid_amount;
        $emptyMessage = 'No milestone found';

        return view($this->activeTemplate . 'user.escrow.milestones', compact('pageTitle', 'emptyMessage', 'escrow', 'milestones', 'restAmount'));
    }

    public function createMilestone(Request $request)
    {
        $request->validate([
            'escrow_id' => 'required',
            'amount'    => 'required|numeric|gt:0',
            'note' => 'required|max:255',
        ]);

        $escrow     = Escrow::where('buyer_id', auth()->user()->id)->whereNotIn('status', [8, 9])->findOrFail(decrypt($request->escrow_id));
        $restAmount    = ($escrow->amount + $escrow->charge) - $escrow->paid_amount;

        if ($request->amount > $restAmount) {
            $notify[] = ['error', 'Your milestone couldn\'t be greater than rest amount'];
            return back()->withNotify($notify);
        }

        $milestone            = new Milestone();
        $milestone->escrow_id = $escrow->id;
        $milestone->user_id   = auth()->id();
        $milestone->amount    = $request->amount;
        $milestone->currency  = $request->currency_sym;
        $milestone->note      = $request->note;
        $milestone->save();

        $notify[] = ['success', 'Milestone created successfully'];
        return back()->withNotify($notify);
    }

    public function payMilestone(Request $request)
    {
        $request->validate([
            'pay_via'     => 'required|in:1,2',
            'milestone_id' => 'required|exists:milestones,id'
        ]);

        $milestone = Milestone::where('payment_status', 0)->whereHas('escrow', function ($query) {
            $query->where('buyer_id', auth()->user()->id)->where('status', '!=', 8)->where('status', '!=', 9);
        })->findOrFail($request->milestone_id);

        $user = auth()->user();

        if ($request->pay_via == 2) {
            session()->put('checkout', encrypt([
                'amount'      => $milestone->amount,
                'milestone_id' => $milestone->id,
            ]));

            return redirect()->route('user.deposit', 'checkout');
        }
        $balance = $user->userBalance->where('currency_sym',$milestone->currency)->first()?->balance??0;
        if ($balance < $milestone->amount) {
            $notify[] = ['error', 'You have no sufficient balance'];
            return back()->withNotify($notify);
        }
        $userBalance_find = $user->userBalance->where('currency_sym',$milestone->currency)->first();
        if ($userBalance_find) {
            $userBalance_find->balance -= $milestone->amount;
            $userBalance_find->save();
        } 
        // $user->balance -= $milestone->amount;
        // $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $milestone->amount;
        $transaction->post_balance = $user->userBalance->where('currency_sym',$milestone->currency)->first()?->balance??0;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->currency_sym = $milestone->currency;

        $transaction->details      = 'Milestone paid for ' . $milestone->escrow->title;
        $transaction->trx          = getTrx();
        $transaction->save();

        $milestone->payment_status = 1;
        $milestone->save();

        $escrow = $milestone->escrow;
        $escrow->paid_amount += $milestone->amount;
        $escrow->save();

        $notify[] = ['success', 'Milestone paid successfully'];
        return back()->withNotify($notify);
    }
}
