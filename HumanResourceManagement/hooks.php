<?php
// ----------------------------------------------------------------
// Creator: Mizan & Kvvaradha
// email:   admin@kvcodes.com
// Title:   Tutorial Hook For HRM
// ----------------------------------------------------------------
define ('SS_HRM', 250<<8);
include_once($path_to_root . "/modules/HumanResourceManagement/HumanResourceManagement.php");

class hooks_HumanResourceManagement extends hooks {
	var $module_name = 'HumanResourceManagement';

	/*
		Install additonal menu options provided by module
	*/
    function install_tabs($app) {
        $app->add_application(new HumanResourceManagement_app);
    }
  
    function install_access()
	{
        $security_sections[SS_HRM] =  _("HRM");

        $security_areas['SA_HRMSETUP'] = array(SS_HRM|1, _("HRM Setup"));
        $security_areas['SA_EMPLOYEE'] = array(SS_HRM|2, _("Employee"));

		return array($security_areas, $security_sections);
	}

    /* This method is called on extension activation for company.   */
    function activate_extension($company, $check_only=true)
    {
        global $db_connections;

        $updates = array(
            'kv_empl.sql' => array('dashboard_widgets')
        );

        return $this->update_databases($company, $updates, $check_only);
    }

    function deactivate_extension($company, $check_only=true)
    {
        global $db_connections;

        $updates = array(
            'kv_empl_drop.sql' => array('ugly_hack') // FIXME: just an ugly hack to clean database on deactivation
        );

        return $this->update_databases($company, $updates, $check_only);
    }
}

?>