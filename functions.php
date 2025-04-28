<?php
    function getListMahasiswa($conn) {
        $result = mysqli_query($conn, "SELECT * FROM tk");
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    function getMahasiswaID($conn, $id) {
        $result = mysqli_query($conn, "SELECT * FROM tk WHERE id = $id");
        return mysqli_fetch_assoc($result);
    }

    function pencarianMahasiswa($conn, $keyword) {
        $sql = "SELECT * FROM tk WHERE 
            nrp LIKE '%$keyword%' OR 
            nama LIKE '%$keyword%' OR 
            jurusan LIKE '%$keyword%' OR 
            email LIKE '%$keyword%' OR 
            alamat LIKE '%$keyword%' OR 
            asal_sma LIKE '%$keyword%'
            ORDER BY created_at DESC";
        $result = mysqli_query($conn, $sql);
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    function inputMasuk($data) {
        $data = htmlspecialchars($data);
        return $data;
    }

    function validasi($data, $field_name) {
        global $errors;

        switch ($field_name) {
            case 'nrp':
                if (empty($data)) {
                    $errors[] = "NRP wajib diisi";
                } elseif (!is_numeric($data)) {
                    $errors[] = "NRP hanya boleh berisi angka";
                }
                break;
            case 'email':
                if (empty($data)) {
                    $errors[] = "Email wajib diisi";
                } elseif (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Format email tidak valid";
                }
                break;
            case 'nomor_hp':
                if (empty($data)) {
                    $errors[] = "Nomor HP wajib diisi";
                } elseif (!is_numeric($data)) {
                    $errors[] = "Nomor HP hanya boleh berisi angka";
                }
                break;
            default:
                if (empty($data) && $field_name != 'hobi' && $field_name != 'matkul_fav') {
                    //Kapital + Replace huruf
                    $errors[] = ucfirst(str_replace('_', ' ', $field_name)) . " wajib diisi";
                }
                break;
        }
        
        return $data;
    }

    function display_message($type, $message) {
        if ($type == 'error') {
            return '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">' . $message . '</span>
                    </div>';
        } else {
            return '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">' . $message . '</span>
                    </div>';
        }
    }
?>