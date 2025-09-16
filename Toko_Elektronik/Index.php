<?php
// NOTE: require Produk.php BEFORE session_start() to avoid "incomplete object" error
require_once __DIR__ . '/Produk.php';
session_start();

// inisialisasi container produk di session (associative by id)
if (!isset($_SESSION['daftarProduk']) || !is_array($_SESSION['daftarProduk'])) {
    $_SESSION['daftarProduk'] = []; // key = product id, value = Produk object
}

// helper upload: mengembalikan path relatif (uploads/...) atau empty string
function uploadImageFile($file) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) return "";
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $base = pathinfo($file['name'], PATHINFO_FILENAME);
    $safe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base);
    $newName = $safe . '_' . time() . '.' . $ext;
    $targetFull = $uploadDir . $newName;
    if (move_uploaded_file($file['tmp_name'], $targetFull)) {
        return 'uploads/' . $newName; // path relatif yang bisa ditaruh ke <img src="">
    }
    return "";
}

// Hapus file gambar kalau ada
function deleteImageFile($path) {
    if (!$path) return;
    $full = __DIR__ . '/' . $path;
    if (file_exists($full) && is_file($full)) {
        @unlink($full);
    }
}

// PROSES FORM POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tambah Data
    if (isset($_POST['tambah'])) {
        $id = trim($_POST['id']);
        $nama = trim($_POST['nama']);
        $merek = trim($_POST['merek']);
        $kategori = trim($_POST['kategori']);
        $harga = (int)$_POST['harga'];
        $stok = (int)$_POST['stok'];

        if ($id === '') {
            $_SESSION['flash'] = "ID wajib diisi.";
            header('Location: index.php'); exit;
        }

        // upload gambar (wajib)
        $gambarPath = uploadImageFile($_FILES['gambar']);
        if ($gambarPath === "") {
            $_SESSION['flash'] = "Gagal upload gambar atau gambar belum dipilih.";
            header('Location: index.php'); exit;
        }

        // jika ID sudah ada -> sesuai versi C++: tambahkan stok
        if (isset($_SESSION['daftarProduk'][$id])) {
            $existing = $_SESSION['daftarProduk'][$id];
            $existing->setStok($existing->getStok() + $stok);
            $_SESSION['flash'] = "Produk sudah ada. Stok ditambahkan.";
            // optionally, kita tidak menimpa gambar lama agar tidak kehilangan referensi
            // hapus gambar baru karena tidak dipakai
            deleteImageFile($gambarPath);
        } else {
            // simpan produk baru
            $produkBaru = new Produk($id, $nama, $merek, $kategori, $harga, $stok, $gambarPath);
            $_SESSION['daftarProduk'][$id] = $produkBaru;
            $_SESSION['flash'] = "Produk berhasil ditambahkan.";
        }

        header('Location: index.php'); exit;
    }

    // Update Data
    if (isset($_POST['update'])) {
        $origId = trim($_POST['orig_id']); // ID tidak boleh diubah (identifier)
        if ($origId === '' || !isset($_SESSION['daftarProduk'][$origId])) {
            $_SESSION['flash'] = "Produk untuk diupdate tidak ditemukan.";
            header('Location: index.php'); exit;
        }

        $nama = trim($_POST['nama']);
        $merek = trim($_POST['merek']);
        $kategori = trim($_POST['kategori']);
        $harga = (int)$_POST['harga'];
        $stok = (int)$_POST['stok'];

        $produk = $_SESSION['daftarProduk'][$origId];

        // jika ada upload gambar baru, ganti (hapus gambar lama)
        $newImage = uploadImageFile($_FILES['gambar']);
        if ($newImage !== "") {
            // hapus gambar lama
            deleteImageFile($produk->getGambar());
            $produk->setGambar($newImage);
        }

        $produk->setNama($nama);
        $produk->setMerek($merek);
        $produk->setKategori($kategori);
        $produk->setHarga($harga);
        $produk->setStok($stok);

        $_SESSION['daftarProduk'][$origId] = $produk;
        $_SESSION['flash'] = "Produk berhasil diupdate.";
        header('Location: index.php'); exit;
    }

    // Cari Data (POST lalu redirect supaya tidak re-post)
    if (isset($_POST['cari'])) {
        $searchId = trim($_POST['search_id']);
        if ($searchId === '') {
            $_SESSION['flash'] = "Masukkan ID untuk mencari.";
            header('Location: index.php'); exit;
        } else {
            header('Location: index.php?search=' . urlencode($searchId));
            exit;
        }
    }

    // Clear all (opsional) - bersihkan session produk
    if (isset($_POST['clear_all'])) {
        // hapus file gambar juga
        foreach ($_SESSION['daftarProduk'] as $p) {
            deleteImageFile($p->getGambar());
        }
        $_SESSION['daftarProduk'] = [];
        $_SESSION['flash'] = "Semua produk dihapus dari session.";
        header('Location: index.php'); exit;
    }
}

