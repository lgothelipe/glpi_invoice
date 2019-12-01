<?php
// GLPI_ROOT
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Html::header("Invoice", $_SERVER['PHP_SELF'], 'management', 'plugininvoiceinvoice');

if (PluginInvoiceInvoice::checkProfileRight()['email_invoice'] == 1) {

/*
header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
include_once "PHPMailer/PHPMailer.php";
include_once "PHPMailer/Exception.php";
include_once "PHPMailer/SMTP.php";

if (!empty($_POST['cliente']))  {
Html::back();
}

*/
} else {
  //Permission error
  Html::displayRightError();
}
?>
