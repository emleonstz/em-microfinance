<?php

namespace App\Models;

use CodeIgniter\Model;

class Guarantor extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guarantors';
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

    public function getSponsersByUser($userid,$microfinaceid){
        $query = $this->db->query("SELECT * FROM `guarantor` WHERE `client_id` = ? AND microfinace_id = ?",[$userid,$microfinaceid],true);
        $result = $query->getResultArray();
        return $result;
    }
}
