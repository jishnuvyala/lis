<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 27-12-2015
 * Time: 19:54
 */
class templatemaster_model extends CI_Model
{

    public function insert($data)
    {
        $this->db->insert('template_master',$data);
        if($this->db->affected_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('template_master',$data);


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
    public function get_details()
    {
        $this->db->where('active_yesno',1);
        $query=$this->db->get('template_master');
        return $query->result();
    }
}