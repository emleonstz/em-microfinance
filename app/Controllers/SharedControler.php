<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use DateTime;
use NumberFormatter;

class SharedControler extends BaseController
{
  private $usersmodel;
  private $key;
  private $stupidEncrypt;
  public function __construct()
  {
    $this->usersmodel = new UsersModel();
    $this->key = "-1neMIEOcfJ?,k(";
    $this->stupidEncrypt = new SimpleEncryption($this->key);
  }
  public function index()
  {
    //
  }
  //stupid ecn
  function simpleEncrypt($text, $key = null)
  {
    
    $ciphertext = $this->stupidEncrypt->encrypt($text);
    return $ciphertext;
  }

  function simpleDecrypt($ciphertext, $key = null)
  {

    $plaintext = $this->stupidEncrypt->decrypt($ciphertext);
    return $plaintext;
  }
  function removeSpecialCharacters($str) {
    // This regular expression matches any character that's not a letter, number, or space.
    return preg_replace('/[^a-zA-Z0-9\s]/', '', $str);
  }
  public function encrypt($plainText)
  {
    $encrypter = \Config\Services::encrypter();
    $ciphertext = $encrypter->encrypt($plainText);
    return $ciphertext;
  }
  function cleanVar($str) {
    // This regular expression matches any character that's not a letter or number.
    return preg_replace('/[^a-zA-Z0-9]/', '', $str);
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
  public function getCurrentUserInfo()
  {
    $userid = $this->decrypt(base64_decode(session()->get('USER_ID')));
    return $this->usersmodel->simpleUserdata($userid);
  }
  public function get_user_microfinance()
  {
    $userid = $this->decrypt(base64_decode(session()->get('USER_ID')));
    return $this->usersmodel->get_user_microfinance($userid);
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
  /**
   * Generate a Random String From Set Of supplied data context
   * @return  string
   */
  function random_num($limit = 10, $context = '1234567890')
  {
    $l = ($limit <= strlen($context) ? $limit : strlen($context));
    return substr(str_shuffle($context), 0, $l);
  }
  //xss mitigation functions
  function xssafe($data, $encoding = 'UTF-8')
  {
    return htmlspecialchars($data, ENT_QUOTES | ENT_HTML401, $encoding);
  }
  /**
   * Format text by removing non letters characters with space.
   * @return  string
   */
  function make_readable($string = '')
  {
    if (!empty($string)) {
      $string = preg_replace("/[^a-zA-Z0-9]/", ' ', $string);
      $string = trim($string);
      $string = ucwords($string);
      $string = preg_replace('/\s+/', ' ', $string);
    }
    return $string;
  }
  /**
   * Set Msg that Will be Display to User in a Session. 
   * Can Be Displayed on Any View.
   * @return  object
   */
  function set_alert_msg($msg, $type = "success", $dismissable = true, $showduration = 5000)
  {
    if ($msg !== '') {
      $class = null;
      $closeBtn = null;
      if ($type != 'custom') {
        $class = "alert alert-$type";
        if ($dismissable == true) {
          $class .= " alert-dismissable";
          $closeBtn = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        }
      }

      $msg = '<div data-show-duration="' . $showduration . '" id="flashmsgholder" class="' . $class . ' animated bounce">
						' . $closeBtn . '
						' . $msg . '
				</div>';

      return $msg;
    }
  }
  function approximate($val, $decimal_points = 0)
  {
    return str_replace(',','',number_format($val, $decimal_points));
  }
  //loan calc
  function kikokotooMkopo($kiasi, $ribaYaMwaka, $muda, $ainaYaMuda = 'mwezi', $tareheYaKuanza = null)
  {
    // Kama aina ya muda ni mwaka, geuza kuwa miezi
    if ($ainaYaMuda == 'mwaka') {
      $muda = $muda * 12;
    }

    $ribaKwaMwezi = $ribaYaMwaka / 12 / 100;
    $malipoKwaMwezi = $kiasi * ($ribaKwaMwezi * pow((1 + $ribaKwaMwezi), $muda)) / (pow((1 + $ribaKwaMwezi), $muda) - 1);

    $jumlaYaMalipo = $malipoKwaMwezi * $muda;
    $jumlaYaRiba = $jumlaYaMalipo - $kiasi;
    $tareheYakuanzaKulipaMwezi = new DateTime($tareheYaKuanza);
    $tareheYakuanzaKulipaMwezi->modify("+1 months");
    // Kupata tarehe ya mwisho wa malipo
    $tareheYaKuanza = ($tareheYaKuanza) ? new DateTime($tareheYaKuanza) : new DateTime();
    $tareheYaMwisho = clone $tareheYaKuanza;
    $tareheYakuanzaKulipaKwaWiki = $tareheYaKuanza->modify("+7 days");
    
    $tareheYaMwisho->modify("+$muda months");
    
    //malipo kwa wiki
    $malipoKwawiki = $malipoKwaMwezi / 4;

    return [
      'malipoKwaWiki' => $this->approximate($malipoKwawiki),
      'weekly'=> $this->to_currency($this->approximate($malipoKwawiki),'sw-Tz'),
      'malipoKwaMwezi' => $this->approximate($malipoKwaMwezi),
      'monthly'=> $this->to_currency($this->approximate($malipoKwaMwezi),'sw-Tz'),
      'jumlaYaMalipo' => $this->approximate($jumlaYaMalipo),
      'totlapayment'=> $this->to_currency($this->approximate($jumlaYaMalipo),'sw-Tz'),
      'jumlaYaRiba' => $this->approximate($jumlaYaRiba),
      'totlrate'=> $this->to_currency($this->approximate($jumlaYaRiba),'sw-Tz'),
      'tareheKuanzaKulipaWiki'=>$tareheYakuanzaKulipaKwaWiki->format('Y-m-d'),
      'tareheKuanzaKulipamwezi'=>$tareheYakuanzaKulipaMwezi->format('Y-m-d'),
      'tareheYaMwisho' => $tareheYaMwisho->format('Y-m-d')
    ];
  }

  function to_currency($val, $lang = 'en-US')
    {
        $f = new NumberFormatter($lang, \NumberFormatter::CURRENCY);
        return $f->format($val);
    }
    function kutoa($a,$b) : int {
      return $a-$b;
    }
  //  
}
