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

// Ambil semua tugas
$tugas = $conn->query("SELECT * FROM assignments ORDER BY deadline ASC");
$total_tugas = $tugas->num_rows;

// Ambil submission user
$res = $conn->query("SELECT assignment_id FROM submissions WHERE user_id = $user_id");
$submitted = [];
while ($s = $res->fetch_assoc()) {
    $submitted[$s['assignment_id']] = true;
}

$jumlah_dikerjakan = count($submitted);
$jumlah_belum = $total_tugas - $jumlah_dikerjakan;
$persen = $total_tugas > 0 ? round(($jumlah_dikerjakan / $total_tugas) * 100) : 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Mahasiswa</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="content">
            <h3>Hi, <?= ucfirst($username) ?> 👋</h3>
            <p class="text-muted">Welcome to your assignment dashboard. Stay on track and submit your tasks on time!</p>

            <!-- Ringkasan -->
            <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5>Total Assignments</h5>
                    <h2><?= $total_tugas ?></h2>
                </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5>Submitted</h5>
                    <h2><?= $jumlah_dikerjakan ?></h2>
                </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h5>Not Yet Submitted</h5>
                    <h2><?= $jumlah_belum ?></h2>
                </div>
                </div>
            </div>
            </div>

            <!-- Progress -->
            <div class="mt-4">
            <h5 class="mb-2">Progress</h5>
            <div class="progress" style="height: 24px;">
                <div class="progress-bar bg-success" style="width: <?= $persen ?>%; font-weight: bold;">
                <?= $persen ?>%
                </div>
            </div>
            </div>

            <!-- Tugas terbaru -->
            <div class="mt-5">
            <h5>Recent Assignments</h5>
            <table class="table table-bordered table-sm mt-2">
                <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $res_recent = $conn->query("SELECT * FROM assignments ORDER BY deadline ASC LIMIT 3");
                while ($row = $res_recent->fetch_assoc()):
                ?>
                    <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= $row['deadline'] ?></td>
                    <td>
                        <?= isset($submitted[$row['id']]) ? '<span class="badge bg-success">Submitted</span>' : '<span class="badge bg-warning text-dark">Pending</span>' ?>
                    </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </div>

            <!-- Informasi Skolearn -->
            <div class="alert alert-info mt-4">
            <strong>ℹ️ About Skolearn:</strong> This platform is built to help students manage their assignments online, efficiently and on time. Stay productive!
            </div>
        </div>
    </div>

</body>
</html>
