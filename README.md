Saya Ervina Kusnanda dengan NIM 2409082 mengerjakan Tugas Praktikum 
dalam mata kuliah Desain Pemogramana Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

Misalnya sebuah toko elektronik mempunyai banyak produk. Setiap produk punya informasi penting yaitu ID, nama, merek, kategori, harga dan jumlah stok. Sebagai pemilik toko atau pegawai, ingin mencatat semua produk, menambah produk baru, mengubah data, meghapus produk yang sudah tidak dijual dan mencari produk dengan cepat. Orang lain tidak bisa mengacak data penting toko. 

Dibuatlah desain ini. Setiap produk di simpan pada sebuah wadah bernama Produk, yg berisi informasi tentang produk tersebut. Wadah ini bersifat private, hanya pemilik atau pegawai toko yg bisa membuka dan mengubah isinya.

Yang bisa dilakukan :
    - Menyimpan daftar produk elektronik.
    - Menampilkan daftar produk.
    - Menambahkan produk baru.
    - Mengubah data produk berdasarkan ID.
    - Menghapus produk berdasarkan ID.
    - Mencari produk berdasarkan ID.

Semua atribut dibuat private karna hanya pemilik atau karyawan toko yang punya akses data ini, jadi tidak semua orang bisa menggati atau mengubah data toko

Atribut yang digunakan :
    - ID = setiap produk punya identitas unik untuk memudahkan menemukan produk
    - Nama = supaya kita tau produk apa saja yg ada ditoko
    - Merek = agar bisa membedakan produk yg namanya mirip tapi beda pembuat atau lainnya
    - kategori = membantu mengelompokan data produk
    - harga = Supaya pemilik atau pegawai tidak lupa dan tahu harga produk untuk transaksi.
    - stok = agar kita tahu berapa banyak barang yg tersedia dan kapan harus restock

Untuk pengisian data produk dibuat constructor agar tidak perlu mengetik atribut setiap kali menambah produk baru


Alur program : 

Program ini seperti seorang asisten di toko. Dia selalu menunggu instruksi dari pemilik atau pegawai. Setiap kali kita menjalankan program, ia akan menampilkan menu pilihan:
    1. Tambah Data
    2. Tampilkan Data
    3. Update Data
    4. Hapus Data
    5. Cari Data
    6. Keluar

    - jika memilih tambah data, maka akan meminta (input user) semua informasu produk. Ia akan memeriksa apakah ID produk yg di input sudah ada. jika sudah ada maka yg dilakukan  hanya menambahkan stok, agar tidak menulis data yg sama dua kali
    - Jika memilih Tampilkan Data, maka akan menampilkan semua produk di toko dalam bentuk tabel, agar kita bisa melihat apa saja yang tersedia.
    - Jika memilih Update Data, maka akan diminta masukan ID produk yg ingin diubah. Program akan mencocokan ID tersebut dan user dapat mengubah nama, merek, kategori, harga, atau stok sesuai kebutuhan.
    - Jika memilih Hapus Data, maka akan di minta input ID produk yang ingin dihapus. Ia akan menghapus data sesuai ID produk 
    - Jika memilih Cari Data, maka diminta input ID produk. Ia akan mencari produk itu dan menampilkan informasinya dengan lengkap.
    - Jika kita memilih Keluar, asisten berhenti bekerja dan program selesai.


Program menyimpan semua data di array statis dengan kapasitas maksimal 100 produk. Setiap kali menambah atau mengubah produk, program selalu memeriksa ID produk terlebih dahulu agar tidak ada produk duplikat, sehingga data tetap rapi dan akurat.

### 1.Tambah data C++
![fitur tambah di c++](https://github.com/Erviina/TP1DPBO2425C2/blob/main/Dokumen/C%2B%2B%20fitur%201.png?raw=true)

### 2.Tampilkan data C++
![fitur tampilkan c++](https://github.com/Erviina/TP1DPBO2425C2/blob/main/Dokumen/C%2B%2B%20fitur%202.png?raw=true)

### 3. Update data C++
![fitur update di c++](https://github.com/Erviina/TP1DPBO2425C2/blob/main/Dokumen/C%2B%2B%20fitur%203.png?raw=true)

### 4. Hapus data C++
![fitur hapus di c++](https://github.com/Erviina/TP1DPBO2425C2/blob/main/Dokumen/C%2B%2B%20fitur%204.png?raw=true)

### 5. cari data C++
![fitur cari di c++](https://github.com/Erviina/TP1DPBO2425C2/blob/main/Dokumen/C%2B%2B%20fitur%205.png?raw=true)

### 6. keluar C++
![fitur keluar di c++](https://github.com/Erviina/TP1DPBO2425C2/blob/main/Dokumen/C%2B%2B%20fitur%206.png?raw=true)
