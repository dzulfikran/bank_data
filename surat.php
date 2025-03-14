<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Data Surat'; 

    //variabel yang berfungsi mengatifkan sidebar
    $surat = 'surat';

    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/datatables/dataTables.bootstrap4.min.css';

    $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : ''; // Ambil parameter dari URL

    if ($jenis == 'masuk') {
        // Tampilkan data surat masuk
    } elseif ($jenis == 'keluar') {
        // Tampilkan data surat keluar
    } else {
        // Default (bisa menampilkan semua surat atau pesan error)
    }

    // menghubungkan file header dengan file Pegawai
    require_once "_template/_header.php";
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page">
        <?= isset($_GET['jenis']) && $_GET['jenis'] == 'masuk' ? 'Data Surat Masuk' : 'Data Surat Keluar' ?>
    </li>
    </ol>
</nav>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <?php if ($jenis == 'masuk') : ?>
            <a href="<?= base_url('tambah_surat') ?>?jenis=masuk" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-envelope"></i> Tambah Surat Masuk</a>
        <?php else : ?>
            <a href="<?= base_url('tambah_surat') ?>?jenis=keluar" class="btn btn-primary btn-sm float-right"><i class="fas fa-fw fa-envelope"></i> Tambah Surat Keluar</a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Surat</th>
                <th>Nomor Surat</th>
                <th>Deskripsi</th>
                <th>Dokumen</th>
                <th>Opsi</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $table = $jenis == 'masuk' ? 'surat_masuk' : 'surat_keluar';
                    $data_p = query("SELECT * FROM $table GROUP BY tanggal_surat ASC");

                    foreach ($data_p as $p) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $p['tanggal_surat'] ?></td>
                            <td><?= $p['nomor_surat'] ?></td>
                            <td><?= ucfirst($p['deskripsi']) ?></td>
                            <td>
                                <?php if (empty($p['dokumen'])) : ?>
                                    <!-- <a href="<?= base_url('_config/proses_surat') ?>?add_doc&id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-upload"></i> Upload Dokumen
                                    </a> -->
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="fas fa-upload"></i> Upload Dokumen
                                    </button>
                                    <small class="text-muted">Format yang diperbolehkan: PDF (Max: 3MB)</small>
                                <?php else : ?>
                                    <a href="<?= base_url('_config/proses_surat') ?>?open_doc&id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <a href="<?= base_url('_config/proses_surat') ?>?download_doc&id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                    <a href="<?= base_url('_config/proses_surat') ?>?delete_doc&id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('edit_surat') ?>?id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit </a>
                                <a href="<?= base_url('_config/proses_surat') ?>?delete&id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>"
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- Modal Upload Dokumen -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="<?= base_url('_config/proses_surat') ?>?add_doc&id=<?= $p['id_surat'] ?>&jenis=<?= $jenis ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="dokumen" class="form-label">Pilih Dokumen (PDF)</label>
                        <input type="file" name="dokumen" id="dokumen" class="form-control" accept=".pdf" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

    // menambahkan script khusus untuk halaman ini saja
    $addscript = '
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script src="'.asset('_assets/vendor/datatables/jquery.dataTables.min.js').'"></script>
        <script src="'.asset('_assets/vendor/datatables/dataTables.bootstrap4.min.js').'"></script>
    
        <script src="'.asset('_assets/js/demo/datatables-demo.js').'"></script>
    ';

    // menghubungkan file footer dengan file detail Pegawai
    require_once "_template/_footer.php";
?>