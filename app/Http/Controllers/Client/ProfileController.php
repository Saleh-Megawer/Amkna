<?php
namespace App\Http\Controllers\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Crm\Client\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

    public function index()
    {
        $pageTitle = __('client.profile.title');
        return view('clients.profile', compact('pageTitle'));
    }

    public function update(Request $request)
    {

        // Phone length logic based on country code
        $countryCode    = $request->input('country_code');
        $phoneLengths   = phoneNumberLengths();
        $expectedLength = $phoneLengths[$countryCode] ?? null;
        $clientId       = clientId();

        //
        $data = $request->validate([
            'name'         => 'required|string|max:100',

            // Unique Email (ignore this record)
            'email'        => ['required', 'email', 'max:150', Rule::unique('clients', 'email')->ignore($clientId)],

            // Country code validation
            'country_code' => ['required', 'string', Rule::in(array_keys($phoneLengths))],

            // Unique Phone (ignore this record)
            'phone'        => ['required', 'string', Rule::unique('clients', 'phone')->ignore($clientId), function ($attribute, $value, $fail) use ($expectedLength) {
                if ($expectedLength && strlen(preg_replace('/\D/', '', $value)) != $expectedLength) {
                    $fail("رقم الهاتف يجب أن يحتوي على {$expectedLength} أرقام بناءً على كود الدولة.");
                }
            }],

            // National ID
            'national_id'      => ['required', 'digits_between:8,20', 'max:20', Rule::unique('clients', 'national_id')->ignore($clientId)],

            // Birth Date
            'birth_date'       => ['required', 'date'],

            // National Address
            'national_address' => ['required', 'string', 'max:255'],
        ]);

        Client::where('id', clientId())->update($data);

        return Response::success(__('client.profile.updated_successfully'), ['style' => 'toastr']);
    }

    public function updatePassword(Request $request)
    {
        // Validate
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'min:8', 'confirmed'],
        ]);

        // Load client model properly
        $client = Client::find(clientId());

        // Check current password
        if (! Hash::check($request->current_password, $client->password)) {
            return Response::warning(__('client.profile.current_password_wrong'), ['style' => 'toastr']);
        }

        // Update password
        $client->update([
            'password' => Hash::make($request->password),
        ]);

        return Response::success(__('client.profile.password_updated_successfully'), ['style' => 'toastr', 'reset' => true]);

    }

}
