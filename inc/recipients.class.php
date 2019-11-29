<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginInvoiceRecipients extends CommonDBTM {

  function __construct() {
    $this->getTable();
      if (!empty($_POST)) {
            $this->fields['entities_id'] = $_POST['entities_id'];
            $this->fields['email_from'] = $_POST['email_from'];
            $this->fields['email_to'] = $_POST['email_to'];
            $this->fields['id'] = $_POST['id'];
      }
      if (!empty($_GET)) {
        $this->fields['id'] = $_GET['id'];
      }
  }
}
