<?php
session_start();
include 'koneksi.php';

// Check if the user is logged in
// if (!isset($_SESSION['user']['id'])) {
//     header("Location: login.php");
//     exit;
// }

// Fetch user data based on session ID
$user_id = $_SESSION['user']['id'];
echo "User ID: " . $user_id; // Tambahkan ini untuk memeriksa nilai user ID
$sql = "SELECT * FROM users WHERE id = ?";
if ($stmt = $koneksi->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Check if user is found
    if (!$user) {
        echo "User not found!";
        exit;
    }
} else {
    echo "Error: " . $koneksi->error;
    exit;
}


$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sqlEmail = "SELECT COUNT(*) FROM users WHERE email=? AND id!=?";
    if ($queryEmail = $koneksi->prepare($sqlEmail)) {
        $queryEmail->bind_param("si", $_POST['email'], $_SESSION['user']['id']);
        $queryEmail->execute();
        $queryEmail->bind_result($count);
        $queryEmail->fetch();
        $queryEmail->close();

        if ($count > 0) {
            $error = 'Email telah digunakan, silahkan pakai email lain';
        } else {
            $sqlUpdate = "UPDATE users SET username=?, nama=?, email=?, umur=?, no_hp=?, gender=?, tinggi_badan=?, berat_badan=?, activity_level=?, calory_needs=? WHERE id=?";
            if ($queryUpdate = $koneksi->prepare($sqlUpdate)) {
                $queryUpdate->bind_param("ssssiisiiii", $_POST['username'], $_POST['nama'], $_POST['email'], $_POST['umur'], $_POST['no_hp'], $_POST['gender'], $_POST['tinggi_badan'], $_POST['berat_badan'], $_POST['activity_level'], $_POST['calory_needs'], $_SESSION['user']['id']);
                $queryUpdate->execute();
                $queryUpdate->close();

                // Update session data
                $_SESSION['user']['username'] = $_POST['username'];
                $_SESSION['user']['nama'] = $_POST['nama'];
                $_SESSION['user']['email'] = $_POST['email'];
                $_SESSION['user']['umur'] = $_POST['umur'];
                $_SESSION['user']['no_hp'] = $_POST['no_hp'];
                $_SESSION['user']['gender'] = $_POST['gender'];
                $_SESSION['user']['tinggi_badan'] = $_POST['tinggi_badan'];
                $_SESSION['user']['berat_badan'] = $_POST['berat_badan'];
                $_SESSION['user']['activity_level'] = $_POST['activity_level'];
                $_SESSION['user']['calory_needs'] = $_POST['calory_needs'];

                if (!empty($_POST['password_lama']) && !empty($_POST['password_baru'])) {
                    if (sha1($_POST['password_lama']) != $user['password']) {
                        $error = 'Password lama salah';
                    } else {
                        if ($_POST['password_baru'] != $_POST['password_baru2']) {
                            $error = 'Password Baru dan Ketik Ulang Password Baru harus sama';
                        } else {
                            $sqlPassword = "UPDATE users SET password=? WHERE id=?";
                            if ($queryPassword = $koneksi->prepare($sqlPassword)) {
                                $newPassword = sha1($_POST['password_baru']);
                                $queryPassword->bind_param("si", $newPassword, $_SESSION['user']['id']);
                                $queryPassword->execute();
                                $queryPassword->close();
                                header("Location: profil.php");
                                exit;
                            } else {
                                echo "Error: " . $koneksi->error;
                                exit;
                            }
                        }
                    }
                } else {
                    header("Location: profil.php");
                    exit;
                }
            } else {
                echo "Error: " . $koneksi->error;
                exit;
            }
        }
    } else {
        echo "Error: " . $koneksi->error;
        exit;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <?php include_once('sidebardiet.php') ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <strong>Profile</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <?php
                        if ($error != '') {
                            echo '<p class="text-danger">' . $error . '</p>';
                        }
                        ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : $user['username']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : $user['nama']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $user['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Umur</label>
                                <input type="number" class="form-control" name="umur" value="<?php echo isset($_POST['umur']) ? $_POST['umur'] : $user['umur']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" class="form-control" name="no_hp" value="<?php echo isset($_POST['no_hp']) ? $_POST['no_hp'] : $user['no_hp']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-control" name="gender" required>
                                    <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="other" <?php echo ($user['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tinggi Badan (cm)</label>
                                <input type="number" class="form-control" name="tinggi_badan" value="<?php echo isset($_POST['tinggi_badan']) ? $_POST['tinggi_badan'] : $user['tinggi_badan']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Berat Badan (kg)</label>
                                <input type="number" class="form-control" name="berat_badan" value="<?php echo isset($_POST['berat_badan']) ? $_POST['berat_badan'] : $user['berat_badan']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Activity Level</label>
                                <select class="form-control" name="activity_level" required>
                                    <option value="1.2" <?php echo ($user['activity_level'] == 1.2) ? 'selected' : ''; ?>>Sedentary (little or no exercise)</option>
                                    <option value="1.375" <?php echo ($user['activity_level'] == 1.375) ? 'selected' : ''; ?>>Lightly active (light exercise/sports 1-3 days/week)</option>
                                    <option value="1.55" <?php echo ($user['activity_level'] == 1.55) ? 'selected' : ''; ?>>Moderately active (moderate exercise/sports 3-5 days/week)</option>
                                    <option value="1.725" <?php echo ($user['activity_level'] == 1.725) ? 'selected' : ''; ?>>Very active (hard exercise/sports 6-7 days a week)</option>
                                    <option value="1.9" <?php echo ($user['activity_level'] == 1.9) ? 'selected' : ''; ?>>Extra active (very hard exercise/sports and a physical job)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Calory Needs</label>
                                <input type="number" class="form-control" name="calory_needs" value="<?php echo isset($_POST['calory_needs']) ? $_POST['calory_needs'] : $user['calory_needs']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" class="form-control" name="password_lama">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="password_baru">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ketik Ulang Password Baru</label>
                                <input type="password" class="form-control" name="password_baru2">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
