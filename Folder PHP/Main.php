<?php

require_once 'Film.php';
session_start();

if (isset($_POST['reset_data'])) {
    unset($_SESSION['daftarFilm']);
    header("Location: Main.php");
    exit;
}

$_SESSION['daftarFilm'] ??= [];
$message = $message_type = "";

// Cek ID
function isIdExists($id, $list, $except = null) {
    foreach ($list as $film) {
        if ($film->getId() == $id && $film->getId() != $except)
            return true;
    }
    return false;
}

// Upload gambar (opsional)
function uploadGambar() {
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0)
        return null;

    if (!is_dir('images'))
        mkdir('images', 0777, true);

    $nama = time() . '_' . basename($_FILES['gambar']['name']);
    $nama = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nama);
    $target = "images/$nama";

    return move_uploaded_file($_FILES['gambar']['tmp_name'], $target)
        ? $target : null;
}

// Tambah film
if (isset($_POST['tambah'])) {

    $id = trim($_POST['id_film']);
    $judul = trim($_POST['judul']);
    $genre = trim($_POST['genre']);
    $durasi = trim($_POST['durasi']);
    $sutradara = trim($_POST['sutradara']);

    if (!$id || !$judul || !$genre || !$durasi || !$sutradara) {
        $message = "Semua data film harus diisi.";
        $message_type = "error";

    } elseif (!is_numeric($durasi) || $durasi < 0) {
        $message = "Durasi harus berupa angka.";
        $message_type = "error";

    } elseif (isIdExists($id, $_SESSION['daftarFilm'])) {
        $message = "ID film sudah digunakan.";
        $message_type = "error";

    } else {
        $film = new Film(
            $id,
            $judul,
            $genre,
            (int)$durasi,
            $sutradara,
            uploadGambar()
        );

        $_SESSION['daftarFilm'][] = $film;
        $message = "Film berhasil ditambahkan.";
        $message_type = "success";
    }
}

// Hapus film
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id = $_GET['id'];
    $sebelum = count($_SESSION['daftarFilm']);

    $_SESSION['daftarFilm'] = array_values(array_filter(
        $_SESSION['daftarFilm'],
        fn($film) => $film->getId() != $id
    ));

    $message = count($_SESSION['daftarFilm']) < $sebelum
        ? "Film berhasil dihapus."
        : "Film tidak ditemukan.";

    $message_type = count($_SESSION['daftarFilm']) < $sebelum
        ? "success" : "error";
}

// Cari film berdasarkan ID
function getFilmById($id) {
    foreach ($_SESSION['daftarFilm'] as $film) {
        if ($film->getId() == $id)
            return $film;
    }
    return null;
}

// Update film
if (isset($_POST['update'])) {

    $lama = $_POST['id_film_lama'];
    $film = getFilmById($lama);

    if (!$film) {
        $message = "Film tidak ditemukan.";
        $message_type = "error";

    } else {
        $id = trim($_POST['id_film']);
        $judul = trim($_POST['judul']);
        $genre = trim($_POST['genre']);
        $durasi = trim($_POST['durasi']);
        $sutradara = trim($_POST['sutradara']);

        if (!$id || !$judul || !$genre || !$durasi || !$sutradara) {
            $message = "Semua data film harus diisi.";
            $message_type = "error";

        } elseif (!is_numeric($durasi) || $durasi < 0) {
            $message = "Durasi harus berupa angka.";
            $message_type = "error";

        } elseif (isIdExists($id, $_SESSION['daftarFilm'], $lama)) {
            $message = "ID film sudah digunakan.";
            $message_type = "error";

        } else {
            $film->setId($id);
            $film->setJudul($judul);
            $film->setGenre($genre);
            $film->setDurasi((int)$durasi);
            $film->setSutradara($sutradara);

            $gambar = uploadGambar();
            if ($gambar)
                $film->setGambar($gambar);

            $message = "Data film berhasil diperbarui.";
            $message_type = "success";
        }
    }
}

