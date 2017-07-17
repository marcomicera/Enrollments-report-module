<?php
	/* Deletes the generated zip archive
	   after the user downloads it. */

	require_once "../config/zipConfig.php";
	require_once "zipManager.php";
	require_once "download.php";

	$zip->deleteZip($zipFileName); // Deletes the zip archive