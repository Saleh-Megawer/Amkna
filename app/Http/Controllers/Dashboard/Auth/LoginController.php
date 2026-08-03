<?php
namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Admin\AdminAttributes;
use App\Models\Dashboard\Admin\AdminPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {

        return view("dashboard.auth.login");
    }

    public function login(Request $request)
    {
        // Inputs
        $email       = $request->email;
        $password    = $request->password;
        $responseMsg = 'خطأ في بيانات الدخول حاول مرة اخري';

        // Check Auth IF Successfully
        if (Auth::guard('admin')->attempt(["email" => $email, 'password' => $password], true)) {

            // Check IF Status Closed
            if (adminAuth('status') > 0) {

                // Admin Attr
                $staticWhere = ['admin_id' => adminId()];

                $adminAttr = AdminAttributes::where($staticWhere)->count();
                if ($adminAttr == 0) {
                    AdminAttributes::create($staticWhere);
                }

                // Admin Port
                $adminPort = AdminPortfolio::where($staticWhere)->count();
                if ($adminPort == 0) {
                    AdminPortfolio::create($staticWhere);
                }


              return redirect(adminUrl("home"));

            } else {
                $responseMsg = 'تم حظر ذلك الحساب لا يمكنك الدخول إلي حسابك';
            }
        }

     
        // ✅ Else Error Login Back WithError Message + Old Input
        return back()
            ->withInput($request->only('email'))
            ->with('error_login', $responseMsg);
    }

}
