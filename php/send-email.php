<?php

function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 ↪checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}

function filter($value) {
  $pattern = array("/\n/","/\r/","/content-type:/i","/to:/i", "/from:/i", "/cc:/i");
  $value = preg_replace($pattern, "", $value);
  return $value;
}

$action = isset($_POST["action"]) ? $_POST["action"] : "";

include 'config.php'
if (empty($action))
{
  echo "Empty Action";
}
else if ($action == "send")
{
  $email = $_POST['email'];

  if (validEmail($email))
  {
    $subject = isset($_POST["subject"]) ? $_POST["subject"] : "Website Contact Form";
    $message = isset($_POST["comment"]) ? $_POST["comment"] : "";
    $name = isset($_POST["name"]) ? $_POST["name"] : "";

    $name=filter($name);
    $subject=filter($subject);
    $email=filter($email);
    
    $body = "From: $name\n\n";
    $body .= "Message: $message";
    $body = wordwrap($body, 70);

    // Build header
    $headers = "From: $email\n";
    $headers .= "X-Mailer: PHP/SimpleModalContactForm";

    // UTF-8
    if (function_exists('mb_encode_mimeheader')) {
      $subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\n");
    }
    else {
      // you need to enable mb_encode_mimeheader or risk 
      // getting emails that are not UTF-8 encoded
    }
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/plain; charset=utf-8\n";
    $headers .= "Content-Transfer-Encoding: quoted-printable\n";

    // Send email
    @mail($to, $subject, $body, $headers) or
      die("Unfortunately, a server issue prevented delivery of your message.");

  echo "OK";
  }

}
else
{
  echo "Unknown Action";
}
?>
