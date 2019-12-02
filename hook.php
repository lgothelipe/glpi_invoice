<?php
/**
 * Install hook
 *
 * @return boolean
 */
function plugin_invoice_install() {
	global $DB, $LANG;

	//Create table only if it does not exists yet!
   if (!$DB->tableExists('glpi_plugin_invoice_profiles')) {
      //table creation query

	  $query = "CREATE TABLE `glpi_plugin_invoice_profiles` (
                  `id` int(11) NOT NULL auto_increment,
				  `profiles_id` int(11) NOT NULL,
					`show_invoice` int(11) NOT NULL,
					`email_invoice` int(11) NOT NULL,
					`config_invoice` int(11) NOT NULL,
				  `is_set` int(11) NOT NULL,
				  UNIQUE KEY unique_prof (profiles_id),
                  PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, $DB->error());

   }

	   if (!$DB->tableExists('glpi_plugin_invoice_services')) {
      //table creation query
      $query = "CREATE TABLE `glpi_plugin_invoice_services` (
                  `id` int(11) NOT NULL auto_increment,
				  `entities_id` int(11) NOT NULL,
				  `name` varchar(255) collate utf8_unicode_ci NOT NULL,
				  `cost` decimal(11,2) NOT NULL,
				  `content` varchar(255) collate utf8_unicode_ci NOT NULL,
					`start_date` date NOT NULL,
  				`end_date` date NOT NULL,
                  PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, $DB->error());

	}

		if (!$DB->tableExists('glpi_plugin_invoice_email')) {
      //table creation query
      $query = "CREATE TABLE `glpi_plugin_invoice_email` (
                  `id` int(11) NOT NULL auto_increment,
				  `host` varchar(255) collate utf8_unicode_ci,
				  `port` int(11),
				  `user` varchar(255) collate utf8_unicode_ci,
				  `password` varchar(255) collate utf8_unicode_ci,
                  PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, $DB->error());

			$insert = "INSERT INTO `glpi_plugin_invoice_email` (`id`, `host`, `port`, `user`, `password`)
			VALUES ('1', 'host', '587', 'user', 'password')";

	  	$DB->queryOrDie($insert, $DB->error());

   }

   if (!$DB->tableExists('glpi_plugin_invoice_recipients')) {
      //table creation query
      $query = "CREATE TABLE `glpi_plugin_invoice_recipients` (
                  `id` int(11) NOT NULL auto_increment,
				  `entities_id` int(11) NOT NULL,
				  `email_from` varchar(255) collate utf8_unicode_ci NOT NULL,
				  `email_to` varchar(255) collate utf8_unicode_ci NOT NULL,
				  UNIQUE KEY unique_prof (entities_id),
                  PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, $DB->error());

   }

	 if (!$DB->tableExists('glpi_plugin_invoice_categories')) {
      //table creation query
      $query = "CREATE TABLE `glpi_plugin_invoice_categories` (
                  `id` int(11) NOT NULL auto_increment,
				  `taskcategories_id` int(11) NOT NULL,
				  `cost` decimal(11,2) NOT NULL,
				  UNIQUE KEY unique_prof (taskcategories_id),
                  PRIMARY KEY  (`id`)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, $DB->error());

   }

   return true;
}

/**
 * Uninstall hook
 *
 * @return boolean
 */
function plugin_invoice_uninstall() {
	global $DB;

    if ($DB->tableExists("glpi_plugin_invoice_profiles")) {

		$query = "DROP TABLE `glpi_plugin_invoice_profiles`";
		$DB->query($query) or die("error deleting glpi_plugin_invoice_profiles");
	}

	if ($DB->tableExists("glpi_plugin_invoice_services")) {

		$query = "DROP TABLE `glpi_plugin_invoice_services`";
		$DB->query($query) or die("error deleting glpi_plugin_invoice_services");
	}

	if ($DB->tableExists("glpi_plugin_invoice_email")) {

		$query = "DROP TABLE `glpi_plugin_invoice_email`";
		$DB->query($query) or die("error deleting glpi_plugin_invoice_email");
	}

	if ($DB->tableExists("glpi_plugin_invoice_recipients")) {

		$query = "DROP TABLE `glpi_plugin_invoice_recipients`";
		$DB->query($query) or die("error deleting glpi_plugin_invoice_recipients");
	}

	if ($DB->tableExists("glpi_plugin_invoice_categories")) {

		$query = "DROP TABLE `glpi_plugin_invoice_categories`";
		$DB->query($query) or die("error deleting glpi_plugin_invoice_categories");
	}

   return true;

}
?>
