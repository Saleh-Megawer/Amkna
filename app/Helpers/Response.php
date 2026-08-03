<?php

namespace App\Helpers;

class Response
{
    /**
     * Methods Names
     * 1- success
     * 2- error
     * 3- info
     * 4- notfound
     * 5- warning
     */

    public function attributes(string $status, string $message, array $options)
    {
        // Prepare $options
        $responseStyle   = $options['style'] ?? 'box';
        $resetForm       = $options['reset'] ?? false;
        $reload          = $options['reload'] ?? false;
        $redirect        = $options['redirect'] ?? null;
        $redirectTimeOut = $options['time_out'] ?? 0;
        $jsonResponse    = $options['json'] ?? true;
        $additionalData  = $options['data'] ?? [];  // ✅ البيانات الإضافية

        if ($jsonResponse == true) {
            // ✅ دمج البيانات الإضافية مع الـ response
            $response = [
                'status'   => $status,
                'message'  => $message,
                'style'    => $responseStyle,
                'reset'    => $resetForm,
                'reload'   => $reload,
                'redirect' => $redirect,
                'time_out' => $redirectTimeOut,
                'json'     => $jsonResponse,
            ];

            // ✅ إضافة البيانات الإضافية
            if (!empty($additionalData)) {
                $response = array_merge($response, $additionalData);
            }

            return response()->json($response);
        } else {
            return request()->session()->flash($status, $message);
        }
    }

    // success
    public static function success(string $message, array $options = [])
    {
        return (new self)->attributes(__FUNCTION__, $message, $options);
    }

    // error
    public static function error(string $message, array $options = [])
    {
        return (new self)->attributes(__FUNCTION__, $message, $options);
    }

    // info
    public static function info(string $message, array $options = [])
    {
        return (new self)->attributes(__FUNCTION__, $message, $options);
    }

    // notfound
    public static function notfound(string $message, array $options = [])
    {
        return (new self)->attributes(__FUNCTION__, $message, $options);
    }

    // warning
    public static function warning(string $message, array $options = [])
    {
        return (new self)->attributes(__FUNCTION__, $message, $options);
    }
}
