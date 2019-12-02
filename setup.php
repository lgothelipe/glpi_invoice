<?php

define ('PLUGIN_INVOICE_VERSION', '1.1.0');

/**
 * Init the hooks of the plugins - Needed
 *
 * @return void
 */
function plugin_init_invoice() {
   global $PLUGIN_HOOKS, $LANG;

  Plugin::registerClass('PluginInvoiceProfile', [
      'addtabon' => ['Profile']
   ]);

    $PLUGIN_HOOKS['csrf_compliant']['invoice'] = true;
    $PLUGIN_HOOKS["menu_toadd"]['invoice'] = array('management'  => 'PluginInvoiceInvoice');
    $PLUGIN_HOOKS['config_page']['invoice'] = 'front/config.php';

}

/**
 * Get the name and the version of the plugin - Needed
 *
 * @return array
 */

 function plugin_version_invoice() {
   return [
      'name'           => 'Invoice',
      'version'        => '1.1.0',
      'author'         => 'Lucas Gothelipe',
      'license'        => 'GLPv3',
      'homepage'       => 'https://github.com/lgothelipe/glpi_invoice',
      'requirements'   => [
         'glpi'   => [
            'min' => '9.4'
         ]
      ]
   ];
}

function plugin_invoice_check_prerequisites(){
        if (GLPI_VERSION>=9.4){
                return true;
        } else {
                echo "GLPI version NOT compatible. Requires GLPI 9.4";
        }
}


function plugin_invoice_check_config($verbose=false){
	if ($verbose) {
		echo 'Installed / not configured';
	}
	return true;
}

?>
