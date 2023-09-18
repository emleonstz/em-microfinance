<?php

namespace App\Models;

use App\Controllers\Functions;
use CodeIgniter\Model;

class MalipoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'payments';
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

    public function getMalipo($userId,$loanId,$microfinanceId){
        $query = $this->db->query("SELECT * FROM `payments` WHERE `client_id` = ? AND `loan_id` = ? AND `microfinance_id` = ?",[$userId,$loanId,$microfinanceId]);
        $result = $query->getResultArray();
        return $result;
    }
    public function getTotalMalipo($userId,$loanId,$microfinanceId){
        $query = $this->db->query("SELECT SUM(`payment_amount`) AS num FROM `payments` WHERE `client_id` = ? AND `loan_id` = ? AND `microfinance_id` = ?",[$userId,$loanId,$microfinanceId]);
        $result = $query->getRowArray();
        return $result;
    }
}
