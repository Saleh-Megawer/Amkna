<?php
namespace App\Http\Controllers\Client\Auth;

use App\Helpers\PhoneNormalizer;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Client\Client;
use App\Models\Dashboard\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{

    public $nextUrl;

    public function __construct()
    {
        $this->nextUrl = request('next');
    }

    public function index()
    {
        return view("clients.auth.register", [
            'navbarOptions' => [
                'show' => false,
            ],
            'footerOptions' => [
                'hide' => true,
            ],
        ]);
    }

    // public function store(Request $request)
    // {

    //     PhoneNormalizer::normalizeIntoRequest($request);

    //     $phoneLengths = phoneNumberLengths();

    //     $data = $request->validate([
    //         'name'         => ['required', 'string', 'min:2', 'max:45'],
    //         'email'        => ['nullable', 'email', 'max:150'],
    //         'country_code' => ['required', 'string', Rule::in(array_keys($phoneLengths))],
    //         'phone'        => ['required', 'string'],
    //         'password'     => ['required', 'min:8', 'max:150'],

    //     ], [
    //         'name.required'         => msg('auth.register.name_required'),
    //         'name.min'              => msg('auth.register.name_invalid'),
    //         'name.max'              => msg('auth.register.name_invalid'),
    //         //
    //         'email.email'           => msg('auth.register.email_invalid'),
    //         'email.max'             => msg('auth.register.email_invalid'),
    //         //
    //         'country_code.required' => msg('auth.register.country_code_required'),
    //         'country_code.in'       => msg('auth.register.country_code_invalid'),
    //         //
    //         'phone.required'        => msg('auth.register.phone_required'),
    //         //
    //         'password.required'     => msg('auth.register.password_required'),
    //         'password.min'          => msg('auth.register.password_rules'),
    //         'password.max'          => msg('auth.register.password_rules'),

    //     ]);

    //     $hashedPassword = Hash::make($request->password);

    //     $fullPhone = $request->country_code . $request->phone;

    //     $existing = Client::where('email', $request->email)
    //         ->orWhereRaw("CONCAT(country_code, phone) = ?", [$fullPhone])
    //         ->first();

    //     if ($existing && $existing->has_account) {
    //         return back()->withErrors([
    //             'email' => msg('auth.register.email_exists'),
    //             'phone' => msg('auth.register.phone_exists'),
    //         ])->withInput();

    //     }

    //     if ($existing && ! $existing->has_account) {
    //         $existing->update([
    //             'name'         => $data['name'],
    //             'email'        => $data['email'],
    //             'phone'        => $request->phone, // normalized
    //             'country_code' => $request->country_code,
    //             'password'     => $hashedPassword,
    //             'has_account'  => true,
    //         ]);

    //         Auth::guard('client')->login($existing);
    //         return redirect(clientUrl(''));
    //     }

    //     $client = Client::create([
    //         'name'         => $data['name'],
    //         'email'        => $data['email'],
    //         'phone'        => $request->phone, // normalized
    //         'country_code' => $request->country_code,
    //         'password'     => $hashedPassword,
    //         'has_account'  => true,
    //         'source_id'    => Source::where('key', 'manual')->where('type', 'client')->value('id'),
    //     ]);

    //     Auth::guard('client')->login($client);
    //     return redirect(clientUrl(''));
    // }

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Normalize phone number into a consistent local format
        | - Validates country code
        | - Removes non-digits
        | - Removes leading trunk zero
        | - Replaces request phone with normalized value
        |--------------------------------------------------------------------------
        */

        PhoneNormalizer::normalizeIntoRequest($request);

        $phoneLengths = phoneNumberLengths();

        /*
        |--------------------------------------------------------------------------
        | Validate input data
        |--------------------------------------------------------------------------
        */
        $data = $request->validate([
            'name'         => ['required', 'string', 'min:2', 'max:45'],
            'email'        => ['nullable', 'email', 'max:150'],
            'country_code' => ['required', 'string', Rule::in(array_keys($phoneLengths))],
            'phone'        => ['required', 'string'],
            'password'     => ['required', 'min:8', 'max:150'],
        ], [
            'name.required'         => msg('auth.register.name_required'),
            'name.min'              => msg('auth.register.name_invalid'),
            'name.max'              => msg('auth.register.name_invalid'),

            'email.email'           => msg('auth.register.email_invalid'),
            'email.max'             => msg('auth.register.email_invalid'),

            'country_code.required' => msg('auth.register.country_code_required'),
            'country_code.in'       => msg('auth.register.country_code_invalid'),

            'phone.required'        => msg('auth.register.phone_required'),

            'password.required'     => msg('auth.register.password_required'),
            'password.min'          => msg('auth.register.password_rules'),
            'password.max'          => msg('auth.register.password_rules'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Prepare derived values
        |--------------------------------------------------------------------------
        */
        $hashedPassword = Hash::make($request->password);
        $fullPhone      = $request->country_code . $request->phone;

        /*
        |--------------------------------------------------------------------------
        | Check for existing ACCOUNT with same email or phone
        |--------------------------------------------------------------------------
        */
        $emailExists = $request->filled('email') && Client::where('email', $request->email)->where('has_account', true)->exists();

        $phoneExists = Client::whereRaw(
            "CONCAT(country_code, phone) = ?",
            [$fullPhone]
        )->where('has_account', true)->exists();


        if ($emailExists || $phoneExists) {
            return back()->withErrors([
                'email' => $emailExists ? msg('auth.register.email_exists') : null,
                'phone' => $phoneExists ? msg('auth.register.phone_exists') : null,
            ])->withInput();
        }

        /*
        |--------------------------------------------------------------------------
        | If client exists without an account (lead → account upgrade)
        |--------------------------------------------------------------------------
        */
        $existingClient = Client::whereRaw(
            "CONCAT(country_code, phone) = ?",
            [$fullPhone]
        )
            ->where('has_account', false)
            ->first();

        if ($existingClient) {

            $updateData = [
                'name'         => $data['name'],
                'phone'        => $request->phone, // normalized
                'country_code' => $request->country_code,
                'password'     => $hashedPassword,
                'has_account'  => true,
            ];

            // Update email only if a new one is provided
            if (! empty($data['email'])) {
                $updateData['email'] = $data['email'];
            }

            $existingClient->update($updateData);

            Auth::guard('client')->login($existingClient);
            return redirect(clientUrl(''));

        }

        /*
        |--------------------------------------------------------------------------
        | Create new client account
        |--------------------------------------------------------------------------
        */
        $client = Client::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone'        => $request->phone, // normalized
            'country_code' => $request->country_code,
            'password'     => $hashedPassword,
            'has_account'  => true,
            'source_id'    => Source::where('key', 'manual')
                ->where('type', 'client')
                ->value('id'),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Auto-login after registration
        |--------------------------------------------------------------------------
        */
        Auth::guard('client')->login($client);
        return redirect(clientUrl(''));
    }
}

// if ($this->nextUrl == 'cart') {
//     return redirect(url($this->nextUrl));
// }
