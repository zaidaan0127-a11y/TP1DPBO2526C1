#include "Film.cpp"
#include <vector>

using namespace std;

vector<Film> daftarFilm; // deklarasi array

// Fungsi untuk mencari posisi data berdasarkan ID
int cariIndex(const string& id)
{
    // looping untuk seluruh elemen dalam array
    for (int i = 0; i < daftarFilm.size(); i++)
    {
        // jika ID ditemukan
        if (daftarFilm[i].getId() == id)
        {
            return i; // mengembalikan posisi data
        }
    }

    return -1; // jika data tidak ditemukan
}

// Fungsi untuk memeriksa apakah ID sudah ada
bool isIdExists(const string& id)
{
    // looping untuk seluruh elemen dalam array
    for (const auto& film : daftarFilm)
    {
        // jika ID sama
        if (film.getId() == id)
        {
            return true; // mengembalikan true
        }
    }

    return false; // jika ID tidak ditemukan
}

// Fungsi untuk input durasi
int inputDurasi()
{
    int durasi;

    while (true)
    {
        cout << "Durasi: ";

        // mengecek apakah input berupa angka
        if (cin >> durasi)
        {
            // mengecek apakah durasi negatif
            if (durasi < 0)
            {
                cout << "Durasi tidak boleh negatif!" << endl;
            }
            else
            {
                cin.ignore();
                return durasi;
            }
        }
        else
        {
            cout << "Durasi harus berupa angka!" << endl;

            // membersihkan input yang salah
            cin.clear();
            cin.ignore(1000, '\n');
        }
    }
}

// prosedur untuk menampilkan menu yang bisa diakses
void tampilkanMenu()
{
    // print
    cout << "\n<================ Menu Bioskop ================>" << endl
         << "1. Tambah Data Film" << endl
         << "2. Tampilkan Semua Data Film" << endl
         << "3. Update Data Film" << endl
         << "4. Hapus Data Film" << endl
         << "5. Cari Data Film" << endl
         << "6. Keluar" << endl
         << "Masukkan pilihan: ";
}

// prosedur untuk menambah data
void tambahData()
{
    // deklarasi variabel
    string id, judul, genre, sutradara;
    int durasi;

    cout << "\n--- Tambahkan Data Film ---" << endl;

    // do while untuk memastikan ID tidak sama
    do
    {
        cout << "\nID Film: ";
        cin >> id;

        if (isIdExists(id))
        {
            // jika ID sudah ada
            cout << "ID ini sudah ada. Silakan masukkan ID lain." << endl;
        }

    } while (isIdExists(id));

    cin.ignore();

    cout << "\nJudul: ";
    getline(cin, judul); // input judul

    cout << "\nGenre: ";
    getline(cin, genre); // input genre

    // input durasi dengan error handling
    durasi = inputDurasi();

    cout << "\nSutradara: ";
    getline(cin, sutradara); // input sutradara

    // menambahkan objek Film ke dalam array
    daftarFilm.push_back(
        Film(id, judul, genre, durasi, sutradara)
    );

    cout << "\nData film berhasil ditambahkan" << endl;
}

// prosedur untuk menampilkan data
void tampilkanData()
{
    cout << "\n--- Daftar Film ---" << endl;

    if (daftarFilm.empty())
    {
        // jika array film kosong
        cout << "\nData film kosong" << endl;
        return;
    }

    // looping untuk menampilkan semua data
    for (const auto& film : daftarFilm)
    {
        film.tampilkanData(); // menampilkan data
        cout << "\n"; // print newline
    }
}

// prosedur untuk memperbarui data
void updateData()
{
    string id_update;

    cout << "\n--- Update Data Film ---" << endl;
    cout << "Masukkan ID Film yang akan diupdate: ";
    cin >> id_update;

    cin.ignore();

    // mencari posisi data berdasarkan ID
    int index = cariIndex(id_update);

    // jika data tidak ditemukan
    if (index == -1)
    {
        cout << "Film dengan ID " << id_update
             << " tidak ditemukan" << endl;
        return;
    }

    // deklarasi data baru
    string judul_baru;
    string genre_baru;
    string sutradara_baru;
    int durasi_baru;

    cout << "Judul baru: ";
    getline(cin, judul_baru);

    cout << "Genre baru: ";
    getline(cin, genre_baru);

    // input durasi baru dengan error handling
    durasi_baru = inputDurasi();

    cout << "Sutradara baru: ";
    getline(cin, sutradara_baru);

    // mengubah data film
    daftarFilm[index].update(
        judul_baru,
        genre_baru,
        durasi_baru,
        sutradara_baru
    );

    cout << "\nData film berhasil diupdate" << endl;
}

// prosedur untuk menghapus data
void hapusData()
{
    string id_hapus;

    cout << "\n--- Hapus Data Film ---" << endl;
    cout << "Masukkan ID Film yang akan dihapus: ";
    cin >> id_hapus;

    // mencari posisi data berdasarkan ID
    int index = cariIndex(id_hapus);

    // jika data tidak ditemukan
    if (index == -1)
    {
        cout << "Film dengan ID " << id_hapus
             << " tidak ditemukan" << endl;
        return;
    }

    // menghapus data dari array
    daftarFilm.erase(daftarFilm.begin() + index);

    cout << "\nData film berhasil dihapus" << endl;
}

// prosedur untuk mencari data
void cariData()
{
    string id_cari;

    cout << "\n--- Cari Data Film ---" << endl;
    cout << "Masukkan ID Film yang akan dicari: ";
    cin >> id_cari;

    // mencari posisi data berdasarkan ID
    int index = cariIndex(id_cari);

    // jika data tidak ditemukan
    if (index == -1)
    {
        cout << "\nData film tidak ditemukan" << endl;
        return;
    }

    // jika data ditemukan
    cout << "\nData film ditemukan" << endl;
    daftarFilm[index].tampilkanData();
}

int main()
{
    int pilihan;

    // selama belum memilih opsi keluar,
    // maka program akan terus berjalan
    do
    {
        tampilkanMenu(); // menampilkan menu

        // mengecek apakah pilihan berupa angka
        if (!(cin >> pilihan))
        {
            cout << "Pilihan harus berupa angka!" << endl;

            // membersihkan input yang salah
            cin.clear();
            cin.ignore(1000, '\n');

            continue;
        }

        // mengecek pilihan hanya 1 sampai 6
        if (pilihan < 1 || pilihan > 6)
        {
            cout << "Pilihan harus antara 1 sampai 6!" << endl;
            continue;
        }

        switch (pilihan)
        {
            case 1:
                tambahData(); // opsi 1 menambah data
                break;

            case 2:
                tampilkanData(); // opsi 2 menampilkan data
                break;

            case 3:
                updateData(); // opsi 3 memperbarui data
                break;

            case 4:
                hapusData(); // opsi 4 menghapus data
                break;

            case 5:
                cariData(); // opsi 5 mencari data
                break;

            case 6:
                cout << "Terima kasih telah menggunakan program ini"
                     << endl; // opsi 6 keluar
                break;
        }

    } while (pilihan != 6); // selama belum memilih opsi 6

    return 0;
}