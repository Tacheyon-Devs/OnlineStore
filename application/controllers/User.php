<?php 

class User extends My_Controller
{

    protected $breadCrumb=array();
    public function __construct()
    {
        parent::__construct();
        $this->load->model('File_Model');
        $this->load->library('template');
        $this->load->model('User_Model');
    }
    // $result = $this->User_Model->signUp($this->input->post());
	// 	$path = 'uploadFolders/user_' . $result['id'];
	// 	mkdir($path);
	// 	$temp = $_FILES['profilePicture']['tmp_name'];
	// 	$profilePictureFolderPath = $path."/profilePicture";
	// 	mkdir($profilePictureFolderPath);		
	// 	$profilePicture =$profilePictureFolderPath."/".$_FILES['profilePicture']['name'];
	// 	move_uploaded_file($temp,$profilePicture);
	// 	$profilePicture =base_url().$profilePictureFolderPath."/".$_FILES['profilePicture']['name'];
	// 	$this->User_Model->setProfilePicture($result['id'],$profilePicture);
    public function updateUserProfile()
    {   
        $user = $this->session->userdata("loggedIn")['id'];
        $this->User_Model->updateUserProfile($this->input->post());
        $data= $this->User_Model->getUserData($user);
        $data = $data['profile_picture'];
        $data = str_replace(base_url(),"",$data);
        unlink($data);
        $path = 'uploadFolders/user_' . $user;
        $profilePictureFolderPath = $path."/profilePicture";
        $profilePicture =$profilePictureFolderPath."/".$_FILES['newProfilePicture']['name'];
        // $pathOfPicture = 'uploadFolders/user_'.$user."/profilePicture/";
        if($_FILES['newProfilePicture'])
        {
            $newFile = $_FILES['newProfilePicture']['tmp_name'];
            move_uploaded_file($newFile,$profilePicture);
            $updatedProfilePicture = base_url().$profilePicture;
            $this->User_Model->setProfilePicture($user,$updatedProfilePicture);
        }
        
    }
    public function loadProfile($id)
    {
        $content = ($this->User_Model->getUserData($id));
        // var_dump( $data[0]);die;
        $data= $content;
        $this->template->load('user/profile',$data);
    }
        public function index()
    {
        // echo $this->BootstrapContentArrange(10);
        $user = $this->session->userdata['loggedIn']['id'];
        $data['files'] = $this->File_Model->getAllFiles();
        if(empty($data['files'])==false)
        {
            foreach( $data['files'] as &$row) 
            {
                $row['is_folder'] = 0;
            }
        }

        $data['folders'] = $this->File_Model->getAllFolders();
        if(empty($data['folders'])==false)
        {
            foreach( $data['folders'] as &$row) 
            {
                $row['is_folder'] = 1;
            }
        }
        $data['totalSpace']=$this->File_Model->getUserTotalSpace($user);
        $data['profile'] = $this->User_Model->getUserData($user);
        $data['profilePicture']=$data['profile']['profile_picture'];
        $data['parentFolder']=0;
        

        $this->getRecursiveParentFolder($data['parentFolder'],$user); //Home / Desktop / A / A2 / A3
        $data['path']  =implode(" ",array_reverse($this->breadCrumb));
        if(empty($data['files']) && empty($data['folders']))
        {
            $data['data']=NULL;
            $this->template->load('user/index',$data);
        }
        else if(empty($data['files']) && empty($data['folders'])==false)
        {
            // var_dump($data['folders']);die;
            $columnArray = array_column($data['folders'],'created_at');
            array_multisort($data['folders'],SORT_DESC,$columnArray);
            $data['data']=($data['folders']);
            $this->template->load('user/index',$data);
        }
        else if(empty($data['files'])==false && empty($data['folders']))
        {
            $columnArray = array_column($data['files'],'created_at');
            array_multisort($data['files'],SORT_DESC,$columnArray);
            $data['data']=($data['files']);
            $this->template->load('user/index',$data);
        }
        else
        {
            $mergedArray = array_merge($data['files'],$data['folders']);
            $columnArray = array_column($mergedArray,'created_at');
            array_multisort($mergedArray,SORT_DESC,$columnArray);
            $data['data']=($mergedArray);
            $this->template->load('user/index',$data);
        }
        
    }
    function BootstrapContentArrange($i) 
    {
		$items = $i;                // qnt of items
		$rows = ceil($items/3);     // rows to fill
		$lr = $items%3;             // last row items
		$lrc = $lr;                 // counter to last row

		while ($items > 0) {        // while still have items
			$cell = 0;
			if ($rows > 1) {        // if not last row...
				echo '<div class="row">'.PHP_EOL;
				while ($cell < 3) {     // iterate with 3x4 cols
					echo '<div class="col-md-4">Content</div>'.PHP_EOL;
					$cell++;
				}
				echo "</div>".PHP_EOL;
			$rows--;        // end a row
			} elseif ($rows == 1 && $lr > 0) {      // if last row and still has items
				echo '<div class="row">'.PHP_EOL;
				while ($lrc > 0) {      // iterate over qnt of remaining items
					$lr == 2 ?      // is it two?
						print('<div class="col-md-6">Content</div>'.PHP_EOL) :  // makes 2x6 row
						print('<div class="col-md-12">Content</div>'.PHP_EOL); // makes 1x12 row
					$lrc--;
				} 
				echo "</div>".PHP_EOL;
				break;
			} else {        // if round qnt of items (exact multiple of 3)
				echo '<div class="row">'.PHP_EOL;
				while ($cell < 3) {     // iterate as usual
					echo '<div class="col-md-4">Content</div>'.PHP_EOL;
					$cell++;
				}
				echo "</div>".PHP_EOL;
				break;
			}
			$items--;       // decrement items until it's over or it breaks
		}
    }
  
