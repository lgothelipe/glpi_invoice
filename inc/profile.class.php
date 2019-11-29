<?php
if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

/**
 * Class PluginAccountsProfile
 */
class PluginInvoiceProfile extends Profile {

   static $rightname = "profile";

   /**
    * @param CommonGLPI $item
    * @param int        $withtemplate
    *
    * @return string
    */
   public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {

      if ($item->getType() == 'Profile') {
         return __('Invoice');
      }
      return '';
   }

   /**
    * @param CommonGLPI $item
    * @param int        $tabnum
    * @param int        $withtemplate
    *
    * @return bool
    */
   public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {

      if ($item->getType() == 'Profile') {
         $prof = new self();
		 $prof->showFormDisplay();

      }
      return true;
   }

   function showFormDisplay() {

      global $CFG_GLPI, $DB;

      if (!Config::canView()) {
         return false;
      }

      if(isset($_GET['id'])) {
	      $query_rights = "SELECT * FROM glpi_plugin_invoice_profiles WHERE profiles_id = ".$_GET['id'];
	      $result_rights = $DB->query($query_rights) or die ("erro");
  			$effective_rights = $DB->fetch_assoc($result_rights);
  		}

      $canedit = Session::haveRight(Config::$rightname, UPDATE);
      if ($canedit) {
        echo "<form name='form' action='../plugins/invoice/front/prof.form.php' method='post'>";
      }
      echo Html::hidden('config_context', ['value' => 'invoice']);
      echo Html::hidden('config_class', ['value' => __CLASS__]);
      echo "<div class='center' id='tabsbody'>";
      echo "<table class='tab_cadre_fixe' style='width:95%;'>";
      echo "<tr><th>" . __('Setup') . "</th></tr>";
      echo "</table>";
      echo "<table class='tab_cadre_fixehov'>";
      echo "<tr class='tab_bg_2'>";
      echo "<td width='20%'>" . __('View Invoice', 'invoice') . "</td>";
      echo "<td>";
      Html::showCheckbox(array('name'    => 'box_is_set',
                               'checked' => $effective_rights['is_set']));
      echo "</td></tr>\n";
      echo "</table>";
      echo "<td><input type='hidden' id='id' name='id' value=".$_GET['id']."></td>";

      if ($canedit) {
         echo "<tr class='tab_bg_2'>";
         echo "<td class='center'>";
         echo "<input type='submit' name='save' class='submit' value=\"" . _sx('button', 'Save') . "\">";
         echo "</td></tr>";
      }
      echo "</table></div>";
      Html::closeForm();
   }
}
?>
