<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 29-11-2015
 * Time: 20:20
 */
class Service_model extends CI_Model
{

    public function get_category(){
        $this->db->where('active_yesno','1');
        $query=$this->db->get('category_master');
        return $query->result();
    }
    public function get_specimen(){
        $this->db->where('active_yesno','1');
        $query=$this->db->get('specimen_master');
        return $query->result();
    }
    public function get_unit(){
        $this->db->where('active_yesno','1');
        $query=$this->db->get('unit_master');
        return $query->result();
    }
    public function get_container(){
        $this->db->where('active_yesno','1');
        $query=$this->db->get('container_master');
        return $query->result();
    }

    public function search($name,$category,$result_type,$active_yesno)
    {
        $this->db->select('s.*,c.name as category,s.id as service_id');
        $this->db->from('service_master s');
        $this->db->join('category_master c', 'c.id = s.category_id','left');
        $this->db->like('s.name',$name);
        $this->db->like('c.name',$category);
        $this->db->like('s.result_type',$result_type);
        $this->db->where('s.active_yesno',$active_yesno);
        $query = $this->db->get();
        return $query->result();

    }
    public function search_p($name,$category,$result_type,$panel,$active_yesno)
    {
        $this->db->select('s.*,c.name as category,s.id as service_id');
        $this->db->from('service_master s');
        $this->db->join('category_master c', 'c.id = s.category_id','left');
        $this->db->like('s.name',$name);
        $this->db->like('c.name',$category);
        $this->db->where('s.active_yesno',$active_yesno);
        $this->db->where('s.panel_yesno',$panel);
        $query = $this->db->get();
        return $query->result();

    }

    public function add_service($data)
    {
        $this->db->insert('service_master',$data);
        if($this->db->affected_rows()!= 1)
        {
            return false;
        }
        else
        {
            $insert_id= $this->db->insert_id();
            return $insert_id;
        }
    }
    public function check_name($name)
    {
        $this->db->where('name',$name);
        $query=$this->db->get('service_master');
        if($query->num_rows >0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
public function add_numericresult($data)
{
    $this->db->insert('service_numeric_results',$data);
    if($this->db->affected_rows()> 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
    public function add_alpharange($data)
    {
        $this->db->insert('service_alpha_normal',$data);
        if($this->db->affected_rows()> 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function get_details($id){

        $this->db->select('s.*,n.*,a.*,s.id as service_id');
        $this->db->from('service_master s');
        $this->db->join('service_numeric_results n','n.service_id=s.id','left');
        $this->db->join('service_alpha_normal a','a.service_id=s.id','left');

        $this->db->where('s.id',$id);
        $this->db->limit(1);
        $query=$this->db->get();
        return $query->result();
    }
    public function check_name_update($name,$id)
    {
        $sql="select * from service_master where name=? and id!=?";
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
    public function update_service($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('service_master',$data);


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
    public function update_numericresult($data,$id)
    {
        $this->db->where('service_id',$id);
        $this->db->update('service_numeric_results',$data);


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
    public function update_alpharange($data,$id)
    {
        $this->db->where('service_id',$id);
        $this->db->update('service_alpha_normal',$data);


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