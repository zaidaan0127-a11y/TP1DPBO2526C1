# deklarasi class
class Film:
    # private atribut
    def __init__(self, id_film, judul, genre, durasi, sutradara):
        self.__id_film = id_film  # inisialisasi
        self.__judul = judul  # inisialisasi
        self.__genre = genre  # inisialisasi
        self.__durasi = durasi  # inisialisasi
        self.__sutradara = sutradara  # inisialisasi

    # getter
    def get_id_film(self):
        return self.__id_film  # mengambil value

    def get_judul(self):
        return self.__judul  # mengambil value

    def get_genre(self):
        return self.__genre  # mengambil value

    def get_durasi(self):
        return self.__durasi  # mengambil value

    def get_sutradara(self):
        return self.__sutradara  # mengambil value

    # prosedur untuk mengupdate data
    def update(self, judul_baru, genre_baru, durasi_baru, sutradara_baru):
        self.__judul = judul_baru
        self.__genre = genre_baru
        self.__durasi = durasi_baru
        self.__sutradara = sutradara_baru

    # prosedur untuk menampilkan data
    def tampilkan_data(self):
        print("ID Film    :", self.get_id_film())
        print("Judul      :", self.get_judul())
        print("Genre      :", self.get_genre())
        print("Durasi     :", self.get_durasi(), "menit")
        print("Sutradara  :", self.get_sutradara())