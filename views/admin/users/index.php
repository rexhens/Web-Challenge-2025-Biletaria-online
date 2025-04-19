<?php
// Include database connection
include_once '../../../config/db_connect.php';

// Fetch users from the database
$query = "SELECT * FROM users";
$users_result = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../../../includes/links.php'; ?>
    <meta property="og:image" content="../../../assets/img/metropol_icon.png">
    <link rel="icon" href="../../../assets/img/metropol_icon.png">
    <title>Teatri Metropol | Shto Përdorues</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">

    <link rel="stylesheet" href="/biletaria_online/assets/css/style-starter.css">

    <!-- Custom fonts for this template-->
    <link href="../../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Popper.js (required for Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="../../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../../assets/js/sb-admin-2.min.js"></script>


    <!-- Custom CSS --><!-- jQuery (duhet të vijë i pari) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


    <style>
       /* Table Styling */
    #userTable {
        border-collapse: collapse;
        width: 100%;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    #userTable thead {
        background-color: #8f793f;
        color: white;
    }

    #userTable th,
    #userTable td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    #userTable tbody tr:hover {
        background-color: #f5f5f5;
    }

    #userTable th {
        font-weight: bold;
    }

    /* Table Container */
    .table-responsive {
        margin: 20px auto;
        max-width: 95%;
    }

    /* Adjust card styling for better alignment */
    .card {
        margin: 20px auto;
        max-width: 95%;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #ddd;
    }

    /* Button Styling */
    .btn-primary-report {
        background-color: #8f793f;
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .btn-primary-report:hover {
        background-color: #6e5e2f;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .card {
            max-width: 100%;
            margin: 10px;
        }

        .table-responsive {
            margin: 10px;
        }
    }
        /* Adjust card styling for better alignment */
        .card {
            margin: 20px auto;
            max-width: 90%;
        }

        /* Button Styling */
        .btn-primary-report {
            background-color: #8f793f;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-primary-report:hover {
            background-color: #6e5e2f;
        }
    </style>

    
</head>

<body id="page-top">

    <div style="display: flex; justify-content: space-between; width: 100%;" id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background-color: #8f793f !important;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">

                <div class="sidebar-brand-text mx-3">Paneli i menaxhimit</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Raporti Mujor</span></a>
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
                    <span>Menaxho Perdoruesit</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Veprime</h6>
                        <a class="collapse-item" href="#">Shto perdorues te ri</a>
                        <a class="collapse-item" href="./index.php">Shiko te gjithe</a>
                    </div>
                </div>
            </li>


            <!-- Nav Item - Utilities Collapse Menu -->
            <!-- Menaxho Shfaqjet -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShows"
                    aria-expanded="true" aria-controls="collapseShows">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Menaxho Shfaqjet</span>
                </a>
                <div id="collapseShows" class="collapse" aria-labelledby="headingShows" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Veprime</h6>
                        <a class="collapse-item" href="../  ../add-show.php">Shto Shfaqje</a>
                        <a class="collapse-item" href="../../shows.php">Te gjitha Shfaqjet</a>
                    </div>
                </div>
            </li>

            <!-- Menaxho Aktoret -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActors"
                    aria-expanded="true" aria-controls="collapseActors">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Menaxho Aktoret</span>
                </a>
                <div id="collapseActors" class="collapse" aria-labelledby="headingActors"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Veprime</h6>
                        <a class="collapse-item" href="../actors/index.php">Te gjithe Aktoret</a>
                        <a class="collapse-item" href="../actors/add.php">Shto nje Aktor te ri</a>
                    </div>
                </div>
            </li>

            <!-- Menaxho Eventet -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvents"
                    aria-expanded="true" aria-controls="collapseEvents">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Menaxho Eventet</span>
                </a>
                <div id="collapseEvents" class="collapse" aria-labelledby="headingEvents"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Veprime</h6>
                        <a class="collapse-item" href="../events/add.php">Shto Event te ri</a>
                        <a class="collapse-item" href="../events/index.php">Te gjitha Eventet</a>
                    </div>
                </div>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div style="    display: flex;
                            align-items: center;
                            justify-content: center;">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>

            </div>

        </ul>

  
<section id="users-section">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary">Lista e Përdoruesve</h5>
            <button class="btn btn-sm btn-primary-report"
                onclick="window.location.href = './users/add-user.php'">Shto Përdorues</button>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


    </div>



</body>

</html>

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
                "info": "Duke shfaqur _START_ deri _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            }
        });
    });
</script>