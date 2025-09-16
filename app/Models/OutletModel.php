<?php namespace App\Models;
use CodeIgniter\Model;

class OutletModel extends Model {
    protected $table = 'outlet';
    protected $primaryKey = 'kdoutlet';
    protected $allowedFields = ['kdoutlet','namaoutlet','alamat','PIC'];
}
