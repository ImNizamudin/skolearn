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

// Ambil semua tugas dosen
$tugas = $conn->query("SELECT * FROM assignments WHERE created_by = $dosen_id");
$total_tugas = $tugas->num_rows;

// Ambil semua submission untuk tugas yang dibuat dosen ini
$sql = "SELECT s.id FROM submissions s
JOIN assignments a ON s.assignment_id = a.id
WHERE a.created_by = $dosen_id";
$submissions = $conn->query($sql);
$total_kiriman = $submissions->num_rows;

// 3 tugas terakhir
$recent = $conn->query("SELECT * FROM assignments WHERE created_by = $dosen_id ORDER BY deadline DESC LIMIT 3");

date_default_timezone_set('Asia/Jakarta');
$tanggal = date("l, d M Y");
$jam = date("H:i");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dosen Dashboard</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
</head>
<body>

    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="content">
            <h3>Welcome, <?= ucfirst($username) ?> 👋</h3>
            <p class="text-muted">This is your dashboard to manage assignments and review submissions.</p>

            <div class="row mt-4">
                <!-- Box Tanggal -->
                <div class="col-md-3 mb-3">
                    <div class="card border-start border-success border-4 shadow-sm h-100">
                    <div class="card-body text-center">
                        <h5 class="mb-1"><?= $tanggal ?></h5>
                        <p class="mb-0 text-muted"><?= $jam ?> WIB</p>
                    </div>
                    </div>
                </div>

                <!-- Statistik tugas -->
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <h5>Total Assignments</h5>
                        <h2><?= $total_tugas ?></h2>
                    </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <h5>Total Submissions</h5>
                        <h2><?= $total_kiriman ?></h2>
                    </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <a href="../tugas/tambah_tugas-dosen.php" class="btn btn-outline-success w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none">
                    <div style="font-size: 2rem;">➕</div>
                    <strong>Create Assignment</strong>
                    </a>
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
                        <th>Submissions</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $recent->fetch_assoc()):
                        $aid = $row['id'];
                        $count = $conn->query("SELECT COUNT(*) as total FROM submissions WHERE assignment_id = $aid")->fetch_assoc()['total'];
                    ?>
                        <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= $row['deadline'] ?></td>
                        <td><?= $count ?></td>
                        <td>
                            <a href="../tugas/nilai.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Grade</a>
                        </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Info -->
            <div class="alert alert-info mt-4">
                <strong>ℹ️ Skolearn for Dosen:</strong> You can create assignments, view student submissions, and provide feedback in one place. Make grading easier and more efficient!
            </div>
        </div>
    </div>

</body>
</html>
