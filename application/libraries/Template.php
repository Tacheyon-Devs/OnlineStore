<?php 
class Template 
{
    var $ci;
    function __construct()
    {
        $this->ci =& get_instance();
    }
    public function load($view,$data = NULL)
    {
       
        $content['content'] = $this->ci->load->view($view,$data,TRUE);
        // var_dump($data[0]['path']);die;
        if($data['path']==NULL)
        {
            // echo "sdfsd";
                $content['path']="";$content['totalSpace']="";
                $content['profilePicture']=$data['profile_picture'];
                // var_dump($content);
                $this->ci->parser->parse('Template/template',$content);
        }
        else
        {
            $content['path']=$data['path'];
            $content['totalSpace']=$data['totalSpace'];
            // var_dump($content);
            $this->ci->parser->parse('Template/template', $content);
        }
    }
}