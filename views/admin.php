<?php
require_once '../config/db_connect.php';

$users_query = 'SELECT * FROM users';
$users_result = $conn->query($users_query);

$actors_query = 'SELECT * FROM actors';
$actors_result = $conn->query($actors_query);

$shows_query = "
    SELECT shows.id, shows.title, shows.description, shows.hall, genres.genre_name, shows.price
    FROM shows
    JOIN genres ON shows.genre_id = genres.id
";
$shows_result = $conn->query($shows_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Paneli i Adminit</title>


    <link rel="stylesheet" href="/biletaria_online/assets/css/style-starter.css">

    <link rel="icon" type="image/x-icon" href="../assets/img/metropol_icon.png">
    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .bg-gold {
            background-color: #8f793f !important;
        }

        .border-left-gold {
            border-left: 0.25rem solid #8f793f !important;
        }

        .text-gold {
            color: #8f793f !important;
        }

        #accordionSidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            height: 100vh;
            z-index: 1030;
            /* make sure it stays on top */
            overflow-y: auto;
            background-color: #8f793f !important;
            background-image: none !important;
            /* removes gradient */
        }

        .btn-primary-report {
            background-color: #8f793f !important;
            background-image: none !important;
            color: white !important;

        }

        #content-wrapper,
        .main-content {
            margin-left: 250px;

            /* adjust if your sidebar is wider/narrower */
        }

        body {
            overflow-x: hidden;
        }

        a.page-link {
            background-color: #8f793f !important;
            /* or your theme color */
            color: white !important;
            box-shadow: none !important;
        }

        .page-item.active .page-link {
            border-color: #8f793f;
        }

        .text-primary-1 {
            color: #8f793f !important;
        }

        .text-success {
            color: #8f793f !important;
        }


        .show-overlay h3 {
            font-family: "Russo One", sans-serif !important;
            margin: 0 0 10px !important;
            font-size: 1.8rem !important;
            color: white !important;
            font-weight: 900 !important;
        }


        .show-overlay h3 span {
            color: #836e4f;
            font-family: "Russo One", sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
        }

        .show-overlay .show-dates span {
            font-size: 0.95rem;
            margin-bottom: 10px;
            color: #836e4f;
        }

        #reservationBtn {
            background-color: #836e4f;
        }

        .custom-size {
            width: 183px;
            height: 75px;
            object-fit: cover;
            /* Ensures images are resized without distortion */
        }

        .dataTables_filter {
            width: 100%;
            margin-bottom: 1rem;
        }

        .dataTables_filter label {
            width: 100%;
            display: flex;
        }

        .dataTables_filter input {
            flex: 1;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            height: 50px;
        }

        #wrapper {
            margin-top: 80px;
        }

        #wrapper #content-wrapper {
            background-color: white;
        }

        .shows-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            justify-items: center;
        }

        /* Card Style */
        .show-card {
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            max-width: 300px;
            height: 400px;
            position: relative;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .show-card:hover {
            transform: translateY(-5px);
        }




        .show-overlay p.show-description {
            display: none !important;
        }

        .btn-group button:nth-child(2) {
            display: none !important;
        }

        /* Animation for overlay */
        @keyframes slideUp {
            from {
                transform: translateY(50%);
                opacity: 0;
            }

            to {
                transform: translateY(0%);
                opacity: 1;
            }
        }

        /* Overlay content */
        .show-overlay h3,
        .show-overlay p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }

        .show-overlay span {
            font-weight: bold;
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-group button {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-group button:hover {
            transform: scale(1.05);
        }

        .black-btn {
            background-color: #111;
            color: #fff;
        }

        .btn-group button:not(.black-btn) {
            background-color: #f0f0f0;
            color: #333;
        }

        @media (max-width: 768px) {
            #content-wrapper {
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
        }

        #content-wrapper {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Kur sidebar është i toggled = i vogël */
        body.sidebar-toggled #content-wrapper {
            margin-left: 100px;
            /* ose 0px nëse sidebar fshihet totalisht */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0% !important;
            margin: 0% !important;
            border: 0.3px solid transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border: none !important;
        }

        .paginate_button page-item active {
            border-color: none !important;
        }

        .page-item.active .page-link {
            border-color: #8f793f !important;
        }
    </style>

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include './admin/users/sidebar.php'; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Konrolli i Panelit te Adminit</h1>
                        <a href="admin/generate_report.php"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary-report shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Gjenero nje report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-gold shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-gold text-uppercase mb-1">
                                                Te ardhurat Mujore
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-gold shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-gold text-uppercase mb-1">
                                                Te ardhurat Vjetore</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-gold shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-gold text-uppercase mb-1">Karrige
                                                te zena
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-gold" role="progressbar"
                                                            style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-gold shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-gold text-uppercase mb-1">
                                                Review te shfaqjeve</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Graphs -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary-1">Te ardhurat e gjeneruara kete vit
                                    </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Gjenerimi i shitjeve:</div>
                                            <a class="dropdown-item" href="#">Online</a>
                                            <a class="dropdown-item" href="#">Ne biletari</a>
                                            <div class="dropdown-divider"></div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary-1">Prenotimi i biletave </h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Online</a>
                                            <a class="dropdown-item" href="#">ne biletari</a>
                                            <div class="dropdown-divider"></div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary-1"></i> Online
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Ne biletari
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabela e userave -->
                    <section id="users-section">
                        <div class="card shadow-sm border-0 rounded">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-primary-1">Lista e Përdoruesve</h5>
                                <button class="btn btn-sm btn-primary-report"
                                    onclick="window.location.href = 'admin/users/add-user.php'">Shto Përdorues</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="userTable" class="table table-hover mb-0 w-100">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Emri</th>
                                                <th>Email</th>
                                                <th>Numri i cel</th>
                                                <th>Roli</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row = $users_result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $row['id'] ?></td>
                                                    <td><?php echo $row['name'] . ' ' . $row['surname'] ?></td>
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['phone'] ?></td>
                                                    <td><?php echo $row['role'] ?></td>

                                                </tr>
                                            <?php } ?>

                                            <!-- Add more rows here -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Menaxhimi i Shfaqjeve -->
                    <div class="card shadow-sm border-0 rounded-4 mt-5" id="shows-section">
                        <div
                            class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-semibold text-dark">Shfaqjet</h5>
                            <button class="btn btn-sm btn-primary-report">+ Shto Shfaqje</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="showsTable" class="table table-hover align-middle mb-0 w-100">
                                    <thead class="table-light text-secondary small text-uppercase">
                                        <tr>
                                            <th>ID</th>
                                            <th>Titulli</th>
                                            <th>Salla</th>
                                            <th>Zhanri</th>
                                            <th>Çmimi</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        <?php while ($row = $shows_result->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="text-muted"><?php echo $row['id']; ?></td>
                                                <td class="fw-medium"><?php echo htmlspecialchars($row['title']); ?></td>
                                                <td><?php echo htmlspecialchars($row['hall']); ?></td>
                                                <td><?php echo htmlspecialchars($row['genre_name']); ?></td>
                                                <td><?php echo number_format($row['price'], 2); ?> €</td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <!-- Menaxhimi i aktoreve -->
                    <div class="card shadow-sm border-0 rounded-4 mt-5" id="actors-section">
                        <div
                            class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-semibold text-dark">Aktorët</h5>
                            <button class="btn btn-sm btn-outline-primary">+ Shto Aktor</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="actorsTable" class="table table-hover align-middle mb-0 w-100">
                                    <thead class="table-light text-secondary small text-uppercase">
                                        <tr>
                                            <th>ID</th>
                                            <th>Emri</th>
                                            <th>Email</th>
                                            <th>Datëlindja</th>
                                            <th>Biografia</th>
                                            <th class="text-end">Veprime</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-dark">
                                        <?php while ($row = $actors_result->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="text-muted"><?php echo $row['id']; ?></td>
                                                <td class="fw-medium"><?php echo htmlspecialchars($row['name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td><?php echo date("d M Y", strtotime($row['birthdate'])); ?></td>
                                                <td class="text-truncate" style="max-width: 200px;">
                                                    <?php echo mb_strimwidth(strip_tags($row['biography']), 0, 80, "..."); ?>
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-sm btn-outline-secondary">Shiko</button>
                                                    <button class="btn btn-sm btn-outline-danger">Fshij</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/chart-area-demo.js"></script>
    <script src="../assets/js/demo/chart-pie-demo.js?v=2"></script>
    <!-- DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                "pageLength": 5,
                "lengthChange": false,
                "dom": '<"row mb-3"<"col-12"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 text-end"p>>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Kërko perdorues...",
                    "paginate": {
                        "previous": "‹",
                        "next": "›"
                    },
                    "zeroRecords": "Asnjë rezultat i gjetur",
                    "info": "Duke shfaqur _START_ deri _END_ nga _TOTAL_",
                    "infoEmpty": "Nuk ka të dhëna"
                }
            });
        });
        $('#actorsTable').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "dom": '<"row mb-3"<"col-12"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 text-end"p>>',
            "language": {
                "search": "",
                "searchPlaceholder": "Kërko aktorë...",
                "paginate": {
                    "previous": "‹",
                    "next": "›"
                },
                "zeroRecords": "Asnjë rezultat i gjetur",
                "info": "Duke shfaqur _START_ deri _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            },
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ]
        });
        $('#showsTable').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "dom": '<"row mb-3"<"col-12"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 text-end"p>>',
            "language": {
                "search": "",
                "searchPlaceholder": "Kërko shfaqje...",
                "paginate": {
                    "previous": "‹",
                    "next": "›"
                },
                "zeroRecords": "Asnjë rezultat i gjetur",
                "info": "Duke shfaqur _START_ deri _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            }
        });

    </script>

    <!-- Scripts for the sidebar movement -->
    <script>
        $(document).ready(function () {
            // Scroll to utilities section when Utilities nav link is clicked
            $('a[data-target="#collapseTwo"]').on('click', function (e) {
                // Small delay to ensure collapse opens first
                setTimeout(function () {
                    const target = $('#users-section');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 600); // 600ms for smooth scroll
                    }
                }, 300); // delay a bit to allow the collapse animation
            });
        });
        $(document).ready(function () {
            // Scroll to utilities section when Utilities nav link is clicked
            $('a[data-target="#collapseShows"]').on('click', function (e) {
                // Small delay to ensure collapse opens first
                setTimeout(function () {
                    const target = $('#shows-section');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 600); // 600ms for smooth scroll
                    }
                }, 300); // delay a bit to allow the collapse animation
            });
        });

        $(document).ready(function () {
            // Scroll to utilities section when Utilities nav link is clicked
            $('a[data-target="#collapseActors"]').on('click', function (e) {
                // Small delay to ensure collapse opens first
                setTimeout(function () {
                    const target = $('#actors-section');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 600); // 600ms for smooth scroll
                    }
                }, 300); // delay a bit to allow the collapse animation
            });
        });

        $(document).ready(function () {
            // Scroll to utilities section when Utilities nav link is clicked
            $('a[data-target="#collapseEvents"]').on('click', function (e) {
                // Small delay to ensure collapse opens first
                setTimeout(function () {
                    const target = $('#events-section');
                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 600); // 600ms for smooth scroll
                    }
                }, 300); // delay a bit to allow the collapse animation
            });
        });
    </script>



</body>

</html>