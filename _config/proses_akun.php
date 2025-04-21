<?php

require_once "config.php";

if (isset($_GET['add'])) {
    $id_pegawai = strip_tags($_POST['id_pegawai']);
    $username = strip_tags($_POST['username']);
    $role = strip_tags($_POST['role']);

    if (!empty($id_pegawai) && !empty($username) && !empty($role)) {
        // Cek apakah username sudah ada
        $check_username = query("SELECT COUNT(*) as count FROM user WHERE username = '$username'");
        
        if ($check_username[0]['count'] > 0) {
            echo '<script>
                alert("Username sudah digunakan, silakan pilih username lain.");
                window.location = "' . base_url('akun/tambah_akun') . '";
            </script>';
            exit(); // Hentikan proses jika username sudah ada
        }

        // Cek apakah pegawai ada di database
        $check_pegawai = query("SELECT COUNT(*) as count FROM pegawai WHERE id_pegawai = '$id_pegawai'");
        
        if ($check_pegawai[0]['count'] > 0) {
            $password = password_hash("12345678", PASSWORD_DEFAULT);
            $query = "INSERT INTO user (id_pegawai, username, role, password) 
                      VALUES ('$id_pegawai', '$username', '$role', '$password')";
            $result = mysqli_query($koneksi, $query);
    
            if ($result) {
                echo '<script>
                    alert("Data Berhasil Ditambah");
                    window.location = "' . base_url('akun/akun') . '";
                </script>';
            } else {
                echo '<script>
                    alert("Gagal Menyimpan Data");
                    window.location = "' . base_url('akun/tambah_akun') . '";
                </script>';
            }
        } else {
            echo '<script>
                alert("Pegawai tidak ditemukan.");
                window.location = "' . base_url('akun/tambah_akun') . '";
            </script>';
        }
    } else {
        echo '<script>
            alert("Semua field harus diisi.");
            window.location = "' . base_url('akun/tambah_akun') . '";
        </script>';
    }    
}

elseif (isset($_GET['edit'])) {
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $username = strip_tags($_POST['username']);
    $role = strip_tags($_POST['role']);

    // Cek apakah username sudah digunakan oleh user lain
    $check_username = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM user WHERE username = '$username' AND id_user != '$id_user'");
    $row = mysqli_fetch_assoc($check_username);

    if ($row['count'] > 0) {
        echo '<script>
                alert("Username sudah digunakan, silakan pilih username lain.");
                window.location = "' . base_url('akun/edit_akun') . '?id=' . $id_user . '";
              </script>';
        exit();
    }

    // Update user jika username tidak duplikat
    $query = "UPDATE user SET 
                username='$username', role='$role'
              WHERE id_user = '$id_user'";

    if (mysqli_query($koneksi, $query)) {
        echo '<script>
                alert("Data Berhasil Diperbarui");
                window.location = "' . base_url('akun/akun') . '";
              </script>';
    } else {
        echo '<script>
                alert("Data Gagal Diperbarui");
                window.location = "' . base_url('akun/edit_akun') . '?id=' . $id_user . '";
              </script>';
    }
}

elseif (isset($_GET['reset'])) {
    $id_user = intval($_GET['id']);
    $password = password_hash("12345678", PASSWORD_DEFAULT);

    $query = "UPDATE user SET 
                password='$password'
                WHERE id_user = $id_user";

    if (mysqli_query($koneksi, $query)) {
        echo '<script>
                alert("Password Berhasil Direset");
                window.location = "' . base_url('akun/akun') . '";
                </script>';
    } else {
        echo '<script>
                alert("Password Gagal Direset");
                window.location = "' . base_url('akun/akun') . '";
                </script>';
    }
}

elseif (isset($_GET['delete'])) {
    $id_user = intval($_GET['id']);

    // Hapus data akun dari database
    $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = $id_user");

    if ($delete) {
        echo '<script>
                alert("Data Berhasil Dihapus");
                window.location = "' . base_url('akun/akun') . '";
                </script>';
    } else {
        echo '<script>
                alert("Data Gagal Dihapus");
                window.location = "' . base_url('akun/akun') . '";
                </script>';
    }
    
}
?>
