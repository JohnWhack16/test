<?php namespace App\Models;
use CodeIgniter\Model;

class PenjualanHeaderModel extends Model {
    protected $table = 'penjualan_header';
    protected $primaryKey = 'nofaktur';
    protected $allowedFields = ['nofaktur','tglfaktur','kdoutlet','amount','discount','ppn','total_amount','created_user','created_date','edit_user','edit_date'];

    public function getAllWithOutlet()
    {
        return $this->select('penjualan_header.*, outlet.namaoutlet')
                    ->join('outlet','penjualan_header.kdoutlet=outlet.kdoutlet','left')
                    ->orderBy('created_date','DESC')
                    ->findAll();
    }

    public function getWithDetails($nofaktur)
    {
        $db = \Config\Database::connect();
        $header = $this->find($nofaktur);
        $details = $db->table('penjualan_detail')->where('nofaktur',$nofaktur)->get()->getResultArray();
        return ['header'=>$header,'details'=>$details];
    }
}
