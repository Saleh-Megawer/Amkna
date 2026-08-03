<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ClientVerifyEmail;
use App\Models\Dashboard\Crm\Client\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    /**
     * Send verification email
     */
    public function send()
    {
        $client = client();

        // لو متحقق خلاص
        if ($client->email_verified_at === '1') {
            return back();
        }

        $url = URL::temporarySignedRoute(
            'main.clients.email.verify',
            now()->addMinutes(30),
            [
                'client' => $client->id,
                'hash'   => sha1($client->email),
            ]
        );

        Mail::to($client->email)->send(new ClientVerifyEmail($url));

        return back()->with(
            'success-send-email',
            __('client.email.verification_sent')
        );
    }

    /**
     * Verify email
     */
    public function verify($clientId, $hash)
    {
        $client = Client::findOrFail($clientId);

        // تحقق من الهاش
        if (! hash_equals(sha1($client->email), $hash)) {
            abort(403);
        }

        // فعل البريد
        $client->update([
            'email_verified_at' => now(),
        ]);

        return redirect(clientUrl(''))
            ->with('success', __('client.email.verified_successfully'));
    }
}
