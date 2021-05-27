<?php 
class User_Model extends CI_Model
{

    public function signUp($data)
    {
        // return $image;
        // echo  ($data['email']);
        // return false;
        $data = array
        (
            'email'=>$data['email'],
            'password'=>$data['password'],
            'name'=>$data['name']
        );
        $this->db->insert('users',$data);
        $id= $this->db->insert_id();
        
        $query=$this->db->order_by('id','desc')->get('users')->row_array();
        // // $last_id = $this->db->insert_id();
        return (($query));
    }
    public function getUserData($user)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$user);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->result_array()[0];
        }
        else
        {
            return 0;
        }
    }
    public function userAuthentication($data)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$data['email']);
        $this->db->where('password',$data['password']);
        $query = $this->db->get();
        $result =  ($query->result_array()[0]); 
        return $result;
    }
    public function setProfilePicture($id,$file)
    {
        $this->db->set('profile_picture',$file);
        $this->db->where("id",$id);
        $this->db->update("users");
    }
    public function updateUserProfile($data)
    {
        $this->db->set('name',$data['name']);
        $this->db->set('email',$data['email']);
        $this->db->set('password',$data['password']);
        $this->db->where("id",$this->session->userdata('loggedIn')['id']);
        $this->db->update('users');

    }

}