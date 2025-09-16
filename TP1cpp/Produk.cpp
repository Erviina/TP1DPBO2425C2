#include <iostream>
#include <string>
#include <iomanip>      //untuk setw di tabel
using namespace std;

// Class Produk untuk menyimpan data barang elektronik
class Produk {
private:
    string id;              // Atribut unik produk
    string nama;            // Atribut nama untuk produk
    string merek;           // Atribut untuk merek produk
    string kategori;        // Atribut kategori untuk produk
    int harga;              // Atribut harga produk
    int stok;               // stok produk

public:
    // Constructor
    Produk(string id = "", string nama = "", string merek = "", string kategori = "", int harga = 0,  int stok = 0) {
        this->id = id;                  // Isi Id
        this->nama = nama;              // Isi nama
        this->merek = merek;            // Isi merek
        this->kategori = kategori;      // Isi kategori
        this->harga = harga;            // Isi harga
        this->stok = stok;              // Isi stok
    }

    // Destructor
    ~Produk() {

    }

    // Setter untuk update data
    void setNama(string nama) { this->nama = nama; }
    void setMerek(string merek) { this->merek = merek; }
    void setKategori(string kategori) { this->kategori = kategori; }
    void setHarga(int harga) { this->harga = harga; }
    void setStok(int stok) { this->stok = stok; }


    // Getter untuk membaca data privat
    string getId() { return id; }
    string getNama() { return nama; }
    string getMerek() { return merek; }
    string getKategori() { return kategori; }
    int getHarga() { return harga; }
    int getStok() { return stok; }

    void tampil(int no) {
        cout << setw(3) << right << no << " | "
             << setw(8) << left << id << " | "
             << setw(20) << left << nama << " | "
             << setw(15) << left << merek << " | "
             << setw(15) << left << kategori << " | "
             << setw(8) << right << harga << " | "
             << setw(11) << right << stok << " | " 
             << endl;
    }

    
};
