<?php 
class File_Model extends CI_Model
{
    public function insertFile($data)
    {
        $array = array
        (
            'name'=>$data['name'],
            'path'=>$data['path'],
            'type'=>$data['type'],
            'parent_folder'=>$data['parentFolder'],
            'user_id'=>$this->session->userdata('loggedIn')['id'],
            'size'=>$data['size']
        );
        $result = $this->db->insert('files',$array);
        return $result;
    }
    public function createFolder($parent,$dbFolderPath,$user,$name)
    {
        $array = array
        (
            'name'=>$name,
            'parent_folder'=>$parent,
            'user_id'=>$user,
            'path'=>$dbFolderPath
        );
        $this->db->insert('folders',$array);
        $result=$this->db->insert_id();
        return $result;
    }
    public function insertBatchFile($data)
    {
        $array = array
        (
            'name'=>$data['name'],
            'path'=>$data['path'],
            'parent_folder'=>$data['parentFolder'],
            'user_id'=>$data['user'],
            'size'=>$data['size']
        );
        $query =$this->db->insert('files',$array);
        return $query;
    }
    public function checkFolder($parent,$user,$name)
    {
        $this->db->select('*');
        $this->db->from('folders');
        $this->db->where('user_id',$user);
        $this->db->where('name',$name);
        $this->db->where('parent_folder',$parent);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->row_array();
        }
        else
        {
            return 0;
        }
        // return ($query->num_rows() > 0)? 1 : 0;  
        // return $query;
    }
    public function getParentFolder($parent,$user)
    {
        $this->db->select('*');
        $this->db->from('folders');
        $this->db->where('user_id',$user);
        $this->db->where('id',$parent);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->row_array();
        }
        else
        {
            return NULL;
        }
        // return ($query->num_rows() > 0)? 1 : 0;  
        // return $query;
    }
    public function updateFolderSize($parent,$user,$size)
    {
        $this->db->set('size',$size);
        $this->db->where('user_id',$user);
        $this->db->where('id',$parent);
        $query = $this->db->update('folders');
    }
    public function getFoldersize($folderId,$user)
    {
        $this->db->select('*');
        $this->db->where('user_id',$user);
        $this->db->where('id',$folderId);
        $query = $this->db->get('folders');
        
        if($query->num_rows())
        {
            return $query->row_array();
        }
        else
        {
            return 0;
        }
    }
    public function getFolderById($id)
    {
        $this->db->select('*');
        $this->db->from('folders');
        $this->db->where('id',$id);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->row_array();
        }
        else
        {
            return 0;
        }

    }
    public function getFolders($id)
    {
        $this->db->select('*');
        $this->db->from('folders');
        $this->db->where('parent_folder',$id);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return 0;
        }
    }
    public function getFiles($id)
    {
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('parent_folder',$id);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return 0;
        }
    }
    public function getAllFiles()
    {
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('user_id',$this->session->userdata('loggedIn')['id']);
        $this->db->where('parent_folder',NULL);
        $query=$this->db->get();
        if($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return 0;
        }
    }
    public function getAllFolders()
    {
        $this->db->select('*');
        $this->db->from('folders');
        $this->db->where('user_id',$this->session->userdata('loggedIn')['id']);
        $this->db->where('parent_folder',NULL);
        $query=$this->db->get();
        if($query->num_rows())
        {
            return $query->result_array();
        }
        else
        {
            return 0;
        }
    }
    public function getFile($id)
    {
        $this->db->select("*");
        $this->db->from("files");
        $this->db->where("id",$id);
        $query = $this->db->get();
        if($query->num_rows())
        {
            return $query->row_array();
        }
        else
        {
            return 0;
        }
    }
    public function getUserTotalSpace($id)
    {
        $this->db->select("size");
        $this->db->from("files");
        $this->db->where("user_id", $id);
        $query = $this->db->get();
        $result =0;
        if($query->num_rows())
        {
            // return $query->result_array()[];
            $temp= $query->result_array();
            foreach($temp as $index)
            {
                $result+=$index['size'];
                // var_dump ($index);
            }
            // return $result;
            $gb = 1073741824;
            $mb = 1048576;
            $kb = 1024;
            if($result>=$gb)
            {
                return $result= number_format((float)$result/$gb, 2, '.', '')." GB";
            }
            else if($result<$gb && $result>=$mb)
            {
                // return $result/$mb;
                return $result= number_format((float)$result/$mb, 2, '.', '')." MB";
            }
            else if($result<$mb && $result>=$kb)
            {
                return $result= number_format((float)$result/$kb, 2, '.', '')." KB";
            }
            else
            {
                return $result= number_format((float)$result, 2, '.', '')." Bytes";
            }
        }
        else
        {
            return 0;
        }
    }
}