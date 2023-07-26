<?php

namespace App\Http\Controllers;

use App\Mail\RequisitionMail;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail from binary it.com',
            'body'  => 'This is a test mail.'
        ];

        // $userMail = User::findOrFail(auth()->user()->id);
        Mail::to('nazmulislam.bdb@gmail.com')->send(new RequisitionMail($mailData));
    }
}
