<?php namespace App\Models;
use CodeIgniter\Model;

class PenjualanDetailModel extends Model {
    protected $table = 'penjualan_detail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nofaktur','kode_barang','qty','harga','sub_total','created_user','created_date','edit_user','edit_date'];
}
