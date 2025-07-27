<?php
$user = $_SESSION['user'];
$role = $user['role'];
?>

<div class="sidebar p-3 text-white">
    <h4 class="mb-4">Skolearn</h4>
    <p class="mb-1"><strong><?= ucfirst($user['username']) ?></strong></p>
    <small class="text-light mb-4 d-block"><?= ucfirst($role) ?></small>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="<?= $role === 'admin' ? '../dashboard/dosen.php' : '../dashboard/mahasiswa.php' ?>" class="nav-link text-white">🏠 Home</a>
        </li>

        <?php if ($role === 'admin'): ?>
            <li class="nav-item"><a href="../tugas/tambah_tugas-dosen.php" class="nav-link text-white">➕ Add Assignment</a></li>
            <li class="nav-item"><a href="../tugas/daftar_tugas-dosen.php" class="nav-link text-white">📋 Assignments</a></li>
        <?php else: ?>
            <li class="nav-item"><a href="../tugas/daftar_tugas-mahasiswa.php" class="nav-link text-white">📤 Tugas</a></li>
        <?php endif; ?>

        <li class="nav-item mt-3"><a href="../logout.php" class="nav-link text-danger">🚪 Logout</a></li>
    </ul>
</div>
