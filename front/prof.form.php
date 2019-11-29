<?php

include ('../../../inc/includes.php');

$prof_id =	$_POST["id"];
$isset = $_POST["box_is_set"];

if($isset == 1) {

$insert = "INSERT INTO glpi_plugin_invoice_profiles (profiles_id, is_set)
					VALUES ('$prof_id', '$isset')
					ON DUPLICATE KEY UPDATE is_set='$isset'";

	$DB->query($insert) or die ("error");

} else {

$delete = "DELETE FROM glpi_plugin_invoice_profiles
					WHERE profiles_id='$prof_id'";

	$DB->query($delete) or die ("error");
}

echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=../../../front/profile.form.php?id=".$prof_id."'>";

?>
