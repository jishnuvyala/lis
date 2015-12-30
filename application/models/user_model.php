<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 15:01
 */
class User_model extends CI_Model
{

    public function search_name($name,$active)
{
    $this->db->like('name',$name);
    $this->db->where('active_yesno',$active);
    $query=$this->db->get('users');
    return $query->result();
}
    public function search_both($username,$name,$active)
    {
        $this->db->like('username',$username);
        $this->db->like('name',$name);
        $this->db->where('active_yesno',$active);
        $query=$this->db->get('users');
        return $query->result();
    }
    public function search_username($username,$active)
{
    $this->db->like('username',$username);
    $this->db->where('active_yesno',$active);
    $query=$this->db->get('users');
    return $query->result();
}
    public function search_full($active)
    {

        $this->db->where('active_yesno',$active);
        $query=$this->db->get('users');
        return $query->result();
    }
    public function check_name($name)
    {
        $this->db->where('username',$name);
        $query=$this->db->get('users');
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
        $this->db->insert('users',$data);
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
        $query=$this->db->get('users');
        return $query->result();
    }
    public function check_name_update($name,$id)
    {
        $sql="select * from users where name=? and id!=?";
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
        $this->db->update('users',$data);


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
    public function update_user_password($data,$username,$userid)
    {
        $this->db->where('username',$username);
        $this->db->where('id',$userid);

        $this->db->update('users',$data);


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