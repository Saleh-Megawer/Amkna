<?php
namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Models\Dashboard\Emails;
use App\Models\Dashboard\Mailbox;
use App\Models\Dashboard\Settings;
use App\Models\Ips;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{

    //
    public function index(Settings $settings)
    {

        $ip = request()->ip();

        // Get from db
        $ipRow = Ips::where('ip', $ip)->first('status');

        if ($ipRow != null) {
            if ($ipRow->status == '0') {
                return abort(403);
            }
        }
        $navbarOptions = [
            'theme'     => 'transparent-bg-with-white-links',
            'fixed_top' => 'absolute',
        ];

        $phoneExplode = explode('|', config('settings.contact.phone'));
        $phone        = isset($phoneExplode[0]) ? $phoneExplode[0] : null;

        $emailExplode = explode('|', config('settings.contact.email'));
        $email        = isset($emailExplode[0]) ? $emailExplode[0] : null;

        //

        // $links = array_values(array_filter(config('settings.social')));

        $googleMapIframe = Settings::first(['google_map_address_embed'])?->google_map_address_embed;

        return view('main.contact', compact('phone', 'email', 'navbarOptions', 'googleMapIframe'));
    }

    public function store(Request $request)
    {

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => '6Lf-UIIsAAAAAI2iBHgP-sIIUQ7UeTfsig_ksWRD',
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (! ($result['success'] ?? false)) {
            return Response::warning(lang() == 'ar' ? 'فشل التحقق من الكابتشا، يرجى المحاولة مرة أخرى.' : 'Captcha verification failed, please try again.', [
                'style' => 'toastr',
            ]);
        }

        $request->validate([
            'name'    => 'required|min:2|max:65',
            'email'   => 'required|max:255|email',
            'phone'   => 'required|numeric|digits_between:9,15',
            'subject' => 'required|min:10|max:255',
            'message' => 'required|min:25|max:10000',
        ]);

        // Form Inputs
        $email   = $request->email;
        $phone   = $request->phone;
        $name    = $request->name;
        $subject = $request->subject;
        $message = $request->message;

        // Check IF This Mail Exist In Emails Tabel in DB
        $rowEmail = Emails::updateOrCreate(['email' => $email], ['email' => $email]);

        // Insert Message
        $insert = Mailbox::create([
            'from'      => $rowEmail->id,
            'name'      => $name,
            'phone'     => $phone,
            'subject'   => $subject,
            'message'   => $message,
            'unix_time' => time(),
        ]);

        $rowEmail = Ips::updateOrCreate(['ip' => request()->ip()], [
            'ip'      => request()->ip(),
            'mail_id' => $insert->id,
        ]);

        return Response::success(
            lang() == 'ar'
                ? 'تم إرسال رسالتك بنجاح، وسنقوم بالرد عليك في أقرب وقت ممكن.'
                : 'Your message has been sent successfully. We will get back to you as soon as possible.',
            [
                'style'    => 'toastr',
                'reset'    => true,
                'reload'   => true,
                'time_out' => 3,
            ]
        );

    }
}
