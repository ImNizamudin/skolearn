<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if (!isMahasiswa()) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];
$submission_id = $_GET['id'] ?? null;

if (!$submission_id) die("Invalid submission ID.");

$res = $conn->query("SELECT s.*, a.title, a.description, a.deadline FROM submissions s
                        JOIN assignments a ON s.assignment_id = a.id
                        WHERE s.id = $submission_id AND s.user_id = $user_id LIMIT 1");

if ($res->num_rows === 0) die("Submission not found.");

$data = $res->fetch_assoc();
$assignment_id = $data['assignment_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $komentar = $_POST['komentar'];
    $filename = $data['file'];

    if ($_FILES['file']['name']) {
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $filename = "user{$user_id}_assign{$assignment_id}_" . time() . "." . $ext;
        move_uploaded_file($_FILES['file']['tmp_name'], "../assets/uploads/" . $filename);
    }

    $stmt = $conn->prepare("UPDATE submissions SET file = ?, komentar = ? WHERE id = ?");
    $stmt->bind_param("ssi", $filename, $komentar, $submission_id);
    $stmt->execute();

    header("Location: detail_tugas-mahasiswa.php?id=$assignment_id");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Submission</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="content">
            <h3>Edit Submission for: <?= htmlspecialchars($data['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($data['description'])) ?></p>
            <p><strong>Deadline:</strong> <?= $data['deadline'] ?></p>

            <hr>
            <p><strong>Current File:</strong> <a href="../assets/uploads/<?= $data['file'] ?>" target="_blank"><?= $data['file'] ?></a></p>

            <form method="POST" enctype="multipart/form-data" style="max-width: 500px;">
                <div class="mb-3">
                    <label>Upload New File (optional)</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Update Comment</label>
                    <input type="text" name="komentar" class="form-control" value="<?= htmlspecialchars($data['komentar']) ?>">
                </div>
                <button class="btn btn-success">Save Changes</button>
                <a href="detail.php?id=<?= $assignment_id ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

</body>
</html>
