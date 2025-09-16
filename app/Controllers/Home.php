<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/penjualan'); // langsung ke modul penjualan
    }
}
