<?php

namespace App\Utils;

use App\Core\Response;

class Validator
{

     private $errors = [];

     public static $patterns = [
          'name' => '/^[A-Za-z]+$/',
          'username' => '/^[a-zA-Z][a-zA-Z0-9]{7,29}$/',
          'password' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
          'nic' => '/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/',
          'phone no' => '/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/',
          'reg no' => '/^[0-9]{8}$/'
     ];

     public static $file_types = [
          "image" => [
               "jpg",
               "jpeg",
               "png"
          ],
          "document" => [
               "pdf"
          ]
     ];

     public function validate($data, $rules)
     {
          $valid = true;

          foreach ($rules as $field => $fieldRules) {
               foreach ($fieldRules as $rule) {
                    $callback = $rule['callback'];

                    if (!$this->$callback($data[$field], $rule)) {
                         $valid = false;
                         $this->errors[$field] = $rule['message'];
                         break;
                    }
               }
          }
          return $valid;
     }

     public function getErrors()
     {
          return $this->errors;
     }

     public function setError($key, $value)
     {
          $this->errors[$key] = $value;
     }

     private function required($value, $rule)
     {
          if (empty(trim($value))) {
               return false;
          } else {
               return true;
          }
     }

     private function min($value, $rule)
     {
          if (strlen($value) < $rule['length']) {
               return false;
          } else {
               return true;
          }
     }

     private function max($value, $rule)
     {
          if (strlen($value) > $rule['length']) {
               return false;
          } else {
               return true;
          }
     }

     private function email($value, $rule)
     {
          if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
               return false;
          } else {
               return true;
          }
     }

     private function verify($value, $rule)
     {
          if ($rule['type'] == 'email') {

               // call to abstract api to validate verify email address
               $api_key = $_ENV['API_KEY'];

               // initialize cURL
               $curl = curl_init();

               $params = http_build_query([
                    'api_key' => $api_key,
                    'email' => $value
               ]);

               curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://emailvalidation.abstractapi.com/v1/?' . $params,
                    // return contents as variables
                    CURLOPT_RETURNTRANSFER => true,
                    // set follow redirects to true
                    CURLOPT_FOLLOWLOCATION => true
               ]);

               // execute request and get response
               $res = curl_exec($curl);

               // close cURL handle
               curl_close($curl);

               // return response data as associative array
               $response = new Response($res);
               $data = $response->toAssoc();

               $status = $data["deliverability"];

               if ($status == "UNDELIVERABLE") {
                    return false;
               } else if ($status == "DELIVERABLE") {
                    return true;
               }
          }

          if ($rule['type'] == 'phone') {
               // call to abstract api to verify phone no
          }

          if ($rule['type'] == 'password' && isset($rule['hash'])) {
               if (!Crypto::verifyHash($rule['hash'], $value)) {
                    return false;
               } else {
                    return true;
               }
          }
     }

     private function match($value, $rule)
     {
          if ($value !== $rule['compare']) {
               return false;
          } else {
               return true;
          }
     }

     private function pattern($value, $rule)
     {
          if (!preg_match($rule['regex'], $value)) {
               return false;
          } else {
               return true;
          }
     }

     private function size($value, $rule)
     {
          if ($value['size'] / 1024 > $rule['size']) {
               return false;
          } else {
               return true;
          }
     }

     private function extension($value, $rule)
     {
          $arr = explode('.', $value['name']);
          $ext = strtolower(end($arr));

          if (!in_array($ext, self::$file_types[$rule['type']])) {
               return false;
          } else {
               return true;
          }
     }
}
