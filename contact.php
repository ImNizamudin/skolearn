<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact – Skolearn</title>
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #3cbdd6, #02b564);
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
.card-contact {
      background: white;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .card-contact img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
      border: 3px solid #02b564;
    }

    a {
      color: #02b564;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }

    .form-control:focus {
      border-color: #02b564;
      box-shadow: 0 0 0 0.2rem rgba(2, 181, 100, 0.2);
    }

    .btn-dark {
      background-color: #022c22;
      border: none;
    }
  </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center align-items-center g-4">

            <!-- Card Profil + Deskripsi -->
            <div class="col-md-5">
                <div class="card-contact text-center">
                    <img src="assets/img/profile.jpeg" alt="profile">
                    <h5 class="fw-bold mb-1">Nabila ika Fitriani</h5>
                    <p class="text-muted mb-3">Tulungagung, East Java</p>
                    <p class="mb-2">Saya Nabila Ika Fitriani, dengan NPM 22183207018, mahasiswa PTI 6A dari Universitas Bhinneka PGRI, Tulungagung, Jawa Timur. Berasal dari Tulungagung, saya antusias untuk terus belajar dan berkarya di bidang teknologi informasi. Senang bisa terhubung di sini!</p>
                    <p>
                        <a href="#" target="_blank">Instagram</a> |
                        <a href="#" target="_blank">Facebook</a> |
                        <a href="#" target="_blank">GitHub</a>
                    </p>
                </div>
            </div>

            <!-- Form Kontak -->
            <div class="col-md-7">
                <div class="card-contact">
                    <h5 class="fw-bold mb-3">Send Me a Message</h5>
                    <form action="#" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message:</label>
                        <textarea id="message" class="form-control" rows="4" required></textarea>
                    </div>
                    <button class="btn btn-dark px-4">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>
</html>