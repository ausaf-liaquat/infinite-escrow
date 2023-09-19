<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Deposit;
use App\Models\Escrow;
use App\Models\Milestone;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Models\Transaction;
use App\Models\UserBalance;

class AdminController extends Controller
{

    public function dashboard()
    {

        $pageTitle = 'Dashboard';

        // User Info
        $widget['total_users'] = User::count();
        $widget['verified_users'] = User::where('status', 1)->count();
        $widget['email_unverified_users'] = User::where('ev', 0)->count();
        $widget['sms_unverified_users'] = User::where('sv', 0)->count();

        // Monthly Deposit & Withdraw Report Graph
        $report['months'] = collect([]);
        $report['deposit_month_amount'] = collect([]);
        $report['withdraw_month_amount'] = collect([]);


        $depositsMonth = Deposit::where('created_at', '>=', Carbon::now()->subYear())
            ->where('status', 1)
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as depositAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();

        $depositsMonth->map(function ($depositData) use ($report) {
            $report['months']->push($depositData->months);
            $report['deposit_month_amount']->push(showAmount($depositData->depositAmount));
        });
        $withdrawalMonth = Withdrawal::where('created_at', '>=', Carbon::now()->subYear())->where('status', 1)
            ->selectRaw("SUM( CASE WHEN status = 1 THEN amount END) as withdrawAmount")
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
            ->orderBy('created_at')
            ->groupBy('months')->get();
        $withdrawalMonth->map(function ($withdrawData) use ($report){
            if (!in_array($withdrawData->months,$report['months']->toArray())) {
                $report['months']->push($withdrawData->months);
            }
            $report['withdraw_month_amount']->push(showAmount($withdrawData->withdrawAmount));
        });

        $months = $report['months'];

        for($i = 0; $i < $months->count(); ++$i) {
            $monthVal      = Carbon::parse($months[$i]);
            if(isset($months[$i+1])){
                $monthValNext = Carbon::parse($months[$i+1]);
                if($monthValNext < $monthVal){
                    $temp = $months[$i];
                    $months[$i]   = Carbon::parse($months[$i+1])->format('F-Y');
                    $months[$i+1] = Carbon::parse($temp)->format('F-Y');
                }else{
                    $months[$i]   = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }

        // Withdraw Graph
        $withdrawal = Withdrawal::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->where('status', 1)
            ->selectRaw('sum(amount) as totalAmount')
            ->selectRaw('DATE(created_at) day')
            ->groupBy('day')->get();

        $withdrawals['per_day'] = collect([]);
        $withdrawals['per_day_amount'] = collect([]);
        $withdrawal->map(function ($withdrawItem) use ($withdrawals) {
            $withdrawals['per_day']->push(date('d M', strtotime($withdrawItem->day)));
            $withdrawals['per_day_amount']->push($withdrawItem->totalAmount + 0);
        });


        // Deposit Graph
        $deposit = Deposit::where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->where('status', 1)
            ->selectRaw('sum(amount) as totalAmount')
            ->selectRaw('DATE(created_at) day')
            ->groupBy('day')->get();
        $deposits['per_day'] = collect([]);
        $deposits['per_day_amount'] = collect([]);
        $deposit->map(function ($depositItem) use ($deposits) {
            $deposits['per_day']->push(date('d M', strtotime($depositItem->day)));
            $deposits['per_day_amount']->push($depositItem->totalAmount + 0);
        });


        // user Browsing, Country, Operating Log
        $userLoginData = UserLogin::where('created_at', '>=', \Carbon\Carbon::now()->subDay(30))->get(['browser', 'os', 'country']);

        $chart['user_browser_counter'] = $userLoginData->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_os_counter'] = $userLoginData->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });
        $chart['user_country_counter'] = $userLoginData->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);


        $payment['total_deposit_amount'] = 0;
        $payment['total_deposit_charge'] = 0;
        $payment['total_deposit_pending'] = 0;

        $paymentWithdraw['total_withdraw_amount'] = 0;
        $paymentWithdraw['total_withdraw_charge'] = 0;
        $paymentWithdraw['total_withdraw_pending'] = 0;

        $totalEscrows = 0;
        $disputedEscrows = 0;
        $cancelledEscrows = 0;
        $escrowFund = 0;
        // $payment['total_deposit_amount'] = Deposit::where('status',1)->sum('amount');
        // $payment['total_deposit_charge'] = Deposit::where('status',1)->sum('charge');
        // $payment['total_deposit_pending'] = Deposit::where('status',2)->count();

        // $paymentWithdraw['total_withdraw_amount'] = Withdrawal::where('status',1)->sum('amount');
        // $paymentWithdraw['total_withdraw_charge'] = Withdrawal::where('status',1)->sum('charge');
        // $paymentWithdraw['total_withdraw_pending'] = Withdrawal::where('status',2)->count();

        // $totalEscrows = Escrow::where('status',1)->sum('amount');
        // $disputedEscrows = Escrow::where('status',8)->sum('amount');
        // $cancelledEscrows = Escrow::where('status',9)->sum('amount');
        // $escrowFund = Milestone::where('payment_status',1)->sum('amount');

        return view('admin.dashboard', compact('pageTitle', 'widget', 'report', 'withdrawals', 'chart','payment','paymentWithdraw','depositsMonth','withdrawalMonth','months','deposits','totalEscrows','disputedEscrows','cancelledEscrows','escrowFund'));
    }


    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => ['nullable','image',new FileTypeValidate(['jpg','jpeg','png'])]
        ]);
        $user = Auth::guard('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, imagePath()['profile']['admin']['path'], imagePath()['profile']['admin']['size'], $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $pageTitle = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password do not match !!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return redirect()->route('admin.password')->withNotify($notify);
    }

    public function notifications(){
        $notifications = AdminNotification::orderBy('id','desc')->with('user')->paginate(getPaginate());
        $pageTitle = 'Notifications';
        return view('admin.notifications',compact('pageTitle','notifications'));
    }


    public function notificationRead($id){
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }

    public function requestReport()
    {
        $pageTitle = 'Your Listed Report & Request';
        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $url = "https://license.viserlab.com/issue/get?".http_build_query($arr);
        $response = json_decode(curlContent($url));
        if ($response->status == 'error') {
            return redirect()->route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports',compact('reports','pageTitle'));
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'type'=>'required|in:bug,feature',
            'message'=>'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name'] = systemDetails()['name'];
        $arr['app_url'] = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $arr['req_type'] = $request->type;
        $arr['message'] = $request->message;
        $response = json_decode(curlPostContent($url,$arr));
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success',$response->message];
        return back()->withNotify($notify);
    }

    public function systemInfo(){
        $laravelVersion = app()->version();
        $serverDetails = $_SERVER;
        $currentPHP = phpversion();
        $timeZone = config('app.timezone');
        $pageTitle = 'System Information';
        return view('admin.info',compact('pageTitle', 'currentPHP', 'laravelVersion', 'serverDetails','timeZone'));
    }

    public function readAll(){
        AdminNotification::where('read_status',0)->update([
            'read_status'=>1
        ]);
        $notify[] = ['success','Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function currencyChange(Request $request)
    {
       $data_totalEscrow= Escrow::where('status',1)->where('currency_sym',$request->currency)->sum('amount');
        $data_exchangeEscrow_fund= Milestone::where('payment_status',1)->where('currency',$request->currency)->sum('amount');
        $data_cancelledEscrows= Escrow::where('status',9)->where('currency_sym',$request->currency)->sum('amount');
        $data_disputedEscrows= Escrow::where('status',8)->where('currency_sym',$request->currency)->sum('amount');
        $totalDepositAmount= Deposit::where('status',1)->where('method_currency',$request->currency)->sum('amount');
        $totalDepositAmount_charge= Deposit::where('status',1)->where('method_currency',$request->currency)->sum('charge');
        $totalWithdrawAmount= Withdrawal::where('status',1)->where('currency',$request->currency)->sum('amount');
        $totalWithdrawAmount_charge= Withdrawal::where('status',1)->where('currency',$request->currency)->sum('charge');
   
        $data=[
            'data_totalEscrow'=>$data_totalEscrow??0,
            'data_exchangeEscrow_fund'=>$data_exchangeEscrow_fund??0,
            'data_cancelledEscrows'=>$data_cancelledEscrows??0,
            'data_disputedEscrows'=>$data_disputedEscrows??0,

            'totalDepositAmount'=>$totalDepositAmount??0,
            'totalDepositAmount_charge'=>$totalDepositAmount_charge??0,
            'totalWithdrawAmount'=>$totalWithdrawAmount??0,
            'totalWithdrawAmount_charge'=>$totalWithdrawAmount_charge??0,
            'sym'=>$request->currency,
  
        ];
        return $data;
    }
    public function currencyUserChange(Request $request)
    {
      
        
        $totalDepositAmount= Deposit::where('status',1)->where('user_id',$request->userID)->where('method_currency',$request->currency)->sum('amount');
        $totalWithdrawAmount= Withdrawal::where('status',1)->where('user_id',$request->userID)->where('currency',$request->currency)->sum('amount');
        $totalTransaction= Transaction::where('user_id',$request->userID)->where('currency_sym',$request->currency)->count();
        $userBalance_find = UserBalance::where('currency_sym', $request->currency)->where('user_id', $request->userID)->first();
        $balance =  $userBalance_find?->balance ?? 0;
        $data=[
            'totalDepositAmount'=>number_format($totalDepositAmount,2)??0,
            'totalWithdrawAmount'=>number_format($totalWithdrawAmount,2)??0,
            'totalTransaction'=>$totalTransaction,
            'totalBalance'=>number_format($balance).' ' .$request->currency,
            'sym'=>$request->currency, 
        ];
        return $data;
    }
}
