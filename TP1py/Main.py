from Produk import Produk   # import class Produk
import sys                 # untuk keluar dari program

# daftarProduk akan menyimpan semua objek Produk
daftarProduk = []

while True:
    # tampilkan pilihan menu yang akan dilakukan
    print("\n=== MENU TOKO ELEKTRONIK ===")
    print("1. Tambah Data")
    print("2. Tampilkan Data")
    print("3. Update Data")
    print("4. Hapus Data")
    print("5. Cari Data")
    print("6. Keluar")

    pilihan = input("Pilih: ")      # input menu pilihan user

    if pilihan == "1":      # jika user pilih menu 1
        # TAMBAH DATA
        id = input("Masukkan ID Produk: ")          # masukan id produk yg akan ditambahkan
        nama = input("Masukkan Nama Produk: ")      # masukan nama produk yg akan ditambahkan
        merek = input("Masukkan Merek: ")           # # masukan merek produk yg akan ditambahkan
        kategori = input("Masukkan Kategori: ")     # masukan kategori produk yg akan ditambahkan
        try:
            harga = int(input("Masukkan Harga Produk: "))       # masukan harga produk yg akan ditambahkan
        except:
            harga = 0       # set awal harga 0
        try:
            stok = int(input("Masukkan Stok Produk: "))         # masukan stok produk yg akan ditambahkan
        except:
            stok = 0

        # Cek apakah produk dengan data sama sudah ada
        ketemu = False
        for p in daftarProduk:
            if not ketemu:
                if (p.get_nama() == nama and p.get_merek() == merek and 
                    p.get_kategori() == kategori and p.get_harga() == harga):
                    p.set_stok(p.get_stok() + stok)         # hanya menambah / mengubah pada stok saja
                    ketemu = True
                    print("\n------Produk sudah ada, stok ditambahkan!------")

        if not ketemu:
            daftarProduk.append(Produk(id, nama, merek, kategori, harga, stok))
            print("\n------Produk baru berhasil ditambahkan!------")


    elif pilihan == "2":        # jika user pilih menu 2
        # TAMPILKAN SEMUA DATA
        print("\n--- Daftar Produk ---")
        if len(daftarProduk) == 0:
            print("\n------Belum ada produk.------")
        else:
            print("-----------------------------------------------------------------------------------------------------------")
            print("No  | ID       | Nama                 | Merek           | Kategori      |    Harga | Stok  |")
            print("------------------------------------------------------------------------------------------------------------")
            for i, p in enumerate(daftarProduk, start=1):
                p.tampil(i)
            print("------------------------------------------------------------------------------------------------------------")
            

    elif pilihan == "3":        # jika user pilih menu 3
        # UPDATE DATA berdasarkan ID
        idCari = input("Masukkan ID produk yang ingin diupdate: ")      # input ID yg akan di update
        ketemu = False          # jika ID ditemukan
        for p in daftarProduk:
            if p.get_id() == idCari:
                namaBaru = input("Masukkan Nama Produk baru: ")         # input nama baru
                merekBaru = input("Masukkan Merek baru: ")              # input merek baru
                kategoriBaru = input("Masukkan Kategori baru: ")        # input kategori baru
                try:
                    hargaBaru = int(input("Masukkan Harga baru: "))     # input harga baru
                except:
                    hargaBaru = 0
                try:
                    stokBaru = int(input("Masukkan Stok baru: "))
                except:
                    stokBaru = p.get_stok()

                # mengupdate data dengan setter
                p.set_nama(namaBaru)
                p.set_merek(merekBaru)
                p.set_kategori(kategoriBaru)
                p.set_harga(hargaBaru)
                p.set_stok(stokBaru)

                ketemu = True       # jika ID tidak ditemukan
                print("\n------Produk berhasil diupdate!------")
        if not ketemu:
            print("\n------Produk tidak ditemukan!------")

    elif pilihan == "4":        # jika user memilih menu 4
        # HAPUS DATA
        idHapus = input("Masukkan ID produk yang ingin dihapus: ")      # input ID yg akan dihapus
        ketemu = False          # jika ketemu
        i = 0
        ketemu = False
        while i < len(daftarProduk) and not ketemu:
            if daftarProduk[i].get_id() == idHapus:
                del daftarProduk[i]
                ketemu = True
                print("\n------Produk berhasil dihapus!------")
            else:
                i += 1

        if not ketemu:          # jika ID tidak ditemukan
            print("\n------Produk tidak ditemukan!------")

    elif pilihan == "5":        # jika user memilih menu 5
        # CARI DATA
        idCari = input("Masukkan ID produk yang ingin dicari: ")        # input ID yang akan dicari
        ketemu = False          # jika ID ditemukan
        for p in daftarProduk:
            if p.get_id() == idCari:
                print("-----------------------------------------------------------------------------------------------------------")
                print("No  | ID       | Nama                 | Merek           | Kategori      |    Harga | Stok  |")
                print("------------------------------------------------------------------------------------------------------------")
                p.tampil(i)
                ketemu = True
                print("------------------------------------------------------------------------------------------------------------")

        if not ketemu:          # jika ID tidak ditemukan
            print("\n------Produk tidak ditemukan!------")

    elif pilihan == "6":            # jika user memilih menu 6
        print("\n------Keluar dari program------")
        sys.exit()

    else:
        print("\n------Pilihan tidak valid. Masukkan 1-6.------")
