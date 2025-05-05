<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

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

$events_query = "
    SELECT events.id, events.title, events.description, events.hall, events.time, events.price
    FROM events";
$events_result = $conn->query($events_query);

$reservations_query = "SELECT COUNT(*) as total FROM reservations";
$reservations_result = $conn->query($reservations_query);
$reservation_count = $reservations_result->fetch_assoc()['total'];

?>


<?php
$pageTitle = 'Paneli i Menaxhimit';
$pageStyles = [
    "/biletaria_online/assets/css/style-starter.css",
    "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i",
    "/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css",
    "/biletaria_online/assets/css/sb-admin-2.min.css",
    "https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>

    <style>
        .card-body {
            margin: 0 !important;

        }

        .bg-gold,
        a.paginate_button:hover,
        a.paginate_button:disabled {
            background-color: #8f793f !important;
        }

        .border-left-gold {
            border-left: 0.25rem solid #8f793f !important;
        }

        .text-gold {
            color: #8f793f !important;
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

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0% !important;
            margin: 0% !important;
            border: 0.3px solid transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border: none !important;
        }

        .paginate_button page-item active {
            border-color: transparent !important;
        }

        .page-item.active .page-link {
            border-color: #8f793f !important;
        }
    </style>

</head>


<body id="page-top">


    <!-- Sidebar -->
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>


    <!-- Main Content -->
    <div id="content" style="padding-top: 30px !important;">

        <!-- Begin Page Content -->
        <div class="container-fluid" style="background-color: white;">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Konrolli i Panelit te Adminit</h1>
                <?php if(checkAdmin($conn)){ ?>
                <a href="generate_report.php"
                    class="d-none d-sm-inline-block btn btn-sm btn-primary-report shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Gjenero nje report</a>
                <?php } ?>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="monthlyRevenue">LEK 0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Earnings (Yearly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-gold shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gold text-uppercase mb-1">
                                        Te ardhurat Vjetore</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="yearlyRevenue">LEK 0</div>
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
                                                <div class="progress-bar bg-gold" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <a href="reviews/index.php" style="text-decoration: none; color: #8f793f!important;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-gold text-uppercase mb-1">
                                        Review te shfaqjeve
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $reservation_count; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Graphs -->
            <div class="col-xl-8 col-lg-7" id="graphs-section">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
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
                                <i class="fas fa-circle text-success" style="color: #716a69 !important"></i> Ne
                                biletari
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela e userave -->
        <section id="users-section">
            <div class="card shadow border-0 rounded">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary-1">Lista e Përdoruesve</h5>
                    <?php if(checkAdmin($conn)){ ?>
                    <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'users/add-user.php'"
                        style="padding: 7px 20px;">+ Shto
                        Përdorues</button>
                    <?php } ?>
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
                                <?php
                                $i = 1;
                                while ($row = $users_result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['name'] . ' ' . $row['surname'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td><?php echo $row['phone'] ?></td>
                                        <td><?php echo $row['role'] ?></td>

                                    </tr>
                                    <?php
                                    $i++;
                                } ?>

                                <!-- Add more rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Menaxhimi i Shfaqjeve -->
        <div class="card shadow border-0 rounded-4 mt-5" id="shows-section">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 text-primary-1">Lista e Shfaqjeve</h5>
                <?php if(checkAdmin($conn)){ ?>
                <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'shows/add-show.php'"
                    style="padding: 7px 20px;">+ Shto Shfaqje</button>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="showsTable" class="table table-hover align-middle mb-0 w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Titulli</th>
                                <th>Salla</th>
                                <th>Zhanri</th>
                                <th>Çmimi</th>

                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <?php
                            $i = 1;
                            while ($row = $shows_result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-muted"><?php echo $i; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hall']); ?></td>
                                    <td><?php echo htmlspecialchars($row['genre_name']); ?></td>
                                    <td><?php echo number_format($row['price'], 2); ?> Leke</td>

                                </tr>
                                <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <!-- Menaxhimi i aktoreve -->
        <div class="card shadow border-0 rounded-4 mt-5" id="actors-section">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 text-primary-1">Lista e Aktorëve</h5>
                <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'actors/add.php'"
                    style="padding: 7px 20px;">+ Shto Aktor</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="actorsTable" class="table table-hover align-middle mb-0 w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Emri</th>
                                <th>Email</th>
                                <th>Datëlindja</th>
                                <th>Biografia</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <?php
                            $i = 1;
                            while ($row = $actors_result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-muted"><?php echo $i; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo date("d M Y", strtotime($row['birthday'])); ?></td>
                                    <td class="text-truncate" style="max-width: 200px;">
                                        <?php echo mb_strimwidth(strip_tags($row['description']), 0, 80, "..."); ?>
                                    </td>

                                </tr>
                                <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Menaxhimi i Eventeve -->
        <div class="card shadow border-0 rounded-4 mt-5" id="events-section" style="margin-bottom: 100px;">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 text-primary-1">Lista e Eventeve</h5>
                <?php if(checkAdmin($conn)){ ?>
                <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'events/add-event.php'"
                    style="padding: 7px 20px;">+ Shto Event
                </button>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="eventsTable" class="table table-hover align-middle mb-0 w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Titulli</th>
                                <th>Salla</th>
                                <th>Orari</th>
                                <th>Çmimi</th>

                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <?php
                            $i = 1;
                            while ($row = $events_result->fetch_assoc()) { ?>
                                <tr>
                                    <td class="text-muted"><?php echo $i; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hall']); ?></td>
                                    <td><?php echo htmlspecialchars($row['time']); ?></td>
                                    <td><?php echo number_format($row['price'], 2); ?> Leke</td>

                                </tr>
                                <?php
                                $i++;
                            } ?>
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

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery Plugins that depend on jQuery -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/biletaria_online/assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets/vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/chart-area-demo.js"></script>
    <script src="../../assets/js/demo/chart-pie-demo.js?v=2"></script>

    <script>
        $(document).ready(function () {
            $("#sidebarToggle").on('click', function (e) {
                e.preventDefault();
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
            });
        });
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
                    "info": "Duke shfaqur _END_ nga _TOTAL_",
                    "infoEmpty": "Nuk ka të dhëna"
                },
                "initComplete": function () {
                    $('.dataTables_filter input').wrap('<div class="position-relative"></div>');
                    $('.dataTables_filter input').before('<span class="search-icon" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%);"><i class="fas fa-search"></i></span>');
                    $('.dataTables_filter input').css({ 'padding-left': '40px' });
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
                "info": "Duke shfaqur _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            },
            "initComplete": function () {
                $('.dataTables_filter input').wrap('<div class="position-relative"></div>');
                $('.dataTables_filter input').before('<span class="search-icon" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%);"><i class="fas fa-search"></i></span>');
                $('.dataTables_filter input').css({ 'padding-left': '40px' });
            }
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
                "info": "Duke shfaqur _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            },
            "initComplete": function () {
                $('.dataTables_filter input').wrap('<div class="position-relative"></div>');
                $('.dataTables_filter input').before('<span class="search-icon" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%);"><i class="fas fa-search"></i></span>');
                $('.dataTables_filter input').css({ 'padding-left': '40px' });
            }
        });
        $('#eventsTable').DataTable({
            "pageLength": 5,
            "lengthChange": false,
            "dom": '<"row mb-3"<"col-12"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 text-end"p>>',
            "language": {
                "search": "",
                "searchPlaceholder": "Kërko event...",
                "paginate": {
                    "previous": "‹",
                    "next": "›"
                },
                "zeroRecords": "Asnjë rezultat i gjetur",
                "info": "Duke shfaqur _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            },
            "initComplete": function () {
                $('.dataTables_filter input').wrap('<div class="position-relative"></div>');
                $('.dataTables_filter input').before('<span class="search-icon" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%);"><i class="fas fa-search"></i></span>');
                $('.dataTables_filter input').css({ 'padding-left': '40px' });
            }
        });
    </script>

    <script>
        // Format numbers with thousands separator
        function formatCurrency(value) {
            return 'LEK ' + value.toLocaleString('en-US', { minimumFractionDigits: 0 });
        }

        // Load and inject monthly revenue
        fetch('../../includes/revenues.php?action=monthly')
            .then(response => response.json())
            .then(data => {
                document.getElementById('monthlyRevenue').textContent = formatCurrency(data);
            })
            .catch(error => console.error('Monthly revenue error:', error));

        // Load and inject yearly revenue
        fetch('../../includes/revenues.php?action=yearly')
            .then(response => response.json())
            .then(data => {
                document.getElementById('yearlyRevenue').textContent = formatCurrency(data);
            })
            .catch(error => console.error('Yearly revenue error:', error));
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