// Pencarian
$hasilPencarian = $_SESSION['daftarFilm'];

if (!empty($_GET['cari_id'])) {
    $cari = trim($_GET['cari_id']);

    $hasilPencarian = array_filter(
        $_SESSION['daftarFilm'],
        fn($film) => stripos($film->getId(), $cari) !== false
    );
}

// Data edit
$edit_id = $edit_judul = $edit_genre = "";
$edit_durasi = $edit_sutradara = $edit_gambar = "";

if (isset($_GET['edit'])) {
    $film = getFilmById($_GET['edit']);

    if ($film) {
        $edit_id = $film->getId();
        $edit_judul = $film->getJudul();
        $edit_genre = $film->getGenre();
        $edit_durasi = $film->getDurasi();
        $edit_sutradara = $film->getSutradara();
        $edit_gambar = $film->getGambar();
    }
}

$isEdit = !empty($edit_id);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Film Library</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background: #111;
    color: white;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
    padding: 30px 0;
}

.header p,
.section-header span,
.film-id,
.film-detail span:first-child {
    color: #aaa;
}

.top-bar,
.form-actions,
.card-actions {
    display: flex;
    gap: 10px;
}

.top-bar {
    margin-bottom: 20px;
}

.search-box {
    display: flex;
    flex: 1;
}

input {
    padding: 10px;
    background: #222;
    color: white;
    border: 1px solid #444;
    border-radius: 5px;
}

.search-box input {
    flex: 1;
}

button,
.btn,
.action-btn,
.reset-btn {
    padding: 10px 15px;
    border: 0;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.search-box button,
.btn-primary {
    background: #e50914;
    color: white;
}

.reset-btn,
.btn-secondary,
.edit-btn {
    background: #333;
    color: white;
}

.message {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.message.success {
    background: #153d20;
}

.message.error {
    background: #4a1717;
}

.main-content {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 20px;
}

.form-panel,
.film-card {
    background: #1b1b1b;
    border: 1px solid #333;
    border-radius: 8px;
}

.form-panel {
    padding: 20px;
}

.form-panel h2 {
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #bbb;
}

.form-group input {
    width: 100%;
}

.section-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.film-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.film-card {
    overflow: hidden;
}

.poster {
    height: 250px;
    background: #222;
    text-align: center;
}

.poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    padding-top: 110px;
    color: #777;
}

.film-info {
    padding: 15px;
}

.film-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 8px;
}

.film-id {
    font-size: 12px;
    margin-bottom: 12px;
}

.film-detail {
    display: flex;
    justify-content: space-between;
    margin-bottom: 7px;
}

.card-actions {
    margin-top: 15px;
}

.action-btn {
    flex: 1;
    text-align: center;
}

.delete-btn {
    background: #6b1515;
    color: white;
}

.empty {
    text-align: center;
    padding: 50px;
    color: #777;
}

@media (max-width: 800px) {
    .main-content {
        grid-template-columns: 1fr;
    }

    .film-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 500px) {
    .top-bar {
        flex-direction: column;
    }

    .film-grid {
        grid-template-columns: 1fr;
    }
}
</style>

</head>

