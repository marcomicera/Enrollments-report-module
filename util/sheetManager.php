<?php
	require "../config/sheetConfig.php";
	require "../config/zipConfig.php"; // for $attachmentsFolderName
	require_once "../lib/PHPExcel.php";
	require_once "../helper.php";

	// Imports the Joomla library in order to use its API
	// (JFactory object used in ModEnrollmentsReportHelper::getData())
	define('_JEXEC', 1);
    define('JPATH_BASE', realpath(dirname(__FILE__).'/../../../'));  
    require_once(JPATH_BASE .'/includes/defines.php');
    require_once(JPATH_BASE .'/includes/framework.php');
    $mainframe = JFactory::getApplication('site');

	class SheetManager {
		private $sheet = null;

		function __construct() {
			// Copies the sheet template in order to modify it
			$this->copySheetTemplate();

			// Adjusts the sheet's style
			$this->setStyle();

			// Fills the all_applications worksheet
			$this->loadDatabaseData();
			
			// Saves Excel File
			global $fileType;
			global $sheetFileName;
			$sheetWriter = PHPExcel_IOFactory::createWriter($this->sheet, $fileType);
			$sheetWriter->save($sheetFileName);
		}

		function copySheetTemplate() {
			global $fileType;
			global $sheetTemplateFile;
			global $sheetFileName;

			// Copies the sheet template (single workbook version)
			if(!copy($sheetTemplateFile, $sheetFileName))
				exit("Sheet template not found.\n");

			$this->sheet = PHPExcel_IOFactory::createReader($fileType)->load(
				$sheetFileName
			);
		}

		function setStyle() {
			// Sets the zoom level on the applications worksheets
			$this->sheet->getSheetByName('all_applications')->getSheetView()->setZoomScale(70);
			$this->sheet->getSheetByName('valid_applications')->getSheetView()->setZoomScale(70);
		}

		function loadDatabaseData() {
			global $firstRow;

			// Gets the data from the database 
			$students = ModEnrollmentsReportHelper::getData();

			$allApplicationsWorksheet = $this->sheet->getSheetByName('all_applications');
			for($i = 0; $i < count($students); ++$i) {
				// Surname
				$allApplicationsWorksheet->setCellValue(
					'F' . ($firstRow + $i + 1),
					$students[$i]->surname
				);

				// First Name and Middle Name (if any)
				$allApplicationsWorksheet->setCellValue(
					'G' . ($firstRow + $i + 1),
					$students[$i]->firstname
				);

				// Gender
				$allApplicationsWorksheet->setCellValue(
					'H' . ($firstRow + $i + 1),
					$students[$i]->gender
				);

				// Date of birth
				$allApplicationsWorksheet->setCellValue(
					'I' . ($firstRow + $i + 1),
					$students[$i]->birthdate
				);

				// Year of birth
				$allApplicationsWorksheet->setCellValue(
					'N' . ($firstRow + $i + 1),
					explode("/", $students[$i]->birthdate)[2]
				);

				// Birthplace
				$allApplicationsWorksheet->setCellValue(
					'Q' . ($firstRow + $i + 1),
					$students[$i]->birthplace
				);

				// Citizenship
				$allApplicationsWorksheet->setCellValue(
					'R' . ($firstRow + $i + 1),
					$students[$i]->citizenship
				);

				// Permanent Address Town/State
				$allApplicationsWorksheet->setCellValue(
					'T' . ($firstRow + $i + 1),
					$students[$i]->country
				);

				// Permanent Address Postal Code/Zip Code
				$allApplicationsWorksheet->setCellValue(
					'U' . ($firstRow + $i + 1),
					$students[$i]->postal_code
				);

				// Permanent Address Address
				$allApplicationsWorksheet->setCellValue(
					'V' . ($firstRow + $i + 1),
					$students[$i]->address
				);

				// Permanent Address Town
				$allApplicationsWorksheet->setCellValue(
					'X' . ($firstRow + $i + 1),
					$students[$i]->town
				);

				// Telephone
				$allApplicationsWorksheet->setCellValue(
					'Y' . ($firstRow + $i + 1),
					$students[$i]->telephone
				);

				// Email
				$allApplicationsWorksheet->setCellValue(
					'AA' . ($firstRow + $i + 1),
					$students[$i]->email
				);

				// Address where you want to be contacted during the selection (if different from permanent residence) Town/State
				$allApplicationsWorksheet->setCellValue(
					'AC' . ($firstRow + $i + 1),
					$students[$i]->country_alt
				);

				// Address where you want to be contacted during the selection (if different from permanent residence) Postal Code/Zip Code
				$allApplicationsWorksheet->setCellValue(
					'AD' . ($firstRow + $i + 1),
					$students[$i]->postal_code_alt
				);

				// Address where you want to be contacted during the selection (if different from permanent residence) Address
				$allApplicationsWorksheet->setCellValue(
					'AE' . ($firstRow + $i + 1),
					$students[$i]->address_alt
				);

				// Address where you want to be contacted during the selection (if different from permanent residence) Town
				$allApplicationsWorksheet->setCellValue(
					'AG' . ($firstRow + $i + 1),
					$students[$i]->town_alt
				);

				// Skype account (candidates admitted to the interview may ask the selection committee, due to proper and justified reasons, to hold the interview through Skype videoconference):
				$allApplicationsWorksheet->setCellValue(
					'AI' . ($firstRow + $i + 1),
					$students[$i]->skype_account
				);
				
				// Pre-enrollment (in case of admission) at the Italian Embassy of (please indicate town and country):
				$allApplicationsWorksheet->setCellValue(
					'AL' . ($firstRow + $i + 1),
					$students[$i]->embassy_of
				);

				// Bachelor Degree in:
				$allApplicationsWorksheet->setCellValue(
					'AN' . ($firstRow + $i + 1),
					$students[$i]->bachelor_course
				);

				// University name:
				$allApplicationsWorksheet->setCellValue(
					'AQ' . ($firstRow + $i + 1),
					$students[$i]->university_name
				);

				// University Country:
				$allApplicationsWorksheet->setCellValue(
					'AR' . ($firstRow + $i + 1),
					$students[$i]->university_country
				);

				// University Web Ranking (absolute)
				$allApplicationsWorksheet->setCellValue(
					'AS' . ($firstRow + $i + 1),
					$students[$i]->university_web_ranking_absolute
				);

				// Faculty/Department name:
				$allApplicationsWorksheet->setCellValue(
					'AV' . ($firstRow + $i + 1),
					$students[$i]->faculty_or_department_name
				);

				// College name (if any):
				$allApplicationsWorksheet->setCellValue(
					'AW' . ($firstRow + $i + 1),
					$students[$i]->branch_name
				);

				// Legal duration of Bachelor's Course (in Years)
				$allApplicationsWorksheet->setCellValue(
					'AX' . ($firstRow + $i + 1),
					$students[$i]->duration
				);

				// Beginning Academic Year of Bachelor's studies:
				$allApplicationsWorksheet->setCellValue(
					'AY' . ($firstRow + $i + 1),
					$students[$i]->beginning_in
				);

				// Degree awarding year
				$allApplicationsWorksheet->setCellValue(
					'BC' . ($firstRow + $i + 1),
					$students[$i]->beginning_in + $students[$i]->BSC_awarded_in
				);

				
				// Languages
				/*	Creates an array of languages (taken from the "Foreign languages" 
					text field filled by the enrolling student) by separating them
					with a regular expression.
						\s	=	white space
						+	=	one or more
				*/
				$languages = preg_split('/(\s|,|-)+/', $students[$i]->foreign_lang, 7);
				/*	Creates an array of all the occurrences of words beginning 
					with 'eng' or 'bri', case insensitive. */
				$keys = preg_grep('/^(eng|bri)/i', $languages);
				// Set the internal pointer of an array to its first element
				reset($keys);
				// Removes all those occurrences from the languages array
				do {
					unset($languages[key($keys)]);
				} while(next($keys));
				// Insert "English" as the first language
				array_unshift($languages, "English");
				// First language column
				$langColumn = 57;
				$allApplicationsWorksheet->setCellValueByColumnAndRow(
					$langColumn + 1,
					$firstRow + $i + 1,
					$students[$i]->english_score
				);
				foreach($languages as $language) {	
					$allApplicationsWorksheet->setCellValueByColumnAndRow(
						$langColumn,
						$firstRow + $i + 1,
						$language
					);
					$langColumn += 6;
				}
			}
		}

		public function deleteSheet($file) {
			if(!unlink($file))
				exit("Cannot delete Excel file.\n");
			$this->sheet = null;
		}
	}