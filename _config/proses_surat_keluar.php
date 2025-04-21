<?php

require_once "config.php";

if (isset($_GET['add'])) {
    $tgl_surat = strip_tags($_POST['tgl_surat']);
    $nmr_surat = strip_tags($_POST['nmr_surat']);
    $alamat = strip_tags($_POST['alamat']);
    $perihal = strip_tags($_POST['perihal']);

    $query = "INSERT INTO surat_keluar (tanggal_surat, nomor_surat, alamat_tujaun, perihal)
                  VALUES ('$tgl_surat', '$nmr_surat', '$alamat', '$perihal')";

    if (mysqli_query($koneksi, $query)) {
        echo '<script>
                alert("Data Berhasil Ditambah");
                window.location = "' . base_url('surat/surat_keluar') . '";
              </script>';
    } else {
        echo '<script>
                alert("Gagal Menyimpan Data");
                window.location = "' . base_url('surat/surat_keluar') . '";
              </script>';
    }
}

elseif (isset($_GET['add_doc'])) {
    $id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0; 
    
    // Validasi ID Surat
    if ($id_surat <= 0 ) {
        echo '<script>alert("ID Surat tidak valid"); window.history.back();</script>';
        exit();
    }

    // Periksa apakah file diunggah
    if (!isset($_FILES['dokumen']) || $_FILES['dokumen']['error'] !== UPLOAD_ERR_OK) {
        echo '<script>alert("Gagal mengunggah dokumen!"); window.history.back();</script>';
        exit();
    }

    // Tentukan direktori penyimpanan
    $targetDir = "../_docs/keluar/";

    // Ambil informasi surat dari database
    $query = "SELECT nomor_surat, tanggal_surat FROM surat_keluar WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dataSurat = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$dataSurat) {
        echo '<script>alert("Surat tidak ditemukan!"); window.history.back();</script>';
        exit();
    }

    // Ambil Nomor Surat dan Tanggal
    $nomor_surat = $dataSurat['nomor_surat'];
    $tanggal_surat = date('Y-m-d', strtotime($dataSurat['tanggal_surat']));

    // Bersihkan Nomor Surat (Hanya huruf, angka, dan "-")
    $nomor_surat_clean = preg_replace('/[^A-Za-z0-9\-]/', '', $nomor_surat);

    // Buat nama file baru dengan format "YYYY-MM-DD-NMR-SRTXX.pdf"
    $namaFileBaru = "{$tanggal_surat}-{$nomor_surat_clean}.pdf";
    $targetFile = $targetDir . $namaFileBaru;

    // Periksa ekstensi file
    $ekstensi = strtolower(pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION));
    if ($ekstensi !== "pdf") {
        echo '<script>alert("Format file tidak didukung (Hanya PDF)"); window.history.back();</script>';
        exit();
    }

    // Periksa ukuran file (Max: 1MB)
    if ($_FILES['dokumen']['size'] > 3145728) {
        echo '<script>alert("Ukuran file terlalu besar (Max: 3MB)"); window.history.back();</script>';
        exit();
    }

    // Pindahkan file yang diunggah ke direktori penyimpanan
    if (!move_uploaded_file($_FILES['dokumen']['tmp_name'], $targetFile)) {
        echo '<script>alert("Gagal menyimpan file!"); window.history.back();</script>';
        exit();
    }

    // Update nama file di database
    $updateQuery = "UPDATE surat_keluar SET dokumen = ? WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $updateQuery);
    mysqli_stmt_bind_param($stmt, "si", $namaFileBaru, $id_surat);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        echo '<script>
                alert("Dokumen berhasil diunggah");
                window.location = "' . base_url('surat/surat_keluar') . '";
              </script>';
    } else {
        echo '<script>
                alert("Gagal menyimpan data ke database");
                window.history.back();
              </script>';
    }
}

elseif (isset($_GET['open_doc'])) {
    $id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id_surat <= 0) {
        echo '<script>alert("ID Surat tidak valid!"); window.history.back();</script>';
        exit();
    }

    // Ambil nama file dokumen dari database
    $query = "SELECT dokumen FROM surat_keluar WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dataSurat = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$dataSurat || empty($dataSurat['dokumen'])) {
        echo '<script>alert("Dokumen tidak ditemukan!"); window.history.back();</script>';
        exit();
    }

    // Buat path file berdasarkan jenis surat
    $filePath = realpath("../_docs/keluar/" . $dataSurat['dokumen']);

    // Periksa apakah file benar-benar ada di dalam folder yang diizinkan
    if (!$filePath || !file_exists($filePath)) {
        echo '<script>alert("Dokumen tidak ditemukan di server!"); window.history.back();</script>';
        exit();
    }

    // Redirect untuk membuka dokumen dalam tab baru
    // header("Location: " . base_url("_docs/keluar/" . $dataSurat['dokumen']));
    $fileUrl = rtrim(base_url("_docs/keluar/" . $dataSurat['dokumen']), ".php");
    header("Location: " . $fileUrl);
    exit();
}