    public function loadFolder($id)
    {
        $data['profile'] = $this->User_Model->getUserData($user);
        $data['profilePicture']=$data['profile'][0]['profile_picture'];
        $data['files']=$this->File_Model->getFiles($id);
        $data['folders']=$this->File_Model->getFolders($id);
        
        $data['parentFolder']=$id;
        $user = $this->session->userdata['loggedIn']['id'];
        if(empty($data['files'])==false)
        {
            foreach( $data['files'] as &$row) 
            {
                $row['is_folder'] = 0;
            }
        }
        if(empty($data['folders'])==false)
        {
            foreach( $data['folders'] as &$row) 
            {
                $row['is_folder'] = 1;
            }
        }
        // $data['path']
        $this->getRecursiveParentFolder($data['parentFolder'],$user); //Home / Desktop / A / A2 / A3
        $data['path']  =implode(" ",array_reverse($this->breadCrumb));
        if(empty($data['files']) && empty($data['folders']))
        {
            $data['data']=NULL;
            $this->template->load('user/index',$data);
        }
        else if(empty($data['files']) && empty($data['folders'])==false)
        {
            // var_dump($data['folders']);die;
            $columnArray = array_column($data['folders'],'created_at');
            array_multisort($data['folders'],SORT_DESC,$columnArray);
            $data['data']=($data['folders']);
            // var_dump($data);die;
            $this->template->load('user/index',$data);
        }
        else if(empty($data['files'])==false && empty($data['folders']))
        {
            $columnArray = array_column($data['files'],'created_at');
            array_multisort($data['files'],SORT_DESC,$columnArray);
            $data['data']=($data['files']);
            // var_dump($data);die;
            $this->template->load('user/index',$data);
        }
        else if(empty($data['files'])==false && empty($data['folders'])==false)
        {
            
            $mergedArray = array_merge($data['files'],$data['folders']);
            $columnArray = array_column($mergedArray,'created_at');
            array_multisort($mergedArray,SORT_DESC,$columnArray);
            $data['data']=($mergedArray);
            $this->template->load('user/index',$data);
        }
    }
    public function logOut()
    {
        // var_dump('logout');
        // die();            
        unset($_SESSION['loggedIn']);
        redirect(base_url().'user/index');
    }
    public function logIn()
    {
        echo 'logi';
        die();
                // echo $this->input->post();
    }
    private function getRecursiveParentFolder($parent,$userId)
    {
        if($parent==NULL)
        {
            array_push($this->breadCrumb,"> <a href='/'>Home</a>");
            return 0;
        }
        else
        {
            $getFoldername = $this->File_Model->getFolderById($parent);
            $temp = $getFoldername['name'];
            array_push($this->breadCrumb, "> <a href='/loadfolder/$parent'>$temp</a>");
            $parentOfParentFolder = $getFoldername['parent_folder'];
            $this->getRecursiveParentFolder($parentOfParentFolder,$userId);
            
        }
    }
    
}