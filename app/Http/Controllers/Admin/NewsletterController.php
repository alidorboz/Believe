<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NewsletterController extends Controller
{
    public function newsletterSubscribers(){
        Session::put('page','newsletter_subscribers');

        $newsletter_subscribers=NewsletterSubscriber::get()->toArray();
        return view('admin.subscribers.newsletter_subscribers')->with(compact('newsletter_subscribers'));
    }
    public function updateSubscriberStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }
            NewsletterSubscriber::where('id',$data['subscriber_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'subscriber_id'=>$data['subscriber_id']]);
        }
    }
    public function deleteSubscriber($id){
        NewsletterSubscriber::where('id',$id)->delete();
        $message="Subscriber deleted successfully";
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
