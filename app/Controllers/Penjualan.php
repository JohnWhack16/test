<?php namespace App\Controllers;

use App\Models\PenjualanHeaderModel;
use App\Models\PenjualanDetailModel;
use App\Models\OutletModel;
use App\Models\BarangModel;

class Penjualan extends BaseController
{
    protected $headerModel;
    protected $detailModel;
    protected $outletModel;
    protected $barangModel;

    public function __construct()
    {
        $this->headerModel = new PenjualanHeaderModel();
        $this->detailModel = new PenjualanDetailModel();
        $this->outletModel = new OutletModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data['penjualan'] = $this->headerModel->getAllWithOutlet();
        echo view('penjualan/index', $data);
    }

    public function create()
    {
        $data['outlets'] = $this->outletModel->findAll();
        $data['barangs'] = $this->barangModel->findAll();
        if ($this->request->getMethod() === 'post') {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $kdoutlet = $this->request->getPost('kdoutlet');
            $created_user = 'gavin'; 

            $items = $this->request->getPost('items'); 

            $amount = 0;
            foreach ($items as $it) {
                $amount += intval($it['qty']) * intval($it['harga']);
            }
            $discount = intval($this->request->getPost('discount') ?? 0);
            $ppn = intval($this->request->getPost('ppn') ?? 0);
            $total_amount = $amount - $discount + $ppn;

            $this->headerModel->insert([
                'nofaktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'kdoutlet' => $kdoutlet,
                'amount' => $amount,
                'discount' => $discount,
                'ppn' => $ppn,
                'total_amount' => $total_amount,
                'created_user' => $created_user,
                'created_date' => date('Y-m-d H:i:s'),
            ]);

            foreach ($items as $it) {
                $sub = intval($it['qty']) * intval($it['harga']);
                $this->detailModel->insert([
                    'nofaktur' => $nofaktur,
                    'kode_barang' => $it['kode'],
                    'qty' => $it['qty'],
                    'harga' => $it['harga'],
                    'sub_total' => $sub,
                    'created_user' => $created_user,
                    'created_date' => date('Y-m-d H:i:s'),
                ]);
            }

            return redirect()->to('/penjualan');
        }

        echo view('penjualan/create', $data);
    }

    public function edit($nofaktur = null)
{
    if (!$nofaktur) return redirect()->to('/penjualan');

    $data['header'] = $this->headerModel->find($nofaktur);
    $data['details'] = $this->detailModel->where('nofaktur', $nofaktur)->findAll();
    $data['outlets'] = $this->outletModel->findAll();
    $data['barangs'] = $this->barangModel->findAll();

    if ($this->request->getMethod() === 'post') {
        // Ambil semua data dari form
        $tglfaktur = $this->request->getPost('tglfaktur');
        $kdoutlet = $this->request->getPost('kdoutlet');
        $discount = intval($this->request->getPost('discount') ?? 0);
        $ppn = intval($this->request->getPost('ppn') ?? 0);

        // Decode items JSON
        $items = json_decode($this->request->getPost('items'), true);

        // Hitung total amount dari items
        $amount = 0;
        foreach ($items as $it) $amount += intval($it['qty']) * intval($it['harga']);
        $total_amount = $amount - $discount + $ppn;

        // Update header
        $this->headerModel->update($nofaktur, [
            'tglfaktur' => $tglfaktur,
            'kdoutlet' => $kdoutlet,
            'amount' => $amount,
            'discount' => $discount,
            'ppn' => $ppn,
            'total_amount' => $total_amount,
            'edit_user' => 'gavin',
            'edit_date' => date('Y-m-d H:i:s'),
        ]);

        // Hapus detail lama & insert detail baru
        $this->detailModel->where('nofaktur', $nofaktur)->delete();
        foreach ($items as $it) {
            $sub = intval($it['qty']) * intval($it['harga']);
            $this->detailModel->insert([
                'nofaktur' => $nofaktur,
                'kode_barang' => $it['kode'],
                'qty' => $it['qty'],
                'harga' => $it['harga'],
                'sub_total' => $sub,
                'created_user' => 'gavin',
                'created_date' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/penjualan/view/'.$nofaktur);
    }

    echo view('penjualan/edit', $data);
}


    public function delete($nofaktur)
    {
        if ($nofaktur) {
            $this->detailModel->where('nofaktur', $nofaktur)->delete();
            $this->headerModel->delete($nofaktur);
        }
        return redirect()->to('/penjualan');
    }

public function view($nofaktur)
{
    $data['header'] = $this->headerModel->find($nofaktur);
    $data['details'] = $this->detailModel->where('nofaktur', $nofaktur)->findAll();
    echo view('penjualan/view', $data);
}

}
