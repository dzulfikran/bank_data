<?php
    // Variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Edit Data Surat';
    // Variabel yang berfungsi mengaktifkan sidebar
    $surat = 'surat';
    // Menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';

    // Menghubungkan file header dengan file edit_pegawai
    require_once "_template/_header.php";

    // Simpan data ID (id_surat) yang dikirim dari halaman sebelumnya ke dalam variabel
    $id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $jenis = isset($_GET['jenis']) ? htmlspecialchars($_GET['jenis']) : '';

    // Pastikan ID surat valid
    if ($id_surat <= 0 || empty($jenis)) {
        echo '<script>alert("ID atau Jenis Surat tidak valid!"); window.history.back();</script>';
        exit();
    }

    // Ambil data surat berdasarkan id_surat
    $query = "SELECT tanggal_surat, nomor_surat, deskripsi, dokumen 
              FROM " . ($jenis == "masuk" ? "surat_masuk" : "surat_keluar") . " 
              WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url('surat') ?>?jenis=<?= $jenis ?>">
            <?= isset($_GET['jenis']) && $_GET['jenis'] == 'masuk' ? 'Data Surat Masuk' : 'Data Surat Keluar' ?>
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_surat') ?>?edit" enctype="multipart/form-data">
            <input type="hidden" name="id_surat" value="<?= $id_surat ?>">
            <input type="hidden" name="jenis" value="<?= $jenis ?>">

            <div class="form-group row">
                <label for="tgl_srt" class="col-sm-3 col-form-label">Tanggal Surat</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" name="tgl_surat" id="tgl_surat" 
                        value="<?= htmlspecialchars($data['tanggal_surat'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nmr_surat" class="col-sm-3 col-form-label">Nomor Surat</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nmr_surat" id="nmr_surat" 
                        value="<?= htmlspecialchars($data['nomor_surat'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Surat</label>
                <div class="col-sm-9">
                    <textarea name="deskripsi" class="form-control" id="deskripsi" cols="10" rows="5" required><?= htmlspecialchars($data['deskripsi'] ?? '') ?></textarea>
                </div>
            </div>    
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right">
            <i class="fas fa-fw fa-save"></i> Simpan
        </button>
        <a href="<?= base_url('surat') ?>?jenis=<?= $jenis ?>" class="btn btn-warning">
            <i class="fas fa-fw fa-chevron-left"></i> Kembali
        </a>
    </div>
    </form>
</div>


<?php

    $addscript = '
        <script src="'.asset('_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'"></script>
        <script>
            $(".datepicker").datepicker()

            
        $(document).on("change", ".custom-file-input", function (event) {
            $(this).next(".custom-file-label").html(event.target.files[0].name);
            })    
        </script>
    ';

    // menghubungkan file footer dengan file edit_pegawai
    require_once "_template/_footer.php";
?>