// PROSES GET: delete atau edit / show
if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    if (isset($_SESSION['daftarProduk'][$deleteId])) {
        // hapus gambar lokal
        $p = $_SESSION['daftarProduk'][$deleteId];
        deleteImageFile($p->getGambar());
        unset($_SESSION['daftarProduk'][$deleteId]);
        $_SESSION['flash'] = "Produk dengan ID {$deleteId} dihapus.";
    } else {
        $_SESSION['flash'] = "Produk tidak ditemukan.";
    }
    header('Location: index.php'); exit;
}

// Jika ada param search di GET, kita tampilkan produk tersebut saja
$displayList = $_SESSION['daftarProduk'];
if (isset($_GET['search'])) {
    $sid = $_GET['search'];
    if ($sid !== '' && isset($_SESSION['daftarProduk'][$sid])) {
        $displayList = [ $_SESSION['daftarProduk'][$sid] ];
    } else {
        $displayList = []; // tidak ditemukan
        $_SESSION['flash'] = "Produk dengan ID '{$sid}' tidak ditemukan.";
    }
}

// Jika edit (GET edit=id) -> ambil product untuk ditampilkan di form update
$editProduct = null;
if (isset($_GET['edit'])) {
    $eid = $_GET['edit'];
    if (isset($_SESSION['daftarProduk'][$eid])) {
        $editProduct = $_SESSION['daftarProduk'][$eid];
    } else {
        $_SESSION['flash'] = "Produk untuk diedit tidak ditemukan.";
        header('Location: index.php'); exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Toko Elektronik - CRUD (session)</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1100px; margin: 20px auto; }
        form.block { border: 1px solid #ccc; padding: 12px; margin-bottom: 16px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background: #eee; }
        img.thumb { width: 80px; height: auto; object-fit: contain; }
        .flash { background: #f0f8ff; border: 1px solid #99c; padding: 8px; margin-bottom: 12px; }
        .actions a { margin: 0 6px; }
    </style>
</head>
<body>
    <h1>Toko Elektronik (Session)</h1>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- FORM CARI -->
    <form class="block" method="post">
        <strong>Cari Produk (by ID):</strong>
        <input type="text" name="search_id" placeholder="Masukkan ID" />
        <button type="submit" name="cari">Cari</button>
        <button type="submit" name="clear_all" onclick="return confirm('Clear semua produk di session? Ini akan menghapus semua produk termasuk file gambar yang diupload.')">Hapus Semua</button>
        <a href="index.php" style="margin-left:12px;">Tampilkan Semua</a>
    </form>

    <!-- FORM TAMBAH / UPDATE -->
    <?php if ($editProduct !== null): ?>
        <form class="block" method="post" enctype="multipart/form-data">
            <h3>Update Produk (ID: <?= htmlspecialchars($editProduct->getId()) ?>)</h3>
            <input type="hidden" name="orig_id" value="<?= htmlspecialchars($editProduct->getId()) ?>">
            <label>Nama</label><br>
            <input type="text" name="nama" required value="<?= htmlspecialchars($editProduct->getNama()) ?>"><br>
            <label>Merek</label><br>
            <input type="text" name="merek" required value="<?= htmlspecialchars($editProduct->getMerek()) ?>"><br>
            <label>Kategori</label><br>
            <input type="text" name="kategori" required value="<?= htmlspecialchars($editProduct->getKategori()) ?>"><br>
            <label>Harga</label><br>
            <input type="number" name="harga" required value="<?= htmlspecialchars($editProduct->getHarga()) ?>"><br>
            <label>Stok</label><br>
            <input type="number" name="stok" required value="<?= htmlspecialchars($editProduct->getStok()) ?>"><br>
            <label>Gambar (upload baru untuk mengganti):</label><br>
            <input type="file" name="gambar" accept="image/*"><br>
            <?php if ($editProduct->getGambar()): ?>
                <small>Preview saat ini:</small><br>
                <img src="<?= htmlspecialchars($editProduct->getGambar()) ?>" class="thumb"><br>
            <?php endif; ?>
            <br>
            <button type="submit" name="update">Simpan Perubahan</button>
            <a href="index.php" style="margin-left:8px;">Batal</a>
        </form>
    <?php else: ?>
        <form class="block" method="post" enctype="multipart/form-data">
            <h3>Tambah Produk Baru</h3>
            <label>ID (unik)</label><br>
            <input type="text" name="id" required><br>
            <label>Nama</label><br>
            <input type="text" name="nama" required><br>
            <label>Merek</label><br>
            <input type="text" name="merek" required><br>
            <label>Kategori</label><br>
            <input type="text" name="kategori" required><br>
            <label>Harga</label><br>
            <input type="number" name="harga" required><br>
            <label>Stok</label><br>
            <input type="number" name="stok" required><br>
            <label>Gambar (file lokal akan di-upload ke folder uploads/)</label><br>
            <input type="file" name="gambar" accept="image/*" required><br><br>
            <button type="submit" name="tambah">Tambah</button>
        </form>
    <?php endif; ?>

    <!-- TABEL HASIL -->
    <h3>Daftar Produk</h3>
    <table>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Nama</th>
            <th>Merek</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
        <?php
        if (empty($displayList)) {
            echo "<tr><td colspan='9'>Belum ada produk</td></tr>";
        } else {
            $no = 1;
            // $displayList may be associative (key = id) or indexed; handle both
            foreach ($displayList as $key => $p) {
                // if stored associative, $p is object; if displayList came from session keyed by id it still works
                if (!($p instanceof Produk)) continue;
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($p->getId()) . "</td>";
                echo "<td>" . htmlspecialchars($p->getNama()) . "</td>";
                echo "<td>" . htmlspecialchars($p->getMerek()) . "</td>";
                echo "<td>" . htmlspecialchars($p->getKategori()) . "</td>";
                echo "<td>" . htmlspecialchars($p->getHarga()) . "</td>";
                echo "<td>" . htmlspecialchars($p->getStok()) . "</td>";
                $img = $p->getGambar();
                echo "<td>";
                if ($img) echo "<img src='" . htmlspecialchars($img) . "' class='thumb'>";
                else echo "-";
                echo "</td>";
                // aksi: edit (by id) dan delete (by id)
                $idEnc = urlencode($p->getId());
                echo "<td class='actions'>
                        <a href='index.php?edit={$idEnc}'>Edit</a> |
                        <a href='index.php?delete={$idEnc}' onclick=\"return confirm('Hapus produk ini?')\">Hapus</a>
                      </td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <p style="margin-top:14px;color:#666;"><small>Catatan: Data disimpan di session. Restart browser atau clear session akan menghapus data.</small></p>
</body>
</html>
