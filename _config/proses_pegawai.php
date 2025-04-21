<?php

require_once "config.php";

if (isset($_GET['add'])) {
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama_pegawai = strip_tags($_POST['nama_pegawai']);
    $tempat_lahir = strip_tags($_POST['tempat_lahir']);
    $tgl_lahir = strip_tags($_POST['tgl_lahir']);
    $jk = strip_tags($_POST['jk']);
    $no_hp = strip_tags($_POST['no_hp']);
    $agama = strip_tags($_POST['agama']);
    $email = strip_tags($_POST['email']);
    $alamat = strip_tags($_POST['alamat']);
    $goldarah = strip_tags($_POST['goldarah']);
    $stat_nikah = strip_tags($_POST['stat_nikah']);
    $stat_pegawai = strip_tags($_POST['stat_pegawai']);

    $ekstensi  = ['png', 'jpeg', 'jpg'];
    $namaFile    = strtolower($_FILES['foto']['name']);
    $tipe   = pathinfo($namaFile, PATHINFO_EXTENSION);
    $ukuranFile    = $_FILES['foto']['size'];
    $sumber   = $_FILES['foto']['tmp_name'];
    $foto = uniqid() . '.' . $tipe;

    if (in_array($tipe, $ekstensi) === true) {
        if ($ukuranFile < 1048576) { // 1 MB
            $lokasi = "../_assets/img/profile/" . $foto;
            $query = "INSERT INTO pegawai (nip, nama_pegawai, foto_pegawai, tempat_lahir, tanggal_lahir, jenis_kelamin, no_hp, agama, email, alamat, gol_darah, status_pernikahan, status_kepegawaian, status_user) 
                      VALUES ('$nip', '$nama_pegawai', '$foto', '$tempat_lahir', '$tgl_lahir', '$jk', '$no_hp', '$agama', '$email', '$alamat', '$goldarah', '$stat_nikah', '$stat_pegawai', 'aktif')";

            if (mysqli_query($koneksi, $query)) {
                move_uploaded_file($sumber, $lokasi);
                echo '<script>
                        alert("Data Berhasil Ditambah");
                        window.location = "' . base_url('pegawai') . '";
                      </script>';
            } else {
                echo '<script>
                        alert("Gagal Menyimpan Data");
                        window.location = "' . base_url('tambah_pegawai') . '";
                      </script>';
            }
        } else {
            echo '<script>alert("Ukuran file terlalu besar (Max: 1MB)");</script>';
        }
    } else {
        echo '<script>alert("Format file tidak didukung (Hanya PNG, JPEG, JPG)");</script>';
    }
}

