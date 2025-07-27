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

// Ambil data tugas yang mau diedit
$stmt = $conn->prepare("SELECT * FROM assignments WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $assignment_id, $dosen_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Assignment not found or you do not have access.");
}
$tugas = $result->fetch_assoc();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $deadline = $_POST['deadline'];

    if ($title && $desc && $deadline) {
        $stmt = $conn->prepare("UPDATE assignments SET title=?, description=?, deadline=? WHERE id=? AND created_by=?");
        $stmt->bind_param("sssii", $title, $desc, $deadline, $assignment_id, $dosen_id);
        if ($stmt->execute()) {
            header("Location: daftar_tugas-dosen.php");
            exit();
        } else {
            $error = "Failed to update assignment.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Assignment</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>

    <div class="content">
        <h3>Edit Assignment</h3>
        <p class="text-muted">Modify the assignment and save changes.</p>

        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="mt-4" style="max-width: 600px;">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" required value="<?= htmlspecialchars($tugas['title']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($tugas['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input name="deadline" type="date" class="form-control" required value="<?= $tugas['deadline'] ?>">
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="daftar_tugas-dosen.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>

</body>
</html>
