<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if (!isMahasiswa()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];
$username = $_SESSION['user']['username'];

$tugas = $conn->query("SELECT * FROM assignments ORDER BY deadline ASC");

$res = $conn->query("SELECT assignment_id FROM submissions WHERE user_id = $user_id");
$submitted = [];
while ($s = $res->fetch_assoc()) {
    $submitted[$s['assignment_id']] = true;
}
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
            <h3>Tugas Kuliah</h3>
            <p class="text-muted">Daftar tugas yang diberikan dosen.</p>

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
                        <a href="../tugas/detail_tugas-mahasiswa.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                        <?= isset($submitted[$row['id']]) ? "Lihat" : "Kerjakan" ?>
                        </a>
                    </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-info">Tidak ada tugas saat ini.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
