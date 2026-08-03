<?php
namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public $nextUrl;

    public function __construct()
    {
        $this->nextUrl = request('next');
    }

    public function index()
    {

        return view("clients.auth.login", [
            'navbarOptions' => [
                'show' => false,
            ],
            'footerOptions' => [
                'hide' => true,
            ],
        ]);
    }

    public function login(Request $request)
    {
        // 1) Validate required fields with your custom copy
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required'    => msg('auth.login.login_required'),
            'password.required' => msg('auth.login.password_required'),
        ]);

        $rawLogin = (string) $request->login;
        $password = (string) $request->password;

        // 2) Decide if email or phone + normalize phone + format checks (no account disclosure)
        $field = filter_var($rawLogin, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $login = $rawLogin;

        if ($field === 'phone') {
            $digits = preg_replace('/\D/', '', $rawLogin);

            // Reject international-style inputs since you have a country code dropdown
            if (str_starts_with(trim($rawLogin), '+') || str_starts_with($digits, '00')) {
                return back()
                    ->withErrors(['login' => msg('phone.local_only')])
                    ->withInput(['login' => $rawLogin]);
            }

            // Remove ONE leading trunk zero only
            if ($digits !== '' && $digits[0] === '0') {
                $digits = substr($digits, 1);
            }

            // If still empty => invalid format
            if ($digits === '') {
                return back()
                    ->withErrors(['login' => msg('auth.login.login_invalid')])
                    ->withInput(['login' => $rawLogin]);
            }

            $login = $digits;
        }

        // 3) Throttle attempts (no disclosure)
        $ip  = (string) $request->ip();
        $key = Str::lower($rawLogin) . '|' . $ip; // use raw input to keep key stable

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withErrors([
                    'password' => msg('auth.login.throttle', ['seconds' => $seconds]),
                ])
                ->withInput(['login' => $rawLogin]);
        }

        // 4) Attempt login
        $ok = Auth::guard('client')->attempt([$field => $login, 'password' => $password], true);

        if (! $ok) {
            RateLimiter::hit($key, 60); // 5 tries per 60 seconds window

            // Put generic message under password only (better UX, no disclosure)
            return back()
                ->withErrors(['password' => msg('auth.login.invalid_credentials')])
                ->withInput(['login' => $rawLogin]);
        }

        // 5) Success -> clear limiter
        RateLimiter::clear($key);

        // 6) Check banned after successful auth (no disclosure beyond logged-in user)
        $user = Auth::guard('client')->user();

        if ((int) $user->status === 0) {
            Auth::guard('client')->logout();

            return back()
                ->withErrors(['password' => msg('auth.login.banned')])
                ->withInput(['login' => $rawLogin]);
        }

        return redirect(clientUrl(''));
    }

    // Forgot Password View
    public function forgotPassword()
    {
        return view('users.auth.forgot-password');
    }
}
