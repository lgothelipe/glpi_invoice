<?php
include ('../../../inc/includes.php');

if(empty($_POST["is_set"])) {

	$_POST["is_set"] = '1';
	$insert = "INSERT INTO glpi_plugin_invoice_profiles (profiles_id, show_invoice, email_invoice, config_invoice, is_set)
						VALUES ('".$_POST["profiles_id"]."', '".$_POST["show_invoice"]."', '".$_POST["email_invoice"]."', '".$_POST["config_invoice"]."', '".$_POST["is_set"]."')";
	$DB->query($insert) or die ("error");

} else {

	$update = "UPDATE glpi_plugin_invoice_profiles
						SET show_invoice='".$_POST["show_invoice"]."', email_invoice='".$_POST["email_invoice"]."', config_invoice='".$_POST["config_invoice"]."'
						WHERE profiles_id='".$_POST["profiles_id"]."'";
	$DB->query($update) or die ("error");

}

HTML::back();

?>
