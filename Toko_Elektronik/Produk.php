<?php
// Produk.php
class Produk {
    private $id;
    private $nama;
    private $merek;
    private $kategori;
    private $harga;
    private $stok;
    private $gambar; // path lokal (misal: uploads/nama_file.jpg)

    public function __construct($id = "", $nama = "", $merek = "", $kategori = "", $harga = 0, $stok = 0, $gambar = "") {
        $this->id = (string)$id;
        $this->nama = (string)$nama;
        $this->merek = (string)$merek;
        $this->kategori = (string)$kategori;
        $this->harga = (int)$harga;
        $this->stok = (int)$stok;
        $this->gambar = (string)$gambar;
    }

    // getters
    public function getId() { return $this->id; }
    public function getNama() { return $this->nama; }
    public function getMerek() { return $this->merek; }
    public function getKategori() { return $this->kategori; }
    public function getHarga() { return $this->harga; }
    public function getStok() { return $this->stok; }
    public function getGambar() { return $this->gambar; }

    // setters
    public function setNama($v) { $this->nama = (string)$v; }
    public function setMerek($v) { $this->merek = (string)$v; }
    public function setKategori($v) { $this->kategori = (string)$v; }
    public function setHarga($v) { $this->harga = (int)$v; }
    public function setStok($v) { $this->stok = (int)$v; }
    public function setGambar($v) { $this->gambar = (string)$v; }
}
