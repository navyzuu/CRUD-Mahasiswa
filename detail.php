<?php
require 'kon.php';
require 'functions.php';

// Memastikan ID ada di parameter URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: home.php');
    exit;
}

$id = inputMasuk($_GET['id']);
$mahasiswa = getMahasiswaID($conn, $id);

// Jika mahasiswa tidak ditemukan, redirect ke halaman utama
if (!$mahasiswa) {
    header('Location: home.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa - <?php echo htmlspecialchars($mahasiswa['nama']); ?></title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Mahasiswa</h1>
            <div>
                <a href="edit.php?id=<?php echo $mahasiswa['id']; ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="home.php" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded">
                    Kembali
                </a>
                <button onclick="hapusMahasiswa(<?php echo $mahasiswa['id']; ?>)" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded ml-2">
                    Hapus
                </button>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h2 class="text-lg font-semibold mb-2">Informasi Pribadi</h2>
                    <p><span class="font-medium">Nama:</span> <?php echo htmlspecialchars($mahasiswa['nama']); ?></p>
                    <p><span class="font-medium">NRP:</span> <?php echo htmlspecialchars($mahasiswa['nrp']); ?></p>
                    <p><span class="font-medium">Jenis Kelamin:</span> <?php echo htmlspecialchars($mahasiswa['jk']); ?></p>
                    <p><span class="font-medium">Hobi:</span> <?php echo htmlspecialchars($mahasiswa['hobi']); ?></p>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-2">Informasi Akademik</h2>
                    <p><span class="font-medium">Jurusan:</span> <?php echo htmlspecialchars($mahasiswa['jurusan']); ?></p>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Alamat dan Kontak</h2>
                <p><span class="font-medium">Alamat:</span> <?php echo htmlspecialchars($mahasiswa['alamat']); ?></p>
                <p><span class="font-medium">Email:</span> <?php echo htmlspecialchars($mahasiswa['email']); ?></p>
                <p><span class="font-medium">Nomor Telepon:</span> <?php echo htmlspecialchars($mahasiswa['NomorHp']); ?></p>
            </div>
        </div>
    </div>

    <script>
        function hapusMahasiswa(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data mahasiswa ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>