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
    $jk = inputMasuk($_POST['jk']);
    $hobi = inputMasuk($_POST['hobi']);
    $jurusan = inputMasuk($_POST['jurusan']);
    $alamat = inputMasuk($_POST['alamat']);
    $email = inputMasuk($_POST['email']);
    $NomorHp = inputMasuk($_POST['NomorHp']);
    $SMA = inputMasuk($_POST['SMA']);
    $MatkulFav = inputMasuk($_POST['MatkulFav']);

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    if (empty($nrp)) {
        $errors[] = "NRP tidak boleh kosong";
    }
    if (empty($jk)) {
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
    if (empty($NomorHp)) {
        $errors[] = "Nomor telepon tidak boleh kosong";
    }

    // Jika tidak ada error, update data
    if (empty($errors)) {
        $sql = "UPDATE tk SET 
                nama = ?, 
                nrp = ?, 
                jk = ?, 
                hobi = ?, 
                jurusan = ?, 
                alamat = ?, 
                email = ?, 
                NomorHp = ?,
                SMA = ?,
                MatkulFav = ?
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            $nama, 
            $nrp, 
            $jk, 
            $hobi, 
            $jurusan, 
            $alamat, 
            $email, 
            $NomorHp, 
            $SMA,
            $MatkulFav,
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

        <div class="bg-white rounded-lg shadow p-6">
    <form method="POST" action="">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nrp" class="block text-sm font-medium text-gray-700 mb-1">NRP</label>
                <input 
                    type="text" 
                    id="nrp" 
                    name="nrp" 
                    value="<?php echo htmlspecialchars($mahasiswa['nrp']); ?>" 
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
                    value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>"
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
                    <option value="Laki-laki" <?php echo ($mahasiswa['jk'] === 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($mahasiswa['jk'] === 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div>
                <label for="hobi" class="block text-sm font-medium text-gray-700 mb-1">Hobi</label>
                <input 
                    type="text" 
                    id="hobi" 
                    name="hobi"
                    value="<?php echo htmlspecialchars($mahasiswa['hobi']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <input 
                    type="text" 
                    id="jurusan" 
                    name="jurusan" 
                    value="<?php echo htmlspecialchars($mahasiswa['jurusan']); ?>"
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
                    value="<?php echo htmlspecialchars($mahasiswa['email']); ?>"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea 
                    id="alamat" 
                    name="alamat" 
                    rows="3"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                ><?php echo htmlspecialchars($mahasiswa['alamat']); ?></textarea>
            </div>

            <div>
                <label for="NomorHp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input 
                    type="text" 
                    id="NomorHp" 
                    name="NomorHp" 
                    value="<?php echo htmlspecialchars($mahasiswa['NomorHp']); ?>"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="SMA" class="block text-sm font-medium text-gray-700 mb-1">Asal SMA</label>
                <input 
                    type="text" 
                    id="SMA" 
                    name="SMA" 
                    value="<?php echo htmlspecialchars($mahasiswa['SMA']); ?>"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="MatkulFav" class="block text-sm font-medium text-gray-700 mb-1">Mata Kuliah Favorit</label>
                <input 
                    type="text" 
                    id="MatkulFav" 
                    name="MatkulFav"
                    value="<?php echo htmlspecialchars($mahasiswa['MatkulFav']); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
            </div>
        </div>

        <div class="mt-6">
            <button 
                type="submit" 
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded"
            >
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

    </div>
</body>
</html>