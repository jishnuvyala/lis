<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: jishnu
 * Date: 02-09-2015
 * Time: 17:06
 */

class Registration_model extends CI_Model
{
//Function To get district details and display in registration
    public function get_district()
    {
        $sql = "select d.name as district,s.name as state,d.id as district_id ,s.id as state_id from district_master d left join state_master s on d.id=s.district_id where d.active_yesno=1";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //Function To get gender details and display in registration
    public function get_gender()
    {
        $sql = "select id,gender FROM  gender_master where active_yesno=1";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //Function For new registration
    public function new_registration($data)
    {
        $this->db->insert('patient', $data);

        if($this->db->affected_rows()!=1)
        {
            return false;
        }
        else
        {
            $insert_id= $this->db->insert_id();
            return $insert_id;
        }
    }
//Function for Lab Card
    public function card_view($id)
    {
        $sql = "select concat(p.first_name,' ',p.last_name)as name ,p.address,gm.gender, sm.name as state,dm.name as district,p.id as lab_number,p.phone_no, p.email,p.age from patient p
                  left join gender_master gm on p.gender=gm.id
                  left join state_master sm on p.state=sm.id
                  left join district_master dm on p.district =dm.id
                  where p.id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result();

    }
//Function to show patient info while doing modify registration
    public function get_patientinfo($id)
    {
        $sql="select p.*,gm.id as gender_id,gm.gender as gender_name,sm.id as state_id,sm.name as state_name,dm.id as district_id,dm.name as district_name from patient p
                  left join gender_master gm on p.gender=gm.id
                  left join state_master sm on p.state=sm.id
                  left join district_master dm on p.district =dm.id
                  where p.id=? limit 1";
        $query = $this->db->query($sql,array($id));
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }

    }
    //Function for modifying registration
    public function update($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('patient',$data);

// was there any update or error?
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