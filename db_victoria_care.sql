
CREATE DATABASE IF NOT EXISTS sales;
USE sales;

DROP TABLE IF EXISTS outlet;
CREATE TABLE outlet (
  kdoutlet VARCHAR(20) PRIMARY KEY,
  namaoutlet VARCHAR(100),
  alamat VARCHAR(255),
  PIC VARCHAR(100)
);

INSERT INTO outlet (kdoutlet, namaoutlet, alamat, PIC) VALUES
('TKO-001','Transmart','Cengkareng','Steve'),
('TKO-002','Hero','Jatiuwung','Jack');

DROP TABLE IF EXISTS barang;
CREATE TABLE barang (
  kdbarang VARCHAR(20) PRIMARY KEY,
  nama_barang VARCHAR(150),
  harga INT
);

INSERT INTO barang (kdbarang, nama_barang, harga) VALUES
('001','Miranda',8000),
('002','Herborist',9500),
('003','Nuface',7000);

DROP TABLE IF EXISTS penjualan_header;
CREATE TABLE penjualan_header (
  nofaktur VARCHAR(50) PRIMARY KEY,
  tglfaktur DATE,
  kdoutlet VARCHAR(20),
  amount INT,
  discount INT,
  ppn INT,
  total_amount INT,
  created_user VARCHAR(50),
  created_date DATETIME,
  edit_user VARCHAR(50),
  edit_date DATETIME,
  FOREIGN KEY (kdoutlet) REFERENCES outlet(kdoutlet)
);

INSERT INTO penjualan_header (nofaktur,tglfaktur,kdoutlet,amount,discount,ppn,total_amount,created_user,created_date)
VALUES
('fak-202403-001','2024-03-22','TKO-001',25500,1000,2805,27305,'gavin','2024-03-22 10:00:00'),
('fak-202403-002','2024-03-22','TKO-002',14000,2000,1540,13540,'gavin','2024-03-22 11:00:00');

DROP TABLE IF EXISTS penjualan_detail;
CREATE TABLE penjualan_detail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nofaktur VARCHAR(50),
  kode_barang VARCHAR(20),
  qty INT,
  harga INT,
  sub_total INT,
  created_user VARCHAR(50),
  created_date DATETIME,
  edit_user VARCHAR(50),
  edit_date DATETIME,
  FOREIGN KEY (nofaktur) REFERENCES penjualan_header(nofaktur),
  FOREIGN KEY (kode_barang) REFERENCES barang(kdbarang)
);

INSERT INTO penjualan_detail (nofaktur,kode_barang,qty,harga,sub_total,created_user,created_date)
VALUES
('fak-202403-001','001',2,8000,16000,'gavin','2024-03-22 10:01:00'),
('fak-202403-001','002',1,9500,9500,'gavin','2024-03-22 10:02:00'),
('fak-202403-002','003',2,7000,14000,'gavin','2024-03-22 11:01:00');
