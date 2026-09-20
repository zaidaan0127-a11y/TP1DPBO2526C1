// deklarasi class
public class Film
{
    // private atribut
    private String idFilm;
    private String judul;
    private String genre;
    private int durasi;
    private String sutradara;

    // constructor
    public Film(String idFilm, String judul, String genre,
                int durasi, String sutradara)
    {
        this.idFilm = idFilm; // inisialisasi
        this.judul = judul; // inisialisasi
        this.genre = genre; // inisialisasi
        this.durasi = durasi; // inisialisasi
        this.sutradara = sutradara; // inisialisasi
    }

    // getter
    public String getIdFilm()
    {
        return idFilm; // mengambil value
    }

    public String getJudul()
    {
        return judul; // mengambil value
    }

    public String getGenre()
    {
        return genre; // mengambil value
    }

    public int getDurasi()
    {
        return durasi; // mengambil value
    }

    public String getSutradara()
    {
        return sutradara; // mengambil value
    }

    // prosedur untuk mengupdate data
    public void update(String judulBaru, String genreBaru,
                       int durasiBaru, String sutradaraBaru)
    {
        judul = judulBaru;
        genre = genreBaru;
        durasi = durasiBaru;
        sutradara = sutradaraBaru;
    }

    // prosedur untuk menampilkan data
    public void tampilkanData()
    {
        System.out.println("ID Film    : " + getIdFilm());
        System.out.println("Judul      : " + getJudul());
        System.out.println("Genre      : " + getGenre());
        System.out.println("Durasi     : " + getDurasi() + " menit");
        System.out.println("Sutradara  : " + getSutradara());
    }
}