<!doctype html>
<html>
<head><title>Penjualan</title></head>
<body>
<h2>Daftar Penjualan</h2>
<p><a href="/penjualan/create">Tambah Penjualan</a></p>
<table border="1" cellpadding="6">
<tr>
  <th>No Faktur</th><th>Tanggal</th><th>Outlet</th><th>Amount</th><th>Total</th><th>Aksi</th>
</tr>
<?php foreach($penjualan as $p): ?>
<tr>
  <td><?= esc($p['nofaktur']) ?></td>
  <td><?= esc($p['tglfaktur']) ?></td>
  <td><?= esc($p['namaoutlet']) ?></td>
  <td><?= number_format($p['amount']) ?></td>
  <td><?= number_format($p['total_amount']) ?></td>
  <td>
    <a href="/penjualan/view/<?= esc($p['nofaktur']) ?>">View</a> |
    <a href="/penjualan/edit/<?= esc($p['nofaktur']) ?>">Edit</a> |
    <a href="/penjualan/delete/<?= esc($p['nofaktur']) ?>" onclick="return confirm('hapus?')">Delete</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
