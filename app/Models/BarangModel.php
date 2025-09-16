<?php namespace App\Models;
use CodeIgniter\Model;

class BarangModel extends Model {
    protected $table = 'barang';
    protected $primaryKey = 'kdbarang';
    protected $allowedFields = ['kdbarang','nama_barang','harga'];
}
