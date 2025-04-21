<?php
    include "../_config/config.php";
    require_once "../_assets/vendor/vendor/autoload.php";

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    $id_pegawai = $_GET['id'];
    $pegawai = query("SELECT * FROM pegawai WHERE id_pegawai='$id_pegawai'");

    // Ambil logo kop surat (ubah path sesuai dengan lokasi file Anda)
    $logo_path = "../_assets/img/logo_buton.png";
    if (file_exists($logo_path)) {
        $logo_data = file_get_contents($logo_path);
        $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_data);
    } else {
        $logo_base64 = "";
    }

    // Ambil foto pegawai atau gunakan default jika tidak ada
    $foto_path = "../_assets/img/profile/".$pegawai[0]['foto_pegawai'];
    if (file_exists($foto_path) && !empty($pegawai[0]['foto_pegawai'])) {
        $foto_data = file_get_contents($foto_path);
        $foto_base64 = 'data:image/png;base64,' . base64_encode($foto_data);
    } else {
        $foto_default = "../_assets/img/default.jpg";
        $foto_data = file_get_contents($foto_default);
        $foto_base64 = 'data:image/png;base64,' . base64_encode($foto_data);
    }

    // Mulai konten HTML
    $content = '<html><head><style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .kop-container { text-align: center; margin-bottom: 20px; }
        .kop-logo { width: auto; height: 80px; position: absolute; left: 30px; top: 5px; }
        .kop-text { text-align: center; }
        h1, h2, h3 { margin: 2px 0; }
        .line { border-bottom: 3.5px solid black; margin-top: -5px; }
        .profile-container { text-align: center; margin: 20px 0; margin-top: 40px; }
        .profile-img { width: 180px; height: 240px; border-radius: 10px; border: 1px solid #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .no-border { border: none; }
        .page-break { page-break-before: always; }
    </style></head><body>';

    // Kop surat
    // $content .= '<div class="kop-container">
    //     <img src="'.$logo_base64.'" class="kop-logo">
    //     <div class="kop-text">
    //         <h2>PEMERINTAH KABUPATEN BUTON</h2>
    //         <h3>DINAS KOMUNIKASI INFORMATIKA DAN PERSANDIAN</h3>
    //         <p style="margin:2px;">Kompleks Perkantoran TAKAWA Gedung B Lt. 2</p>
    //         <p style="margin:2px;">Telepon (0402) 2810302 Faximile (0402) 2821221</p>
    //     </div>
    // </div>
    // <div class="line"></div>';

    // Foto pegawai di tengah
    // $content .= '<div class="profile-container">
    //     <img src="'.$foto_base64.'" class="profile-img" alt="Foto Pegawai">
    // </div>';

    // Data pegawai
    $content .= '<h3 style="text-align:center; font-size: 20px; margin-bottom: -50px; ">Biodata Pegawai</h3><br/>
    <div class="profile-container">
        <img src="'.$foto_base64.'" class="profile-img" alt="Foto Pegawai">
    </div>
    <table class="no-border">
        <tr><th width="30%">NIP</th><td>: '.$pegawai[0]['nip'].'</td></tr>
        <tr><th>Nama Lengkap</th><td>: '.ucwords($pegawai[0]['nama_pegawai']).'</td></tr>
        <tr><th>Tempat, Tanggal Lahir</th><td>: '.ucwords($pegawai[0]['tempat_lahir']).', '.date('d-m-Y', strtotime($pegawai[0]['tanggal_lahir'])).'</td></tr>
        <tr><th>Agama</th><td>: '.ucwords($pegawai[0]['agama']).'</td></tr>
        <tr><th>Jenis Kelamin</th><td>: '.ucwords($pegawai[0]['jenis_kelamin']).'</td></tr>
        <tr><th>Golongan Darah</th><td>: '.strtoupper($pegawai[0]['gol_darah']).'</td></tr>
        <tr><th>Status Perkawinan</th><td>: '.ucwords($pegawai[0]['status_pernikahan']).'</td></tr>
        <tr><th>Alamat</th><td>: '.ucwords($pegawai[0]['alamat']).'</td></tr>
        <tr><th>Email</th><td>: '.$pegawai[0]['email'].'</td></tr>
        <tr><th>No. HP</th><td>: '.$pegawai[0]['no_hp'].'</td></tr>
    </table>';

    // **Halaman Baru**
    $content .= '<div class="page-break"></div>';

    // Fungsi untuk membuat tabel data dinamis
    function createTable($title, $headers, $data) {
        $table = '<h3 style="text-align:; margin-top: 20px;">'.$title.'</h3><table><tr>';
        foreach ($headers as $header) {
            $table .= '<th>'.$header.'</th>';
        }
        $table .= '</tr>';
        $no = 1;
        foreach ($data as $row) {
            $table .= '<tr><td>'.$no.'</td>';
            foreach ($row as $value) {
                $table .= '<td>'.ucwords($value).'</td>';
            }
            $table .= '</tr>';
            $no++;
        }
        $table .= '</table>';
        return $table;
    }

    // Data pendidikan
    $pendidikan = query("SELECT tingkat, nama_sekolah, lokasi, jurusan, tgl_ijazah, no_ijazah FROM pendidikan WHERE id_pegawai = '$id_pegawai' GROUP BY tgl_ijazah asc");
    $content .= createTable("Data Pendidikan", ["No", "Tingkat", "Nama Sekolah", "Lokasi", "Jurusan", "Tanggal Ijazah", "No. Ijazah"], $pendidikan);

    // Data jabatan
    $jabatan = query("SELECT nama_jabatan, eselon, tmt, sampai_tgl, status_jabatan FROM jabatan WHERE id_pegawai = '$id_pegawai' GROUP BY tmt desc");
    $content .= createTable("Data Jabatan", ["No", "Nama Jabatan", "Eselon", "TMT", "Sampai Tanggal", "Status Jabatan"], $jabatan);

    // Data pangkat
    $pangkat = query("SELECT nama_pangkat, jenis_pangkat, tmt_pangkat, sah_sk, nama_pengesah_sk, no_sk, status_pangkat FROM pangkat WHERE id_pegawai = '$id_pegawai' GROUP BY tmt_pangkat desc");
    $content .= createTable("Data Pangkat", ["No", "Nama Pangkat", "Jenis Pangkat", "TMT Pangkat", "Sah SK", "Nama Pengesah SK", "No. SK", "Status Pangkat"], $pangkat);

    $content .= '</body></html>';

    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("Data_Pegawai.pdf", ["Attachment" => false]);
?>
