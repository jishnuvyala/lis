<?php

Class User extends CI_Model
{
function login($username, $password)
{
$sql="select * from users where username=? and password =?  and active_yesno=1 limit 1";

$query = $this ->db->query($sql,array($username,$password));

if($query->num_rows()== 1)
{
return $query->result();
}
else
{
return false;
}
}
    function role($id)
    {
        $sql="select role_id from user_role_map where user_id=?";
        $query=$this->db->query($sql,array($id));
        if ($query->num_rows() > 0) {


            return $query->result();
        }
        else
        {
            return false;
        }

    }

}
?>