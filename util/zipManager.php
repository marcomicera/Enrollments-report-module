<?php
	require "../config/zipConfig.php";

	class ZipManager {
		private $zip = null;

		function __construct() {
			global $zipFileName;		
			
			$this->zip = new ZipArchive();

			// Creates the zip file
			if(!$this->zip->open($zipFileName, ZipArchive::CREATE))
				exit("Cannot create zip file.\n");
		}

		public function addFile($file) {
			$this->zip->addFile($file);
		}

		public function addDirectory($directory) {
			global $attachmentsFolderName;

			// Returns the canonicalized absolute pathname
			$rootPath = realpath($directory);

			// Iterates through recursive iterators
			// (all node's children are a RecursiveIterator)
			$files = new RecursiveIteratorIterator(
				// Iterator that traverses through subfolders
				new RecursiveDirectoryIterator($rootPath)
			);

			foreach($files as $file) {
				// Skips directories (they would be added automatically)
				if(!$file->isDir()) {
					// Real source file path
					$filePath = $file->getRealPath();
					// Relative destination file path
					$relativePath = substr($filePath, strlen($rootPath) + 1);

					// Adds current file to archive
					$this->zip->addFile($filePath, $attachmentsFolderName.'/'.$relativePath);
				}
			}
		}

		public function saveZip() {
			$this->zip->close();
		}

		public function deleteZip($file) {
			if(!unlink($file))
				exit("Cannot delete zip archive.\n");
		}
	}