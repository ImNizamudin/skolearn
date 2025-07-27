<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if (!isMahasiswa()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];
$assignment_id = $_GET['id'] ?? null;

if (!$assignment_id) die("ID tugas tidak valid.");

$stmt = $conn->prepare("SELECT * FROM assignments WHERE id = ?");
$stmt->bind_param("i", $assignment_id);
$stmt->execute();
$tugas = $stmt->get_result()->fetch_assoc();

if (!$tugas) die("Tugas tidak ditemukan.");

$res = $conn->query("SELECT * FROM submissions WHERE user_id = $user_id AND assignment_id = $assignment_id LIMIT 1");
$submitted = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$submitted) {
    $komentar = $_POST['komentar'];
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $filename = "user{$user_id}_assign{$assignment_id}_" . time() . "." . $ext;
    $target = "../assets/uploads/" . $filename;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file, komentar) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $assignment_id, $filename, $komentar);
        $stmt->execute();
        header("Location: detail_tugas-mahasiswa.php?id=$assignment_id");
        exit();
    } else {
        $error = "Gagal upload file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Detail Tugas</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>
        <div class="content">
            <h3><?= htmlspecialchars($tugas['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($tugas['description'])) ?></p>
            <p><strong>Deadline:</strong> <?= $tugas['deadline'] ?></p>

            <hr>
            <?php if ($submitted): ?>
            <div class="alert alert-success">
                <strong>✅ Sudah dikumpulkan</strong><br>
                File: <a href="../assets/uploads/<?= $submitted['file'] ?>" target="_blank"><?= $submitted['file'] ?></a><br>
                Nilai: <?= $submitted['nilai'] ?? '-' ?><br>
                Komentar: <?= $submitted['komentar'] ?? '-' ?>
            </div>
            <a href="edit_tugas-mahasiswa.php?id=<?= $submitted['id'] ?>" class="btn btn-warning">Edit Kiriman</a>
            <?php else: ?>
            <h5>Kumpulkan Tugas</h5>
            <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
            <form method="post" enctype="multipart/form-data" style="max-width: 500px;">
                <div class="mb-2">
                    <label>File</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Komentar</label>
                    <input type="text" name="komentar" class="form-control" placeholder="Komentar (opsional)">
                </div>
                <button type="submit" class="btn btn-success">Kumpulkan</button>
            </form>
            <?php endif; ?>

            <a href="daftar_tugas-mahasiswa.php" class="btn btn-link mt-4">← Kembali ke daftar</a>
        </div>
    </div>

</body>
</html>
