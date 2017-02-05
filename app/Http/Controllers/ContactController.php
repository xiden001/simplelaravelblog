<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    //
    public function index(){
        return view('contact');
    }

    public function saveMessage(Request $request){

        //get post info and save thru ORm
        //also send as email to gmail account

        $input['name'] = $request->input('name');
        $input['email'] = $request->input('email');
        $input['phone_number'] = $request->input('phone');
        $input['message'] = $request->input('message');

        Contact::create($input);

        return redirect('/contact')->with('status', ' Your message has been sent successfully!!');
    }
}
