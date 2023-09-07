<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SharedControler extends BaseController
{
    public function index()
    {
        //
    }
    function convertNumberToSwahili($num) {
        // Define the names of the digits and the tens in Swahili
        $digits = array("sifuri", "moja", "mbili", "tatu", "nne", "tano", "sita", "saba", "nane", "tisa");
        $tens = array("", "kumi", "ishirini", "thelathini", "arobaini", "hamsini", "sitini", "sabini", "themanini", "tisini");
      
        // Check if the number is valid
        if ($num < 0 || $num > 99) {
          return "Invalid number";
        }
      
        // Check if the number is zero
        if ($num == 0) {
          return $digits[0];
        }
      
        // Split the number into tens and ones
        $ten = floor($num / 10);
        $one = $num % 10;
      
        // Build the Swahili word
        $word = "";
      
        // Add the ten if it is not zero
        if ($ten > 0) {
          $word .= $tens[$ten];
        }
      
        // Add the one if it is not zero
        if ($one > 0) {
          // Add a separator if both ten and one are not zero
          if ($ten > 0) {
            $word .= " na ";
          }
          $word .= $digits[$one];
        }
      
        // Return the word
        return $word;
      }
}
