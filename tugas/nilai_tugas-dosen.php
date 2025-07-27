<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

$assignment_id = $_GET['id'] ?? null;
$dosen_id = $_SESSION['user']['id'];

if (!$assignment_id) {
    die("Assignment ID is required.");
}

// Validasi tugas milik dosen
$stmt = $conn->prepare("SELECT * FROM assignments WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $assignment_id, $dosen_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    die("Assignment not found or you don't have access.");
}
$tugas = $result->fetch_assoc();

// Update nilai & komentar jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = $_POST['nilai'];
    $komentar = $_POST['komentar'];
    $submission_id = $_POST['submission_id'];

    $stmt = $conn->prepare("UPDATE submissions SET nilai = ?, komentar = ? WHERE id = ?");
    $stmt->bind_param("isi", $nilai, $komentar, $submission_id);
    $stmt->execute();
    echo "<script>location.href='nilai_tugas-dosen.php?id=$assignment_id';</script>";
}

// Ambil semua submission untuk tugas ini
$sql = "SELECT s.*, u.username FROM submissions s JOIN users u ON s.user_id = u.id WHERE s.assignment_id = $assignment_id";
$submissions = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Grade Assignment</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="content">
            <h3>Grade: <?= htmlspecialchars($tugas['title']) ?></h3>
            <p class="text-muted">Manage student submissions and provide feedback.</p>

            <?php if ($submissions->num_rows > 0): ?>
            <div class="table-responsive mt-4">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                <tr>
                    <th>Student</th>
                    <th>File</th>
                    <th>Nilai</th>
                    <th>Comment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while($s = $submissions->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($s['username']) ?></td>
                    <td><a href="../assets/uploads/<?= $s['file'] ?>" target="_blank"><?= $s['file'] ?></a></td>
                    <td><?= $s['nilai'] ?? '-' ?></td>
                    <td><?= nl2br(htmlspecialchars($s['komentar'])) ?></td>
                    <td>
                    <form method="post" class="d-flex flex-column gap-1">
                        <input type="hidden" name="submission_id" value="<?= $s['id'] ?>">
                        <input type="number" name="nilai" class="form-control form-control-sm" value="<?= $s['nilai'] ?>" placeholder="Nilai" required>
                        <input type="text" name="komentar" class="form-control form-control-sm" value="<?= $s['komentar'] ?>" placeholder="Komentar">
                        <button class="btn btn-sm btn-success">Save</button>
                    </form>
                    </td>
                </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </div>
            <?php else: ?>
            <div class="alert alert-warning">No student has submitted this assignment yet.</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
