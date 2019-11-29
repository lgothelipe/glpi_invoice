<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

class PluginInvoiceInvoice extends CommonDBTM {


   static protected $notable = true;

   /**
    * @see CommonGLPI::getMenuName()
   **/
   static function getMenuName() {
      return __('Invoice');
   }

   /**
    * @see PluginInvoiceInvoice::getRightProf()
	based on profile tab Invoice
   **/
  public static function getRightProf(){
	  global $DB;

	  $activeprofile = $_SESSION['glpiactiveprofile']['id'];

	  $query_rgt = "SELECT is_set
    FROM glpi_plugin_invoice_profiles
    WHERE profiles_id = ".$activeprofile;

    $result_rgt = $DB->query($query_rgt);
	  $rgt = $DB->fetch_assoc($result_rgt);

	  return $rgt['is_set'];

  }

   /**
    *  @see CommonGLPI::getMenuContent()
    *
    *  @since version 0.5.6
   **/
   static function getMenuContent() {
   	global $CFG_GLPI;

	if (self::getRightProf() == 1) {


   	$menu = array();

      $menu['title']   = __('Invoice','invoice');
      $menu['page']    = '/plugins/invoice/front/invoice.php';

      $image = "<img src='".
            $CFG_GLPI["root_doc"]."/pics/options_search.png' title='".
            _n('Configurations', 'Configurations', 2, 'invoice')."' alt='".
            _n('Configurations', 'Configurations', 2, 'invoice')."'>";

      $menu['links'][$image]                          = "/plugins/invoice/front/config.php";

   	return $menu;
	}

   }

}
?>
