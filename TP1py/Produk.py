# Class Produk untuk menyimpan data barang elektronik
class Produk:
    # Constructor
    def __init__(self, id="", nama="", merek="", kategori="", harga=0, stok=0):
        # atribut private
        self.__id = id
        self.__nama = nama
        self.__merek = merek
        self.__kategori = kategori
        self.__harga = harga
        self.__stok = stok
        

    # Getter untuk mengambil nilai atribut private
    def get_id(self):           #  mengambil nilai ID
        return self.__id

    def get_nama(self):         #  mengambil nama
        return self.__nama

    def get_merek(self):        # mengambil merek
        return self.__merek

    def get_kategori(self):     #  mengambil kategori
        return self.__kategori

    def get_harga(self):        #  mengambil nilai harga
        return self.__harga

    def get_stok(self):
        return self.__stok      # mengambil stok


    # Setter untuk mengubah nilai atribut private
    def set_nama(self, nama):           # mengubah nama
        self.__nama = nama

    def set_merek(self, merek):         # mengubah merek
        self.__merek = merek

    def set_kategori(self, kategori):   # mengubah kategori
        self.__kategori = kategori

    def set_harga(self, harga):         # mengubah harga
        self.__harga = harga

    def set_stok(self, stok):           # mengubah stok
        self.__stok = stok

    # Menampilkan semua data produk
    def tampil(self, no):
        print(f"{no:<3} | {self.__id:<8} | {self.__nama:<20} | "
              f"{self.__merek:<15} | {self.__kategori:<12} | "
              f"{self.__harga:>8} | {self.__stok:>5} | ")