#include <iostream>
#include <string>

using namespace std;

// deklarasi class
class Film
{
    private:
        // private atribut
        string id_film;
        string judul;
        string genre;
        int durasi;
        string sutradara;

    public:
        // constructor
        Film(string id, string judul, string genre, int durasi,
             string sutradara)
        {
            this->id_film = id; // inisialisasi
            this->judul = judul; // inisialisasi
            this->genre = genre; // inisialisasi
            this->durasi = durasi; // inisialisasi
            this->sutradara = sutradara; // inisialisasi
        }

        // getter
        string getId() const
        {
            return id_film; // mengambil value
        }

        string getJudul() const
        {
            return judul; // mengambil value
        }

        string getGenre() const
        {
            return genre; // mengambil value
        }

        int getDurasi() const
        {
            return durasi; // mengambil value
        }

        string getSutradara() const
        {
            return sutradara; // mengambil value
        }

        // prosedur untuk mengupdate data
        void update(string judulBaru, string genreBaru,
                    int durasiBaru, string sutradaraBaru)
        {
            judul = judulBaru; // mengubah judul
            genre = genreBaru; // mengubah genre
            durasi = durasiBaru; // mengubah durasi
            sutradara = sutradaraBaru; // mengubah sutradara
        }

        // prosedur untuk menampilkan data
        void tampilkanData() const
        {
            // print
            cout << "ID Film    : " << getId() << endl
                 << "Judul      : " << getJudul() << endl
                 << "Genre      : " << getGenre() << endl
                 << "Durasi     : " << getDurasi() << " menit" << endl
                 << "Sutradara  : " << getSutradara() << endl;
        }
};