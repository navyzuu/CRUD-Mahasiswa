<?php
    require 'kon.php';
    require 'functions.php';
    $search = isset($_GET['search']) ? inputMasuk($_GET['search']) : '';

    if (!empty($search)) {
        $mahasiswa_list = pencarianMahasiswa($conn, $search);
    } else {
        $mahasiswa_list = getListMahasiswa($conn);
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Data Mahasiswa</h1>
            <a href="tambah.php" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Tambah Mahasiswa
            </a>
        </div>
        <div class="mb-6">
            <form action="home.php" method="GET" class="flex gap-2">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari mahasiswa..."
                    value="<?php echo htmlspecialchars($search); ?>"
                    class="flex-grow px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg"
                >
                    Cari
                </button>
                <?php if (!empty($search)): ?>
                <a 
                    href="home.php" 
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg"
                >
                    Reset
                </a>
                <?php endif; ?>
            </form>
        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NRP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (count($mahasiswa_list) > 0): ?>
                            <?php foreach ($mahasiswa_list as $mhs): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($mhs['nrp']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($mhs['nama']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($mhs['jk']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($mhs['jurusan']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap"><?php echo htmlspecialchars($mhs['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <a href="detail.php?id=<?php echo $mhs['id']; ?>" class="text-blue-500 hover:text-blue-700">
                                            Detail
                                        </a>
                                        <a href="edit.php?id=<?php echo $mhs['id']; ?>" class="text-yellow-500 hover:text-yellow-700 ml-2">
                                            Edit
                                        </a>
                                        <a href="home.php?id=<?php echo $mhs['id']; ?>" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');" 
                                           class="text-red-500 hover:text-red-700 ml-2">
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    <?php echo !empty($search) ? 'Tidak ada hasil yang ditemukan' : 'Belum ada data mahasiswa'; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>