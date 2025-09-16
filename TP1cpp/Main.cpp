#include <iostream>
#include <string>
#include <limits>   // untuk numeric_limits
#include "Produk.cpp"
using namespace std;

int main() {
    Produk daftarProduk[100]; // array statis untuk menyimpan produk, maksimal 100 produk
    int jumlahProduk = 0;      // variabel jumlah produk yg berhasil tersimpan
    int pilihan;              // variabel untuk menyimpan menu yang dipilih user

    do {
        // Tampilkan menu yang akan dipilih
        cout << "\n=== MENU TOKO ELEKTRONIK ===\n";
        cout << "1. Tambah Data\n";
        cout << "2. Tampilkan Data\n";
        cout << "3. Update Data\n";
        cout << "4. Hapus Data\n";
        cout << "5. Cari Data\n";
        cout << "6. Keluar\n";
        cout << "Pilih: ";

        // cek input user apakah angka
        if (!(cin >> pilihan)) {
            // kalo input bukan angka -> reset input
            cin.clear();    //reset eror
            cin.ignore(numeric_limits<streamsize>::max(), '\n');    // buang input yg salah
            cout << "Input tidak valid. Masukkan angka 1-6.\n";
            continue;       // kembali ke menu
        }
        // buang newline agar getline berikutnya tidak terlewat
        cin.ignore(numeric_limits<streamsize>::max(), '\n');

        if (pilihan == 1) {     // jika user memilih menu 1
            // TAMBAH DATA (pakai getline agar bisa input dengan spasi)
            string id, nama, merek, kategori, hargaStr, stokStr;
            int harga = 0;
            int stok = 0;

            cout << "Masukkan ID Produk: ";     // minta user masukan ID produk
            getline(cin, id);

            cout << "Masukkan Nama Produk: ";   // minta user masukan nama produk
            getline(cin, nama);

            cout << "Masukkan Merek Produk: ";   // minta user masukan merek produk
            getline(cin, merek);

            cout << "Masukkan Kategori: ";      // minta user masukan kategoei produk
            getline(cin, kategori);

            cout << "Masukkan Harga Produk: ";  // minta user masukan harga produk
            getline(cin, hargaStr);
            // konversi string ke int (jika gagal, harga = 0)
            try {
                harga = stoi(hargaStr);
            } catch (...) {
                harga = 0;
            }

            cout << "Masukkan Stok Produk: ";  // minta user masukan harga produk
            getline(cin, stokStr);
            // konversi string ke int (jika gagal, harga = 0)
            try {
                stok = stoi(stokStr);
            } catch (...) {
                harga = 0;
            }

            // Cek apakah ID barang sudah ada, jika ada tambah stoknya
            bool ketemu = false;
            // loop untuk mengecek smua produk yg ada di array
            for (int i = 0; i < jumlahProduk && !ketemu; i++) {
                if (daftarProduk[i].getId() == id) {            // jika ada ID sama dengan inputan user
                    daftarProduk[i].setStok(daftarProduk[i].getStok() + stok);      // maka tambahkan atau update stok produk
                    cout << "Produk sudah ada. Stok ditambahkan!\n";
                    ketemu = true;      // penanda produk sudah ada
                }
            }


            if (!ketemu) {          // jika ID tidak ada yang sama
                if (jumlahProduk < 100) {       // periksa apakah masih ada array kosong
                    // tambahkan produk baru dengan data inputan user
                    daftarProduk[jumlahProduk] = Produk(id, nama, merek, kategori, harga, stok);
                    jumlahProduk++;         // produk bertambah
                    cout << "\n------Produk baru berhasil ditambahkan!------\n";
                } else {
                    // kalo array penuh 
                    cout << "Daftar penuh.\n";
                }
            }

        } else if (pilihan == 2) {  // jika user memilih menu 2
            // TAMPILKAN SEMUA DATA
            cout << "\n                                         --- Daftar Produk ---\n";
            if (jumlahProduk == 0) {
                cout << "Belum ada produk.\n";  // jika kosong
            } else {
                // tampilkan semua produk dengan loop
                cout << "----------------------------------------------------------------------------------------------------\n";
                cout << "No  | ID       | Nama                 | Merek           | Kategori        |   Harga  | Stok        |\n";
                cout << "----------------------------------------------------------------------------------------------------\n";
                for (int i = 0; i < jumlahProduk; i++) {
                    daftarProduk[i].tampil(i + 1);
                }
                cout << "----------------------------------------------------------------------------------------------------\n";

            }

        } else if (pilihan == 3) {  // jika user memilih menu 3 
            // UPDATE DATA (cari ID dulu)
            string idCari;
            cout << "Masukkan ID produk yang ingin diupdate: ";
            getline(cin, idCari);

            int ketemu = 0; // penanda produk ketemu atau tidak
            // loop mencocokan ID
            for (int i = 0; i < jumlahProduk; i++) {
                if (daftarProduk[i].getId() == idCari) {
                    // Jika ID ditemukan input data baru
                    string namaBaru, MerekBaru, kategoriBaru, hargaStr, stokStr;
                    int hargaBaru = 0;
                    int stokBaru = 0;

                    cout << "Masukkan Nama Produk baru: ";  // minta user masukan nama produk baru
                    getline(cin, namaBaru);

                    cout << "Masukkan Merek Produk : ";  // minta user masukan nama produk baru
                    getline(cin, MerekBaru);

                    cout << "Masukkan Kategori : ";     //  minta user masukan kategori produk
                    getline(cin, kategoriBaru);

                    cout << "Masukkan Harga : ";        // minta user masukan harga produk
                    getline(cin, hargaStr);
                    try {
                        hargaBaru = stoi(hargaStr);
                    } catch (...) {
                        hargaBaru = 0;
                    }

                    cout << "Masukkan Stok : ";        // minta user masukan harga produk
                    getline(cin, stokStr);
                    try {
                        stokBaru = stoi(stokStr);
                    } catch (...) {
                        stokBaru = 0;
                    }

                    // update via setter
                    daftarProduk[i].setNama(namaBaru);
                    daftarProduk[i].setMerek(MerekBaru);
                    daftarProduk[i].setKategori(kategoriBaru);
                    daftarProduk[i].setHarga(hargaBaru);
                    daftarProduk[i].setStok(stokBaru);

                    ketemu = 1;     // produk ditemukan
        
                }
            }
            if (ketemu) {
                cout << "\n------Produk berhasil diupdate!------\n";
            } else {
                cout << "\n------Produk tidak ditemukan!------\n";
            }

        } else if (pilihan == 4) {      // jika user memilih menu 4 
            // HAPUS DATA
            string idHapus;
            cout << "Masukkan ID produk yang ingin dihapus: ";
            getline(cin, idHapus);

            int index = -1;     // index produk yg akan di hapus
            // cari produk berdasarkan id
            for (int i = 0; i < jumlahProduk; i++) {
                if (daftarProduk[i].getId() == idHapus) {
                    index = i;
                    
                }
            }

            if (index != -1) {
                // geser semua elemen setelahnya ke kiri 
                for (int i = index; i < jumlahProduk - 1; i++) {
                    daftarProduk[i] = daftarProduk[i + 1];
                }
                jumlahProduk--;     // kurangi jumlah produk
                cout << "\n------Produk berhasil dihapus!------\n";
            } else {
                cout << "\n------Produk tidak ditemukan!------\n";
            }

        } else if (pilihan == 5) {  // jika user memilih menu 5
            // CARI DATA
            string idCari;
            cout << "Masukkan ID produk yang ingin dicari: ";
            getline(cin, idCari);

            bool ketemu = false;
            for (int i = 0; i < jumlahProduk; i++) {
                if (daftarProduk[i].getId() == idCari) {
                    cout << "----------------------------------------------------------------------------------------------------\n";
                    cout << "No  | ID       | Nama                 | Merek           | Kategori        |   Harga  | Stok        |\n";
                    cout << "----------------------------------------------------------------------------------------------------\n";
                    daftarProduk[i].tampil(i + 1);
                    ketemu = true;
                    cout << "----------------------------------------------------------------------------------------------------\n";

                }
            }
            if (!ketemu) cout << "------Produk tidak ditemukan!------\n";


        } else if (pilihan == 6) {  // jika user memilih menu 5
            cout << "\n------Keluar dari program------\n";
        } else {
            cout << "------Pilihan tidak valid. Masukkan 1-6.------\n";
        }

    } while (pilihan != 6);

    cout << "\n~~Program selesai.~~\n";
    return 0;
}
