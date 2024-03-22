<?php 
function CallDatabase(){
    return mysqli_connect("localhost","root","","gpi_audit");
}

function sanitizeData($data):int{
    return filter_var($data,FILTER_SANITIZE_NUMBER_INT);
}

function sanitizeString($data):String{
    return filter_var($data,FILTER_SANITIZE_STRING);
}

/**
 * Encode data to Base64URL
 * @param string $data
 * @return boolean|string
 */
function base64url_encode($data)
{
  // First of all you should encode $data to Base64 string
  $b64 = base64_encode($data);

  // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
  if ($b64 === false) {
    return false;
  }

  // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
  $url = strtr($b64, '+/', '-_');

  // Remove padding character from the end of line and return the Base64URL result
  return rtrim($url, '=');
}

/**
 * Decode data from Base64URL
 * @param string $data
 * @param boolean $strict
 * @return boolean|string
 */
function base64url_decode($data, $strict = false)
{
  // Convert Base64URL to Base64 by replacing “-” with “+” and “_” with “/”
  $b64 = strtr($data, '-_', '+/');

  // Decode Base64 string and return the original data
  return base64_decode($b64, $strict);
}

function craftToken($data) {
  $payload = [];
    $tokenHeader = [
        "alg" => "SHA256",
        "typ" => "JWT"
    ];
    foreach($data as $key => $value){
        $payload[$key] = $value;
    }
    $token = base64url_encode(json_encode($tokenHeader)) . "." . base64url_encode(json_encode($payload));
    return $token . "." . base64url_encode(hash_hmac("SHA256",$token,"My_Sup3r-S3cret&T0k3n_!"));
}

function decodeToken($token){
	return json_decode(base64url_decode(explode(".",$token)[1],true),true);
}

