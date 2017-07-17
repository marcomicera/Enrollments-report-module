<?php
	/* Creates the zip file containing
	   the admissions data. */

	require_once "../config/sheetConfig.php";
	require_once "sheetManager.php";
	require_once "../config/zipConfig.php";
	require_once "zipManager.php";

	$sheet = new SheetManager();

	$zip = new ZipManager();
	// Adds the Excel file to the archive
	$zip->addFile($sheetFileName);
	$zip->addDirectory($attachmentsDirectory);
	$zip->saveZip();

	// Deletes the Excel file outside the zip archive
	$sheet->deleteSheet($sheetFileName);

	// Returns the zip file's directory
	echo "../../../modules/mod_enrollments_report/util/".$zipFileName;