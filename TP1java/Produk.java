// Class Produk untuk menyimpan data barang elektronik
public class Produk {
    // atribut private agar tidak bisa langsung diakses dari luar
    private String id;       // atribut unik produk
    private String nama;     // nama produk
    private String merek;    // atribut merek
    private String kategori; // kategori produk
    private int harga;       // harga produk
    private int stok;        // atribut stok

    // Constructor
    public Produk(String id, String nama, String merek, String kategori, int harga, int stok) {
        this.id = id;
        this.nama = nama;
        this.merek = merek;
        this.kategori = kategori;
        this.harga = harga;
        this.stok = stok;
    }

    // Setter (untuk mengubah data)
    public void setNama(String nama) { this.nama = nama; }
    public void setMerek(String merek) { this.merek = merek; }
    public void setKategori(String kategori) { this.kategori = kategori; }
    public void setHarga(int harga) { this.harga = harga; }
    public void setStok(int stok) { this.stok = stok; }

    // Getter (untuk membaca data privat)
    public String getId() { return id; }
    public String getNama() { return nama; }
    public String getMerek() { return merek; }
    public String getKategori() { return kategori; }
    public int getHarga() { return harga; }
    public int getStok() { return stok; }

    // Tambah stok
    public void tambahStok(int jumlah) {
        this.stok += jumlah;
    }

    // Menampilkan semua data produk
    public void tampil(int no) {
        System.out.printf("%-3d | %-8s | %-20s | %-15s | %-12s | %10d | %5d |%n",
                no, id, nama, merek, kategori, harga, stok);
    }
}
