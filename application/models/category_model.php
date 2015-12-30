<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 15:01
 */
class Category_model extends CI_Model
{

    public function search($name,$active)
    {
        $this->db->like('name',$name);
        $this->db->where('active_yesno',$active);
        $query=$this->db->get('category_master');
        return $query->result();
    }
    public function search_full($name,$active)
    {

        $this->db->where('active_yesno',$active);
        $query=$this->db->get('category_master');
        return $query->result();
    }
    public function check_name($name)
    {
        $this->db->where('name',$name);
        $query=$this->db->get('category_master');
        if($query->num_rows >0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function add($data)
    {
        $this->db->insert('category_master',$data);
        if($this->db->affected_rows() > 0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function get_details($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('category_master');
        return $query->result();
    }
    public function check_name_update($name,$id)
    {
        $sql="select * from category_master where name=? and id!=?";
        $query=$this->db->query($sql,array($name,$id));
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function update($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('category_master',$data);


        if ($this->db->affected_rows() == '1') {
            return true;
        } else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return false;
            }
            return true;
        }
    }


}