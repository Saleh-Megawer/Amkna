<?php
namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    /**
     * عرض صفحة طلب رابط إعادة التعيين
     */
    public function showLinkRequestForm()
    {
        return view("clients.auth.passwords.email", [
            'navbarOptions' => [
                'show' => false,
            ],
            'footerOptions' => [
                'hide' => true,
            ],
        ]);
    }

    /**
     * إرسال رابط إعادة التعيين للبريد الإلكتروني
     */

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Rate Limiting بناءً على IP + Email
        $throttleKey = strtolower($request->email) . '|' . $request->ip();
        $key         = 'password-reset:' . $throttleKey;

        // 3 محاولات كل 60 دقيقة
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);

            return back()->withErrors([
                'email' => "تم تجاوز عدد المحاولات المسموحة. يرجى المحاولة بعد {$minutes} دقيقة.",
            ]);
        }

        $status = Password::broker('clients')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            // تسجيل المحاولة - block لمدة 60 دقيقة
            RateLimiter::hit($key, 3600);

            return back()->with([
                'status' => 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.',
            ]);
        }

        // حتى لو فشل الإرسال، نسجل المحاولة (أمان إضافي)
        RateLimiter::hit($key, 3600);

        return back()->withErrors(['email' => 'حدث خطأ. يرجى المحاولة لاحقاً.']);
    }

    /**
     * عرض صفحة إعادة تعيين كلمة المرور
     */
    public function showResetForm(Request $request, $token)
    {
        return view('clients.auth.passwords.reset', [
            'token'         => $token,
            'email'         => $request->email,
            'navbarOptions' => [
                'show' => false,
            ],
            'footerOptions' => [
                'hide' => true,
            ],
        ]);
    }

    /**
     * حفظ كلمة المرور الجديدة
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // إعادة تعيين كلمة المرور
        $status = Password::broker('clients')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($client, $password) {
                $client->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $client->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('main.clients.login.index')
                ->with('success', 'تم إعادة تعيين كلمة المرور بنجاح! يمكنك الآن تسجيل الدخول.');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

}
