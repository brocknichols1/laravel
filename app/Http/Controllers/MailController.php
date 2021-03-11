<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailTool;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class MailController extends Controller
{

    public function sendEmail(Request $request) {

        $email = $request->json()->all();
        try{
            $validator = new EmailValidator();
            $is_valid = $validator->isValid("{$email['email']}", new RFCValidation()); //true
            
            if (!$is_valid) {
                $status = ['success' => false, 'message' => 'Please try again with a valid email address'];
                return response()->json(compact('status'));
            }
            
            Mail::to($email['email'])->send(new MailTool($email));
            $status = ['success' => true, 'message' => 'Your Message has been sent!'];
            
        } catch (Exception $ex) {
            $status = ['success' => false, 'message' => 'Sorry. We could not send your message.'];
        }

        return response()->json(compact('status'));
    }

}
