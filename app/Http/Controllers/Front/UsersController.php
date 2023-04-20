<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SMS;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Session;
use Auth;

class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }
    public function about()
    {
        return view('front.users.about');
    }
    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            //Check if user already exists
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                $message = "E-Mail already exists!";
                session::flash('error_message', $message);
                return redirect()->back();
            } else {
                //Register the User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                // Send Configuration E-Mail
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email'])

                ];
                Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Confirm your Account');
                });

                //Redirect Back with Success Message
                $message = "Please Confirm Your E-Mail to activate your account!!";
                Session::put('success_message', $message);
                return redirect()->back();

                /*  if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                
                //Update User Cart with user id
                if(!empty(Session::get('session_id'))){
                $user_id = Auth::user()->id;
                $session_id= Session::get('session_id');
                Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }
                //Send Register SMS
                //$message="Welcome to the Believe Community! We look forword for a great journey together <3 ";
                $mobile = $data['mobile'];
                SMS::sendSms($message,$mobile);
                // Send Register E-Mail
                $email=$data['email'];
                $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                Mail::send('emails.register',$messageData,function($message) use($email){
                $message->to($email)->subject('Welcome To BELIEVE Community');
                });
                return redirect('cart');
                }*/
            }
        }
    }

    public function confirmAccount($email)
    {
        Session::forget('error_message');
        Session::forget('success_message');
        //Decode User E-Mail
        $email = base64_decode($email);

        //Check User E-Mail exists
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            //User E-Mail is already activated or not
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {
                $message = "Your E-Mail is already activated. You can login";
                Session::put('error_message', $message);
                return redirect('login-register');
            } else {
                //Update User Status to 1 to activate account
                User::where('email', $email)->update(['status' => 1]);
               
                //Send Register SMS
               /* $message="Welcome to the Believe Community! We look forword for a great journey together <3 ";
                $mobile = $userDetails['mobile'];
                SMS::sendSms($message, $mobile);
*/


                // Send Register E-Mail
                $messageData = ['name' => $userDetails['name'], 'mobile' => $userDetails['mobile'], 'email' => $email];
                Mail::send('emails.register', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Welcome To BELIEVE Community');
                });

                //redirect to Login/Register page with Success message
                $message = "Yur E-Mail account is activated. You can login now.";
                Session::put('success_message',$message);
                return redirect('login-register');
            }
        } else {
            abort(404);
        }
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if ($emailCount > 0) {
            return "false";
        } else {
            return "true";
        }
    }
    public function logoutUser()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                //Check E-Mail is activated or not
                $userStatus = User::where('email', $data['email'])->first();
                if ($userStatus->status == 0) {
                    Auth::logout();
                    $message = "Your account is not activated yet! Please Confirm your E-Mail to activate !";
                    Session::put('error_message', $message);
                    return redirect()->back();
                }
                //Update User Cart with user id
                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id' => $user_id]);
                }

                return redirect('/cart');
            } else {
                $message = "Invalid Username OR Password";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    public function forgotPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request ->all();
            $emailCount = User::where('email',$data['email'])->count();
            if($emailCount == 0){
                $message= "E-Mail does not exists!";
                Session::put('error_message','Email does not exists!');
                Session::forget('success_message');
                return redirect()->back();
            }

            //Generate Random Password
             $random_password = str_random(8); 
            // Encode/Secure Password 
            $new_password= bcrypt($random_password);
            //Update Password
            User::where('email',$data['email'])->update(['password'=>$new_password]);

            //Get User Name
            $userName = User::select('name')->where('email',$data['email'])->first();

            //Send Forgot Password
            $email = $data['email'];
            $name=$userName->name;
            $messageData = [
                'email'=>$email,
                'name' => $name,
                'password'=>$random_password 
            ];
            Mail::send('emails.forgot_password',$messageData,function($message)use($email){
                $message->to($email)->subject('New Password --- Believe');
            });
            //Redirect to Login/Register Page with Success message
            $message = "Please Check Your E-Mail for the new password";
            Session::put('success_message',$message);
            Session::forget('error_message');
            return redirect('login-register');

        }
        return view('front.users.forgot_password');
    }
    public function account(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();
        if($request->isMethod('post')){
            $data= $request->all();
            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            $message = "Your account details has been updated successfully";
            Session::put('success_message',$message);
            Session::forget('error_message');
            return redirect()->back();
        }
        return view('front.users.account')->with(compact('userDetails'));
    }
    public function chkUserPassword(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
            $user_id=Auth::User()->id;
            $chkPassword = User::select('password')->where('id',$user_id)->first();
            if(Hash::check($data['current_password'], $chkPassword->password)){
                return "true";
            }else{
                return "false";
            }
        }
    }
    public function updateUserPassword(Request $request){
        if($request->isMethod('post')){
            $data= $request->all();
            $user_id=Auth::User()->id;
            $chkPassword = User::select('password')->where('id',$user_id)->first();
            if(Hash::check($data['current_password'], $chkPassword->password)){
                //Update
                $new_password = bcrypt($data['new_password']);
                User::where('id',$user_id)->update(['password'=>$new_password]);
                $message = "Password updated successfully!";
                Session::put('success_message',$message);
                Session::forget('error_message');
                return redirect()->back();
            }else{
                $message = "Incorrect Current Password!";
                Session::put('error_message',$message);
                Session::forget('success_message');
                return redirect()->back();
            }
        }
    }
}