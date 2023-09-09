<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class SharedControler extends BaseController
{
  private $usersmodel;
  public function __construct()
  {
    $this->usersmodel = new UsersModel();
  }
  public function index()
  {
    //
  }
  function convertNumberToSwahili($num)
  {
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
  public function encrypt($plainText)
  {
    $encrypter = \Config\Services::encrypter();
    $ciphertext = $encrypter->encrypt($plainText);
    return $ciphertext;
  }

  public function decrypt($ciphertext)
  {
    $encrypter = \Config\Services::encrypter();
    $deciphertext = $encrypter->decrypt($ciphertext);
    return $deciphertext;
  }

  public function checkLogin()
  {
    if (!empty(session()->get('USER_ID'))) {
      $userid = $this->decrypt(base64_decode(session()->get('USER_ID')));
      $userinfo = $this->usersmodel->simpleUserdata($userid);
      if (!empty($userinfo) && is_array($userinfo)) {
        if ($userinfo['api_key'] != $this->decrypt(base64_decode(session()->get('USER_APIKEY')))) {
          return false;
        } else {
          if ($userinfo['accout_status'] != "Active") {
            return false;
          } else {
            $currenttime = time();
            $lastime  = $userinfo['last_activity'];
            if ($lastime > $currenttime) {
              return true;
            } else {
              return false;
            }
          }
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  public function updateLastActivity()
  {
    $userid = $this->decrypt(base64_decode(session()->get('USER_ID')));
    $this->usersmodel->setLastActivity($userid);
  }
  public function getCurrentUserInfo(){
    $userid = $this->decrypt(base64_decode(session()->get('USER_ID')));
    return $this->usersmodel->simpleUserdata($userid);
  }
}
