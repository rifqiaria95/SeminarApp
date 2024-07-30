<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EncryptionHelper
{
    public static function encrypt($data)
    {
        try {
            $encrypted = Crypt::encryptString($data);
            Log::info('Encrypted data: ' . $encrypted);
            return $encrypted;
        } catch (\Exception $e) {
            Log::error('Encryption failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function decrypt($encryptedData)
    {
        try {
            $decrypted = Crypt::decryptString($encryptedData);
            Log::info('Decrypted data: ' . $decrypted);
            return $decrypted;
        } catch (\Exception $e) {
            Log::error('Decryption failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
