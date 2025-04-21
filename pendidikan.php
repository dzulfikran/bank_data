<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Riwayat Pendidikan'; 
    //variabel yang berfungsi mengatifkan sidebar
    $riwayat = 'riwayat';
    //variabel yang berfungsi mengatifkan sidebar
    $pendidikan = 'pendidikan';
    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';

    $id_pegawai = isset($_GET['id_pegawai']) ? $_GET['id_pegawai'] : '';
    // menghubungkan file header dengan file pendidikan
    require_once "_template/_header.php";
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php if (isset($id_pegawai) && !empty($id_pegawai)) : ?>
        <li class="breadcrumb-item">
            <a href="<?= base_url('pegawai') ?>">Data Pegawai</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <a href="<?= base_url('detail_pegawai') ?>?id=<?= $id_pegawai ?>">Detail Pegawai</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Data Pendidikan</li>
    <?php else : ?>
        <li class="breadcrumb-item active" aria-current="page">Data Pendidikan</li>
    <?php endif; ?>
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_pendidikan') ?>?add">
            <div class="form-group row">
                <label for="id_pegawai" class="col-sm-3 col-form-label">Pilih Pegawai</label>
                <div class="col-sm-9">
                <select class="form-control" name="id_pegawai" id="id_pegawai" required autocomplete="off" autofocus>
                    <?php
                        // Cek apakah $nip ada dan tidak kosong
                        if (!isset($id_pegawai) || empty($id_pegawai)) {
                            // Jika $nip kosong, ambil semua data pegawai
                            $data_pegawai = query("SELECT * FROM pegawai ORDER BY nama_pegawai ASC");
                        } else {
                            // Jika $nip ada, ambil pegawai berdasarkan NIP tertentu
                            $data_pegawai = query("SELECT * FROM pegawai WHERE id_pegawai = '" . mysqli_real_escape_string($koneksi, $id_pegawai) . "'");
                        }

                        foreach ($data_pegawai as $pegawai) : ?>
                            <option value="<?= $pegawai['id_pegawai'] ?>" <?= (isset($id_pegawai) && $pegawai['id_pegawai'] == $id_pegawai) ? 'selected' : '' ?>>
                                <?= $pegawai['nama_pegawai'] . ' - ' . $pegawai['nip'] ?>
                            </option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="tingkat" class="col-sm-3 col-form-label">Tingkat</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="tingkat" id="tingkat" placeholder="Tingkat" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="sekolah" class="col-sm-3 col-form-label">Nama Sekolah/Universitas</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="sekolah" id="sekolah" placeholder="Nama Sekolah/Universitas" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="lokasi" class="col-sm-3 col-form-label">Lokasi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Lokasi" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="jurusan" class="col-sm-3 col-form-label">Jurusan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="jurusan" id="jurusan" placeholder="Jurusan" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="tgl" class="col-sm-3 col-form-label">Tanggal Ijazah</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" name="tgl" placeholder="Tanggal Ijazah" required>
                </div>
            </div>   
            <div class="form-group row">
                <label for="no_ijazah" class="col-sm-3 col-form-label">No. Ijazah</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="no_ijazah" id="no_ijazah" placeholder="No Ijazah" required autocomplete="off">
                </div>
            </div>

        <!-- disini tanda tempat form -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-fw fa-save"></i> Simpan</button>
        <a href="<?= base_url('detail_pegawai') ?>?id=<?= $id_pegawai ?>" class="btn btn-warning"><i class="fas fa-fw fa-chevron-left"></i> Kembali</a>
    </div>
    </form>
</div>


<?php

    // menambahkan script khusus untuk halaman ini saja
    $addscript = '
        <script src="'.asset('_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'"></script>
        <script>
            $(".datepicker").datepicker()
        </script>
    ';
    // menghubungkan file footer dengan file pendidikan
    require_once "_template/_footer.php";
?>