elseif (isset($_GET['edit'])) {
    // $id_pegawai = $_GET['id'];
    $id_pegawai = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama_pegawai = strip_tags($_POST['nama_pegawai']);
    $tempat_lahir = strip_tags($_POST['tempat_lahir']);
    $tgl_lahir = strip_tags($_POST['tgl_lahir']);
    $jk = strip_tags($_POST['jk']);
    $no_hp = strip_tags($_POST['no_hp']);
    $agama = strip_tags($_POST['agama']);
    $email = strip_tags($_POST['email']);
    $alamat = strip_tags($_POST['alamat']);
    $goldarah = strip_tags($_POST['goldarah']);
    $stat_nikah = strip_tags($_POST['stat_nikah']);
    $stat_pegawai = strip_tags($_POST['stat_pegawai']);
    $stat_user = strip_tags($_POST['stat_user']);
    $foto_lama = strip_tags($_POST['foto_lama']); // Foto lama jika tidak diubah

    // Cek apakah user mengubah foto
    if ($_FILES['foto']['name'] == '') {
        // Jika foto tidak diubah, update data saja
        $query = "UPDATE pegawai SET 
                    nip='$nip', nama_pegawai='$nama_pegawai', 
                    tempat_lahir='$tempat_lahir', tanggal_lahir='$tgl_lahir', 
                    jenis_kelamin='$jk', no_hp='$no_hp', agama='$agama', 
                    email='$email', alamat='$alamat', gol_darah='$goldarah', 
                    status_pernikahan='$stat_nikah', status_kepegawaian='$stat_pegawai', 
                    status_user='$stat_user'
                  WHERE id_pegawai = $id_pegawai";

        if (mysqli_query($koneksi, $query)) {
            echo '<script>
                    alert("Data Berhasil Diperbarui");
                    window.location = "' . base_url('pegawai') . '";
                  </script>';
        } else {
            echo '<script>
                    alert("Data Gagal Diperbarui");
                    window.location = "' . base_url('edit_pegawai') . '?id=' . $id_pegawai . '";
                  </script>';
        }
    } else {
        // Jika foto diubah, lakukan validasi & upload foto baru
        $ekstensi  = ['png', 'jpeg', 'jpg'];
        $namaFile  = strtolower($_FILES['foto']['name']);
        $tipe      = pathinfo($namaFile, PATHINFO_EXTENSION);
        $ukuranFile = $_FILES['foto']['size'];
        $sumber    = $_FILES['foto']['tmp_name'];
        $foto = uniqid() . '.' . $tipe;

        if (in_array($tipe, $ekstensi) === true) {
            if ($ukuranFile < 1048576) { // 1 MB
                // Hapus foto lama sebelum upload yang baru
                if (!empty($foto_lama) && file_exists("../_assets/img/profile/" . $foto_lama)) {
                    unlink("../_assets/img/profile/" . $foto_lama);
                }

                // Update data pegawai dengan foto baru
                $query = "UPDATE pegawai SET 
                            nip='$nip', nama_pegawai='$nama_pegawai', 
                            foto_pegawai='$foto', tempat_lahir='$tempat_lahir', 
                            tanggal_lahir='$tgl_lahir', jenis_kelamin='$jk', 
                            no_hp='$no_hp', agama='$agama', email='$email', 
                            alamat='$alamat', gol_darah='$goldarah', 
                            status_pernikahan='$stat_nikah', status_kepegawaian='$stat_pegawai', 
                            status_user='$stat_user'
                          WHERE id_pegawai = $id_pegawai";

                if (mysqli_query($koneksi, $query)) {
                    move_uploaded_file($sumber, "../_assets/img/profile/" . $foto);
                    echo '<script>
                            alert("Data Berhasil Diperbarui");
                            window.location = "' . base_url('pegawai') . '";
                          </script>';
                } else {
                    echo '<script>
                            alert("Data Gagal Diperbarui");
                            window.location = "' . base_url('edit_pegawai') . '?id=' . $id_pegawai . '";
                          </script>';
                }
            } else {
                echo '<script>alert("Ukuran file terlalu besar (Max: 1MB)");</script>';
            }
        } else {
            echo '<script>alert("Format file tidak didukung (Hanya PNG, JPEG, JPG)");</script>';
        }
    }
}

elseif (isset($_GET['delete'])) {
    $id_pegawai = intval($_GET['id']);

    // Ambil foto pegawai sebelum menghapus data
    $query = mysqli_query($koneksi, "SELECT foto_pegawai FROM pegawai WHERE id_pegawai = $id_pegawai");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $foto = $data['foto_pegawai'];
        $lokasi = "../_assets/img/profile/" . $foto;

        // Hapus data pegawai dari database
        $delete = mysqli_query($koneksi, "DELETE FROM pegawai WHERE id_pegawai = $id_pegawai");

        if ($delete) {
            if (!empty($foto) && file_exists($lokasi)) {
                unlink($lokasi);
            }
            echo '<script>
                    alert("Data Berhasil Dihapus");
                    window.location = "' . base_url('pegawai') . '";
                  </script>';
        } else {
            echo '<script>
                    alert("Data Gagal Dihapus");
                    window.location = "' . base_url('pegawai') . '";
                  </script>';
        }
    } else {
        echo '<script>
                alert("Data Tidak Ditemukan");
                window.location = "' . base_url('pegawai') . '";
              </script>';
    }
}
?>
