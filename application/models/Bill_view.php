<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 08-11-2015
 * Time: 12:32
 */

class Bill_view extends CI_Model
{

    public function service_view()
    {
        $this->db->where('active_yesno',1);
        $query=$this->db->get('service_master');
        return $query->result();
    }
}