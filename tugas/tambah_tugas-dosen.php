<?php
session_start();
include '../includes/db.php';
include '../includes/auth.php';

if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

$success = null;
$error = null;

// Tangani form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $deadline = $_POST['deadline'];
    $created_by = $_SESSION['user']['id'];

    if ($title && $desc && $deadline) {
        $stmt = $conn->prepare("INSERT INTO assignments (title, description, deadline, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $desc, $deadline, $created_by);
        if ($stmt->execute()) {
            $success = "Assignment successfully added.";
            header("Location: ../dashboard/dosen.php");
            exit();
        } else {
            $error = "Failed to insert assignment.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Assignment</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>

    <div class="content">
        <h3>Add New Assignment</h3>
        <p class="text-muted">Fill out the form to create a new assignment for students.</p>

        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" class="mt-4" style="max-width: 600px;">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" type="text" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input name="deadline" type="date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Assignment</button>
        <a href="../dashboard/dosen.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>

</body>
</html>
