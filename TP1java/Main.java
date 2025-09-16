import java.util.Scanner; // untuk input
import java.util.ArrayList; // untuk menyimpan banyak produk

public class Main {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in); // scanner untuk input user
        ArrayList<Produk> daftarProduk = new ArrayList<>(); // list untuk simpan produk
        int pilihan;

        do {
            // tampilkan menu
            System.out.println("\n=== MENU TOKO ELEKTRONIK ===");
            System.out.println("1. Tambah Data");
            System.out.println("2. Tampilkan Data");
            System.out.println("3. Update Data");
            System.out.println("4. Hapus Data");
            System.out.println("5. Cari Data");
            System.out.println("6. Keluar");
            System.out.print("Pilih: ");

            // cek input angka, kalau salah default ke 0
            String inputPilihan = sc.nextLine();
            try {
                pilihan = Integer.parseInt(inputPilihan);
            } catch (Exception e) {
                pilihan = 0;
            }

            if (pilihan == 1) {
                // TAMBAH DATA
                System.out.print("Masukkan ID Produk: ");
                String id = sc.nextLine();

                // cek apakah produk sudah ada
                Produk produkLama = null;
                // loop untuk memeriksa ID
                for (int i = 0; i < daftarProduk.size() && produkLama == null; i++) {
                    if (daftarProduk.get(i).getId().equals(id)) {
                        produkLama = daftarProduk.get(i);
                    }
                }


                if (produkLama != null) {           // jika ID ada yg cocok (produk sudah ada)
                    System.out.print("\n------Produk sudah ada. Masukkan tambahan stok:------");
                    int tambah = Integer.parseInt(sc.nextLine());           // input tambahan stok
                    produkLama.tambahStok(tambah);                          // stok lama ditambah stok baru
                    System.out.println("\n------Stok produk berhasil ditambahkan!------");
                } else {            // jika produk belum ada, input data produk baru
                    System.out.print("Masukkan Nama Produk: ");     // masukan nama produk
                    String nama = sc.nextLine();

                    System.out.print("Masukkan Merek: ");           // masukan merek produk
                    String merek = sc.nextLine();

                    System.out.print("Masukkan Kategori: ");        // masukan kategori produk
                    String kategori = sc.nextLine();

                    System.out.print("Masukkan Harga Produk: ");    // masukan harga produk
                    int harga = 0;
                    try {
                        harga = Integer.parseInt(sc.nextLine());    // cek eror inputan
                    } catch (Exception e) {
                        harga = 0;                  // jika inputan bukan angka, default harga = 0
                    }

                    System.out.print("Masukkan Stok Produk: ");     // masukan stok produk
                    int stok = 0;
                    try {
                        stok = Integer.parseInt(sc.nextLine());     // cek eror
                    } catch (Exception e) {
                        stok = 0;                   // jika inputan bukan angka, default stok = 0
                    }

                    // tambahkan produk dengan data yg sudah di input user 
                    daftarProduk.add(new Produk(id, nama, merek, kategori, harga, stok));
                    System.out.println("\n------Produk baru berhasil ditambahkan!------");
                }

            } else if (pilihan == 2) {          // jika pilih menu 2
                // TAMPILKAN SEMUA DATA
                System.out.println("\n                                     --- Daftar Produk ---");
                if (daftarProduk.isEmpty()) {
                    System.out.println("Belum ada produk.");            // jika data kosong 
                } else {
                    // print header tabel
                    System.out.println("----------------------------------------------------------------------------------------------");
                    System.out.printf("%-3s | %-8s | %-20s | %-15s | %-12s | %10s | %5s |%n",
                            "No", "ID", "Nama", "Merek", "Kategori", "Harga", "Stok");
                    System.out.println("----------------------------------------------------------------------------------------------");


                    // loop menampilkan semua produk
                    int no = 1;
                    for (Produk p : daftarProduk) {
                        p.tampil(no++);
                    }
                    System.out.println("----------------------------------------------------------------------------------------------");



                }

            } else if (pilihan == 3) {          // jika milih menu 3
                // UPDATE DATA
                System.out.print("Masukkan ID produk yang ingin diupdate: ");       // masukan ID yg mau di update
                String idCari = sc.nextLine();

                boolean ketemu = false;
                // loop pengecekan
                for (Produk p : daftarProduk) {
                    if (p.getId().equals(idCari)) {         // jika ID produk di temukan, update smua atribut
                        System.out.print("Masukkan Nama Produk baru: ");            // masukan nama produk baru
                        p.setNama(sc.nextLine());

                        System.out.print("Masukkan Merek baru: ");                  // masukan merek produk baru
                        p.setMerek(sc.nextLine());

                        System.out.print("Masukkan Kategori baru: ");               // masukan kategori produk baru
                        p.setKategori(sc.nextLine());

                        System.out.print("Masukkan Harga baru: ");                  // masukan harga produk baru
                        try {
                            p.setHarga(Integer.parseInt(sc.nextLine()));            // pengecekan eror
                        } catch (Exception e) {
                            p.setHarga(0);              // jika yang di masukan bukan angka, maka 0
                        }

                        System.out.print("Masukkan Stok baru: ");                   // masukan stok produk baru
                        try {
                            p.setStok(Integer.parseInt(sc.nextLine()));             // pengecekan eror
                        } catch (Exception e) {
                            p.setStok(0);                // jika yang di masukan bukan angka, maka 0
                        }

                        ketemu = true;
                        System.out.println("\n------Produk berhasil diupdate!------");
                    }
                }
                if (!ketemu) {          // jika ID tidak ada yg cocok
                    System.out.println("\n------Produk tidak ditemukan!------");
                }

            } else if (pilihan == 4) {          // jika memilih 4
                // HAPUS DATA
                System.out.print("Masukkan ID produk yang ingin dihapus: ");            // masuka ID produk yg mau dihapus
                String idHapus = sc.nextLine();

                boolean ketemu = false;
                // loop dengan index supaya bisa remove berdasarkan posisi
                for (int i = 0; i < daftarProduk.size() && !ketemu; i++) {
                    if (daftarProduk.get(i).getId().equals(idHapus)) {      // jika ID ada yg cocok
                        daftarProduk.remove(i);             // hapus produk dari list
                        ketemu = true;
                        System.out.println("\n------Produk berhasil dihapus!------");
                    }
                }
                if (!ketemu) {      // jika tidak ada ID yg cocok
                    System.out.println("\n------Produk tidak ditemukan!------");
                }

            } else if (pilihan == 5) {          // jika user milih menu 5
                // CARI DATA
                System.out.print("Masukkan ID produk yang ingin dicari: ");         // masukan ID yg akan dicari
                String idCari = sc.nextLine();

                boolean ketemu = false;
                int no = 1;
                for (Produk p : daftarProduk) {
                    if (p.getId().equals(idCari)) {
                        System.out.println("----------------------------------------------------------------------------------------------");
                        System.out.printf("%-3s | %-8s | %-20s | %-15s | %-12s | %10s | %5s |%n",
                            "No", "ID", "Nama", "Merek", "Kategori", "Harga", "Stok");
                         System.out.println("----------------------------------------------------------------------------------------------");

                        // tampilkan produk yg ditemukan
                        p.tampil(no);
                        ketemu = true;
                    }
                    System.out.println("----------------------------------------------------------------------------------------------");

                
                }
                if (!ketemu) {          // jika ID tidak ada yg cocok
                    System.out.println("Produk tidak ditemukan!");
                }


            } else if (pilihan == 6) {          // jika user milih menu 6
                System.out.println("\n------Keluar dari program------");
            } else {
                System.out.println("\n------Pilihan tidak valid. Masukkan 1-6.------");
            }

        } while (pilihan != 6);

        System.out.println("\n------Program selesai.------");
        sc.close();
    }
}
