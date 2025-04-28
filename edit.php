<?php
require 'kon.php';
require 'functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = inputMasuk($_GET['id']);
$mahasiswa = getMahasiswaID($conn, $id);

if (!$mahasiswa) {
    header('Location: index.php');
    exit;
}

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = inputMasuk($_POST['nama']);
    $nrp = inputMasuk($_POST['nrp']);
    $jenis_kelamin = inputMasuk($_POST['jenis_kelamin']);
    $hobi = inputMasuk($_POST['hobi']);
    $jurusan = inputMasuk($_POST['jurusan']);
    $alamat = inputMasuk($_POST['alamat']);
    $email = inputMasuk($_POST['email']);
    $no_telepon = inputMasuk($_POST['no_telepon']);

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    if (empty($nrp)) {
        $errors[] = "NRP tidak boleh kosong";
    }
    if (empty($jenis_kelamin)) {
        $errors[] = "Jenis kelamin harus dipilih";
    }
    if (empty($hobi)) {
        $errors[] = "Hobi tidak boleh kosong";
    }
    if (empty($jurusan)) {
        $errors[] = "Jurusan tidak boleh kosong";
    }
    if (empty($alamat)) {
        $errors[] = "Alamat tidak boleh kosong";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid";
    }
    if (empty($no_telepon)) {
        $errors[] = "Nomor telepon tidak boleh kosong";
    }

    // Jika tidak ada error, update data
    if (empty($errors)) {
        $sql = "UPDATE mahasiswa SET 
                nama = ?, 
                nrp = ?, 
                jk = ?, 
                hobi = ?, 
                jurusan = ?, 
                alamat = ?, 
                email = ?, 
                NomorHp = ? 
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $nama, 
            $nrp, 
            $jenis_kelamin, 
            $hobi, 
            $jurusan, 
            $alamat, 
            $email, 
            $no_telepon, 
            $id
        ]);

        if ($result) {
            $success_message = "Data mahasiswa berhasil diperbarui!";
            $mahasiswa = getMahasiswaID($conn, $id);
        } else {
            $errors[] = "Gagal memperbarui data. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa - <?php echo htmlspecialchars($mahasiswa['nama']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Data Mahasiswa</h1>
            <a href="detail.php?id=<?php echo $mahasiswa['id']; ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                Kembali
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error!</strong>
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Informasi Pribadi</h2>
                        
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-medium mb-2">Nama</label>
                            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="nrp" class="block text-gray-700 font-medium mb-2">NRP</label>
                            <input type="text" id="nrp" name="nrp" value="<?php echo htmlspecialchars($mahasiswa['nrp']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Jenis Kelamin</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo $mahasiswa['jenis_kelamin'] === 'Laki-laki' ? 'checked' : ''; ?> class="mr-2">
                                    Laki-laki
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" <?php echo $mahasiswa['jenis_kelamin'] === 'Perempuan' ? 'checked' : ''; ?> class="mr-2">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="hobi" class="block text-gray-700 font-medium mb-2">Hobi</label>
                            <input type="text" id="hobi" name="hobi" value="<?php echo htmlspecialchars($mahasiswa['hobi']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold mb-4">Informasi Akademik</h2>
                        <div class="mb-4">
                            <label for="jurusan" class="block text-gray-700 font-medium mb-2">Jurusan</label>
                            <input type="text" id="jurusan" name="jurusan" value="<?php echo htmlspecialchars($mahasiswa['jurusan']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h2 class="text-lg font-semibold mb-4">Alamat dan Kontak</h2>
                    
                    <div class="mb-4">
                        <label for="alamat" class="block text-gray-700 font-medium mb-2">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"><?php echo htmlspecialchars($mahasiswa['alamat']); ?></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($mahasiswa['email']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="no_telepon" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                            <input type="text" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($mahasiswa['no_telepon']); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>