<?php
	/* From: https://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
	 *
	 * This file is the main entry point for the module.
	 * It includes the template which will display the module output.
	 */
	
	// Checks to make sure that this file is being included from the Joomla! application.
	defined('_JEXEC') or die;

	// Includes the template file 'tmpl/default.php'
	require JModuleHelper::getLayoutPath('mod_enrollments_report');