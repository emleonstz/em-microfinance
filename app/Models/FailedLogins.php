<?php

namespace App\Models;

use CodeIgniter\Model;

class FailedLogins extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'faillogin_atempts';
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
    protected $validationRules      = [];
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

    public function get_count_atempts($ipAdress) {
        $query = $this->db->query("SELECT COUNT(`ip_adress`) AS num FROM `faillogin_atempts` WHERE `ip_adress` = ? AND DATE(`date`) = DATE(NOW())",[$ipAdress],true);
        $result = $query->getRowArray();
        return $result;
    }
    function temporaryBan($ipAdress){
        $enableTime = time() + 1200;
        $this->setAllowedFields(['ip_adress', 'atempt_count', 'enable_after']);
        $data = ['ip_adress'=>$ipAdress,
         'atempt_count'=>0, 
         'enable_after'=>$enableTime];
        $this->save($data);
    }
    public function getLastAttempt($ipAdress){
        $query = $this->db->query("SELECT * FROM `faillogin_atempts` WHERE `ip_adress` = ? ORDER BY id DESC LIMIT 1;",[$ipAdress],true);
        $result = $query->getRowArray();
        return $result;
    }
    public function unBan($ipAdress){
        $query = $this->db->query("DELETE FROM `faillogin_atempts` WHERE `ip_adress` = ?",[$ipAdress],true);
    }
}
