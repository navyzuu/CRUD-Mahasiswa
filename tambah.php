<?php
// Memuat file konfigurasi dan fungsi
require 'kon.php';
require 'functions.php';

function create_mahasiswa($conn, $data) {
    $errors = [];
    
    // Validasi data
    $nrp = validasi($data['nrp'], 'nrp');
    $nama = validasi($data['nama'], 'nama');
    $jk = validasi($data['jk'], 'jk');
    $hobi = isset($data['hobi']) ? validasi($data['hobi'], 'hobi') : '';
    $jurusan = validasi($data['jurusan'], 'jurusan');
    $email = validasi($data['email'], 'email');
    $alamat = validasi($data['alamat'], 'alamat');
    $nomor_hp = validasi($data['nomor_hp'], 'nomor_hp');
    $asal_sma = validasi($data['asal_sma'], 'asal_sma');
    $matkul_fav = isset($data['matkul_fav']) ? validasi($data['matkul_fav'], 'matkul_fav') : '';
    
    // Cek apakah NRP sudah ada di database
    $check_nrp = "SELECT * FROM tk WHERE nrp = '$nrp'";
    $result = mysqli_query($conn, $check_nrp);
    
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "NRP sudah terdaftar, gunakan NRP lain";
    }
    
    // Jika tidak ada error, simpan data ke database
    if (empty($errors)) {
        $sql = "INSERT INTO tk (nrp, nama, jk, hobi, jurusan, email, alamat, NomorHp, SMA, MatkulFav) 
                VALUES ('$nrp', '$nama', '$jk', '$hobi', '$jurusan', '$email', '$alamat', '$nomor_hp', '$asal_sma', '$matkul_fav')";
        
        if (mysqli_query($conn, $sql)) {
            return [
                'status' => 'success',
                'message' => 'Data mahasiswa berhasil ditambahkan'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error: ' . mysqli_error($conn)
            ];
        }
    } else {
        return [
            'status' => 'error',
            'message' => implode('<br>', $errors)
        ];
    }
}
// Inisialisasi variabel-variabel
$errors = [];
$success_message = '';

// Jika ada submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = create_mahasiswa($conn, $_POST);
    
    if ($result['status'] === 'success') {
        $success_message = $result['message'];
    } else {
        $errors[] = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Mahasiswa</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Data Mahasiswa</h1>
            <a href="home.php" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
        
        <!-- Pesan Sukses atau Error -->
        <?php if (!empty($success_message)): ?>
            <?php echo display_message('success', $success_message); ?>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $error): ?>
                <?php echo display_message('error', $error); ?>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <!-- Form Tambah Data -->
        <div class="bg-white rounded-lg shadow p-6">
            <form action="tambah.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nrp" class="block text-sm font-medium text-gray-700 mb-1">NRP</label>
                        <input 
                            type="text" 
                            id="nrp" 
                            name="nrp" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="jk" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select 
                            id="jk" 
                            name="jk" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="hobi" class="block text-sm font-medium text-gray-700 mb-1">Hobi</label>
                        <input 
                            type="text" 
                            id="hobi" 
                            name="hobi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                        <input 
                            type="text" 
                            id="jurusan" 
                            name="jurusan" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea 
                            id="alamat" 
                            name="alamat" 
                            required
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        ></textarea>
                    </div>
                    
                    <div>
                        <label for="nomor_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                        <input 
                            type="text" 
                            id="nomor_hp" 
                            name="nomor_hp" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="asal_sma" class="block text-sm font-medium text-gray-700 mb-1">Asal SMA</label>
                        <input 
                            type="text" 
                            id="asal_sma" 
                            name="asal_sma" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                    
                    <div>
                        <label for="matkul_fav" class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah Favorit</label>
                        <input 
                            type="text" 
                            id="matkul_fav" 
                            name="matkul_fav"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>
                
                <div class="mt-6">
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
                    >
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>