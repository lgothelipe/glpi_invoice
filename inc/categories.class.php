<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginInvoiceCategories extends CommonDBTM {

  function __construct() {
    $this->getTable();
      if (!empty($_POST)) {
            $this->fields['taskcategories_id'] = $_POST['taskcategories_id'];
            $this->fields['cost'] = $_POST['cost'];
            $this->fields['id'] = $_POST['id'];
      }
      if (!empty($_GET)) {
        $this->fields['id'] = $_GET['id'];
      }
  }
}
