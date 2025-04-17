<?php
require_once '../../config/db_connect.php';

$users_query = 'SELECT * FROM users';
$users_result = $conn->query($users_query);

$actors_query = 'SELECT * FROM actors';
$actors_result = $conn->query($actors_query);
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

    <link rel="icon" type="image/x-icon" href="../../assets/img/metropol_icon.png">
    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
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

        #content-wrapper,
        .main-content {
            margin-left: 250px;

            /* adjust if your sidebar is wider/narrower */
        }

        body {
            overflow-x: hidden;
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
    </style>

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">

                <div class="sidebar-brand-text mx-3">Paneli i menaxhimit</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboardi</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Grafiket</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menaxhimi
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Menaxho Userat</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
                    </div>
                </div>
            </li>


            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Menaxho Shfaqjet</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Shfaqjet</h6>
                        <a class="collapse-item" href="utilities-color.html">Shto Shfaqje</a>
                        <a class="collapse-item" href="utilities-border.html">Shiko Shfaqjet</a>

                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->


            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
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
                        <a href="generate_report.php"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Gjenero nje report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Te ardhurat Mujore</div>
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
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Karrige
                                                te zena
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
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
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
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
                                    <h6 class="m-0 font-weight-bold text-primary">Te ardhurat e gjeneruara kete vit</h6>
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
                                            <a class="dropdown-item" href="#">Media sociale</a>
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
                                    <h6 class="m-0 font-weight-bold text-primary">Prenotimi i biletave </h6>
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
                                            <a class="dropdown-item" href="#">Media sociale</a>
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
                                            <i class="fas fa-circle text-primary"></i> Online
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Ne biletari
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Media sociale
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Tabela e userave -->
                    <section id="users-section">
                        <div class="card shadow-sm border-0 rounded" style="margin-left: 5%; margin-right: 5%;">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-primary">Lista e Përdoruesve</h5>
                                <button class="btn btn-sm btn-outline-primary">Shto Përdorues</button>
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
                                                <th>Statusi</th>
                                                <th>Veprime</th>
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
                                                    <td><span class="badge badge-success">Aktiv</span></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-secondary">Edito</button>
                                                        <button class="btn btn-sm btn-outline-danger">Fshij</button>
                                                    </td>
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

                    <div class="card shadow-sm border-0 rounded-4 mt-5" id="shows-section"
                        style="margin-left: 1%; margin-right: 0%;">
                        <h1 style="margin: 0;">Menaxho Shfaqjet</h1>
                        <button>Shiko te gjitha</button>


                        <div class="shows-container" id="shows-container"></div>
                    </div>


                    <!-- Menaxhimi i aktoreve -->
                    <div class="card shadow-sm border-0 rounded-4 mt-5" style="margin-left: 5%; margin-right: 5%;">
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

    <script>
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        async function fetchFilteredShows() {
            const genre = "";
            const dateFilterValue = "admin";

            try {
                const response = await fetch('../filter_shows.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `show_time_filter=${encodeURIComponent(dateFilterValue)}&genre_id=${encodeURIComponent(genre)}`,
                });

                const html = await response.text();
                const showsContainer = document.getElementById("shows-container");
                showsContainer.innerHTML = html;

                document.querySelectorAll('.show-card').forEach(card => {
                    observer.observe(card);
                });

            } catch (error) {
                console.error('Error fetching shows:', error);
                document.getElementById("shows-container").innerHTML = "<div class='errors show'><p>Gabim gjatë filtrimit!</p></div>";
            }
        }



        fetchFilteredShows();
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/chart-area-demo.js"></script>
    <script src="../../assets/js/demo/chart-pie-demo.js?v=2"></script>
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

    </script>

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
            $('a[data-target="#collapseUtilities"]').on('click', function (e) {
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
    </script>



</body>

</html>