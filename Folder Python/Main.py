from Film import Film

# deklarasi array of object
daftar_film = []


# prosedur untuk mencari index berdasarkan ID
def cari_index(id_film):
    for i in range(len(daftar_film)):
        if daftar_film[i].get_id_film() == id_film:
            return i

    return -1


# prosedur untuk mengecek ID
def is_id_exists(id_film):
    return cari_index(id_film) != -1


# prosedur untuk input durasi
def input_durasi():
    while True:
        try:
            durasi = int(input("Durasi: "))

            if durasi < 0:
                print("Durasi tidak boleh negatif!")
            else:
                return durasi

        except ValueError:
            print("Durasi harus berupa angka!")


# prosedur untuk menampilkan menu
def tampilkan_menu():
    print("\n<================ Menu Bioskop ================>")
    print("1. Tambah Data Film")
    print("2. Tampilkan Semua Data Film")
    print("3. Update Data Film")
    print("4. Hapus Data Film")
    print("5. Cari Data Film")
    print("6. Keluar")


# prosedur untuk menambah data
def tambah_data():
    print("\n--- Tambahkan Data Film ---")

    # mengecek ID agar unik
    while True:
        id_film = input("\nID Film: ")

        if is_id_exists(id_film):
            print("ID ini sudah ada. Silakan masukkan ID lain.")
        else:
            break

    judul = input("\nJudul: ")
    genre = input("\nGenre: ")
    durasi = input_durasi()
    sutradara = input("\nSutradara: ")

    # memasukkan object ke dalam list
    film = Film(id_film, judul, genre, durasi, sutradara)
    daftar_film.append(film)

    print("\nData film berhasil ditambahkan")


# prosedur untuk menampilkan semua data
def tampilkan_data():
    print("\n--- Daftar Film ---")

    if len(daftar_film) == 0:
        print("\nData film kosong")
        return

    for film in daftar_film:
        film.tampilkan_data()
        print()


# prosedur untuk mengupdate data
def update_data():
    print("\n--- Update Data Film ---")

    id_film = input("Masukkan ID Film yang akan diupdate: ")

    index = cari_index(id_film)

    if index == -1:
        print("Film dengan ID", id_film, "tidak ditemukan")
        return

    judul = input("Judul baru: ")
    genre = input("Genre baru: ")
    durasi = input_durasi()
    sutradara = input("Sutradara baru: ")

    daftar_film[index].update(
        judul,
        genre,
        durasi,
        sutradara
    )

    print("\nData film berhasil diupdate")


# prosedur untuk menghapus data
def hapus_data():
    print("\n--- Hapus Data Film ---")

    id_film = input("Masukkan ID Film yang akan dihapus: ")

    index = cari_index(id_film)

    if index == -1:
        print("Film dengan ID", id_film, "tidak ditemukan")
        return

    daftar_film.pop(index)

    print("\nData film berhasil dihapus")


# prosedur untuk mencari data
def cari_data():
    print("\n--- Cari Data Film ---")

    id_film = input("Masukkan ID Film yang akan dicari: ")

    index = cari_index(id_film)

    if index == -1:
        print("\nData film tidak ditemukan")
        return

    print("\nData film ditemukan")
    daftar_film[index].tampilkan_data()


# program utama
def main():
    while True:
        tampilkan_menu()

        try:
            pilihan = int(input("Masukkan pilihan: "))

            if pilihan < 1 or pilihan > 6:
                print("Pilihan harus antara 1 sampai 6.")
                continue

        except ValueError:
            print("Pilihan harus berupa angka!")
            continue

        if pilihan == 1:
            tambah_data()

        elif pilihan == 2:
            tampilkan_data()

        elif pilihan == 3:
            update_data()

        elif pilihan == 4:
            hapus_data()

        elif pilihan == 5:
            cari_data()

        elif pilihan == 6:
            print("Terima kasih telah menggunakan program ini")
            break


# menjalankan program utama
if __name__ == "__main__":
    main()