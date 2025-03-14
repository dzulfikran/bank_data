<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Jabatan Pegawai'; 
    //variabel yang berfungsi mengatifkan sidebar
    $riwayat = 'riwayat';
    //variabel yang berfungsi mengatifkan sidebar
    $jabatan = 'jabatan';

    $id_pegawai = isset($_GET['id_pegawai']) ? $_GET['id_pegawai'] : '';

    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';

    // menghubungkan file header dengan file jabatan
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
        <li class="breadcrumb-item active" aria-current="page">Data Jabatan</li>
    <?php else : ?>
        <li class="breadcrumb-item active" aria-current="page">Data Jabatan</li>
    <?php endif; ?>
    
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_jabatan') ?>?add">
            <div class="form-group row">
                <label for="nip" class="col-sm-3 col-form-label">Pilih Pegawai</label>
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
                <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="eselon" class="col-sm-3 col-form-label">Eselon</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="eselon" id="eselon" placeholder="Eselon" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="tmt" class="col-sm-3 col-form-label">TMT</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" name="tmt" placeholder="TMT" required>
                </div>
            </div>   
            <div class="form-group row">
                <label for="sampai_tgl" class="col-sm-3 col-form-label">Sampai Tanggal</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" name="sampai_tgl" placeholder="Tanggal Ijazah" required>
                </div>
            </div>   

        <!-- disini tanda tempat form -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-fw fa-save"></i> Simpan</button>
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
    // menghubungkan file footer dengan file jabatan
    require_once "_template/_footer.php";
?>