elseif (isset($_GET['download_doc'])) {
    $id_surat = intval($_GET['id']);

    if ($id_surat <= 0) {
        echo '<script>alert("ID Surat tidak valid!"); window.history.back();</script>';
        exit();
    }

    // Ambil nama file dokumen dari database
    $query = "SELECT dokumen FROM surat_keluar WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dataSurat = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$dataSurat || empty($dataSurat['dokumen'])) {
        echo '<script>alert("Dokumen tidak ditemukan!"); window.history.back();</script>';
        exit();
    }

    // Path file
    $filePath = realpath("../_docs/keluar/" . $dataSurat['dokumen']);

    // Cek apakah file ada dan dalam folder yang benar
    if (!$filePath || !file_exists($filePath)) {
        echo '<script>alert("Dokumen tidak ditemukan di server!"); window.history.back();</script>';
        exit();
    }

    // Set header untuk download file
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: " . filesize($filePath));

    // Baca file dan kirim ke output
    readfile($filePath);
    exit();
}

elseif (isset($_GET['delete_doc'])) {
    $id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id_surat <= 0) {
        echo '<script>alert("ID Surat tidak valid!"); window.history.back();</script>';
        exit();
    }

    // Ambil nama file dokumen dari database
    $query = "SELECT dokumen FROM surat_keluar WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $dataSurat = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$dataSurat || empty($dataSurat['dokumen'])) {
        echo '<script>alert("Dokumen tidak ditemukan!"); window.history.back();</script>';
        exit();
    }

    // Buat path file berdasarkan jenis surat
    $filePath = realpath("../_docs/keluar/" . $dataSurat['dokumen']);

    // Hapus file dari server jika ada
    if ($filePath && file_exists($filePath)) {
        unlink($filePath);
    }

    // Hapus nama dokumen dari database
    $deleteQuery = "UPDATE surat_keluar SET dokumen = NULL WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        echo '<script>
                alert("Dokumen berhasil dihapus!");
                window.location = "' . base_url('surat/surat_keluar') . '";
              </script>';
    } else {
        echo '<script>
                alert("Gagal menghapus dokumen dari database!");
                window.history.back();
              </script>';
    }
}

elseif (isset($_GET['edit'])) {
    $id_surat = intval($_POST['id_surat']);  // Pastikan ID dalam bentuk angka
    $tgl_surat = strip_tags($_POST['tgl_surat']);
    $nmr_surat = strip_tags($_POST['nmr_surat']);
    $alamat = strip_tags($_POST['alamat']);
    $perihal = strip_tags($_POST['perihal']);

    // Cek apakah semua data terisi
    if (empty($id_surat) || empty($tgl_surat) || empty($nmr_surat) || empty($perihal)) {
        echo '<script>alert("Semua data harus diisi!"); window.history.back();</script>';
        exit();
    }

    // Query update
    $query = "UPDATE surat_keluar SET 
                tanggal_surat = ?, 
                nomor_surat = ?, 
                alamat_tujuan = ?, 
                perihal = ? 
              WHERE id_surat = ?";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $tgl_surat, $nmr_surat, $alamat, $perihal, $id_surat);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($success) {
        echo '<script>
                alert("Data Berhasil Diperbarui");
                window.location = "' . base_url('surat/surat_keluar') . '";
              </script>';
    } else {
        echo '<script>
                alert("Data Gagal Diperbarui");
                window.history.back();
              </script>';
    }
}


elseif (isset($_GET['delete'])) {
    $id_surat = intval($_GET['id']);  // Pastikan ID dalam bentuk angka

    // Ambil dokumen sebelum menghapus data
    $query = "SELECT dokumen FROM surat_keluar WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$data) {
        echo '<script>alert("Data tidak ditemukan!"); window.history.back();</script>';
        exit();
    }

    $dokumen = $data['dokumen'];
    $filePath = "../_docs/keluar/$dokumen";

    // Hapus data dari database
    $deleteQuery = "DELETE FROM surat_keluar WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    $deleteSuccess = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($deleteSuccess) {
        // Hapus file jika ada
        if (!empty($dokumen) && file_exists($filePath)) {
            unlink($filePath);
        }

        echo '<script>
                alert("Data Berhasil Dihapus");
                window.location = "' . base_url('surat/surat_keluar') . '";
              </script>';
    } else {
        echo '<script>
                alert("Data Gagal Dihapus");
                window.history.back();
              </script>';
    }
}

?>
