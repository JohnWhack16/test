<!doctype html>
<html>
<head><title>Edit Penjualan</title></head>
<body>
<h2>Edit Penjualan: <?= esc($header['nofaktur']) ?></h2>

<form method="post" action="/penjualan/edit/<?= esc($header['nofaktur']) ?>" id="form-penjualan">
  <label>No Faktur: 
    <input type="text" name="nofaktur" value="<?= esc($header['nofaktur']) ?>" readonly>
  </label><br>

  <label>Tanggal: 
    <input type="date" name="tglfaktur" value="<?= esc($header['tglfaktur']) ?>" required>
  </label><br>
  
  <label>Outlet:
    <select name="kdoutlet">
      <?php foreach($outlets as $o): ?>
        <option value="<?= esc($o['kdoutlet']) ?>" <?= $header['kdoutlet']==$o['kdoutlet']?'selected':'' ?>>
          <?= esc($o['namaoutlet']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label><br>

  <h3>Items</h3>
  <div id="items-area"></div>
  <button type="button" onclick="addItem()">Tambah Item</button><br>

  <label>Discount: 
    <input type="number" name="discount" value="<?= esc($header['discount']) ?>">
  </label><br>
  <label>PPN: 
    <input type="number" name="ppn" value="<?= esc($header['ppn']) ?>">
  </label><br>

  <input type="hidden" name="items" id="items-input">

  <button type="submit">Update</button>
  <a href="/penjualan">Back</a>   <!-- ✅ Tombol Back -->
</form>

<h2>Edit Penjualan: <?= esc($header['nofaktur']) ?></h2>

<form method="post" id="form-penjualan">
  <label>No Faktur: 
    <input type="text" name="nofaktur" value="<?= esc($header['nofaktur']) ?>" required>
  </label><br>

  <label>Tanggal: 
    <input type="date" name="tglfaktur" value="<?= esc($header['tglfaktur']) ?>" required>
  </label><br>

  <label>Outlet:
    <select name="kdoutlet">
      <?php foreach($outlets as $o): ?>
        <option value="<?= esc($o['kdoutlet']) ?>" <?= $header['kdoutlet']==$o['kdoutlet']?'selected':'' ?>>
          <?= esc($o['namaoutlet']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label><br>

  <label>Discount: 
    <input type="number" name="discount" value="<?= esc($header['discount']) ?>">
  </label><br>

  <label>PPN: 
    <input type="number" name="ppn" value="<?= esc($header['ppn']) ?>">
  </label><br>

  <h3>Items</h3>
  <div id="items-area"></div>
  <button type="button" onclick="addItem()">Tambah Item</button><br>

  <input type="hidden" name="items" id="items-input">

  <button type="submit">Update</button>
  <a href="/penjualan">Back</a>
</form>

<script>
let items = <?= json_encode(array_map(function($d){
  return ['kode'=>$d['kode_barang'],'qty'=>$d['qty'],'harga'=>$d['harga']];
}, $details)) ?>;

const barangs = <?= json_encode($barangs) ?>;

function addItem(){
  items.push({kode: barangs[0].kdbarang, qty:1, harga: barangs[0].harga});
  renderItems();
}

function renderItems(){
  const area = document.getElementById('items-area');
  area.innerHTML = '';
  items.forEach((it,i)=>{
    const div = document.createElement('div');

    const select = document.createElement('select');
    barangs.forEach(b=>{
      const opt = document.createElement('option');
      opt.value = b.kdbarang;
      opt.text = b.nama_barang + ' ('+b.harga+')';
      if (b.kdbarang==it.kode) opt.selected=true;
      select.appendChild(opt);
    });
    select.addEventListener('change', e => { items[i].kode = e.target.value; });

    const qty = document.createElement('input');
    qty.type='number'; qty.value=it.qty;
    qty.addEventListener('input', e => { items[i].qty = parseInt(e.target.value) || 0; });

    const harga = document.createElement('input');
    harga.type='number'; harga.value=it.harga;
    harga.addEventListener('input', e => { items[i].harga = parseFloat(e.target.value) || 0; });

    const remove = document.createElement('button');
    remove.type='button'; remove.innerText='X';
    remove.onclick = () => { items.splice(i,1); renderItems(); };

    div.appendChild(select);
    div.appendChild(qty);
    div.appendChild(harga);
    div.appendChild(remove);
    area.appendChild(div);
  });
}

document.getElementById('form-penjualan').addEventListener('submit', function(e){
  document.getElementById('items-input').value = JSON.stringify(items);
});

renderItems();
</script>

</body>
</html>
