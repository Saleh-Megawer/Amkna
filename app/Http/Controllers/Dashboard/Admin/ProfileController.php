<?php
namespace App\Http\Controllers\Dashboard\Admin;

use App\Helpers\File;
use App\Helpers\Response;
use App\Helpers\RoleHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Admin\PortfolioController;
use App\Mail\Dashboard\Admin\ResetPassword;
use App\Mail\Dashboard\Admin\VerifyEmail;
use App\Models\Dashboard\Admin\AdminAttributes;
use App\Models\Dashboard\Admin\AdminJobExperience;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProfileController extends Controller
{

    use AdminHelpers;

    public function __construct()
    {
        $this->middleware(['permission:show_another_admins_profile'], ['only' => 'show']);
        $this->middleware(['role:' . owner()], ['only' => 'changeRoles']);

    }

    // Show Profile
    public function show($id = null)
    {

        if ($id == null || $id == adminId()) {
            $row         = auth(adminGuardName())->user();
            $isMyProfile = true;
        } else {
            $row         = DB::table($this->table())->where('id', '!=', 1)->where('id', $id)->first();
            $isMyProfile = false;
        }

        // Check if exist this admin
        if (empty($row)) {
            return abort(404);
        }

        // // Check IF Auth ID Not Equal Request ID Check IF Have Permission For Open This Page
        // if ($row->id != adminId()) {
        //     // Check if have permission
        //     if (! canPermission('view admins profile')) {
        //         return abort(403, 'You do not have permission to visit this page');
        //     }
        // }

        //
        $this->createAdminTables($row->id);

        // Get Portfolio Controller
        $portfolioController = new PortfolioController;

        // Get Roles
        $roles = $this->adminRoles($row->id);

        return view('dashboard.admin.profile.show', [
            'isMyProfile' => $isMyProfile,
            'row'         => $row,
            'portfolio'   => $portfolioController->getPortfolio($row->id),
            'coverPath'   => $this->cover($row->cover),
            'avatarPath'  => $this->avatar($row->avatar),
            'roles'       => $roles,
        ]);
    }

    // Edit Profile
    public function edit(AdminJobExperience $adminJobExperience, PortfolioController $portfolioController, $id = null)
    {
                                         // Check IF Have Perfix Admins Or Profile In Url
        $prefix = request()->segment(2); // Get Url Perfix Like ( admins , profile )

        // Check IF Url Prefix Equla Admins For Edit
        if ($prefix === 'admins') {
            // Check IF ID Equal Auth Admin ID
            if (intval($id) === adminId()) {
                // IF Url ID Equal Admin Auth Go Redirect
                return redirect(adminUrl('profile/edit'));
            } else {
                // Other Admins
                $row = DB::table($this->table())->where('id', $id)->first();

                // Check IF This Row Exist IN DB
                if (empty($row)) {
                    return abort('404');
                }
            }
        } else {
            $row = auth(adminGuardName())->user();
        }

        //
        $this->createAdminTables($row->id);

        // Admin ID Input Properties
        $inputId = [
            'input' => [
                'type'  => 'hidden',
                'name'  => 'id',
                'value' => Crypt::encryptString($row->id),
            ],
        ];

        // Roles
        $roles = RoleHelper::getAvailableRoles()->pluck('name', 'name')->all();

        $userRole = $this->model()->find($row->id)->roles->pluck('name', 'name')->all();

        // Return View And Data
        return view('dashboard.admin.profile.edit', [
            'row'         => $row,
            'inputId'     => $inputId,
            'avatarPath'  => $this->avatar($row->avatar),
            'coverPath'   => $this->cover($row->cover),
            'years'       => array_reverse($this->yearsList()),
            'experiences' => DB::table($adminJobExperience->table)->where('admin_id', $row->id)->get(), // Get Admin Job Exp
            'admin'       => $this->adminAttr($row->id, ['email_verified']),
            'portfolio'   => $portfolioController->getPortfolio($row->id),
            'roles'       => $roles,
            'hasRoles'    => $userRole,
        ]);
    }

    // Profile Image
    public function updateProfileAvatar()
    {
        // Request ID
        $id = $this->getAdminIdFromRequest();

        request()->validate([
            'avatar' => 'required|max:5120|mimes:' . mimesType('image'),
        ]);

        $fileName = File::upload('avatar', [
            'path'      => $this->avatarPath,
            'hash'      => $this->hash,
            'extension' => $this->extension,
            'delete'    => adminAuth('avatar'),
            'small'     => '164*164',
        ]);

        // Update Avatar Column In DB
        $update = $this->model()->where('id', $id)->update(['avatar' => $fileName]);

        if ($update > 0) {
            return Response::success(dbTrans('admin.Profile avatar has been updated successfully'), [
                'style' => 'toastr',
                'reset' => true,
            ]);
        } else {
            return Response::warning(dbTrans('admin.Something went wrong while updating the image, try again'), [
                'style' => 'toastr',
                'reset' => true,
            ]);
        }
    }

    // Profile Cover
    public function updateProfileCover()
    {

        // Request ID
        $id = $this->getAdminIdFromRequest();

        request()->validate([
            'cover' => 'required',
        ]);

        $coverInput = request('cover');

        if (! in_array($coverInput->getClientOriginalExtension(), ["jpeg", "jpg", "png", "webp", "bmp", "tiff", "svg"])) {
            return Response::warning(dbTrans('admin.This cover extension is not allowed'), [
                'style' => 'toastr',
                'reset' => true,
            ]);
        }

        if (10485760 <= $coverInput->getSize()) {
            return Response::warning(dbTrans('admin.The cover image is too big') . ' 10MP', [
                'style' => 'toastr',
                'reset' => true,
            ]);
        }

        $fileName = File::upload('cover', [
            'path'      => $this->coverPath,
            'hash'      => $this->hash,
            'extension' => $this->extension,
            'delete'    => adminAuth('cover'),
            'large'     => '1920*1080',
            'small'     => '640*240',
        ]);

        // Update cover Column In DB
        $update = $this->model()->where('id', $id)->update(['cover' => $fileName]);

        if ($update > 0) {
            return Response::success(dbTrans('admin.Profile cover has been updated successfully'), [
                'style' => 'toastr',
                'reset' => true,
            ]);
        } else {
            return Response::warning(dbTrans('admin.Something went wrong while updating the image, try again'), [
                'style' => 'toastr',
                'reset' => true,
            ]);
        }
    }

    // Personal Data
    public function updatePersonalData(Request $request, AdminAttributes $adminAttributes)
    {

        // Request ID
        $id = $this->getAdminIdFromRequest();

        // Validate Row
        $data = $request->validate([
            'f_name'       => 'required|max:20|min:2',
            'l_name'       => 'required|max:20|min:2',
            'email'        => 'required|email|max:255|unique:' . $this->table() . ',email,' . $id,
            'phone'        => 'required|numeric|digits_between:6,14|unique:' . $this->table() . ',phone,' . $id,
            'about'        => 'required|max:3500',
            'country'      => 'required|max:75',
            'city'         => 'required|max:75',
            'zip_code'     => 'nullable|max:75',
            'job'          => 'required|max:75',
            'is_available' => 'sometimes|boolean',
        ]);

        // Archive flag handling
        $data['is_available'] = $request->boolean('is_available');

        // Check IF Update Email Address
        if ($data['email'] != adminAuth('email')) {
            // Remove Verify From This Account
            DB::table($adminAttributes->table)->where('admin_id', $id)->update([
                'email_verified'    => '0',
                'email_verified_at' => null,
            ]);
        }
        // List For Change To HeadLine Text Format
        $textFormatItems = ['f_name', 'l_name', 'city', 'country'];

        foreach ($textFormatItems as $item) {
            $data[$item] = Str::headline($data[$item]);
        }

        // Set Full Name
        $data['full_name'] = $data['f_name'] . ' ' . $data['l_name'];

        // Update
        $this->model()->where('id', $id)->update($data);

        return Response::success(dbTrans('admin.Successfull Update Personal Data'), ['style' => 'toastr']);
    }

    // Verified Email
    public function sendMailForVerifyEmail()
    {

        // Check IF This ID Equal Auth ID
        if ($this->getAdminIdFromRequest() == adminId()) {

            // Get Admin Attr
            $adminAttr = $this->adminAttr(adminId(), ['email_verified']);

            if ($adminAttr->email_verified == 0) {

                // Send Mail For Verified
                Mail::to(adminAuth('email'))->send(new VerifyEmail([
                    'token' => Crypt::encryptString(adminAuth('email') . '|' . adminId()),
                    'email' => adminAuth('email'),
                ]));

                return Response::success(dbTrans('admin.A verification link has been sent to your email'), ['style' => 'toastr']);
            } elseif ($adminAttr->email_verified == 1) {
                // Return Message => Your Email Is Verifid Success
                return Response::info(dbTrans('admin.Your email has already been verified successfully'), ['style' => 'toastr']);
            } else {
                // Return Error Complate Your Request
                return Response::error(dbTrans('admin.Error completing your request'), ['style' => 'toastr']);
            }
        } else {
            return Response::error(dbTrans('admin.This operation can only be performed by the account holder'), [
                'style' => 'toastr',
            ]);
        }
    }

    public function verifiedEmail($token, AdminAttributes $adminAttributes)
    {
        $response = [];
        // Decript
        try {

            // Explode Token To Array
            $token = explode('|', Crypt::decryptString($token));
            // In Token Have 2 Parts [ Admin Email , Admin ID ]
            $email = $token[0];
            $id    = $token[1];

            if ($id == adminId()) {
                if ($email == adminAuth('email')) {

                    // Check IF ID Equal The Admin Auth ID
                    if ($id == adminId()) {

                        // Check IF Isset Data In DB
                        $row = $this->model()->where(['id' => $id, 'email' => $email])->first();

                        if (! empty($row)) {

                            // Get The Admin Attr
                            $adminAttr = $this->adminAttr(adminId());

                            if ($adminAttr->email_verified == 0) {

                                // Verfiy This Email
                                $update = $adminAttributes->where('admin_id', adminId())->update([
                                    'email_verified'    => '1',
                                    'email_verified_at' => now(),
                                ]);

                                if ($update == 1) {
                                    $response = [
                                        'message' => dbTrans('admin.Email verified successfully'),
                                        'status'  => 'success',
                                    ];
                                } else {
                                    $response = [
                                        'message' => dbTrans('admin.Something went wrong during the verification process, try again'),
                                        'status'  => 'error',
                                    ];
                                }
                            } else {
                                $response = [
                                    'message' => dbTrans('admin.Your email has already been verified'),
                                    'status'  => 'success',
                                ];
                            }
                        } else {
                            $response = [
                                'message' => dbTrans('admin.This data is no longer available in the system'),
                                'status'  => 'error',
                            ];
                        }
                    } else {
                        $response = [
                            'message' => dbTrans('admin.Don\'t Have Permission For This Request'),
                            'status'  => 'error',
                        ];
                    }
                } else {
                    $response = [
                        'message' => dbTrans('admin.Your current mail does not match the mail you want to check, request a new verification !'),
                        'status'  => 'warning',
                    ];
                }
            } else {
                return abort(403, 'You are not authorized to complete this operation');
            }
        } catch (DecryptException $e) {
            $response = [
                'message' => dbTrans('admin.Verification code error, request a new code from your profile !'),
                'status'  => 'error',
            ];
        }

        return view('dashboard.admin.profile.verify-email', compact('response'));
    }

    // Password
    public function changeProfilePassword(Request $request)
    {
        // Request ID
        $id = $this->getAdminIdFromRequest();

        $request->validate([
            'old_password' => 'required',
            'password'     => 'required|min:8|max:255|confirmed',
        ]);

        if (Hash::check($request->old_password, adminAuth('password'))) {
            // Update New Passowrd
            $this->model()->where('id', $id)->update(['password' => Hash::make($request->password)]);

            return Response::success(dbTrans('admin.Successfull Change Password'), ['style' => 'toastr']);
        } else {
            return Response::warning(dbTrans('admin.The current password is incorrect'), ['style' => 'toastr']);
        }
    }

    public function forgotPassword(AdminAttributes $adminAttributes)
    {

        $id = $this->getAdminIdFromRequest();
        // Check IF This ID Equal Auth ID
        if ($id == adminId()) {

            $adminAttr = $this->adminAttr($id);

            // IF This Admin Verified The Email
            if ($adminAttr->email_verified == 1) {

                // Check IF Have Already Mail Sending
                if ($adminAttr->forget_password_expiry_date < time() + 25 * 60) {

                    // Create Token
                    $token = Crypt::encryptString(time() * rand(10000, 10000000));

                                                    // Create Expiry Date
                    $expiryDate = time() + 30 * 60; // Add 30 min

                    // Set Token In DB And Send To Email
                    $adminAttributes->where('admin_id', adminId())->update([
                        'forgot_password_token'       => $token,
                        'forget_password_expiry_date' => $expiryDate,
                    ]);

                    // Send Mail For Reset Password
                    Mail::to(adminAuth('email'))->send(new ResetPassword([
                        'token' => $token,
                    ]));

                    return Response::success(dbTrans('admin.A password reset link has been emailed to you'), ['style' => 'toastr']);
                } else {

                    return Response::warning(dbTrans('admin.An email has already been sent, order again in 5 minutes'), ['style' => 'toastr']);
                }
            } else {
                return Response::warning(dbTrans('admin.You must confirm your email address before this step'), ['style' => 'toastr']);
            }
        } else {
            return Response::error(dbTrans('admin.This operation can only be performed by the account holder'), [
                'style' => 'toastr',
            ]);
        }
    }

    public function resetPasswordView($token, AdminAttributes $adminAttributes)
    {
        // Check IF Token Isset In DB
        $row = $this->passwordAttr(['admin_id' => adminId(), 'forgot_password_token' => $token]);

        if (! empty($row)) {

            // Check Expiry Time
            if ($row->forget_password_expiry_date < time()) {
                return abort(403, 'This link is expired');
            } else {
                // Return View
                return view('dashboard.admin.profile.reset-password', compact('token'));
            }
        } else {
            return redirect(adminUrl('profile'));
        }
    }

    public function resetPasswordUpdate(Request $request, AdminAttributes $adminAttributes)
    {
        // Validate
        $request->validate([
            'password' => 'required|min:8|max:255|confirmed',
        ]);

        // Check IF Token Exist In DB
        $row = $this->passwordAttr(['admin_id' => adminId(), 'forgot_password_token' => $request->token]);

        if (! empty($row)) {
            // Update New Passowrd
            $this->model()->where('id', adminId())->update(['password' => Hash::make($request->password)]);

            // Reset Admin Attr

            $adminAttributes->where('admin_id', adminId())->update([
                'forgot_password_token'       => null,
                'forget_password_expiry_date' => null,
            ]);

            return Response::success(dbTrans('admin.Successfull Change Password'), [
                'style'    => 'toastr',
                'reload'   => true,
                'time_out' => 2,
                'reset'    => true,
            ]);
        } else {
            return Response::error(dbTrans('admin.Error Update Password'), ['style' => 'toastr']);
        }
    }

    // Experience
    public function experience(Request $request, AdminJobExperience $adminJobExperience)
    {

        $adminId = $this->getAdminIdFromRequest();

        // Validate Exp Inputs
        $request->validate([
            'job_title.*'    => 'required|max:75',
            'job_desc.*'     => 'required|max:2500|min:50',
            'company_name.*' => 'required|max:100',
            'start_year.*'   => 'required|in:' . implode(',', $this->yearsList()),
            'end_year.*'     => 'required|in:' . implode(',', $this->yearsList()),
        ]);

        if (isset($request->job_title)) {

            // Loop
            for ($i = 0; $i < count($request->job_title); $i++) {
                // Data
                $exp_id      = isset($request->exp_id[$i]) ? $request->exp_id[$i] : null;
                $jobTitle    = $request->job_title[$i];
                $jobDesc     = $request->job_desc[$i];
                $companyName = $request->company_name[$i];
                $startYear   = $request->start_year[$i];
                $endYear     = $request->end_year[$i];

                // Check If Start Year Large Than End Year
                if ($endYear < $startYear) {
                    return Response::warning(dbTrans('admin.The ending year must not be less than the starting year!'), ['style' => 'toastr']);
                } else {
                    // Add Or Update Data
                    $adminJobExperience::updateOrCreate([
                        'id'       => $exp_id,
                        'admin_id' => $adminId,
                    ], [
                        'job_title'    => $jobTitle,
                        'job_desc'     => $jobDesc,
                        'company_name' => $companyName,
                        'start_year'   => $startYear,
                        'end_year'     => $endYear,
                        'admin_id'     => $adminId,
                    ]);
                }
            }
            return Response::success(dbTrans('admin.Your Data Saved Successfully'), ['style' => 'toastr']);
        } else {
            return Response::warning(dbTrans('admin.Add New Experience Befor Save !'), ['style' => 'toastr']);
        }
    }

    public function destroyExperience(Request $request, AdminJobExperience $adminJobExperience)
    {
        $adminId = $this->getAdminIdFromRequest();

        // Delete
        $delete = $adminJobExperience->where(['admin_id' => $adminId, 'id' => $request->exp_id])->delete();

        if ($delete > 0) {
            return Response::success(dbTrans('admin.Job experience Has Been Deleted Successfully'), ['style' => 'toastr']);
        } else {
            return Response::error(dbTrans('admin.Error Delete Job Experience'), ['style' => 'toastr']);
        }
    }

    // Roles
    public function changeRoles(Request $request)
    {

        $id = $this->getAdminIdFromRequest();

        $request->validate([
            'roles.*' => 'in:' . inValidateByPluck(DB::table('roles')->pluck('name')),
        ]);

        // Check IF Choose From Role
        if (! isset($request->roles)) {
            return Response::warning(dbTrans('admin.At least one role must be selected'), ['style' => 'toastr']);
        } else {

            // Remove From DB
            DB::table('model_has_roles')->where('model_id', $id)->delete();

            // Get Admin
            $admin = $this->model()->find($id);

            // Assign
            foreach ($request->roles as $role) {
                $admin->assignRole($role);
            }

            return Response::success(dbTrans('admin.Roles updated successfully'), ['style' => 'toastr']);
        }
    }

    public function deleteAdmin(Request $request)
    {
        $adminId        = $this->getAdminIdFromRequest();
        $currentAdminId = adminAuth('id');

        $isOwner      = canRole(owner());
        $isSelfDelete = $adminId == $currentAdminId;

        if (($isOwner && ! $isSelfDelete) || (! $isOwner && $isSelfDelete)) {
            // يعني: Owner يحذف غيره OR Admin عادي يحذف نفسه

            $delete = $this->model()->where('id', $adminId)->delete();

            if ($delete > 0) {
                Response::success('تم حذف الحساب بنجاح', ['style' => 'toastr', 'json' => false]);
            } else {
                Response::error('خطأ في حذف البيانات', ['style' => 'toastr', 'json' => false]);
            }
        } else {
            Response::error('غير مسموح لك بحذف هذا الحساب', ['style' => 'toastr', 'json' => false]);
        }

        return redirect(adminUrl('admins'));

    }

}
