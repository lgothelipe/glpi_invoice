<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginInvoiceServices extends CommonDBTM {

  function __construct() {
    $this->getTable();
      if (!empty($_POST)) {
        $this->fields['entities_id'] = $_POST['entities_id'];
        $this->fields['name'] = $_POST['name'];
        $this->fields['cost'] = $_POST['cost'];
        $this->fields['content'] = $_POST['content'];
        $this->fields['start_date'] = $_POST['start_date'];
        $this->fields['end_date'] = $_POST['end_date'];
        $this->fields['id'] = $_POST['id'];
      }
      if (!empty($_GET)) {
        $this->fields['id'] = $_GET['id'];
      }
    }
  }
