<?php
defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH.'core\My_Controller.php';
class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->load->library('session');
		$this->load->model('User_Model');
		$this->load->helper('url');
		$this->load->model('File_Model');
	}
	// protected $currentFile = 0;
	public function login()
	{
		
		$this->template->load('login');
	}
	public function verifyUser()
	{
		$userData = $this->User_Model->UserAuthentication($this->input->post());
		$this->session->set_userdata('loggedIn', $userData);
	}
	public function signUp()
	{
		$this->template->load('signup');
	}
	public function createUser()
	{
		$result = $this->User_Model->signUp($this->input->post());
		$path = 'uploadFolders/user_' . $result['id'];
		mkdir($path);
		$temp = $_FILES['profilePicture']['tmp_name'];
		$profilePictureFolderPath = $path."/profilePicture";
		mkdir($profilePictureFolderPath);		
		$profilePicture =$profilePictureFolderPath."/".$_FILES['profilePicture']['name'];
		move_uploaded_file($temp,$profilePicture);
		$profilePicture =base_url().$profilePictureFolderPath."/".$_FILES['profilePicture']['name'];
		$this->User_Model->setProfilePicture($result['id'],$profilePicture);
	}
	function createDir($path, $mode = 0777, $recursive = true) 
	{
		if(file_exists($path)) return true;
		return mkdir($path, $mode, $recursive);
	}
	public function incrementParentFolderSize($parent,$user,$size)
	{
		if($parent==NULL)
		{
			echo "function reached parent : ".$parent;
			echo "\n";	
			return 0;
		}	
		else
		{	
			$oldSize = $this->File_Model->getFolderSize($parent,$user);
			$newSize = $oldSize['size']+$size;
			$this->File_Model->updateFolderSize($parent,$user,$newSize);
			$parentOfParent = $this->File_Model->getParentFolder($parent,$user);
			if($parentOfParent==NULL)
			{
				return 0;
			}
			else
			{
				$this->incrementParentFolderSize($parentOfParent['parent_folder'],$user,$size);
			}
		}
	}
