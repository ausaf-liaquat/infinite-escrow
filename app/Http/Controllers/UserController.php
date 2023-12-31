<?php

namespace App\Http\Controllers;

use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Escrow;
use App\Models\GeneralSetting;
use App\Models\Transaction;
use App\Models\WithdrawMethod;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Milestone;
use App\Models\User;
use App\Models\UserBalance;

class UserController extends Controller
{
    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }

    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $escrow = $escrows = Escrow::where(function($query){
            $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        });

        $escrow1 = clone $escrow;
        $escrow2 = clone $escrow;
        $escrow3 = clone $escrow;
        $escrow4 = clone $escrow;
        $escrow5 = clone $escrow;
        $escrow6 = clone $escrow;

        $totalEscrow = $escrow1->count();
        $accepted = $escrow2->where('status',2)->count();
        $notAccepted = $escrow3->where('status',0)->count();
        $completed = $escrow4->where('status',1)->count();
        $cancelled = $escrow5->where('status',9)->count();
        $disputed = $escrow6->where('status',8)->count();
        $latestTransactions = Transaction::where('user_id',auth()->id())->latest()->limit(10)->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle','user','escrow','accepted','notAccepted','completed','cancelled','disputed','totalEscrow', 'latestTransactions'));
    }

    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = Auth::user();
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCode = $user->country_code;
        $dialCode = $countryData->$countryCode->dial_code;
        return view($this->activeTemplate. 'user.profile_setting', compact('pageTitle','user','dialCode'));
    }

    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'address' => 'sometimes|required|max:80',
            'state' => 'sometimes|required|max:80',
            'zip' => 'sometimes|required|max:40',
            'city' => 'sometimes|required|max:50',
            'image' => ['image',new FileTypeValidate(['jpg','jpeg','png'])]
        ],[
            'firstname.required'=>'First name field is required',
            'lastname.required'=>'Last name field is required'
        ]);

        $user = Auth::user();

        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;

        $in['address'] = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];


        if ($request->hasFile('image')) {
            $location = imagePath()['profile']['user']['path'];
            $size = imagePath()['profile']['user']['size'];
            $filename = uploadImage($request->image, $location, $size, $user->image);
            $in['image'] = $filename;
        }
        $user->fill($in)->save();
        $notify[] = ['success', 'Profile updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $password_validation = Password::min(6);
        $general = GeneralSetting::first();
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required','confirmed',$password_validation]
        ]);


        try {
            $user = auth()->user();
            if (Hash::check($request->current_password, $user->password)) {
                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                $notify[] = ['success', 'Password changes successfully.'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
        } catch (\PDOException $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }
    }

    /*
     * Deposit History
     */
    public function depositHistory($type = null)
    {
        $pageTitle = 'Deposit History';
        $emptyMessage = 'No history found.';
        $logs = auth()->user()->deposits();

        if ($type == 'pending') {
            $logs = $logs->where('status', 2);
            $pageTitle = 'Pending Deposits';
        }
        $logs = $logs->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'emptyMessage', 'logs'));
    }

    /*
     * Withdraw Operation
     */

    public function withdrawMoney()
    {
        $withdrawMethod = WithdrawMethod::where('status',1)->get();
        $pageTitle = 'Withdraw Money';
        return view($this->activeTemplate.'user.withdraw.methods', compact('pageTitle','withdrawMethod'));
    }

    public function withdrawStore(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'method_code' => 'required',
            'amount'      => 'required|numeric'
        ]);
       $method  = WithdrawMethod::where('currency', $request->currency_symbol)->where('status', 1)->firstOrFail();
       $user    = auth()->user();
       $balance = auth()->user()->userBalance->where('currency_sym',$request->currency_symbol)->first()?->balance??0;

        // dd($balance);
        if (empty($method)) {
            $notify[] = ['error', 'Add withdrawal method for this currency.'];
            return back()->withNotify($notify);
        }
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount.'];
            return back()->withNotify($notify);
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount.'];
            return back()->withNotify($notify);
        }

        if ($request->amount > $balance) {
            $notify[] = ['error', 'You do not have sufficient balance for withdraw.'];
            return back()->withNotify($notify);
        }

        $charge      = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;
        $finalAmount = $afterCharge;
        // $finalAmount = $afterCharge * $method->rate;

        $withdraw               = new Withdrawal();
        $withdraw->method_id    = $method->id;        // wallet method ID
        $withdraw->user_id      = $user->id;
        $withdraw->amount       = $request->amount;
        $withdraw->currency     = $method->currency;
        $withdraw->rate         = $method->rate;
        $withdraw->charge       = $charge;
        $withdraw->final_amount = $finalAmount;
        $withdraw->after_charge = $afterCharge;
        $withdraw->trx          = getTrx();
        $withdraw->save();
        session()->put(['wtrx'=>$withdraw->trx,'balance'=>$balance]);

        return redirect()->route('user.withdraw.preview');
    }

    public function withdrawPreview()
    {
        // dd(session()->all());
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        $balance = session()->get('balance');
        return view($this->activeTemplate . 'user.withdraw.preview', compact('pageTitle','withdraw','balance'));
    }

    public function withdrawSubmit(Request $request)
    {
        $general = GeneralSetting::first();
        $withdraw = Withdrawal::with('method','user')->where('trx', session()->get('wtrx'))->where('status', 0)->orderBy('id','desc')->firstOrFail();

        $rules = [];
        $inputField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($withdraw->method->user_data as $key => $cus) {
                $rules[$key] = [$cus->validation];
                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], new FileTypeValidate(['jpg','jpeg','png']));
                    array_push($rules[$key], 'max:2048');
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:300');
                }
                $inputField[] = $key;
            }
        }

        $this->validate($request, $rules);

        $user = auth()->user();
        if ($user->ts) {
            $response = verifyG2fa($user,$request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify);
            }
        }
        $userBalance_find = UserBalance::where('currency_sym', $withdraw->currency)->where('user_id', $user->id)->first();
        $balance = auth()->user()->userBalance->where('currency_sym',$withdraw->currency)->first()?->balance??0;
        if ($withdraw->amount > $balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify);
        }

        $directory = date("Y")."/".date("m")."/".date("d");
        $path = imagePath()['verify']['withdraw']['path'].'/'.$directory;
        $collection = collect($request);
        $reqField = [];
        if ($withdraw->method->user_data != null) {
            foreach ($collection as $k => $v) {
                foreach ($withdraw->method->user_data as $inKey => $inVal) {
                    if ($k != $inKey) {
                        continue;
                    } else {
                        if ($inVal->type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $reqField[$inKey] = [
                                        'field_name' => $directory.'/'.uploadImage($request[$inKey], $path),
                                        'type' => $inVal->type,
                                    ];
                                } catch (\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $reqField[$inKey] = $v;
                            $reqField[$inKey] = [
                                'field_name' => $v,
                                'type' => $inVal->type,
                            ];
                        }
                    }
                }
            }
            $withdraw['withdraw_information'] = $reqField;
        } else {
            $withdraw['withdraw_information'] = null;
        }


        $withdraw->status = 2;
        $withdraw->save();
        $user->balance  -=  $withdraw->amount;
        $user->save();
        
        if ($userBalance_find) {
            $userBalance_find->balance -= $withdraw->amount;
            $userBalance_find->save();
        } 


        $transaction = new Transaction();
        $transaction->user_id = $withdraw->user_id;
        $transaction->amount = $withdraw->amount;
        $transaction->post_balance = $userBalance_find->balance;
        $transaction->charge = $withdraw->charge;
        $transaction->currency_sym = $withdraw->currency;
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
            'currency' =>  $withdraw->currency,
            'rate' => showAmount($withdraw->rate),
            'trx' => $withdraw->trx,
            'post_balance' => showAmount($userBalance_find->balance),
            'delay' => $withdraw->method->delay
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return redirect()->route('user.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog($type = null)
    {
        $pageTitle = "Withdraw Log";
        $withdraws = Withdrawal::where('user_id', Auth::id())->where('status', '!=', 0);
        if($type == 'pending') {
            $withdraws = $withdraws->where('status', 2);
            $pageTitle = "Pending Withdrawals";
        }
        $withdraws = $withdraws->with('method')->orderBy('id','desc')->paginate(getPaginate());
        $emptyMessage = "No Data Found!";

        return view($this->activeTemplate.'user.withdraw.log', compact('pageTitle','withdraws','emptyMessage'));
    }



    public function show2faForm()
    {
        $general = GeneralSetting::first();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->sitename, $secret);
        $pageTitle = 'Two Factor';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
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
            $notify[] = ['success', 'Google authenticator enabled successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }


    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user     = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = 0;
            $user->save();
            $userAgent = getIpInfo();
            $osBrowser = osBrowser();
            notify($user, '2FA_DISABLE', [
                'operating_system' => @$osBrowser['os_platform'],
                'browser'          => @$osBrowser['browser'],
                'ip'               => @$userAgent['ip'],
                'time'             => @$userAgent['time']
            ]);
            $notify[] = ['success', 'Two factor authenticator disable successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(){
        $pageTitle    = 'Transactions';
        $emptyMessage = 'Transactions not found';
        $transactions = Transaction::where('user_id',auth()->user()->id)->orderBy('id','desc')->paginate(getPaginate());

        return view($this->activeTemplate.'user.transactions',compact('pageTitle','transactions','emptyMessage'));
    }

    public function CurrencyExchange(Request $request)
    {
        $user = auth()->user();
        // $escrow = $escrows = Escrow::where(function($query){
        //     $query->orWhere('buyer_id',auth()->user()->id)->orWhere('seller_id',auth()->user()->id);
        // });

        // $escrow1 = clone $escrow;
        // $escrow2 = clone $escrow;
        // $escrow3 = clone $escrow;
        // $escrow4 = clone $escrow;
        // $escrow5 = clone $escrow;
        // $escrow6 = clone $escrow;
        
        $userBalance = UserBalance::where('user_id',auth()->user()->id)->where('currency_sym',$request->currency)->first();

        $balanceAmount       = $userBalance?$userBalance->balance??0:0;
        $depositAmount_total = $user->deposits->where('status',1)->where('method_currency',$request->currency)->sum('amount');

        $withdrawAmount_total        = $user->withdrawals->where('status',1)->where('currency',$request->currency)->sum('amount');
        $depositAmountPending_total  = $user->deposits->where('status',2)->where('currency_sym',$request->currency)->sum('amount');
        $withdrawAmountPending_total = $user->withdrawals->where('status',2)->where('currency',$request->currency)->sum('amount');
        $milestoneAmount_total       = Milestone::where('user_id',$user->id)->whereHas('escrow',function ($q) use($request)
        {
            $q->where('currency_sym',$request->currency);
        })->where('payment_status',1)->sum('amount');
        $user->milestones->where('payment_status',1)->sum('amount');
      
   
        $data=[
            'balanceAmount'               => number_format($balanceAmount,2)??0,
            'depositAmount_total'         => number_format($depositAmount_total,2)??0,
            'withdrawAmount_total'        => number_format($withdrawAmount_total,2)??0,
            'depositAmountPending_total'  => number_format($depositAmountPending_total,2)??0,
            'withdrawAmountPending_total' => number_format($withdrawAmountPending_total,2)??0,
            'milestoneAmount_total'       => number_format($milestoneAmount_total,2)??0,
            'sym'                         => $request->currency,
  
        ];
        return $data;
    }
}
