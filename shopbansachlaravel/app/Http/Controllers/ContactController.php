<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function view_contact(Request $request){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $meta_desc = "Liên hệ với cửa hàng sách Fahasa";
        $meta_keywords = "lien he,liên hệ";
        $meta_title = "Liên hệ với chúng tôi";
        $url_canonical = $request->url();

        return view('pages.contact.view_contact')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }

    public function send_contact(Request $request){
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|regex:/^0[0-9]{9}$/',
            'contact_subject' => 'required|string|max:255',
            'contact_message' => 'required'
        ]);

        $contact = [
            'contact_name' => strip_tags($request->contact_name),
            'contact_email' => strip_tags($request->contact_email),
            'contact_phone' => strip_tags($request->contact_phone),
            'contact_subject' => strip_tags($request->contact_subject),
            'contact_message' => strip_tags($request->contact_message)
        ];        

        try {
            Mail::to('toramhatsunemiku69@gmail.com')->send(new ContactMail($contact));
            return redirect('/lien_he')->with('success', 'Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất có thể.');
        } catch (\Exception $e) {
            Log::error("Lỗi gửi email: " . $e->getMessage());
            return redirect('/lien_he')->with('error', 'Đã có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.');
        }
    }
}
