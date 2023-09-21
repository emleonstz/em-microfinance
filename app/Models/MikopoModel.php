<?php

namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

class MikopoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'loans';
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

    public function getLastItemId(){
        $query = $this->db->query("SELECT `id` FROM `loans` ORDER BY `id` DESC LIMIT 1");
        $result = $query->getRowArray();
        return $result;
    }

    public function getOverDueLoansbyUser($userid,$microfinanceid){
        $now = time();
        $query = $this->db->query("SELECT * FROM `loans` WHERE '$now'>`duration` AND `client_id` = ? AND `microfinance_id` = ? AND `unpaid_amount` != 0",[$userid,$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function getHajiaguswaLoansbyUser($userid,$microfinanceid){
        $now = time();
        $query = $this->db->query("SELECT * FROM `loans` WHERE payment_amount - unpaid_amount = payment_amount AND `client_id` = ? AND `microfinance_id` = ?",[$userid,$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function getincompletengLoansbyUser($userid,$microfinanceid){
        $now = time();
        $query = $this->db->query("SELECT * FROM `loans` WHERE `payment_amount` !=`unpaid_amount` AND  payment_amount - unpaid_amount != payment_amount AND `client_id` = ? AND `microfinance_id` = ?;",[$userid,$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function getAllLoansbyUser($userid,$microfinanceid){
        $now = time();
        $query = $this->db->query("SELECT * FROM `loans` WHERE  `client_id` = ? AND `microfinance_id` = ?;",[$userid,$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function leteMikopYote($microfinanceid){
        $query = $this->db->query("SELECT loans.*,clients.full_name,clients.middle_name,clients.last_name FROM `loans` INNER JOIN clients ON loans.microfinance_id = ? AND clients.id = loans.client_id ORDER BY loans.borrowing_date DESC;",[$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function leteMikopHaijamalizika($microfinanceid){
        $query = $this->db->query("SELECT loans.*,clients.full_name,clients.middle_name,clients.last_name FROM `loans` INNER JOIN clients ON loans.microfinance_id = ? AND clients.id = loans.client_id AND loans.unpaid_amount != 0 AND loans.application_status = 'Accepted' ORDER BY loans.borrowing_date DESC;",[$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function leteMikoHaijalipwa($microfinanceid){
        $query = $this->db->query("SELECT loans.*,clients.full_name,clients.middle_name,clients.last_name FROM `loans` INNER JOIN clients ON loans.microfinance_id = ? AND clients.id = loans.client_id AND loans.unpaid_amount = loans.payment_amount AND loans.application_status = 'Accepted' ORDER BY loans.borrowing_date DESC;",[$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function leteMikopPending($microfinanceid){
        $query = $this->db->query("SELECT loans.*,clients.full_name,clients.middle_name,clients.last_name FROM `loans` INNER JOIN clients ON loans.microfinance_id = ? AND clients.id = loans.client_id AND loans.application_status != 'Accepted' ORDER BY loans.borrowing_date DESC;",[$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
    public function leteMikopIlopitiliza($microfinanceid){
        $query = $this->db->query("SELECT loans.*,clients.full_name,clients.middle_name,clients.last_name FROM `loans` INNER JOIN clients ON loans.microfinance_id = ? AND clients.id = loans.client_id AND DATE(NOW())>loans.duration AND loans.payment_amount - loans.unpaid_amount != loans.payment_amount AND loans.application_status = 'Accepted' ORDER BY loans.borrowing_date DESC;",[$microfinanceid],true);
        $result = $query->getResultArray();
        return $result;
    }
}
