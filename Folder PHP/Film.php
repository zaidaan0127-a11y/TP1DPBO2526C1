<?php

class Film
{
    private string $id_film;
    private string $judul;
    private string $genre;
    private int $durasi;
    private string $sutradara;
    private ?string $gambar;

    // Constructor
    public function __construct(
        string $id,
        string $judul,
        string $genre,
        int $durasi,
        string $sutradara,
        ?string $gambar = null
    ) {
        $this->id_film = $id;
        $this->judul = $judul;
        $this->genre = $genre;
        $this->durasi = $durasi;
        $this->sutradara = $sutradara;
        $this->gambar = $gambar;
    }

    // Getter
    public function getId(): string
    {
        return $this->id_film;
    }

    public function getJudul(): string
    {
        return $this->judul;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getDurasi(): int
    {
        return $this->durasi;
    }

    public function getSutradara(): string
    {
        return $this->sutradara;
    }

    public function getGambar(): ?string
    {
        return $this->gambar;
    }

    // Setter
    public function setId(string $id_film): void
    {
        $this->id_film = $id_film;
    }

    public function setJudul(string $judul): void
    {
        $this->judul = $judul;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public function setDurasi(int $durasi): void
    {
        if ($durasi >= 0) {
            $this->durasi = $durasi;
        }
    }

    public function setSutradara(string $sutradara): void
    {
        $this->sutradara = $sutradara;
    }

    public function setGambar(?string $gambar): void
    {
        $this->gambar = $gambar;
    }

    // Menampilkan data
    public function tampilkanData(): void
    {
        echo "ID Film: " . htmlspecialchars($this->id_film) . "<br>";
        echo "Judul: " . htmlspecialchars($this->judul) . "<br>";
        echo "Genre: " . htmlspecialchars($this->genre) . "<br>";
        echo "Durasi: " . $this->durasi . " menit<br>";
        echo "Sutradara: " . htmlspecialchars($this->sutradara) . "<br>";
        echo "Gambar: " . htmlspecialchars($this->gambar ?? "Tidak ada") . "<br>";
    }
}
?>