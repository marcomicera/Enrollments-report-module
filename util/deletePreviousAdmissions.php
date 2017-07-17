<?php
	require_once "../helper.php";

	// Imports the Joomla library in order to use its API
	// (JFactory object used in ModEnrollmentsReportHelper::deleteData())
	define('_JEXEC', 1);
    define('JPATH_BASE', realpath(dirname(__FILE__).'/../../../'));  
    require_once(JPATH_BASE .'/includes/defines.php');
    require_once(JPATH_BASE .'/includes/framework.php');
    $mainframe = JFactory::getApplication('site');

	// Empties the student form table
	ModEnrollmentsReportHelper::deleteData();

	$dir = '../../mod_student_form/uploads/';
	$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
	$files = new RecursiveIteratorIterator(
		$it,
		RecursiveIteratorIterator::CHILD_FIRST
	);

	foreach($files as $file) {
		if($file->isDir())
			rmdir($file->getRealPath());
		else
			unlink($file->getRealPath());
	}