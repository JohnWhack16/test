<!doctype html>
<html>
<head><title>Tambah Penjualan</title></head>
<body>
<h2>Tambah Penjualan</h2>
<form method="post" action="/penjualan/create" id="form-penjualan">
  <label>No Faktur: <input type="text" name="nofaktur" required></label><br>
  <label>Tanggal: <input type="date" name="tglfaktur" required></label><br>
  <label>Outlet:
    <select name="kdoutlet">
      <?php foreach($outlets as $o): ?>
        <option value="<?= esc($o['kdoutlet']) ?>"><?= esc($o['namaoutlet']) ?></option>
      <?php endforeach; ?>
    </select>
  </label><br>

  <h3>Items</h3>
  <div id="items-area"></div>
  <button type="button" onclick="addItem()">Tambah Item</button><br>

  <label>Discount: <input type="number" name="discount" value="0"></label><br>
  <label>PPN: <input type="number" name="ppn" value="0"></label><br>

  <input type="hidden" name="items" id="items-input">
  <button type="submit">Simpan</button>
</form>

<script>
let items = [];
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
    select.addEventListener('change', (e)=>{
      items[i].kode = e.target.value;
    });
    barangs.forEach(b=>{
      const opt = document.createElement('option');
      opt.value = b.kdbarang;
      opt.text = b.nama_barang + ' ('+b.harga+')';
      if (b.kdbarang==it.kode) opt.selected=true;
      select.appendChild(opt);
    });

    const qty = document.createElement('input');
    qty.type='number'; qty.value=it.qty;
    qty.addEventListener('input', (e)=>{ items[i].qty = e.target.value; });

    const harga = document.createElement('input');
    harga.type='number'; harga.value=it.harga;
    harga.addEventListener('input', (e)=>{ items[i].harga = e.target.value; });

    const remove = document.createElement('button');
    remove.type='button'; remove.innerText='X';
    remove.onclick=()=>{ items.splice(i,1); renderItems(); };

    div.appendChild(select); 
    div.appendChild(qty); 
    div.appendChild(harga); 
    div.appendChild(remove);
    area.appendChild(div);
  });
}

function buildItemsFromDOM(){
  const area = document.getElementById('items-area');
  const newItems = [];
  Array.from(area.children).forEach(div=>{
    const sel = div.querySelector('select');
    const inputs = div.querySelectorAll('input[type="number"]');
    const qtyVal = inputs[0] ? inputs[0].value : 0;
    const hargaVal = inputs[1] ? inputs[1].value : 0;
    newItems.push({ kode: sel.value, qty: qtyVal, harga: hargaVal });
  });
  return newItems;
}

document.getElementById('form-penjualan').addEventListener('submit', function(e){
  const built = buildItemsFromDOM();
  document.getElementById('items-input').value = JSON.stringify(built);
});

renderItems();
</script>
</body>
</html>
