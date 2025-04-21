<?php
$data_pendidikan = query("SELECT * FROM pendidikan WHERE id_pegawai='$id_pegawai' ORDER BY tgl_ijazah");
$id_pegawai_login = $_SESSION['id_pegawai'];
?>
<div class="table-responsive mt-3">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Tingkat</th>
                <th>Nama Sekolah</th>
                <th>Lokasi</th>
                <th>Jurusan</th>
                <th>Tanggal Ijazah</th>
                <th>Nomor Ijazah</th>
                <?php if (cek_role('admin') || ($id_pegawai_login == $id_pegawai)) : ?>
                <th>Opsi</th>
                <?php endif ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data_pendidikan as $pendidikan) :
            ?>
                <tr>
                    <td><?= ucwords($pendidikan['tingkat']) ?></td>
                    <td><?= ucwords($pendidikan['nama_sekolah']) ?></td>
                    <td><?= ucwords($pendidikan['lokasi']) ?></td>
                    <td><?= ucwords($pendidikan['jurusan']) ?></td>
                    <td><?= date('Y-m-d',strtotime($pendidikan['tgl_ijazah'])) ?></td>
                    <td><?= ucwords($pendidikan['no_ijazah']) ?></td>
                    <?php if (cek_role('admin') || ($id_pegawai_login == $id_pegawai)) : ?>
                    <td>
                        <a href="<?= base_url('detail_pegawai/edit_pendidikan') ?>?id=<?= $pendidikan['id_pendidikan'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a href="<?= base_url('_config/proses_pendidikan') ?>?delete&id=<?= $pendidikan['id_pendidikan'] ?>&id_pegawai=<?= $pendidikan['id_pegawai']?>" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>