<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 14-12-2015
 * Time: 16:35
 */
class Patientbrowser_model extends CI_Model
{
    public function search($fname,$lname,$age,$addr,$phone,$email)
    {
        $this->db->select('p.*,d.name as district,s.name as state,g.gender as gender');
        $this->db->from('patient p');
        $this->db->join('district_master d','d.id=p.district','left');
        $this->db->join('state_master s','s.id=p.state','left');
        $this->db->join('gender_master g','g.id=p.gender','left');
        $this->db->like('p.first_name',$fname);
        $this->db->like('p.last_name',$lname);
        $this->db->like('p.age',$age);
        $this->db->like('p.address',$addr);
        $this->db->like('p.phone_no',$phone);
        $this->db->like('p.email',$email);
        $query=$this->db->get();
        return $query->result();


    }
}