<body>
<div class="container">

    <div class="header">
        <h1>Film Library</h1>
        <p>Kelola koleksi film dengan mudah.</p>
    </div>

    <div class="top-bar">
        <form method="GET" class="search-box">
            <input type="text" name="cari_id"
                placeholder="Cari berdasarkan ID film..."
                value="<?= htmlspecialchars($_GET['cari_id'] ?? '') ?>">
            <button>Cari</button>
        </form>

        <form method="POST">
            <button name="reset_data" class="reset-btn"
                onclick="return confirm('Hapus semua data film?')">Reset Data</button>
        </form>
    </div>

    <?php if ($message): ?>
        <div class="message <?= $message_type ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <div class="main-content">

        <!-- Form Film -->
        <div class="form-panel">
            <h2><?= $isEdit ? 'Edit Film' : 'Tambah Film' ?></h2>

            <form method="POST" enctype="multipart/form-data">
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id_film_lama"
                        value="<?= htmlspecialchars($edit_id) ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>ID Film</label>
                    <input type="text" name="id_film"
                        value="<?= htmlspecialchars($edit_id) ?>"
                        placeholder="Contoh: F001" required>
                </div>

                <div class="form-group">
                    <label>Judul Film</label>
                    <input type="text" name="judul"
                        value="<?= htmlspecialchars($edit_judul) ?>"
                        placeholder="Judul film" required>
                </div>

                <div class="form-group">
                    <label>Genre</label>
                    <input type="text" name="genre"
                        value="<?= htmlspecialchars($edit_genre) ?>"
                        placeholder="Contoh: Action" required>
                </div>

                <div class="form-group">
                    <label>Durasi</label>
                    <input type="number" name="durasi"
                        value="<?= htmlspecialchars($edit_durasi) ?>"
                        placeholder="Dalam menit" min="0" required>
                </div>

                <div class="form-group">
                    <label>Sutradara</label>
                    <input type="text" name="sutradara"
                        value="<?= htmlspecialchars($edit_sutradara) ?>"
                        placeholder="Nama sutradara" required>
                </div>

                <div class="form-group">
                    <label><?= $isEdit ? 'Ganti Poster' : 'Poster Film' ?></label>
                    <input type="file" name="gambar" accept="image/*">
                </div>

                <div class="form-actions">
                    <?php if ($isEdit): ?>
                        <button name="update" class="btn btn-primary">
                            Update Film
                        </button>
                        <a href="Main.php" class="btn btn-secondary">Batal</a>
                    <?php else: ?>
                        <button name="tambah" class="btn btn-primary">
                            Tambah Film
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Daftar Film -->
        <div class="film-section">
            <div class="section-header">
                <h2>Daftar Film</h2>
                <span><?= count($hasilPencarian) ?> film</span>
            </div>

            <div class="film-grid">
                <?php if ($hasilPencarian): ?>

                    <?php foreach ($hasilPencarian as $film): ?>
                        <div class="film-card">

                            <div class="poster">
                                <?php if ($film->getGambar() && file_exists($film->getGambar())): ?>
                                    <img src="<?= htmlspecialchars($film->getGambar()) ?>"
                                         alt="<?= htmlspecialchars($film->getJudul()) ?>">
                                <?php else: ?>
                                    <div class="no-image">Tidak ada poster</div>
                                <?php endif; ?>
                            </div>

                            <div class="film-info">
                                <div class="film-title">
                                    <?= htmlspecialchars($film->getJudul()) ?>
                                </div>

                                <div class="film-id">
                                    ID: <?= htmlspecialchars($film->getId()) ?>
                                </div>

                                <div class="film-detail">
                                    <span>Genre</span>
                                    <span><?= htmlspecialchars($film->getGenre()) ?></span>
                                </div>

                                <div class="film-detail">
                                    <span>Durasi</span>
                                    <span><?= htmlspecialchars($film->getDurasi()) ?> menit</span>
                                </div>

                                <div class="film-detail">
                                    <span>Sutradara</span>
                                    <span><?= htmlspecialchars($film->getSutradara()) ?></span>
                                </div>

                                <div class="card-actions">
                                    <a href="Main.php?edit=<?= urlencode($film->getId()) ?>"
                                       class="action-btn edit-btn">Edit</a>

                                    <a href="Main.php?action=hapus&id=<?= urlencode($film->getId()) ?>"
                                       class="action-btn delete-btn"
                                       onclick="return confirm('Hapus film ini?')">Hapus</a>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <div class="empty">
                        <h3>Belum ada film</h3>
                        <p>Tambahkan film menggunakan form.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
</body>
</html>

