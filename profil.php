<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM users WHERE id=?";
if ($query = $koneksi->prepare($sql)) {
    $query->bind_param("i", $_SESSION['user']['id']);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $query->close();

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
    $sqlEmail = "SELECT count(*) FROM users WHERE email=? AND id!=?";
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
                                    <option value="female" <?php echo ($user['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="male" <?php echo ($user['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
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
                                    <option value="sedentary" <?php echo ($user['activity_level'] == 'sedentary') ? 'selected' : ''; ?>>Sedentary</option>
                                    <option value="light" <?php echo ($user['activity_level'] == 'light') ? 'selected' : ''; ?>>Light</option>
                                    <option value="moderate" <?php echo ($user['activity_level'] == 'moderate') ? 'selected' : ''; ?>>Moderate</option>
                                    <option value="active" <?php echo ($user['activity_level'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="very active" <?php echo ($user['activity_level'] == 'very active') ? 'selected' : ''; ?>>Very Active</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Calory Needs</label>
                                <input type="number" class="form-control" name="calory_needs" value="<?php echo isset($_POST['calory_needs']) ? $_POST['calory_needs'] : $user['calory_needs']; ?>" required>
                            </div>
                            <hr />
                            <h5>Ganti Password</h5>
                            <p class="text-info">Kosongkan jika tidak diganti</p>
                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" name="password_lama" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password_baru" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ketik Ulang Password Baru</label>
                                <input type="password" name="password_baru2" class="form-control">
                            </div>
                            <div class="text-end mb-5">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/inspinia.js"></script>
</body>

</html>

<!-- AKHIR TEMPLATE  -->


<!-- Mainly scripts -->
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Jvectormap -->
<script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- EayPIE -->
<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>

<script>
    $(document).ready(function() {
        $('.chart').easyPieChart({
            barColor: '#f8ac59',
            //                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        $('.chart2').easyPieChart({
            barColor: '#1c84c6',
            //                scaleColor: false,
            scaleLength: 5,
            lineWidth: 4,
            size: 80
        });

        var data2 = [
            [gd(2012, 1, 1), 7],
            [gd(2012, 1, 2), 6],
            [gd(2012, 1, 3), 4],
            [gd(2012, 1, 4), 8],
            [gd(2012, 1, 5), 9],
            [gd(2012, 1, 6), 7],
            [gd(2012, 1, 7), 5],
            [gd(2012, 1, 8), 4],
            [gd(2012, 1, 9), 7],
            [gd(2012, 1, 10), 8],
            [gd(2012, 1, 11), 9],
            [gd(2012, 1, 12), 6],
            [gd(2012, 1, 13), 4],
            [gd(2012, 1, 14), 5],
            [gd(2012, 1, 15), 11],
            [gd(2012, 1, 16), 8],
            [gd(2012, 1, 17), 8],
            [gd(2012, 1, 18), 11],
            [gd(2012, 1, 19), 11],
            [gd(2012, 1, 20), 6],
            [gd(2012, 1, 21), 6],
            [gd(2012, 1, 22), 8],
            [gd(2012, 1, 23), 11],
            [gd(2012, 1, 24), 13],
            [gd(2012, 1, 25), 7],
            [gd(2012, 1, 26), 9],
            [gd(2012, 1, 27), 9],
            [gd(2012, 1, 28), 8],
            [gd(2012, 1, 29), 5],
            [gd(2012, 1, 30), 8],
            [gd(2012, 1, 31), 25]
        ];

        var data3 = [
            [gd(2012, 1, 1), 800],
            [gd(2012, 1, 2), 500],
            [gd(2012, 1, 3), 600],
            [gd(2012, 1, 4), 700],
            [gd(2012, 1, 5), 500],
            [gd(2012, 1, 6), 456],
            [gd(2012, 1, 7), 800],
            [gd(2012, 1, 8), 589],
            [gd(2012, 1, 9), 467],
            [gd(2012, 1, 10), 876],
            [gd(2012, 1, 11), 689],
            [gd(2012, 1, 12), 700],
            [gd(2012, 1, 13), 500],
            [gd(2012, 1, 14), 600],
            [gd(2012, 1, 15), 700],
            [gd(2012, 1, 16), 786],
            [gd(2012, 1, 17), 345],
            [gd(2012, 1, 18), 888],
            [gd(2012, 1, 19), 888],
            [gd(2012, 1, 20), 888],
            [gd(2012, 1, 21), 987],
            [gd(2012, 1, 22), 444],
            [gd(2012, 1, 23), 999],
            [gd(2012, 1, 24), 567],
            [gd(2012, 1, 25), 786],
            [gd(2012, 1, 26), 666],
            [gd(2012, 1, 27), 888],
            [gd(2012, 1, 28), 900],
            [gd(2012, 1, 29), 178],
            [gd(2012, 1, 30), 555],
            [gd(2012, 1, 31), 993]
        ];


        var dataset = [{
            label: "Number of orders",
            data: data3,
            color: "#1ab394",
            bars: {
                show: true,
                align: "center",
                barWidth: 24 * 60 * 60 * 600,
                lineWidth: 0
            }

        }, {
            label: "Payments",
            data: data2,
            yaxis: 2,
            color: "#1C84C6",
            lines: {
                lineWidth: 1,
                show: true,
                fill: true,
                fillColor: {
                    colors: [{
                        opacity: 0.2
                    }, {
                        opacity: 0.4
                    }]
                }
            },
            splines: {
                show: false,
                tension: 0.6,
                lineWidth: 1,
                fill: 0.1
            },
        }];


        var options = {
            xaxis: {
                mode: "time",
                tickSize: [3, "day"],
                tickLength: 0,
                axisLabel: "Date",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 10,
                color: "#d5d5d5"
            },
            yaxes: [{
                position: "left",
                max: 1070,
                color: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Arial',
                axisLabelPadding: 3
            }, {
                position: "right",
                clolor: "#d5d5d5",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: ' Arial',
                axisLabelPadding: 67
            }],
            legend: {
                noColumns: 1,
                labelBoxBorderColor: "#000000",
                position: "nw"
            },
            grid: {
                hoverable: false,
                borderWidth: 0
            }
        };

        function gd(year, month, day) {
            return new Date(year, month - 1, day).getTime();
        }

        var previousPoint = null,
            previousLabel = null;

        $.plot($("#flot-dashboard-chart"), dataset, options);

        var mapData = {
            "US": 298,
            "SA": 200,
            "DE": 220,
            "FR": 540,
            "CN": 120,
            "AU": 760,
            "BR": 550,
            "IN": 200,
            "GB": 120,
        };

        $('#world-map').vectorMap({
            map: 'world_mill_en',
            backgroundColor: "transparent",
            regionStyle: {
                initial: {
                    fill: '#e4e4e4',
                    "fill-opacity": 0.9,
                    stroke: 'none',
                    "stroke-width": 0,
                    "stroke-opacity": 0
                }
            },

            series: {
                regions: [{
                    values: mapData,
                    scale: ["#1ab394", "#22d6b1"],
                    normalizeFunction: 'polynomial'
                }]
            },
        });
    });
</script>
</body>

</html>