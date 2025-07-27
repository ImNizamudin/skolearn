<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

$dosen_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

// Ambil semua tugas dari dosen ini
$stmt = $conn->prepare("SELECT * FROM assignments WHERE created_by = ? ORDER BY deadline DESC");
$stmt->bind_param("i", $dosen_id);
$stmt->execute();
$tugas = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Daftar Tugas</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="content">
            <h3>Daftar Tugas</h3>
            <p class="text-muted">Berikut daftar semua tugas yang telah Anda buat.</p>

            <?php if ($tugas->num_rows > 0): ?>
            <table class="table table-bordered table-sm align-middle mt-3">
                <thead class="table-light">
                <tr>
                    <th>Judul</th>
                    <th>Deadline</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $tugas->fetch_assoc()): ?>
                    <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['deadline'] ?></td>
                    <td>
                        <a href="nilai_tugas-dosen.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Lihat Kiriman</a>
                        <a href="edit_tugas-dosen.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_tugas-dosen.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                    </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-info">Belum ada tugas dibuat.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
