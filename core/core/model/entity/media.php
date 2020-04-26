<?php

class media extends baseEntity{
	
	public $mediaFile;
	public $config;
	
	public function __construct(){
		$this->isLoggedIn = FALSE;	
		$this->mediaFile = NULL;
		$this->config['onlySeeTheirs'] = true;
		$this->config['primaryIDProperty'] = 'name';
		$this->config['primaryViewProperties'] = array('name');
		
		//$this->config['associations'] = array(
		//	'user'=>'belongsTo',
		//	'product'=>'belongsTo'
		//);	
		
		
		$this->config['associations']['belongsTo'] = array('user','product');
		$this->config['associations']['has'] = array();
		
		
		parent::__construct();
		
		
	}
	
	public function init(){
		global $hooks;
		
		$hooks->add_action('user_table_viewport', array($this, 'media'));
		$hooks->add_action('user_tile_viewport', array($this, 'media'));
		
		
	}
	
	public static function media($entity){
		global $hooks;
		global $user;
		include(dirname(dirname(dirname(dirname(__FILE__))))."/view/default/write_media_module_dynamic.php");
		
		
	}
	
	//Expect expects an array of data where elements should match object properties,
	//elements that do no match properties will be ignored
	public function validate(array $data){
		$v = New validation();
		
		/*
		if(!$v->email($data['email']))
			{SetError('Email address is not valid');}
		
		if(!$v->notBlank($data['phone']))
			{SetError('Phone Number was left blank');}
		if(!$v->numeric($data['phone']))
			{SetError('Phone Number must be numeric');}
		 * 
		 */
	}
	
	public function Delete(){
		//delete the file resource.
		unlink($this->mediaFile);
		parent::Delete();
	}
	
	public function upload(){
		
		
		
		//Validate Media Files
		$target_dir = MEDIA_DIRECTORY;
		$target_file = $target_dir . basename($_FILES["mediaFile"]["name"]);
		$uploadOk = 1;
		$mediaFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$rnd_bits = bin2hex(openssl_random_pseudo_bytes(64));
		$file_name_no_ext = $target_dir . $rnd_bits;
		$file_name_rand = $target_dir . $rnd_bits  . "." . $mediaFileType;
		$file_name_rand_png = $target_dir . $rnd_bits . ".png";
		$file_name_rand_mp3 = $target_dir . $rnd_bits . ".mp3";
		$file_name_rand_mp4 = $target_dir . $rnd_bits . ".mp4";
		$file_name_rand_pdf = $target_dir . $rnd_bits . ".pdf";
		
		if(!media::isAudio($mediaFileType)
		&& !media::isVideo($mediaFileType)
		&& !media::isImage($mediaFileType)
		&& !media::isPDF($mediaFileType)){
			SetError("This file type is not supported.");
			$uploadOk = 0;
		}
		
		
		// Check if file already exists
		if (file_exists($file_name_rand)) {
		    SetError("Sorry, file already exists.");
		    $uploadOk = 0;
		}
		//Check size contraints
	
		if ($_FILES["mediaFile"]["size"] > 5000000000) {
		    SetError("Sorry, your file is too large.");
		    $uploadOk = 0;
		}
		
		
		//if the file is a img
		if(media::isImage($mediaFileType)){
			$file_name_rand_png = $target_dir . $rnd_bits . ".png";
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["mediaFile"]["tmp_name"]);
			    if($check !== false) {
			    	//use GD lib to create an image from the resource
			    	$gd_img = imagecreatefrom.$mediaFileType($_FILES["mediaFile"]["tmp_name"]);
					imagepng($gd_img,$file_name_rand);
					
			        //echo "File is an image - " . $check["mime"] . ".";
			       // $uploadOk = 1;
			    } else {
			        SetError("File is not an image.");
			        $uploadOk = 0;
			    }
			}
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    SetError("Sorry, your file was not uploaded.");
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["mediaFile"]["tmp_name"], $file_name_rand)) {
		  
		    	
				//Process image uploads
				if(media::isImage($mediaFileType)){
					
					if($mediaFileType = 'jpg'){$mediaFileType = 'jpeg';}
					//Recreate the image and lose all of its extra data
			    	$gd_func =	'imagecreatefrom'.$mediaFileType;
					$gd_img = $gd_func($file_name_rand);
					imagepng($gd_img,$file_name_rand_png);	
					//Delete the original
					//unlink($file_name_rand);
					$this->mediaFile = $file_name_rand_png;
					
				}
				
				//Process Audio files
				elseif(media::isAudio($mediaFileType)){
					//convert audio file
					$executor_str = escapeshellcmd(dirname(dirname(dirname(dirname(__FILE__)))) . "/vendors/ffmpeg/bin/ffmpeg -i ". $file_name_rand ." -vn -ar 44100 -ac 2 -ab 320 -f mp3 " . $file_name_rand_mp3);				
					passthru($executor_str);
					//unlink($file_name_rand);	
					$this->mediaFile = $file_name_rand_mp3;		
				}
				//Process Video files
				elseif(media::isVideo($mediaFileType)){
					//convert video file
					$executor_str = escapeshellcmd(dirname(dirname(dirname(dirname(__FILE__)))) . "/vendors/ffmpeg/bin/ffmpeg -i ". $file_name_rand ."  " . $file_name_rand_mp4);				
					passthru($executor_str);
					//unlink($file_name_rand);			
					$this->mediaFile = $file_name_rand_mp4;
				}
				//Process Video files
				elseif(media::isPDF($mediaFileType)){
					$this->mediaFile = $file_name_rand_pdf;
				}
				else{
					unlink($file_name_rand);
				}
		   	}
			else{SetError("Sorry, there was an error uploading your file.");}
		}
		
	}
//+++++++++++++++++++++++++++++
	public function getType(){
		$file_name = explode(".", $this->mediaFile);
		
		if(media::isAudio($file_name[count($file_name)-1])){
			return "audio";
		}
		if(media::isImage($file_name[count($file_name)-1])){
			return "image";
		}
		if(media::isVideo($file_name[count($file_name)-1])){
			return "video";
		}
		if(media::isPDF($file_name[count($file_name)-1])){
			return "pdf";
		}
		return FALSE;
	}

//++++++++++++++++++++++++++++
	public static function isImage($ext_type){
		if($ext_type == "jpg" 
		|| $ext_type == "png" 
		|| $ext_type == "jpeg"
		|| $ext_type == "gif")
			{return TRUE;}
		else{return FALSE;} 
		
	}
	public static function isVideo($ext_type){
		if($ext_type == "avi" 
		|| $ext_type == "flv" 
		|| $ext_type == "wmv"
		|| $ext_type == "mov"
		|| $ext_type == 'mp4'
		|| $ext_type == 'mpg'
		|| $ext_type == 'mpeg')
			{return TRUE;}
		else{return FALSE;} 
		
	}
	public  static function isAudio($ext_type){
		if($ext_type == "wav" 
		
		|| $ext_type == "mp3"
		|| $ext_type == "wma" 
		)
			{return TRUE;}
		else{return FALSE;} 
		
	}
	public  static function isPDF($ext_type){
		if($ext_type == "pdf" 
		)
			{return TRUE;}
		else{return FALSE;} 
		
	}
	
}

?>