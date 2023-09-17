<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use NumberFormatter;

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
            return "Dakika " . round($difference / 60) . " zilizopita";
        } else if ($difference < 86400) {
            return "Maa yaliyopita " . round($difference / 3600) . " yalizopita";
        } else if ($difference < 2592000) {
            return "Siku " . round($difference / 86400) . " zilizopitz";
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
                        $output;
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
    //relative date
    function relative_date($date)
    {
        if (empty($date)) {
            return "No date provided";
        }

        $periods         = array("sec", "min", "hour", "day", "week", "month", "year", "decade");
        $lengths         = array("60", "60", "24", "7", "4.35", "12", "10");

        $now             = time();

        //check if supplied Date is in unix date form
        if (is_numeric($date)) {
            $unix_date        = $date;
        } else {
            $unix_date         = strtotime($date);
        }


        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if ($now > $unix_date) {
            $difference     = $now - $unix_date;
            $tense         = "ago";
        } else {
            $difference     = $unix_date - $now;
            $tense         = "from now";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if ($difference != 1) {
            $periods[$j] .= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
    /**
     * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016)
     * @return  string
     */
    function human_date($date)
    {
        if (empty($date)) {
            return "Null date";
        }
        if (is_numeric($date)) {
            $unix_date        = $date;
        } else {
            $unix_date         = strtotime($date);
        }
        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }
        return date("jS F, Y", $unix_date);
    }

    /**
     * Parse Date Or Timestamp Object into Human Readable Date (e.g. 26th of March 2016)
     * @return  string
     */
    function human_time($date)
    {
        if (empty($date)) {
            return "Null date";
        }
        if (is_numeric($date)) {
            $unix_date        = $date;
        } else {
            $unix_date         = strtotime($date);
        }
        // check validity of date
        if (empty($unix_date)) {
            return "Bad date";
        }
        return date("h:i:s", $unix_date);
    }

    /**
     * Trucate string
     * @return  string
     */
    function str_truncate($string, $length = 50, $ellipse = '...')
    {
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length) . $ellipse;
        }
        return $string;
    }

    /**
     * Return String formatted in currency mode
     * @return  string
     */
    function to_currency($val, $lang = 'en-US')
    {
        $f = new NumberFormatter($lang, \NumberFormatter::CURRENCY);
        return $f->format($val);
    }
    /**
     * return a numerical representation of the string in a readable format
     * @return  string
     */
    function to_number($val, $lang = 'en')
    {
        $f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
        return $f->format($val);
    }

    /**
     * Convert Number to words
     * @return  string
     */
    function number_to_words($val, $lang = "en")
    {
        $f = new NumberFormatter($lang, NumberFormatter::SPELLOUT);
        return $f->format($val);
    }

    /**
     * Generate a random string and characters from set of supplied data context
     * @return  string
     */
    function random_chars($limit = 12, $context = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
    {
        $l = ($limit <= strlen($context) ? $limit : strlen($context));
        return substr(str_shuffle($context), 0, $l);
    }
}
