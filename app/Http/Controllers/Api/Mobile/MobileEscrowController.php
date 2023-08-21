<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Deposit;
use App\Models\Escrow;
use App\Models\EscrowCharge;
use App\Models\Frontend;
use App\Models\GatewayCurrency;
use App\Models\GeneralSetting;
use App\Models\Message;
use App\Models\Milestone;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBalance;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Storage;

class MobileEscrowController  extends Controller
{
    public function states(Request $request){
        $user = auth()->user();
        $balance = UserBalance::where('id',auth()->user()->id)->where('currency_sym','NGN')->first();;
        $depositAmount = Deposit::where('status', 1)->where('user_id', auth()->user()->id)->where('method_currency','NGN')->sum('amount');
        $withdrawAmount = Withdrawal::where('status', 1)->where('user_id', auth()->user()->id)->where('currency','NGN')->sum('amount');
        $depositAmountPending = Deposit::where('status', 2)->where('user_id', auth()->user()->id)->where('method_currency','NGN')->sum('amount');
        $withdrawAmountPending = Withdrawal::where('status', 2)->where('user_id', auth()->user()->id)->where('currency','NGN')->sum('amount');
        $milestoneAmount = Milestone::where('payment_status', 1)->where('user_id', auth()->user()->id)->where('currency','NGN')->sum('amount');
        $escrows = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        });
        $totalEscrow = $escrows->count();
        $accepted = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->where('status',2)->count();
        $notAccepted =Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->where('status',0)->count();
        $completed = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->where('status',1)->count();
        $cancelled = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->where('status',9)->count();
        $disputed = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        })->where('status',8)->count();
        $latestTransactions = Transaction::where('user_id',auth()->id())->latest()->limit(10)->get();
        return response()->json([
            'message'=>'success',
            'data'=> [
                'total' => $totalEscrow,
                'accepted'=>$accepted,
                'noAccepted' => $notAccepted,
                'completed' => $completed,
                'cancelled' => $cancelled,
                'disputed'=> $disputed,
                'latestTransactions'=>$latestTransactions,
                'balance'=>$balance ? $balance->balance: "0",
                'depositAmount'=>$depositAmount,
                'withdrawAmount' => $withdrawAmount,
                'depositAmountPending'=>$depositAmountPending,
                'withdrawAmountPending' =>$withdrawAmountPending,
                'milestoneAmount' => $milestoneAmount
            ]
        ])->setStatusCode(200);
    }
    public function escrowCategory()
    {
        $categories = Category::where('status', 1)->get();
        return response()->json([
            'data'=> $categories
        ])->setStatusCode(200);;    }
    public function CurrencyExchange(Request $request)
    {
        $user = auth()->user();

        $userBalance = UserBalance::where('id',auth()->user()->id)->where('currency_sym',$request->currency)->first();
        $balanceAmount= $userBalance?$userBalance->sum('balance')??0:0;
        $depositAmount_total= $user->deposits->where('status',1)->where('method_currency',$request->currency)->sum('amount');
        $withdrawAmount_total= $user->withdrawals->where('status',1)->where('currency',$request->currency)->sum('amount');
        $depositAmountPending_total= $user->deposits->where('status',2)->where('currency_sym',$request->currency)->sum('amount');
        $withdrawAmountPending_total= $user->withdrawals->where('status',2)->where('currency',$request->currency)->sum('amount');
        $milestoneAmount_total= Milestone::where('user_id',$user->id)->whereHas('escrow',function ($q) use($request)
        {
            $q->where('currency_sym',$request->currency);
        })->where('payment_status',1)->sum('amount');
        $user->milestones->where('payment_status',1)->sum('amount');
        $data=[
            'balanceAmount'=>$balanceAmount??0,
            'depositAmount'=>$depositAmount_total??0,
            'withdrawAmount'=>$withdrawAmount_total??0,
            'depositAmountPending'=>$depositAmountPending_total??0,
            'withdrawAmountPending'=>$withdrawAmountPending_total??0,
            'milestoneAmount'=>$milestoneAmount_total??0,
            'sym'=>$request->currency,

        ];
        return response()->json([
            'data'=> $data
        ])->setStatusCode(200);;
    }
    public function CurrencyAllBalance(Request $request)
    {
        $user = auth()->user();

        $ngn = UserBalance::where('id',auth()->user()->id)->where('currency_sym','NGN')->first();
        $usd = UserBalance::where('id',auth()->user()->id)->where('currency_sym','USD')->first();
        $euro = UserBalance::where('id',auth()->user()->id)->where('currency_sym','EURO')->first();
        $btc = UserBalance::where('id',auth()->user()->id)->where('currency_sym','BTC')->first();
        $eth = UserBalance::where('id',auth()->user()->id)->where('currency_sym','ETH')->first();
        $data=[
            'ngn'=>$ngn ? $ngn->balance: 0,
            'usd'=>$usd ? $usd->balance: 0,
            'euro'=>$euro ? $euro->balance: 0,
            'btc'=>$btc ? $btc->balance: 0,
            'eth'=>$eth  ? $eth->balance: 0,
        ];
        return response()->json([
            'data'=> $data
        ])->setStatusCode(200);;
    }
    public function submitProfile(Request $request)
    {
        $user = Auth::user();
        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];
        error_log($request['file']);
        if ($request['file']) {
            $fileData = $request['file'];
            $filename = Storage::disk('user')->putFile('', $fileData);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        return response()->json([
            'data'=> [
                'user'=> $user
            ]
        ])->setStatusCode(200);;
    }

    public function escrowList($type = null)
    {
        $escrows = Escrow::select('amount', 'currency_sym', 'title', 'status', 'created_at', 'id')->where(function ($query) {
            $query->orWhere('buyer_id', auth()->id())
                ->orWhere('seller_id', auth()->id());
        });

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

        $escrows = $escrows->orderBy('id', 'desc')->paginate(getPaginate());
        return response()->json([
            'data'=> [
                'escrows'=> $escrows
            ]
        ])->setStatusCode(200);
    }
    public function escrowDetails($id)
    {
        $escrow = Escrow::where('id', $id)->where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->with( 'seller','buyer' , 'disputer', 'conversation', 'conversation.messages', 'conversation.messages.sender', 'conversation.messages.admin')->firstOrFail();
        $restAmount = ($escrow->amount + $escrow->buyer_charge) - $escrow->paid_amount;
        $milestoneFunded = $escrow->milestones->where('payment_status', 1)->sum('amount');
        $milestoneUnfunded = $escrow->milestones->where('payment_status', 0)->sum('amount');
        return response()->json([
            'data'=> [
                'escrows'=> $escrow,
                'restAmount'=>$restAmount,
                'milestoneFunded'=> $milestoneFunded,
                'milestoneUnfunded' => $milestoneUnfunded
            ]
        ])->setStatusCode(200);
    }
    public function replyMessage(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['message' => $validate->errors()])->setStatusCode(400);
        }
        $conversation = Conversation::where('id', $request->conversation_id)->where(function ($query) {
            $query->orWhere('buyer_id', auth()->id())->orWhere('seller_id', auth()->id());
        })->where('status', 1)->first();

        if (!$conversation) {
            return response()->json(['message' => ['Conversation not found']])->setStatusCode(400);
        }
        $message = new Message();
        $message->sender_id = auth()->id();
        $message->conversation_id = $conversation->id;
        $message->message = $request->message;
        $message->save();
        if ($request['file']) {
            $fileData = $request['file'];
            $filename = Storage::disk('user')->putFile('', $fileData);
            $message->file = $filename;
            $message->save();
        }

        return response()->json([
            'data'=> [
                'message' => $message->message,
                'file' => $message->file ?? null,
                'file_type' => $message->file ? pathinfo(url('') . '/uploads/' . $message->file, PATHINFO_EXTENSION) : null
            ]
        ])->setStatusCode(200);
    }

    public function cancel(Request $request)
    {
        $escrow  = Escrow::where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->where('status', 0)->findOrFail($request->escrow_id);
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

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '+';
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
                'currency' => $general->cur_text,
            ]);
        }

        return response()->json([
            'data'=> [
                'message' => 'success',
            ]
        ])->setStatusCode(200);
    }
    public function dispute(Request $request)
    {
        $escrow = Escrow::where(function ($query) {
            $query->orWhere('buyer_id', auth()->user()->id)->orWhere('seller_id', auth()->user()->id);
        })->where('status', 2)->findOrFail($request->escrow_id);

        $escrow->status = 8;
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
            'currency'    => $general->cur_text,
        ]);

        return response()->json([
            'data'=> [
                'message' => 'success',
            ]
        ])->setStatusCode(200);
    }
    public function changePassword(Request $request){
        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => ['required',$password_validation]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = 'Password changes successfully';
            $status = 200;
        } else {
            $notify[] = 'The password doesn\'t match!';
            $status = 400;
        }
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>$notify,
        ])->setStatusCode($status);
    }
    public function viewTicket($ticket)
    {
        $userId =  auth()->user()->id;
        error_log($ticket);
        $my_ticket = SupportTicket::where('id', $ticket)->orderBy('id','desc')->firstOrFail();
        $messages = SupportMessage::where('supportticket_id', $ticket)->with('attachments')->orderBy('id','desc')->get();
        return response()->json([
            'data'=>[
                'my_ticket' => $my_ticket,
                'messages'=> $messages
            ],
        ])->setStatusCode(200);
    }
    public function supportTicket(Request $request)
    {
        if($request->type == 1){
            $supports = SupportTicket::where('user_id', auth()->user()->id)->where('status', 0)->orderBy('priority', 'desc')->orderBy('id','desc')->paginate(getPaginate());
        }else{
            $supports = SupportTicket::where('user_id', auth()->user()->id)->orderBy('priority', 'desc')->orderBy('id','desc')->paginate(getPaginate());
        }
        return response()->json([
            'data'=>[
                'my_ticket' => $supports,
            ],
        ])->setStatusCode(200);
    }
    public function replyTicket(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $ticket = SupportTicket::where('user_id',$userId)->where('id',$id)->firstOrFail();
        $message = new SupportMessage();
        if ($request->replayTicket == 1) {
            $attachments = [$request->file('attachments')];
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf', 'doc','docx');
            $validator = Validator::make($request->all(), [
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($attachments, $allowedExts) {
                        foreach ($attachments as $file) {
                            $ext = strtolower($file->getClientOriginalExtension());
                            if (($file->getSize() / 1000000) > 2) {
                                return $fail("Miximum 2MB file size allowed!");
                            }
                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg, pdf doc docx files are allowed");
                            }
                        }
                        if (count($attachments) > 5) {
                            return $fail("Maximum 5 files can be uploaded");
                        }
                    },
                ],
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'code'=>200,
                    'status'=>'ok',
                    'message'=>$validator->errors()->all(),
                ])->setStatusCode(400);
            }
            $ticket->status = 2;
            $ticket->last_reply = Carbon::now();
            $ticket->save();
            $message->supportticket_id = $ticket->id;
            $message->message = $request->message;
            $message->save();
            $path = imagePath()['ticket']['path'];
            if ($request->hasFile('attachments')) {
                foreach ($attachments as $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = uploadFile($file, $path);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        return response()->json([
                            'message'=>['Could not upload your ' . $file],
                        ])->setStatusCode(400);
                    }
                }
            }

            $notify = ['Support ticket replied successfully!'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(200);
        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->last_reply = Carbon::now();
            $ticket->save();
            $notify = ['Support ticket closed successfully!'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(200);
        }else{
            $notify = ['Invalid request'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }
    }
    public function store(Request $request)
    {
        $validat = Validator::make($request->all(), [
            'email'       => 'required|email',
            'title'       => 'required|max:255|min:5',
            'details'     => 'required|min:10',
            'charge_payer' => 'required|in:1,2,3',
            'category_id' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'currency_sym' => 'required'
        ]);
        if ($validat->fails()) {
            return response()->json([
                'message'=>$validat->errors()->all(),
            ])->setStatusCode(400);
        }

        $category_id  = $request->category_id;
        $user         = auth()->user();
        $toUser       = User::where('email', $request->email)->first();
        $amount       = $request->amount;
        $charge       = $this->getCharge($amount);
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

        if ($request->type == 1) {
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
        $escrow->currency_sym =  $request->currency_sym;
        $escrow->category_id   = $category_id;
        $escrow->title         = $request->title;
        $escrow->details       = $request->details;

        if (!$toUser) {
            $escrow->invitation_mail = $request->email;
        }

        if ($request->file) {
            $filename = Storage::disk('user')->putFile('', $request->file('file'));
            $escrow->file = $filename;
        }

        $escrow->save();
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

            notify($mailReceiver, 'INVITATION_LINK', [
                'link' => route('user.register'),
            ]);

            $message = ['Escrow created and invitation link sent successfully'];
            return response()->json([
                'message'=>$message,
            ])->setStatusCode(200);
        }
        $notify[] = [$message];

        return response()->json([
            'message'=>$notify,
        ])->setStatusCode(200);
    }
    private function getCharge($amount)
    {

        $general           = GeneralSetting::first();
        $percentCharge     = $general->percent_charge;
        $fixedCharge       = $general->fixed_charge;
        $escrowCharge      = EscrowCharge::where('minimum', '<=', $amount)->where('maximum', '>=', $amount)->first();

        if ($escrowCharge) {
            $percentCharge = $escrowCharge->percent_charge;
            $fixedCharge   = $escrowCharge->fixed_charge;
        }

        $charge            = ($amount * $percentCharge) / 100 + $fixedCharge;

        if ($charge > $general->charge_cap) {
            $charge        = $general->charge_cap;
        }

        return $charge;
    }

    public function newSupportTicket(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $files = [$request->file('attachments')];
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf','doc','docx');
        $validat = Validator::make($request->all(), [
            'subject' => 'required|max:100',
            'message' => 'required',
            'priority' => 'required|in:1,2,3',
            'attachments'=>[
                'max:4096',
                function ($attribute, $value, $fail) use ($files, $allowedExts) {
                    foreach ($files as $file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        if (($file->getSize() / 1000000) > 2) {
                            return $fail("Miximum 2MB file size allowed!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                        }
                    }
                    if (count($files) > 5) {
                        return $fail("Maximum 5 files can be uploaded");
                    }
                },
            ],
        ]);
        if ($validat->fails()) {
            return response()->json([
                'message'=>$validat->errors()->all(),
            ])->setStatusCode(400);
        }
        $user = auth()->user();
        $ticket->user_id = $user->id;
        $random = rand(100000, 999999);
        $ticket->ticket = $random;
        $ticket->name = $user->firstname . ' '. $user->lastname;
        $ticket->email = $user->email;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->priority = $request->priority;
        $ticket->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New support ticket has opened';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $path = imagePath()['ticket']['path'];
        if ($request->hasFile('attachments')) {
            foreach ($files as  $file) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->attachment = uploadFile($file, $path);
                    $attachment->save();
                } catch (\Exception $exp) {
                    $notify[] = ['Could not upload your file'];
                    return response()->json([
                        'message'=>$notify,
                    ])->setStatusCode(400);
                }
            }
        }
        $notify[] = ['ticket created successfully!'];
        return response()->json([
            'message'=>$notify,
        ])->setStatusCode(200);
    }
    public function depositHistory($type = null)
    {
        $logs = auth()->user()->deposits();

        if ($type == 'pending') {
            $logs = $logs->where('status', 2);
        }
        $logs = $logs->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate(40));

        return response()->json([
            'data'=>$logs,
        ])->setStatusCode(200);
    }
    public function withdrawHistory($type = null)
    {
        $withdraws = Withdrawal::where('user_id', auth()->user()->id)->where('status', '!=', 0);
        if($type == 'pending') {
            $withdraws = $withdraws->where('status', 2);
        }
        $withdraws = $withdraws->with('method')->orderBy('id','desc')->paginate(getPaginate(40));

        return response()->json([
            'data'=>$withdraws,
        ])->setStatusCode(200);
    }
    public function milestoneHistory($type = null)
    {
        $withdraws = Milestone::where('user_id', auth()->user()->id);
        if($type == 'pending') {
            $withdraws = $withdraws->where('payment_status', 0);
        }
        $withdraws = $withdraws->orderBy('id','desc')->paginate(getPaginate(40));

        return response()->json([
            'data'=>$withdraws,
        ])->setStatusCode(200);
    }
    public function depositMethods()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return response()->json([
            'data'=>[
                'methods'=>$gatewayCurrency,
                'image_path'=>imagePath()['gateway']['path']
            ],
        ])->setStatusCode(200);
    }
    public function withdrawMethods()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        return response()->json([
            'data'=>[
                'methods'=>$withdrawMethod,
                'image_path'=>imagePath()['gateway']['path']
            ],
        ])->setStatusCode(200);
    }

    public function depositInsert(Request $request){
        $validator = Validator::make($request->all(),[
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }

        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify = 'Invalid gateway';
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify = ['Please follow deposit limit'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $data = new Deposit();
        $data->user_id = $user->id;
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->from_api = 1;
        $data->save();

        if ($data->method_code >= 1000) {
            return response()->json([
                'message'=>['Please Conform manual'],
            ])->setStatusCode(400);
        }

        $dirName = $data->gateway->alias;
        $new = '\\App\\Http\\Controllers\\Gateway\\' . $dirName . '\\ProcessController';

        $data1 = $new::process($data);
        $data1 = json_decode($data1);


        if (isset($data1->error)) {
            $notify = [ $data1->message];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }
        if (isset($data1->redirect)) {
            return response()->json([
                'message'=>[],
                'data'=> ['redirect'=> $data1->redirect_url]
            ])->setStatusCode(200);
        }

        // for Stripe V3
        if(@$data1->session){
            $data->btc_wallet = $data1->session->id;
            $data->save();
        }
        $notify = ['Deposit Created'];
        return response()->json([
            'message'=>$notify,
            'data'=>$data,
        ])->setStatusCode(200);
    }

    public function withdrawStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }
        $method = WithdrawMethod::where('id', $request->method_code)->where('status', 1)->firstOrFail();
        $user = auth()->user();
        if ($request->amount < $method->min_limit) {
            $notify = ['Your requested amount is smaller than minimum amount.'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }
        if ($request->amount > $method->max_limit) {
            $notify = [ 'Your requested amount is larger than maximum amount.'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }
        $user_balance = UserBalance::where('id',auth()->user()->id)->where('currency_sym',$method->currency)->first();
        if( $method->currency == '$' ){
            $user_balance = UserBalance::where('id',auth()->user()->id)->where('currency_sym','USD')->first();
        }
        $bal = $user_balance != null ? $user_balance->balance : 0;
        if ($request->amount > $bal) {
            $notify = ['You do not have sufficient balance for withdraw.'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }

        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge * $method->rate;

        $withdraw = new Withdrawal();
        $withdraw->method_id = $method->id; // wallet method ID
        $withdraw->user_id = $user->id;
        $withdraw->amount = $request->amount;
        $withdraw->currency = $method->currency;
        $withdraw->rate = $method->rate;
        $withdraw->charge = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx = getTrx();
        $withdraw->save();

        return response()->json([
            'message'=>["Success"],
            'withdraw'=> $withdraw
        ])->setStatusCode(200);
    }
    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('id', $request['id'])->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $user = auth()->user();
        // 1 bank
        // 2 crypto
        if($request['type'] == 1){
            $withdraw['withdraw_information'] = ['full_name'=>['field_name'=>$request['name'],'type'=> 'text'],
                'bank_name'=>['field_name'=>$request['bank'],'type'=> 'text'],
                'bank_account_number'=>['field_name'=>$request['account'],'type'=> 'text'],
            ];
        }else{
            $withdraw['withdraw_information'] = ['wallet_id'=>['field_name'=>$request['wallet'],'type'=> 'text'],
                'network'=>['field_name'=>$request['network'],'type'=> 'text'],
            ];
        }
        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();
        $userBalance_find = UserBalance::where('currency_sym', $withdraw->currency)->where('user_id', $user->id)->first();
        if ($userBalance_find) {
            $userBalance_find->balance -= $withdraw->amount;
            $userBalance_find->save();
        }
        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->trx_type = '-';
        $transaction->details = showAmount($withdraw->final_amount) . ' ' . $withdraw->currency . ' Withdraw Via ' . $withdraw->method->name;
        $transaction->trx =  $withdraw->trx;
        $transaction->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New withdraw request from '.$user->username;
        $adminNotification->click_url = urlPath('admin.withdraw.details',$withdraw->id);
        $adminNotification->save();

        notify($user, 'WITHDRAW_REQUEST', [
            'method_name' => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount' => showAmount($withdraw->final_amount),
            'amount' => showAmount($withdraw->amount),
            'charge' => showAmount($withdraw->charge),
            'currency' => $general->cur_text,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($user->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify = ['Withdraw request sent successfully'];
        return  response()->json([
            'message'=> $notify
        ])->setStatusCode(200);;
    }

    public function createMilestone(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'escrow_id' => 'required',
            'amount'    => 'required|numeric|gt:0',
            'note' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }

        $escrow = Escrow::where('buyer_id', auth()->user()->id)->whereNotIn('status', [8, 9])->findOrFail($request->escrow_id);
        $restAmount    = ($escrow->amount + $escrow->buyer_charge) - $escrow->paid_amount;

        if ($request->amount > $restAmount) {
            $notify = ['Your milestone couldn\'t be greater than rest amount'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }

        $milestone            = new Milestone();
        $milestone->escrow_id = $escrow->id;
        $milestone->user_id   = auth()->id();
        $milestone->amount    = $request->amount;
        $milestone->note      = $request->note;
        $milestone->save();

        $notify = ['Milestone created successfully'];
        return response()->json([
            'message'=>$notify,
        ])->setStatusCode(200);
    }
    public function blogs()
    {
        $blogs = Frontend::where('data_keys','blog.element')->latest()->paginate(getPaginate());
        return response()->json([
            'data'=>$blogs,
        ])->setStatusCode(200);
    }

    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        return response()->json([
            'secret'=>$secret,
            'qrCodeUrl'=>$qrCodeUrl,
        ])->setStatusCode(200);
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'key' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_ENABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify = ['Google authenticator enabled successfully'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        } else {
            $notify = [ 'Wrong verification code'];
            return response()->json([
                'message'=>$notify,
            ])->setStatusCode(400);
        }
    }
    public function disable2fa(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->errors()->all(),
            ])->setStatusCode(400);
        }
        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser' => @$osBrowser['browser'],
                'ip' => @$userAgent['ip'],
                'time' => @$userAgent['time']
            ]);
            $notify = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

}
