<?php
	/* From: https://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
	 *
	 * This file contains the helper class
	 * which is used to do the actual work
	 * in retrieving the information to be
	 * displayed in the module (usually
	 * from the database or some other source).
	 */

	class ModEnrollmentsReportHelper {
		public static function getData() {
			$db = JFactory::getDbo();
			$db->setQuery("select * from g9f7i_student_form");
			return $db->loadObjectList();
		}

		public static function deleteData() {
			$db = JFactory::getDbo();
			$db->setQuery("truncate table g9f7i_student_form");
			$db->execute();
		}
	}