function zipFilesAndDownload($file_names,$archive_file_name)
{
        //echo $file_path;die;
    $zip = new ZipArchive();
    //create the file and throw the error if unsuccessful
    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
        exit("cannot open <$archive_file_name>\n");
    }
    //add each files of $file_name array to archive
    foreach($file_names as $files)
    {
        $zip->addFile($files);
        // echo $files;

    }
    $zip->close();
    //then send the headers to force download the zip file
    header("Content-type: application/zip"); 
	header("Content-Disposition: attachment; filename=$archive_file_name"); 
	header("Content-length: " . filesize($archive_file_name));
    header("Pragma: no-cache"); 
	header("Expires: 0");
	ob_clean();
	flush();
	 
    readfile($archive_file_name);
	unlink($archive_file_name);
	exit;
	// die;
}

	public function createZipFolder()
	{
		$zipFile =  'uploadFolders/user_'.$this->session->userdata('loggedIn')['id'].'/'.$this->input->post('zipFolder').".zip";
		// var_dump($zipName);
		$filesToZipArray = array();
		$filesToZip = $this->input->post('zipFiles');
		$zip = new ZipArchive();
		if ( $zip->open($zipFile, ZipArchive::CREATE) !== TRUE) 
		{
			exit("message");
		}
		foreach($filesToZip as $fileToZip)
		{
			$file = $this->File_Model->getFile($fileToZip);
			// array_push($filesToZipArray,$file['path']);
			$filePath = str_replace(base_url(),"",$file['path']);
			 $zip->addFile($filePath,$file['name']);
			// var_dump($file['name']);
		}
		$zip->close();
		// //then send the headers to force download the zip file
		header('Content-type: application/zip');
		header('Content-Disposition: attachment; filename="'.basename($zipFile).'"');
		header("Content-length: " . filesize($zipFile));
		header("Pragma: no-cache");
		header("Expires: 0");
		// ob_clean();
		// flush();
		readfile($zipFile);
		unlink($zipFile);
		exit;
		
	}
	public function folderUpload()
	{
		
		$currentFile= $this->input->post('currentFile');
		
		$parent=($this->input->post('parentFolder'));												//parent Folder id
		$root = base_url().'uploadFolders/user_'.$this->session->userdata('loggedIn')['id']."/";
		$folderName = ($this->File_Model->getFolderById($parent)['name']);							//users assest folder
		$pathOfFolder = ($this->File_Model->getFolderById($parent)['path'].$folderName);		//path of folder from DB
		
		$exactFolderAddress= str_replace($root,"",$pathOfFolder);	//folder path without asset folder
		
		$totalFiles = count($_FILES['uploadFolder']['tmp_name']);
		
		$pathWithComma = $this->input->post('filePath');
		$path = explode(",",$pathWithComma); 						//['desktop','A','A_1']
		
		$count = count($path);
		$user = $this->input->post('user');
		$temp = 'uploadFolders/user_'.$this->session->userdata('loggedIn')['id'].$exactFolderAddress;
		// var_dump( $exactFolderAddress);die;
		for($i=0;$i<=$count-1;$i++)
		{
			if($i!=($count-1))
			{
				if($parent==0)
				{
					$parent=NULL;
				}
				$name = $path[$i];						
				$checkResult = ($this->File_Model->checkFolder($parent,$user,$name));
				if($checkResult)
				{
					$parent=$checkResult['id'];
					$temp.="/".$name;
				}
				else
				{
					$dbFolderPath = base_url().$temp;
					// echo "Db path : ".$dbFolderPath;die;
					$insertedID=$this->File_Model->createFolder($parent,$dbFolderPath,$user,$name);
					$temp =$temp.'/'.$name;
					$parent=$insertedID;
					$this->createDir($temp);
				}
			}
			else
			{
				if($parent==0)
				{
					$parent=NULL;
				}
				$size = $_FILES['uploadFolder']['size'][$currentFile];
				$this->incrementParentFolderSize($parent,$user,$size);
				$name = $path[$i];
				echo "size : ".$size;
				echo "\n";
				echo "parent : ".$parent;
				echo "\n";
				echo "file : ".$_FILES['uploadFolder']['tmp_name'][$currentFile];
				echo "\n";
				$tempFile = $_FILES['uploadFolder']['tmp_name'][$currentFile];
				$temp = $temp."/".$name;
				$data['path']=base_url().$temp;
				$data['name']=$name;
				$data['user']=$user;
				$data['size']=$this->input->post('fileSize');
				$data['parentFolder']=$parent;
				echo "data : ".(json_encode($data));
				echo "\n";
				move_uploaded_file($tempFile,$temp);
				echo "temp : ".$temp;
				echo "\n";
				$this->File_Model->insertBatchFile($data);	
			}
		}
	}

	public function createNewFolder()
	{
		$parentFolder=($this->input->post('parentFolder'));
		$folderName = ($this->File_Model->getFolderById($parentFolder)['name']);
		$root = base_url().'uploadFolders/user_'.$this->session->userdata('loggedIn')['id']."/";
		$pathOfFolder = ($this->File_Model->getFolderById($parentFolder)['path']."/".$folderName);
		$user = $this->session->userdata['loggedIn']['id'];
		$exactFolderAddress= str_replace($root,"",$pathOfFolder);
		if($parentFolder==0)
		{
			$parentFolder=NULL;
			$fileUploadPath = 'uploadFolders/user_'.$this->session->userdata('loggedIn')['id'].'/';
		}
		else
		{
			$fileUploadPath = 'uploadFolders/user_'.$this->session->userdata('loggedIn')['id'].$exactFolderAddress."/";
		}
		$this->createDir($fileUploadPath.$this->input->post('folderName'));
		$dbFolderPath= base_url().$fileUploadPath;
		$this->File_Model->createFolder($parentFolder,$dbFolderPath,$user,$this->input->post('folderName'));	
	}
	public function fileUpload()
	{
		$parentFolder=($this->input->post('parentFolder'));
		$folderName = ($this->File_Model->getFolderById($parentFolder)['name']);
		$root = base_url().'uploadFolders/user_'.$this->session->userdata('loggedIn')['id']."/";
		$pathOfFolder = ($this->File_Model->getFolderById($parentFolder)['path']."/".$folderName);
		
		$exactFolderAddress= str_replace($root,"",$pathOfFolder);
		
		if($parentFolder==0)
		{
			$parentFolder=NULL;
			$fileUploadPath = 'uploadFolders/user_'.$this->session->userdata('loggedIn')['id'].'/';
		}
		else
		{
			$fileUploadPath = 'uploadFolders/user_'.$this->session->userdata('loggedIn')['id'].$exactFolderAddress."/";
		}
		$data = [];
		$count = count($_FILES['uploadFile']['name']);
		$files = $_FILES; 
		for ($i = 0; $i < $count; $i++) 
		{
			$_FILES = $files;
			$_FILES['uploadFile']['name']=$_FILES['uploadFile']['name'][$i];
			$_FILES['uploadFile']['type']=$_FILES['uploadFile']['type'][$i];
			$_FILES['uploadFile']['tmp_name'] = $_FILES['uploadFile']['tmp_name'][$i];
			$_FILES['uploadFile']['error'] = $_FILES['uploadFile']['error'][$i];
			$_FILES['uploadFile']['size'] = $_FILES['uploadFile']['size'][$i];
			// $parentFolder = $this->input->post('parentFolder');
			$config['upload_path']          = $fileUploadPath;
			$config['allowed_types']        = '*';
			$config['max_size']             = 1000000;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			// var_dump($config);die();
			$this->load->library('upload', $config);
			if(!$this->upload->do_upload('uploadFile'))
			{
				$this->session->set_flashdata('message',$this->upload->display_errors());
				echo $this->upload->display_errors();
			}
			else
			{
				$data = $this->upload->data();
				$image_path = ( base_url().$fileUploadPath.$data['file_name']);
				$file['path']=$image_path;
				$file['name']=$data['file_name'];
				$file['type']=$data['file_type'];
				$file['parentFolder']=$parentFolder;
				$file["size"]= $_FILES['uploadFile']['size'];
				// var_dump($data);
				$result=$this->File_Model->insertFile($file);
			}
		}
	}
	public function createFolder()
	{
		$user_id = rand(1, 100);
		$this->session->set_userdata('user_id', $user_id);
		$path = 'uploadFolders/user_' . $user_id;
		mkdir($path);
	}
	public function index()
	{
		redirect(base_url() . 'user/index');
	}
}
// "file_name"]=>
//   string(10) "bano17.jpg"
//   ["file_type"]=>
//   string(10) "image/jpeg"
//   ["file_path"]=>
//   string(88) "C:/Users/BAD Malik/Google Drive/Office Projects/OnlineFileStorage/uploadFolders/user_16/"
//   ["full_path"]=>
//   string(98) "C:/Users/BAD Malik/Google Drive/Office Projects/OnlineFileStorage/uploadFolders/user_16/bano17.jpg"
//   ["raw_name"]=>
//   string(6) "bano17"
//   ["orig_name"]=>
//   string(8) "bano.jpg"
//   ["client_name"]=>
//   string(8) "bano.jpg"
//   ["file_ext"]=>
//   string(4) ".jpg"
//   ["file_size"]=>
//   float(15.17)
//   ["is_image"]=>
//   bool(true)
//   ["image_width"]=>
//   int(236)
//   ["image_height"]=>
//   int(301)
//   ["image_type"]=>
//   string(4) "jpeg"
//   ["image_size_str"]=>