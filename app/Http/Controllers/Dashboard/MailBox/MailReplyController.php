<?php

namespace App\Http\Controllers\Dashboard\MailBox;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Helpers\Response;
use Illuminate\Http\Request;
use App\Models\Dashboard\MailReply;
use App\Http\Controllers\Controller;
use App\Mail\Dashboard\MailBox\Reply;
use App\Models\Dashboard\Emails;
use App\Models\Dashboard\Mailbox;
use Illuminate\Support\Facades\Mail;

class MailReplyController extends Controller
{


    public function store(Request $request)
    {

        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        // Tokens
        $to        = $request->token_1; // To Email
        $email_id  = $request->token_2; // Email ID
        $mail_id   = $request->token_3; // Mail ID

        try {
            // Un Hash Tokens Key
            $to        = Crypt::decryptString($to);
            $email_id  = Crypt::decryptString($email_id);
            $mail_id   = Crypt::decryptString($mail_id);

            //  Get Mail Row
            $mail = Mailbox::where('id', $mail_id)->count();

            // Check IF This Mail Exist
            if ($mail > 0) {

                // Get Email Row
                $email = Emails::where(['id' => $email_id, 'email' => $to])->first('email');

                // Check IF This Email Exist
                if (!empty($email)) {

                    // Send Reply
                    $send = MailReply::create([
                        'subject' => $request->subject,
                        'message' => $request->message,
                        'mail' => $mail_id,
                        'reply_by' => adminId(),
                        'unix_time' => time(),
                    ]);

                    // IF Send Success
                    if ($send->save()) {

                        // Send To Mail
                        Mail::to($to)->send(new Reply($send));
                        // Succes
                        Response::success('Reply Has Ben Sent', ['json' => false]);
                    }
                } else {
                    // Else This Mails Dos not exist
                    Response::notfound('This Email Notfound !', ['json' => false]);
                }
            } else {
                // Else This Mails Dos not exist
                Response::notfound('This Mail Don\'t Not Exists !', ['json' => false]);
            }
        } catch (DecryptException $e) {
            Response::notfound('Error The transmission data has been tampered with', ['json' => false]);
        }

        return back();
    }


    public function show(MailReply $mailReply,$id)
    {
        $row = $mailReply->find($id);

        if(empty($row)){
            return abort(404);
        }

        return view('dashboard.mailbox.show-reply',compact('row'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailReply  $mailReply
     * @return \Illuminate\Http\Response
     */
    public function edit(MailReply $mailReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MailReply  $mailReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailReply $mailReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailReply  $mailReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailReply $mailReply)
    {
        //
    }
}
