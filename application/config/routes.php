<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['welcome/login']="welcome/login";
$route['file/upload']= 'Welcome/fileUpload';
$route['create/folder'] = "Welcome/createFolder";
$route['signup']= "Welcome/signUp";
$route['loadfolder/(:any)']="User/loadFolder/$1";
$route['loadProfile/(:any)']="User/loadProfile/$1";
$route['updateuserprofile']="User/updateUserProfile";
$route['createNewFolder']= "Welcome/createNewFolder";
$route['login']="Welcome/verifyUser";
$route['createZipFolder']="Welcome/createZipFolder";
$route['fileUpload']="Welcome/fileUpload";
$route['folderUpload']="Welcome/folderUpload";
$route['createUser'] = "Welcome/createUser";
$route['user/logout'] = "User/logOut";
$route['default_controller'] = 'User';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
