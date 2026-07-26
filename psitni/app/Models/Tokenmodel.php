<?php namespace App\Models;

use CodeIgniter\Model;

class Tokenmodel extends Model
{
    protected $table      = 'users';
    // protected $primaryKey = 'user_id';
    protected $allowedFields = ['token', 'start_date','end_date','status_cd'];



    public function simpantoken($data) {
        return $this->db->table('token')
                        ->insert($data);
    }


    public function checktoken($token,$group_id) {
        $date = date("Y-m-d");
        return $this->db->table('token')
                        ->select('*')
                        ->where('token',$token)
                        ->where('start_date <=',$date)
                        ->where('end_date >=',$date)
                        ->where('group_id',$group_id)
                        ->get();
    }

    public function checktokenUsername($token) {
        return $this->db->table('users')
                        ->select('*')
                        ->where('user_nm',$token)
                        ->get();
    }
}