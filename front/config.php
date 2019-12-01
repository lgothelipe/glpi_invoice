<?php

// GLPI_ROOT
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

Html::header(__('Invoice Config'), $_SERVER['PHP_SELF'], 'management', 'plugininvoiceinvoice');

//check right
if(PluginInvoiceInvoice::checkProfileRight()['config_invoice'] == 1) {

echo "<div class='center' id='tabsbody'>";
echo "<table class='tab_cadre_fixe' style='width:95%;'>";
echo "<tr style='font-weight: bold; text-align: center; font-size: 1.1em; padding: 10px 5px;'>";
echo "<td style='padding: 10px 5px;'><a href='config.php?config=services'>Services</td>";
echo "<td style='padding: 10px 5px;'><a href='config.php?config=email'>Email Configuration</td>";
echo "<td style='padding: 10px 5px;'><a href='config.php?config=categories'>Categories</td>";
echo "</tr>\n";
echo "</table>";
echo "</div><br>";


if(empty($_GET['config'])) {
$_GET['config'] = 1;
}

switch ($_GET['config']) {

	 case 'services' :
			PluginInvoiceConfig::getServicesPage();
			break;

	 case 'email' :
			PluginInvoiceConfig::getEmailPage();
			break;

	 case 'categories' :
	 		PluginInvoiceConfig::getCategoriesPage();
			break;

	 default :
			PluginInvoiceConfig::getServicesPage();

		}

  Html::footer();

}

	else {
			//Permission error
			Html::displayRightError();
	}

?>
