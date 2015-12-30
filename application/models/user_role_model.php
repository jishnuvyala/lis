<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 24-11-2015
 * Time: 15:01
 */
class User_role_model extends CI_Model
{

    public function search_role($username)
{
    $sql="select r.name as role,r.id as role_id,u.id as user_id ,u.username,u.name,u.user_desc from user_role_map ur
left join users u on u.id=ur.user_id
left join role r on r.id=ur.role_id
where u.username=?";
    $query=$this->db->query($sql,array($username));
    return $query->result();
}

    public function delete($userid,$roleid)
    {
        $this->db->where('user_id',$userid);
        $this->db->where('role_id',$roleid);
        $query=$this->db->delete('user_role_map');
       if($this->db->affected_rows()>0)
       {
           return true;
       }
        else{
            return false;
        }
    }
    public function check_map($userid,$roleid)
    {
        $this->db->where('user_id',$userid);
        $this->db->where('role_id',$roleid);
        $query=$this->db->get('user_role_map');
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
        $this->db->insert('user_role_map',$data);
        if($this->db->affected_rows() > 0)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function get_details($username)
    {
        $sql="select * from users where username=? limit 1";
        $query=$this->db->query($sql,array($username));
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
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


}