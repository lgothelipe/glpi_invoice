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
      echo Html::hidden('config_context', ['value' => 'invoice_rights']);
      echo Html::hidden('config_class', ['value' => __CLASS__]);
      echo "<div class='center' id='tabsbody'>";
      echo "<table class='tab_cadre_fixehov'>";
      echo "<tr class='tab_bg_5'><th colspan='2'>".__('Invoice Plugin')."</th></tr>\n";

      echo "<tr class='tab_bg_2'>";
      echo "<td width=30%>".__('Preview invoices')."</td><td>";
      Html::showCheckbox(array('name'    => 'show_invoice',
                               'checked' => $effective_rights['show_invoice']));
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_2'>";
      echo "<td width=30%>".__('Send invoices via email')."</td><td>";
      Html::showCheckbox(array('name'    => 'email_invoice',
                               'checked' => $effective_rights['email_invoice']));
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_2'>";
      echo "<td width=30%>".__('Ivoice configuration')."</td><td>";
      Html::showCheckbox(array('name'    => 'config_invoice',
                               'checked' => $effective_rights['config_invoice']));
      echo "</td></tr>\n";

      if ($canedit) {
         echo "<tr class='tab_bg_1'>";
         echo "<td colspan='4' class='center'>";
         echo "<input type='hidden' name='profiles_id' value='".$_GET['id']."'>";
         echo "<input type='hidden' name='is_set' value='".$effective_rights['is_set']."'>";
         echo "<input type='submit' name='update' value=\""._sx('button','Save')."\" class='submit'>";
         echo "</td></tr>\n";
         echo "</table>\n";
         Html::closeForm();
      } else {
         echo "</table>\n";
      }
      echo "</div>";
   }
}
?>
