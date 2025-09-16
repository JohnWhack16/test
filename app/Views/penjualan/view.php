<!doctype html>
<html>
<head><title>View Penjualan</title></head>
<body>
<h2>Detail Penjualan: <?= esc($header['nofaktur']) ?></h2>
<p>Tanggal: <?= esc($header['tglfaktur']) ?></p>
<p>Outlet: <?= esc($header['kdoutlet']) ?></p>
<table border="1" cellpadding="6">
<tr><th>Kode</th><th>Qty</th><th>Harga</th><th>Sub</th></tr>
<?php foreach($details as $d): ?>
<tr>
  <td><?= esc($d['kode_barang']) ?></td>
  <td><?= esc($d['qty']) ?></td>
  <td><?= number_format($d['harga']) ?></td>
  <td><?= number_format($d['sub_total']) ?></td>
</tr>
<?php endforeach; ?>
</table>
<p>Amount: <?= number_format($header['amount']) ?></p>
<p>Discount: <?= number_format($header['discount']) ?></p>
<p>PPN: <?= number_format($header['ppn']) ?></p>
<p>Total: <?= number_format($header['total_amount']) ?></p>
<p><a href="/penjualan">Back</a></p>
</body>
</html>
