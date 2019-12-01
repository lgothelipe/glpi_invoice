<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginInvoiceConfig extends CommonDBTM {

  static function getServicesPage() {
    global $DB;

    $date = new DateTime();
  	$date->modify("last day of this month");

    $rowedit['entities_id'] = '';
    $rowedit['name'] = '';
    $rowedit['cost'] = '';
    $rowedit['content'] = '';
    $rowedit['start_date'] = date('Y-m-01');
    $rowedit['end_date'] = $date->format("Y-m-d");

      if(!empty($_GET['id'])) {

        $query_edit = "SELECT *
        FROM glpi_plugin_invoice_services
        WHERE id = ".$_GET['id'];
        $result_edit = $DB->query($query_edit) or die ("erro");
        $rowedit = $DB->fetch_assoc($result_edit);

      }

    echo "<div class='center' id='tabsbody'>";
    echo "<form name='form' action='config.form.php' method='post'>";
    echo Html::hidden('config_context', ['value' => 'services']);
    echo Html::hidden('config_class', ['value' => __CLASS__]);
    echo "<table class='tab_cadre_fixe' style='width:100%;'>";

      if(!empty($_GET['id'])) {
        echo "<tr><th>" . __('Edit monthly service') . "</th></tr>";
      } else {
        echo "<tr><th>" . __('Add monthly services') . "</th></tr>";
      }

    echo "</table>";
    echo "<table class='tab_cadre_fixehov'>";
    echo "<tr class='tab_bg_2'>";
    echo "<td width='10%'>" . __('Entity') . ":<span class='required'>*</span></td>";
    echo "<td colspan='3>";
    Dropdown::show('Entity', array('value' => $rowedit['entities_id']));
    echo "</td></tr>\n";
    echo "<tr class='tab_bg_2'>";
    echo "<td width='10%'>" . __('Name') . ":<span class='required'>*</span></td>";
    echo "<td><input type='text' class='form-control' name='name' value='" . $rowedit['name'] . "'></td>";
    echo "<td width='10%'>" . __('Cost') . ":<span class='required'>*</span></td>";
    echo "<td><input type='text' class='form-control' name='cost' value='" . $rowedit['cost'] . "'></td>";
    echo "</tr>\n";
    echo "<tr class='tab_bg_2'>";
    echo "<td width='10%'>" . __('Description') . ":<span class='required'>*</span></td>";
    echo "<td colspan='3'><input type='text' class='form-control' name='content' value='" . $rowedit['content'] . "' style='width: 80%;'></td>";
    echo "</tr>\n";
    echo "<tr class='tab_bg_2'>";
    echo "<td width='10%'>" . __('Start date') . ":<span class='required'>*</span></td>";
    echo "<td width='30%'>";
    Html::showDateFormItem("start_date", $rowedit['start_date'], false, true);
    echo "<td width='10%'>" . __('End date') . ":<span class='required'>*</span></td>";
    echo "<td width='30%'>";
    Html::showDateFormItem("end_date", $rowedit['end_date'], false, true);
    echo "</td></tr>\n";
      if(!empty($_GET['id'])) {
        echo "<input type='hidden' name='id' value=".$_GET['id'].">";
        echo "<input type='hidden' name='type' value='update'>";
      }
    echo "</table>";
    echo "<br>";
    echo "<tr class='tab_bg_2'>";
    echo "<td  class='center'>";
    echo "<input type='submit' name='save' class='submit' value=\"" . _sx('button', 'Save') . "\">";
    echo "</td></tr>";
    echo "</table></div>";
  	Html::closeForm();
    echo "<br>";

    $serv_extra = "SELECT a.id, b.name as entity, a.name, a.cost, a.content, a.start_date, a.end_date
    FROM glpi_plugin_invoice_services a
    INNER JOIN glpi_entities b on a.entities_id = b.id
    ORDER BY b.name ASC;";
    $serv_result = $DB->query($serv_extra) or die ("erro");

      if(!empty($serv_result->num_rows)) {
        echo "<div class='center' id='tabsbody'>";
        echo "<table class='tab_cadre_fixe' style='max-width:1120px;'>";
        echo "<tr><th>" . __('Monthly services') . "</th></tr>";
        echo "</table>";
        echo "<table class='tab_cadre_fixehov' style='max-width:1120px'>";
        echo "<tr class='tab_bg_2' style='text-align:left'>";
        echo "<td width='10%'><b>" . __('Entity') . "</td>";
        echo "<td width='15%'><b>" . __('Name') . "</td>";
        echo "<td width='5%'><b>" . __('Cost') . "</td>";
        echo "<td width='30%'><b>" . __('Description') . "</td>";
        echo "<td width='10%'><b>" . __('Start date') . "</td>";
        echo "<td width='10%'><b>" . __('End date') . "</td>";
        echo "<td style='text-align:center' width='10%'><b>" . __('Action') . "</td>";
        echo "</tr>\n";
      	echo "<tr class='tab_bg_2'>";

      	  if(!empty($serv_result)) {
        		while($serv_row = $DB->fetch_assoc($serv_result)) {
              echo "<td>" . $serv_row["entity"] . "</td>";
              echo "<td>" . $serv_row["name"] . "</td>";
          	  echo "<td>$ " . $serv_row["cost"] . "</td>";
              echo "<td>" . $serv_row["content"] . "</td>";
              echo "<td>". Html::convDateTime($serv_row["start_date"]). "</td>";
              echo "<td>". Html::convDateTime($serv_row["end_date"]). "</td>";
              echo "<td style='text-align:center'><a href=config.php?config=services&id=" . $serv_row['id'] . " class='link' style='padding-right: 25px'><img alt='Edit' title='Edit' src='../images/edit.png' width='15px' height='15px' hspace='10' /></a>
              <a href=config.form.php?id=" . $serv_row['id'] . "&context=services class='link'><img alt='Delete' title='Delete' src='../images/delete.png' width='15px' height='15px'hspace='10' /></a></td>";
          	  echo "</tr>\n";
            }
          }
        echo "</table>";
        echo "<br><br>";
      }
  }

  static function getEmailPage() {
    global $DB;

    $query_e = "SELECT *
    FROM glpi_plugin_invoice_email";
    $result_e = $DB->query($query_e) or die ("erro");
    $row_e = $DB->fetch_assoc($result_e);

    echo "<div class='center' id='tabsbody'>";
    echo "<form name='form' action='config.form.php' method='post'>";
    echo Html::hidden('config_context', ['value' => 'email']);
    echo Html::hidden('config_class', ['value' => __CLASS__]);
    echo "<table class='tab_cadre_fixe' style='width:100%;'>";
    echo "<tr><th>" . __('Email server configuration') . "</th></tr>";
    echo "</table>";
    echo "<table class='tab_cadre_fixehov'>";
    echo "<tr class='tab_bg_2'>";
    echo "<td width='15%'>" . __('Host') . ":<span class='required'>*</span></td>";
    echo "<td><input type='text' class='form-control' name='host' value='" . $row_e['host'] . "'></td>";
    echo "<td width='15%'>" . __('Port') . ": (TLS enabled)<span class='required'>*</span></td>";
    echo "<td><input type='text' class='form-control' name='port' value='" . $row_e['port'] . "'></td>";
    echo "</tr>";
    echo "<tr class='tab_bg_2'>";
    echo "<td width='15%'>" . __('User') . ":<span class='required'>*</span></td>";
    echo "<td><input type='text' class='form-control' name='user' value='" . $row_e['user'] . "'></td>";
    echo "<td width='15%'>" . __('Password') . ":<span class='required'>*</span></td>";
    echo "<td><input type='password' class='form-control' name='password' value='**********'></td>";
    echo "</tr>";
    echo "<input type='hidden' name='id' value=".$row_e['id'].">";
    echo "</table><br>";
    echo "<tr class='tab_bg_2'>";
    echo "<td class='center'>";
    echo "<input type='submit' name='save' class='submit' value=\"" . _sx('button', 'Save') . "\">";
    echo "</td></tr>";
    echo "</table></div>";
    Html::closeForm();
    echo "<br>";

    // recipients
		$row_d['entities_id'] = '';
		$row_d['email_from'] = '';
		$row_d['email_to'] = '';

      if(!empty($_GET['id'])) {
        $query_d = "SELECT *
        FROM glpi_plugin_invoice_recipients
        WHERE id = ".$_GET['id'];
        $result_d = $DB->query($query_d) or die ("erro");
        $row_d = $DB->fetch_assoc($result_d);
    	}

    echo "<div class='center' id='tabsbody'>";
    echo "<form name='form' action='config.form.php' method='post'>";
    echo Html::hidden('config_context', ['value' => 'recipients']);
    echo Html::hidden('config_class', ['value' => __CLASS__]);
    echo "<table class='tab_cadre_fixe' style='width:100%;'>";

      if(!empty($_GET['id'])) {
        echo "<tr><th>" . __('Edit recipients') . "</th></tr>";
      } else {
        echo "<tr><th>" . __('Add recipients') . "</th></tr>";
      }

    echo "</table>";
    echo "<table class='tab_cadre_fixehov'>";
    echo "<tr class='tab_bg_2'>";
    echo "<td>" . __('Entity') . ":<span class='required'>*</span></td>";
    echo "<td style='padding-right:60px;'>";
    Dropdown::show('Entity', array('value' => $row_d['entities_id']));
    echo "</td>";
    echo "<td>" . __('From') . ":<span class='required'>*</span></td>";
    echo "<td style='padding-right:60px;'><input style='width:180px;' type='text' class='form-control' name='email_from' value='" . $row_d['email_from'] . "'></td>";
    echo "</td>";
    echo "<td>" . __('To') . ":<span class='required'>*</span></td>";
    echo "<td style='padding-right:60px;'><input style='width:180px;' type='text' class='form-control' name='email_to' value='" . $row_d['email_to'] . "'></td>";
    echo "</td></tr>";
      if(!empty($_GET['id'])) {
        echo "<input type='hidden' name='id' value=".$_GET['id'].">";
        echo "<input type='hidden' name='type' value='update'>";
      }
    echo "</table><br>";

    echo "<tr class='tab_bg_2'>";
    echo "<td class='center'>";
    echo "<input type='submit' name='save' class='submit' value=\"" . _sx('button', 'Save') . "\">";
    echo "</td></tr>";
    echo "</table></div>";
    Html::closeForm();
    echo "<br>";

    //show recipients
    $dest = "SELECT a.id, b.name, a.entities_id, a.email_from, a.email_to
    FROM glpi_plugin_invoice_recipients a
    INNER JOIN glpi_entities b on a.entities_id = b.id
    ORDER BY a.entities_id asc";
    $dest_result = $DB->query($dest) or die ("erro get dest");

      if (!empty($dest_result->num_rows)) {
        echo "<div class='center' id='tabsbody'>";
        echo "<table class='tab_cadre_fixe' style='width:100%;'>";
        echo "<tr><th>" . __('Recipients') . "</th></tr>";
        echo "</table>";

        echo "<table class='tab_cadre_fixehov'>";
        echo "<tr class='tab_bg_2'>";
        echo "<td width='20%'><b>" . __('Entity') . "</td>";
        echo "<td width='20%'><b>" . __('From') . "</td>";
        echo "<td width='20%'><b>" . __('To') . "</td>";
        echo "<td style='text-align:center' width='20%'><b>" . __('Action') . "</td>";
        echo "</tr>\n";
        echo "<tr class='tab_bg_2'>";
          if(!empty($dest_result)) {
            while($d_row = $DB->fetch_assoc($dest_result)) {
              echo "<td width='20%'>" . $d_row["name"] . "</td>";
              echo "<td width='20%'>" . $d_row["email_from"] . "</td>";
              echo "<td width='20%'>" . $d_row["email_to"] . "</td>";
              echo "<td style='text-align:center' width='20%'><a href=config.php?config=email&id=" . $d_row['id'] . " class='link' style='padding-right: 25px'><img alt='Edit' title='Edit' src='../images/edit.png' width='15px' height='15px' hspace='10' /></a>
              <a href=config.form.php?id=" . $d_row['id'] . "&context=recipients class='link'><img alt='Delete' title='Delete' src='../images/delete.png' width='15px' height='15px'hspace='10' /></a></td>";
              echo "</tr>";
            }
          }
        echo "</table><br>";
      }
  }

  static function getCategoriesPage() {
    global $DB;

    $row_c['cost'] = '';
    $row_c['taskcategories_id'] = '';

      if(!empty($_GET['id'])) {
         $query_c = "SELECT *
         FROM glpi_plugin_invoice_categories
         WHERE id = '".$_GET['id']."'";
         $result_c = $DB->query($query_c) or die ("erro invoice categories");
         $row_c = $DB->fetch_assoc($result_c);
      }

      echo "<div class='center' id='tabsbody'>";
      echo "<form name='form' action='config.form.php' method='post'>";
      echo Html::hidden('config_context', ['value' => 'categories']);
      echo Html::hidden('config_class', ['value' => __CLASS__]);
      echo "<table class='tab_cadre_fixe' style='width:100%;'>";
        if(!empty($_GET['id'])) {
          echo "<tr><th>" . __('Edit category cost') . "</th></tr>";
        } else {
          echo "<tr><th>" . __('Add category cost') . "</th></tr>";
        }
      echo "</table>";
      echo "<table class='tab_cadre_fixehov'>";
      echo "<tr class='tab_bg_2'>";
      echo "<td width='15%'>" . __('Task category') . ":<span class='required'>*</span></td>";
      echo "<td width='35%'>";
      TaskCategory::dropdown(array('value'  => $row_c['taskcategories_id'],
                                   'entity' => $_SESSION['glpiactive_entity'],
                                   'condition' => "`is_active` = '1'"));
      echo "</td>";
      echo "<td width='15%'>" . __('Cost') . "<span class='required'>:* </span></td>";
      echo "<td>";
      echo "<input width='35%' type='text' class='form-control' name='cost' value=".$row_c['cost']."></td>";
      echo "</tr>\n";
        if(!empty($_GET['id'])) {
          echo "<input type='hidden' name='id' value=".$_GET['id'].">";
          echo "<input type='hidden' name='type' value='update'>";
        }
      echo "</table>";
      echo "<br>";
      echo "<tr class='tab_bg_2'>";
      echo "<td class='center'>";
      echo "<input type='submit' name='save' class='submit' value=\"" . _sx('button', 'Save') . "\">";
      echo "</td></tr>";
      echo "</table></div>";
      Html::closeForm();
      echo "<br>";

      $taskcat = "SELECT a.id, b.name, cost
      FROM glpi_plugin_invoice_categories a
      INNER JOIN glpi_taskcategories b on a.taskcategories_id = b.id
      ORDER BY b.name ASC";
      $tc_result = $DB->query($taskcat) or die ("erro get dest");

        if(!empty($tc_result->num_rows)) {
          echo "<div class='center' id='tabsbody'>";
          echo "<table class='tab_cadre_fixe' style='width:100%;'>";
          echo "<tr><th>" . __('Task categories cost') . "</th></tr>";
          echo "</table>";
          echo "<table class='tab_cadre_fixehov'>";
          echo "<tr class='tab_bg_2'>";
          echo "<td width='40%'><b>" . __('Task category') . "</td>";
          echo "<td width='40%'><b>" . __('Cost') . "</td>";
          echo "<td style='text-align:center' width='20%'><b>" . __('Action') . "</td>";
          echo "</tr>\n";
          echo "<tr class='tab_bg_2'>";
            if(!empty($tc_result))	 {
              while($tc_row = $DB->fetch_assoc($tc_result)) {
                echo "<td width='40%'>" . $tc_row["name"] . "</td>";
                echo "<td width='40%'>$" . $tc_row["cost"] . "</td>";
                echo "<td style='text-align:center' width='20%'><a href=config.php?config=categories&id=" . $tc_row['id'] . " class='link' style='padding-right: 25px'><img alt='Edit' title='Edit' src='../images/edit.png' width='15px' height='15px' hspace='10' /></a>
                <a href=config.form.php?id=" . $tc_row['id'] . "&context=categories class='link'><img alt='Delete' title='Delete' src='../images/delete.png' width='15px' height='15px'hspace='10' /></a></td>";
                echo "</tr>\n";
              }
            }
          echo "</table>";
          echo "<br><br>";
        }
  }
}
