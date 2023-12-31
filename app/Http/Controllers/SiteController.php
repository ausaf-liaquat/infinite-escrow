<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        function hexToRgb($hex, $alpha = false) {
            $hex      = str_replace('#', '', $hex);
            $length   = strlen($hex);
            $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
            $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
            $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
            if ( $alpha ) {
               $rgb['a'] = $alpha;
            }
            return $rgb;
        }

        $pageTitle = 'Home';
        $categories = Category::where('status',1)->get();
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();

        return view($this->activeTemplate . 'home', compact('pageTitle','sections','categories'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','contact')->count();

        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'CONTACT';
            $page->slug = 'contact';
            $page->save();
        }
        $pageTitle = "Contact Us";
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','contact')->first();

        return view($this->activeTemplate . 'contact',compact('pageTitle','sections'));
    }
    public function about()
    {
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','about-us')->count();

        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'ABOUT US';
            $page->slug = 'about-us';
            $page->save();
        }
        $pageTitle = "About Us";
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','about-us')->first();

        return view($this->activeTemplate . 'about-us',compact('pageTitle','sections'));
    }


    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blogs()
    {
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'BLOG';
            $page->slug = 'blog';
            $page->save();
        }

        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','blog')->first();
        $pageTitle = 'Blogs';
        $blogs = Frontend::where('data_keys','blog.element')->latest()->paginate(getPaginate());

        return view($this->activeTemplate . 'blogs', compact('pageTitle','blogs','sections'));
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $recentBlogs = Frontend::where('data_keys','blog.element')->latest()->limit(10)->get();
        $pageTitle = 'Blog Details';

        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle','recentBlogs'));
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cookie accepted successfully']);
    }

    public function policyDetails($id,$slug)
    {
        $policyDetails = Frontend::where('data_keys', 'policy_pages.element')->findOrFail($id);
        $pageTitle = $policyDetails->data_values->title;

        return view($this->activeTemplate.'policy',compact('pageTitle', 'policyDetails'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

}
