<?php

  /*

   setValues($fileType); 

   uploadFileValidation(); 

   uploadFile();

   getFileExtension($fileRequired); 

   deleteFile();

 */

 include_once('../../../../libraries/class/constants.php');

 

 class FileUpload {

	private $arrAllowedExts=array();

	private $arrSupportedFormats=array();

	

	/* 

	   ...................

      //note: 

  	*/

	function setValues($fileType){  

	  //$fileType=$this->fileType;

	  if($fileType==TEXT_FILE) {

	     $this->arrAllowedExts= getTextExtensions();

	     $this->arrSupportedFormats=getTextFormats();

	  } else if($fileType==IMAGE_FILE) {

	     $this->arrAllowedExts= getImageExtensions();

	     $this->arrSupportedFormats=getImageFormats();

      }

	}

	

	

	/* 

	   ...................

      //note: 

  	*/

	function uploadFileValidation() {

		$upFile=$this->requiredFile;

		//$requiredFileName=$this->requiredFileName;

		//$filePath=$this->filePath;

		$fileType=$this->fileType;

		$maxFileSize=$this->maxFileSize;

		

		$this->setValues($fileType);

		$arrAllowedExts = $this->arrAllowedExts;

		$arrSupportedFormats= $this->arrSupportedFormats;   

		

		//$arrFile=explode(".", $upFile["name"]);

		//$extension = end($arrFile);

		$extension = $this->getFileExtension($upFile);  

		//$requiredFileName.=".".$extension;

		

		//$filePath.=$requiredFileName;

		$uploadStatus="file uploaded";



        if (  in_array($upFile["type"], $arrSupportedFormats)    

      		  && ($upFile["size"] <= $maxFileSize) 

      		  && in_array($extension, $arrAllowedExts) ){

				 if($upFile["error"] > 0) 

     			    $uploadStatus="upload failed";

				 else

				    $uploadStatus="Valid";

				    //move_uploaded_file($upFile["tmp_name"], $filePath);

		} else 

  			$uploadStatus="Invalid file";

		 return $uploadStatus;

	}

	

	

	/* 

	   ...................

      //note: 

  	*/

	function uploadFile() {

		$filePath=$this->filePath;

		$upFile=$this->requiredFile;

		$requiredFileName=$this->requiredFileName;

		$extension = $this->getFileExtension($upFile);  

		$filePath.=$requiredFileName.".".$extension;

		

		move_uploaded_file($upFile["tmp_name"], $filePath);

		return "file uploaded";

	}

	

	

	/* 

	   ...................

      //note: 

  	*/

	function getFileExtension($fileRequired) {

		$fileExtension = pathinfo($fileRequired['name'], PATHINFO_EXTENSION);

		return $fileExtension;

	}

	

	

	/*

	 if(file_exists($filePath)) 

        $uploadStatus="file already exists ";

     else 

	*/

	

	

	/* 

	   ...................

      //note: 

  	*/

	function deleteFile() {

		$filePath=$this->filePath;

		unlink($filePath);

	}

 }

 

/****************************************************

 

/*

function  : setValues(); 

   			uploadFileValidation(); 

   			uploadFile();

   			getFileExtension(); 

   			deleteFile();

Date      : 26.08-2013   

modified  : Naveen MRK 

note      : 

*/

?>