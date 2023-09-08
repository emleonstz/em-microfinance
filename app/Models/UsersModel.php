<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'staff_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'username'     => 'required|max_length[30]|alpha_numeric_space|min_length[3]',
        'email'        => 'required|max_length[254]|valid_email|is_unique[staff_users.email]',
        'password'     => 'required|max_length[255]|min_length[6]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function simpleUserdata($uid){
        $query  = $this->db->query("SELECT `id`, `first_name`, `last_name`, `email`, `phone`, `system_role`,`accout_status`, `api_key`, `photo`, `microfinance_id` FROM `staff_users` WHERE `id` = ?",[$uid],true);
        $result = $query->getRowArray();
        return $result;
    }
    public function setLastActivity($id){
        $lastactiontime = time()+180;
        $query = $this->db->query("UPDATE `staff_users` SET `last_activity`= '$lastactiontime' WHERE `id` = ?",[$id],true);
    }
}