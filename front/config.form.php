<?php
// GLPI_ROOT
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT . "/inc/includes.php");

// Check if plugin is activated...
$plugin = new Plugin();
if (!$plugin->isInstalled('invoice') || !$plugin->isActivated('invoice')) {
Html::displayNotFoundError();
}

if ($_POST['config_context'] == 'services' || $_GET['context'] == 'services') {

  $object = new PluginInvoiceServices();
  $updates = array('entities_id', 'name', 'cost', 'content', 'start_date', 'end_date');

} else if ($_POST['config_context'] == 'recipients' || $_GET['context'] == 'recipients') {

  $object = new PluginInvoiceRecipients();
  $updates = array('entities_id', 'email_from', 'email_to');

} else if ($_POST['config_context'] == 'categories' || $_GET['context'] == 'categories') {

  if ($_POST['taskcategories_id'] == 0) {
    $_POST['taskcategories_id'] = '';
  }
  $object = new PluginInvoiceCategories();
  $updates = array('taskcategories_id', 'cost');

} else if ($_POST['config_context'] == 'email') {

  if ($_POST["password"] != '**********') {
    $update = "UPDATE glpi_plugin_invoice_email
    SET host='" . $_POST["host"] . "', port='" . $_POST["port"] . "', user='" . $_POST["user"] . "',  password='" . $_POST["password"] . "'
    WHERE id =" . $_POST["id"];
    $DB->query($update) or die ("error updating email");
  }
  Html::back();
}

if (!isset($_POST['id']) && !in_array("", $_POST) && empty($_GET)) {
  //Do add to DB
  $object->addToDB();
  //Redirect to form
  Html::back();
} else if (isset($_POST['id']) && isset($_POST['type'])) {
  //Do update
  $object->updateInDB($updates);
  //Redirect to object form
    if ($_POST['config_context'] == 'recipients') {
      die ("<meta HTTP-EQUIV='refresh' CONTENT='0;URL=config.php?config=email'>");
    } else {
      die ("<meta HTTP-EQUIV='refresh' CONTENT='0;URL=config.php?config=".$_POST['config_context']."'>");
    }
} else if (isset($_GET['id']) && isset($_GET['context'])) {
  //Do purge
  $object->deleteFromDB('1');
  //Redirect to object form
  Html::back();
}

//Redirect to form
Html::back();
