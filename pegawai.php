<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Data Pegawai'; 

    //variabel yang berfungsi mengatifkan sidebar
    $pegawai = 'pegawai';

    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/datatables/dataTables.bootstrap4.min.css';

    // menghubungkan file header dengan file Pegawai
    require_once "_template/_header.php";
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">Data Pegawai</li>
    </ol>
</nav>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php if (cek_role('admin')) : ?>
        <a href="<?= base_url('tambah_pegawai') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-user-plus"></i> Tambah Pegawai</a>
        <?php endif; ?>
        <a href="<?= base_url('_report/print_semua_data_pegawai') ?>" target="_blank" class="btn btn-info btn-sm float-right mr-3"><i class="fas fa-print"></i> Print Data Pegawai</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>No.</th>
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Status Kepegawaian</th>
                <th>Aktif/Nonaktif</th>
                <th>Opsi</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $id_pegawai_login = $_SESSION['id_pegawai'];
                    $no = 1;
                    // $data_p = query("SELECT * FROM pegawai GROUP BY nama_pegawai asc");
                    $data_p = query("SELECT * FROM pegawai 
                                    ORDER BY 
                                    CASE 
                                        WHEN id_pegawai = '$id_pegawai_login' THEN 0 
                                        ELSE 1 
                                    END, 
                                    nama_pegawai ASC");
                    foreach ($data_p as $p) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= ucwords($p['nama_pegawai']) ?></td>
                            <td><?= $p['nip'] ?></td>
                            <td><?= $p['email'] ?></td>
                            <td><?= $p['no_hp'] ?></td>
                            <td><?= strtoupper($p['status_kepegawaian']) ?></td>
                            <td><?= ucwords($p['status_user']) ?></td>
                            <td>
                                <a href="<?= base_url('detail_pegawai') ?>?id=<?= $p['id_pegawai'] ?>" class="btn btn-success btn-sm"><i class="fas fa-eye"></i> Detail</a>
                                <a href="<?= base_url('_report/print_data_pegawai') ?>?id=<?= $p['id_pegawai'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Print</a>
                                
                                <?php if (cek_role('admin') || ($id_pegawai_login == $p['id_pegawai'])) : ?>
                                <a href="<?= base_url('edit_pegawai') ?>?id=<?= $p['id_pegawai'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <?php if (cek_role('admin')) : ?>
                                    <a href="<?= base_url('_config/proses_pegawai') ?>?delete&id=<?= $p['id_pegawai'] ?>" 
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php

    // menambahkan script khusus untuk halaman ini saja
    $addscript = '
        <script src="'.asset('_assets/vendor/datatables/jquery.dataTables.min.js').'"></script>
        <script src="'.asset('_assets/vendor/datatables/dataTables.bootstrap4.min.js').'"></script>
    
        <script src="'.asset('_assets/js/demo/datatables-demo.js').'"></script>
    ';

    // menghubungkan file footer dengan file detail Pegawai
    require_once "_template/_footer.php";
?>