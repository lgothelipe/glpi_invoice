<?php

	// GLPI_ROOT
	define('GLPI_ROOT', '../../..');
	include (GLPI_ROOT . "/inc/includes.php");

	Html::header("Invoice", $_SERVER['PHP_SELF'], 'management', 'plugininvoiceinvoice');

	//check right
	if(PluginInvoiceInvoice::getRightProf('show_invoice') == 1) {

	$date = new DateTime();
	$date->modify("first day of previous month");
	$startdate = $date->format("Y-m-d");

	$date = new DateTime();
	$date->modify("last day of previous month");
	$enddate = $date->format("Y-m-d");
	$rand = rand(10001,99999);

	//report
  echo "<div class='center' id='tabsbody'>";
  echo "<form name='report' action='report.php' method='post'>";
  echo Html::hidden('context', ['value' => 'invoice_page']);

  echo "<table class='tab_cadre_fixe' style='width:95%;'>";
  echo "<tr><th colspan='4'>1. Invoice Preview</th></tr>";
  echo "</table>";

  echo "<table class='tab_cadre_fixehov'>";

  echo "<tr class='tab_bg_2' style='text-align:center'>";
	echo "<td>" .__('Start date') . ": ";
	Html::showDateField("start_date", array('value'      => $startdate, //yyyy-mm-dd
																					'maybeempty' => false,
																					'canedit'    => true,
																					'min'        => '',
																					'max'        => '',
																					'showyear'   => true));
  echo "</td>";

	echo "<td>" .__('End date') . ": ";
	Html::showDateField("end_date", array('value'        => $enddate,
  																			  'maybeempty' => false,
  																			  'canedit'    => true,
  																			  'min'        => '',
  																			  'max'        => '',
  																			  'showyear'   => true));
	echo "</td>";

  echo "<td>Client: ";
  echo "<select name='client'>";
  echo "<option value='select' selected>Select client</option>";
	$sqlquery = "SELECT id, name FROM glpi_entities ORDER BY name";
	$result = $DB->query($sqlquery) or die ("erro");
	while ($rows = $DB->fetch_assoc($result)) {
  echo "<option value='".$rows['id']."'>".$rows['name']."</option>";
  }
  echo "</select></td>";
  echo "<td><input type='submit' value='Preview' class='submit' style='width: 56px;'></td>";
  echo "</tr>\n";

  echo "<tr class='tab_bg_2' style='text-align:center'>";
  echo "<td>".__('Invoice')."#: ";
  echo "<input style='width: 20%;' type='text' name='invonum' value=".$rand."></td>";
  echo "<td>" .__('Due Date') . ": ";
  echo "<input style='width: 25%;' type='text' name='due_date' value=".date('05/m/Y')."></td>";
  echo "<td>" .__('Tax') . " %: ";
  echo "<input style='width: 15%;' type='text' name='tax' value='10'></td>";
  echo "<td></td>";
  echo "</tr>\n";
  Html::closeForm();
  echo "</table></div>";

  echo "<br><br>";

	//email
  echo "<div class='center' id='tabsbody'>";
  echo "<form name='email' action='email.form.php' method='post' enctype='multipart/form-data'>";

  echo "<table class='tab_cadre_fixe' style='width:95%;'>";
  echo "<tr><th colspan='4'>2. Send Invoice via email</th></tr>";
  echo "</table>";


  echo "<table class='tab_cadre_fixehov'>";
  echo "<tr class='tab_bg_2' style='text-align:center'>";
	echo "<td>" .__('Start date') . ": ";
	Html::showDateField("start_date", array('value'      => $startdate, //yyyy-mm-dd
																					'maybeempty' => false,
																					'canedit'    => true,
																					'min'        => '',
																					'max'        => '',
																					'showyear'   => true));
  echo "</td>";

	echo "<td>" .__('End date') . ": ";
	Html::showDateField("end_date", array('value'        => $enddate,
  																			  'maybeempty' => false,
  																			  'canedit'    => true,
  																			  'min'        => '',
  																			  'max'        => '',
  																			  'showyear'   => true));
	echo "</td>";

  echo "<td>Client: ";
  echo "<select name='client'>";
  echo "<option value='' selected>Select client</option>";
	$result = $DB->query($sqlquery) or die ("erro");
	while ($rows = $DB->fetch_assoc($result)) {
  echo "<option value='".$rows['id']."'>".$rows['name']."</option>";
  }
  echo "</select></td>";
  echo "<td><input type='submit' value='Send' class='submit' style='width: 56px;'></td>";
  echo "</tr>\n";

  echo "<tr class='tab_bg_2' style='text-align:center'>";
	echo "<td>".__('Invoice')."#: ";
  echo "<input style='width: 20%;' type='text' name='invonum' value=".$rand."></td>";
  echo "<td>" .__('Due Date') . ": ";
  echo "<input style='width: 25%;' type='text' name='due_date' value=".date('05/m/Y')."></td>";
  echo "<td>" .__('Tax') . " %: ";
  echo "<input style='width: 15%;' type='text' name='tax' value='10'></td>";
  echo "<td></td>";
  echo "</tr>\n";
  Html::closeForm();
  echo "</table></div>";
	Html::footer();
	}
		else {
			//Permission error
			Html::displayRightError();
		}
?>
