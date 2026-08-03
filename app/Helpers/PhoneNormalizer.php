<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PhoneNormalizer
{
    public static function normalize(string $countryCode, string $phone): array
    {
        $lengths = phoneNumberLengths();

        if (empty($lengths) || ! is_array($lengths)) {
            throw new \RuntimeException(msg('phone.config_missing'));
        }

        $expected = $lengths[$countryCode] ?? null;

        $raw    = trim($phone);
        $digits = preg_replace('/\D/', '', $raw);

        // Empty phone handling
        if ($digits === '' || $digits === null) {
            return [
                'country_code' => $countryCode,
                'national'     => '',
                'e164'         => $countryCode,
                'valid'        => false,
                'error'        => msg('phone.required'),
                'expected'     => $expected,
            ];
        }

        // Since you already have a country_code dropdown, reject international-style inputs
        // like "+2010..." or "0020..."
        if (str_starts_with($raw, '+') || str_starts_with($digits, '00')) {
            return [
                'country_code' => $countryCode,
                'national'     => '',
                'e164'         => $countryCode,
                'valid'        => false,
                'error'        => msg('phone.local_only'),
                'expected'     => $expected,
            ];
        }

        // Remove ONE leading trunk zero only
        if ($digits[0] === '0') {
            $digits = substr($digits, 1);
        }

        // Validate length if configured
        if ($expected !== null && strlen($digits) !== $expected) {
            return [
                'country_code' => $countryCode,
                'national'     => $digits,
                'e164'         => $countryCode . $digits,
                'valid'        => false,
                'error'        => msg('phone.length', ['expected' => $expected]),
                'expected'     => $expected,
            ];
        }

        return [
            'country_code' => $countryCode,
            'national'     => $digits,
            'e164'         => $countryCode . $digits,
            'valid'        => true,
            'error'        => null,
            'expected'     => $expected,
        ];
    }

    public static function normalizeIntoRequest(Request $request): void
    {
        $phoneLengths = phoneNumberLengths();

        if (empty($phoneLengths) || ! is_array($phoneLengths)) {
            throw new \RuntimeException(msg('phone.config_missing'));
        }


        // Basic validation (country code must be allowed)
        $request->validate([
            'country_code' => ['required', 'string', Rule::in(array_keys($phoneLengths))],
            'phone'        => ['required', 'string'],
        ], [
            'country_code.required' => msg('phone.invalid_cc'),
            'country_code.in'       => msg('phone.invalid_cc'),
            'phone.required'        => msg('phone.required'),
        ]);


        $norm = self::normalize((string) $request->country_code, (string) $request->phone);


        if (! $norm['valid']) {

            throw ValidationException::withMessages([
                'phone' => $norm['error'],
            ]);
        }

        // Replace request phone with normalized value so the rest of your code uses it
        $request->merge(['phone' => $norm['national']]);
    }



    
}
