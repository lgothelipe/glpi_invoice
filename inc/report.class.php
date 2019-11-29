
<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginInvoiceReport extends CommonDBTM {

  function getEntityDetails($ID, $options='var') {
    global $DB;

    $query = "SELECT name, email, address, phonenumber
    FROM glpi_entities WHERE id =".$ID;

    $result = $DB->query($query) or die ("erro");
    $row = $DB->fetch_assoc($result);

    $this->fields["$options"]['name'] = $row['name'];
    $this->fields["$options"]['email'] = $row['email'];
    $this->fields["$options"]['address'] = $row['address'];
    $this->fields["$options"]['phonenumber'] = $row['phonenumber'];
  }

  function getSeller($ID) {
    $this->getEntityDetails($ID,'seller');

  }

  function getClient($ID) {
    $this->getEntityDetails($ID,'client');
  }

  static function getDateFormat() {

  switch ($_SESSION['glpidate_format']) {

     case 1 :
        return $format='d/m/Y';
        break;

     case 2 :
        return $format='m/d/Y';
        break;

     default :
        return $format='Y/m/d';
      }
    }

  function getTasks($ID) {
    global $DB;

    $sd = new DateTime($_POST['_start_date']);
    $ed = new DateTime($_POST['_end_date']);

    $date_start = "'". $sd->format("Y-m-d") ." 00:00:00'";
    $date_end = "'". $ed->format("Y-m-d") ." 23:59:59'";

    $tasks = "SELECT DATE_FORMAT(c.date, '%d/%m/%Y') as date, a.id as tID, h.cost, c.content as task, SEC_TO_TIME(c.actiontime) as time, c.actiontime, (h.cost * c.actiontime / 3600) as totalcost
    FROM glpi_tickets a
    INNER JOIN glpi_entities b on a.entities_id = b.id
    INNER JOIN glpi_tickettasks c on a.id = c.tickets_id
    INNER JOIN glpi_taskcategories e on c.taskcategories_id = e.id
    INNER JOIN glpi_plugin_invoice_categories h ON e.id = h.taskcategories_id
    WHERE b.id = " . $ID . "
    AND c.date > " . $date_start . "
    AND c.date < " . $date_end . "
    ORDER BY c.date desc";

    $this->fields['tasks'] = $DB->query($tasks) or die ('error');

    $sumt = '';
    $result_tasks = $DB->query($tasks);
    while($row_tasks = $DB->fetch_assoc($result_tasks)) {
    $sumt = $sumt + $row_tasks["totalcost"];
    }
    $this->fields['sumt'] = $sumt;
  }

  function getServices($ID) {
    global $DB;

    $sd = new DateTime($_POST['_start_date']);
    $yearmonth = $sd->format("Ym");

    $services = "SELECT *
    FROM glpi_plugin_invoice_services
    WHERE entities_id = " . $ID . "
    AND '". $yearmonth ."'  >= DATE_FORMAT(start_date,'%Y%m')
    AND '".$yearmonth."' <= DATE_FORMAT(end_date,'%Y%m')";

    $this->fields['services'] = $DB->query($services) or die ('error');

    //sum cost services
    $sumserv = '';
    $result_serv = $DB->query($services) or die ('error');
    while($row_serv = $DB->fetch_assoc($result_serv)) {
      $sumserv = $sumserv + $row_serv["cost"];
    }
    $this->fields['sumserv'] = $sumserv;

  }

}
