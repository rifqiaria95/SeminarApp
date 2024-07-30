<?php

namespace App\Helpers;

class Helper {

    /**
     * Generate a unique ID with a prefix, sequential number, and zero-padding.
     *
     * @param  string  $model    The model class name.
     * @param  string  $trow     The column name where the ID is stored.
     * @param  int     $length   The length of the numeric part of the ID.
     * @param  string  $prefix   The prefix for the ID.
     * @return string            The generated ID.
     */
    public static function IDGenerator($model, $trow, $length = 4, $prefix = '') {
        // Validate inputs
        if (empty($model) || empty($trow) || !is_numeric($length) || $length <= 0) {
            throw new \InvalidArgumentException("Invalid parameters provided.");
        }

        // Fetch the latest record
        $data = $model::orderBy('id', 'desc')->first();

        // Determine the last number and its length
        if (!$data) {
            $last_number = 0;
        } else {
            $code = substr($data->$trow, strlen($prefix) + 1);
            $last_number = (int)$code;
        }

        // Increment the number and calculate padding
        $last_number++;
        $last_number_length = strlen($last_number);
        $padding_length     = $length - $last_number_length;
        $zeros              = str_repeat('0', $padding_length);

        // Generate the new ID
        return $prefix . '-' . $zeros . $last_number;
    }
}
