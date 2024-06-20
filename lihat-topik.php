<?php

// Sertakan file koneksi.php atau inisialisasikan $koneksi di sini
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Konsultasi</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        :root {
            --bs-light-rgb: 248, 249, 250;
            --bs-dark-rgb: 33, 37, 41;
        }

        .col {
            flex: 1 0 0%;
        }

        .bg-light {
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important;
        }

        .fw-bold {
            font-weight: 700 !important;
            margin-left: 10px;
        }

        .col-auto {
            flex: 0 0 auto;
            width: auto;
        }

        .row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            width: auto;
            max-width: 100%;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(1 * var(--bs-gutter-x));
            margin-left: calc(0.5 * var(--bs-gutter-x));
        }

        .mt-2 {
            margin-top: 1rem !important;
            margin-bottom: 1rem;
            margin-left: calc(1 * var(--bs-gutter-x));
        }

        .mb-3 {
            margin-bottom: 1rem !important;
        }

        .text-muted {
            --bs-text-opacity: 1;
            color: #6c757d !important;
            margin-left: 10px;
        }

        .h2,
        h2 {
            font-size: calc(1.325rem + 0.9vw);
            margin-left: 10px
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
            margin-left: 10px;
        }

        a {
            color: #0d6efd;
            text-decoration: underline;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php include_once('sidebardiet.php'); ?>

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
                    <h2>Forum Konsultasi</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="active">
                            <strong>Konsultasi</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <hr>

            <div class="container">
                <?php
                if (isset($_GET['id']) && !empty($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT topik.*, users.nama, users.email FROM topik
                    INNER JOIN users ON topik.id_user=users.id
                    WHERE topik.id=?";
                    $query = $koneksi->prepare($sql);
                    if ($query) {
                        $query->bind_param('i', $id);
                        $query->execute();
                        $result = $query->get_result();
                        $topik = $result->fetch_assoc();
                        if (empty($topik)) {
                            echo '<p class="text-warning">Topik tidak ditemukan</p>';
                        } else {
                ?>
                            <div class="row mb-3">
                                <div class="col-auto">
                                    <img src="//www.gravatar.com/avatar/<?php echo md5($topik['email']); ?>?s=48&d=monsterid" class="rounded-circle" />
                                </div>
                                <div class="col">
                                    <div class="fw-bold"><?php
                                                            if (isset($_SESSION['user'])) {
                                                                echo htmlentities($_SESSION['user']['nama'] ?? '');
                                                            }
                                                            ?></div>
                                    <small class="text-muted"><?php echo date('d M Y H:i', strtotime($topik['tanggal'])); ?></small>
                                </div>
                            </div>
                            <h2><?php echo htmlentities($topik['judul']); ?></h2>
                            <p><?php echo nl2br(htmlentities($topik['deskripsi'])); ?></p>
                            <hr />
                            <?php
                            $sql2 = "SELECT komentar.*, users.nama, users.email FROM komentar
                             INNER JOIN users ON users.id = komentar.id_user
                             WHERE id_topik=?";
                            $query2 = $koneksi->prepare($sql2);
                            if ($query2) {
                                $query2->bind_param('i', $id);
                                $query2->execute();
                                $result2 = $query2->get_result();
                                while ($komentar = $result2->fetch_assoc()) {
                            ?>
                                    <div class="row mb-3">
                                        <div class="col-auto">
                                            <img src="//www.gravatar.com/avatar/<?php echo md5($komentar['email']); ?>?s=48&d=monsterid" class="rounded-circle" />
                                        </div>
                                        <div class="col">
                                            <div class="bg-light py-2 px-3 rounded">
                                                <div class="row gx-2">
                                                    <div class="col fw-bold">
                                                        <?php
                                                        if (isset($_SESSION['user'])) {
                                                            echo htmlentities($_SESSION['user']['nama'] ?? '');
                                                        }
                                                        ?> </div>
                                                    <?php
                                                    if ($_SESSION['user']['id'] == $komentar['id_user']) {
                                                    ?>
                                                        <div class="col-auto">
                                                            <a href="hapus-komentar.php?id=<?php echo $komentar['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')" class="text-muted"><small>Hapus</small></a>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="col-auto">
                                                        <small class="text-muted"><?php echo date('d M Y H:i', strtotime($komentar['tanggal'])); ?></small>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <?php echo nl2br(htmlentities($komentar['komentar'])); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                                $query2->close();
                            }
                            ?>
                            <hr />
                            <div class="row">
                                <div class="col-auto">
                                    <img src="//www.gravatar.com/avatar/<?php echo md5($_SESSION['user']['email']); ?>?s=48&d=monsterid" class="rounded-circle" />
                                </div>
                                <div class="col">
                                    <form method="POST" action="jawab-topik.php">
                                        <div class="mb-3">
                                            <textarea class="form-control" name="komentar" placeholder="Jawab topik"></textarea>
                                            <input type="hidden" value="<?php echo $topik['id']; ?>" name="id_topik" />
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-primary" type="submit">Kirim</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                <?php
                        }
                        $query->close();
                    } else {
                        echo "Error: " . $koneksi->error;
                    }
                }
                ?>
            </div>
        </div>
    </div>

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
            // Script JavaScript Anda
        });
    </script>
</body>

</html>