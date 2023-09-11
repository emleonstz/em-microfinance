<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Functions extends BaseController
{
    private $shared;
    public function __construct()
    {
        $this->shared = new SharedControler;
    }
    public function index()
    {
    }
    public function encrypt($textplain)
    {
        return $this->shared->simpleEncrypt($textplain);
    }
    public function decrypt($encrypted)
    {
        return $this->shared->simpleDecrypt($encrypted);
    }
    //time diff
    public function time_ago($timestamp)
    {
        $time = $timestamp;
        $difference = time() - strtotime($time);

        if ($difference < 60) {
            return "recently";
        } else if ($difference < 3600) {
            return "Dakika ".round($difference / 60)." zilizopita" ;
        } else if ($difference < 86400) {
            return "Maa yaliyopita ".round($difference / 3600) . " yalizopita";
        } else if ($difference < 2592000) {
            return "Siku ".round($difference / 86400) . " zilizopitz";
        } else {
            return date("M j, Y", strtotime($time));
        }
    }

    function format_currency(int $amount): string
    {
        // Get the Tanzanian currency symbol.
        $currency_symbol = 'TSh';

        // Format the amount as a string with commas for thousands and a space after the currency symbol.
        $formatted_amount = number_format($amount, 0, '', ',');

        // Return the formatted amount with the currency symbol.
        return  $currency_symbol . " " . $formatted_amount;
    }
    //left
    function time_left($timestamp)
    {
        // Get the current time as a timestamp
        $now = time();
        
        // Check if the parameter timestamp is in the future or not
        if ($timestamp > $now) {
            // Calculate the difference in seconds between the two timestamps
            $diff = $timestamp - $now;

            // Convert the difference to days, hours, minutes, and seconds
            $days = floor($diff / 86400);
            $hours = floor(($diff % 86400) / 3600);
            $minutes = floor(($diff % 3600) / 60);
            $seconds = $diff % 60;

            // Create an array to store the time units and their values
            $units = array(
                'siku' => $days,
                'masaa' => $hours,
                'dakika' => $minutes,
                'sekunde' => $seconds
            );

            // Create an empty string to store the output
            $output = '';

            // Loop through the array and append the units and values to the output
            foreach ($units as $unit => $value) {
                // Check if the value is greater than zero
                if ($value > 0) {
                    // Add a comma and a space if the output is not empty
                    if ($output != '') {
                        $output .= ', ';
                    }

                    // Add the value and the unit to the output
                    // Add an 's' if the value is plural
                    $output .= $unit . ' ' . $value;
                    if ($value > 1) {
                        $output ;
                    }
                }
            }

            // Return the output with 'left' at the end
            return $output . ' zimebaki';
        } else {
            // Return 'expired' if the parameter timestamp is not in the future
            return 'Umepitiliza';
        }
    }
}
