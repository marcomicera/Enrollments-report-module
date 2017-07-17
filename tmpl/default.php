<?php
    /* From: https://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
     *
     * This is the module template.
     * This file will take the data collected
     * by mod_enrollments_report.php and generate
     * the HTML to be displayed on the page.
	 * [...] The template file has the same scope 
	 * as the mod_helloworld.php file.
     */

    defined('_JEXEC') or die;
?>
<html>
	<head>
		<meta charset="UTF-8">

		<!-- jQuery -->
		<script src="modules/mod_enrollments_report/lib/jquery-3.1.1.min.js"></script>
	</head>
    <body>
        <h2>Enrollments report module</h2>
        <ul>
            <li><a id="download" href="##">Download admissions</a></li>
            <li><a id="delete" href="##">Delete previous admissions</a></li>
        </ul>

        <script type="text/javascript" charset="utf-8">
			var utilDirectory = "../../../modules/mod_enrollments_report/util/";

			// Zip archive deleting delay
			var deleteAfter = 10 * 1000;
		
            $(
				$("#download").click(function() {					
					jQuery.ajax({
						url: utilDirectory + "download.php",
						success: function(data) {
							// Downloads the zip file
							window.location.href = data;
							
							/*	Deletes the generated zip archive 
								after the user downloads it */
							setTimeout(function(){
								jQuery.ajax({
									url: utilDirectory + "deleteZipFile.php"
								});
							}, deleteAfter);
						}
					});
				})
			);

			$(
				$("#delete").click(function() {
					jQuery.ajax({
						url: utilDirectory + "deletePreviousAdmissions.php"
					});
				})
			);
        </script>
    </body>
</html>