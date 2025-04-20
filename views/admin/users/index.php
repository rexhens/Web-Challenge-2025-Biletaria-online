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

    <!-- Styles -->
    <link rel="stylesheet" href="/biletaria_online/assets/css/style-starter.css">
    <link href="../../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Scripts (in proper order) -->

    <!-- jQuery (must come first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 with Popper included -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- sb-admin-2 (your custom template) -->
    <script src="../../../assets/js/sb-admin-2.min.js"></script>

    <!-- jQuery Easing (if used in sb-admin-2) -->
    <script src="../../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <style>
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

        .btn-primary-report {
            background-color: #8f793f !important;
            background-image: none !important;
            color: white !important;

        }

        #users-section {
            flex: 1;
            /* allows it to take all the remaining width */
            padding: 20px;
        }

        .card {
            width: 100%;
        }

        .table-responsive {
            width: 100%;
        }

        table.dataTable {
            width: 100% !important;
            /* forces table full width */
        }

        input {
            box-shadow: none !important;
        }
    </style>



</head>

<body id="page-top">

    <div style="display: flex; justify-content: flex-start; width: 100%; gap: 3%;" id="wrapper">
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
                        <a class="collapse-item" href="./add-user.php">Shto perdorues te ri</a>
                        <a class="collapse-item" href="#">Shiko te gjithe</a>
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
                    <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Përdoruesve</h5>
                    <button class="btn btn-sm btn-primary-report" onclick="window.location.href = './add-user.php'">Shto
                        Përdorues</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
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
                                            <button class="btn-sm btn-outline-secondary editUserBtn"
                                                data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"
                                                data-surname="<?php echo $row['surname'] ?>"
                                                data-email="<?php echo $row['email'] ?>"
                                                data-phone="<?php echo $row['phone'] ?>"
                                                data-role="<?php echo $row['role'] ?>">Edito</button>
                                            <button class="btn-sm btn-outline-danger">Fshij</button>
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
    <!-- Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edito Përdoruesin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Mbyll">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Fields -->
                    <form id="editUserForm" method="POST" action="edit.php">
                        <input type="hidden" id="editUserId" name="userId"> <!-- fixed name -->

                        <div class="form-group">
                            <label for="editName">Emri</label>
                            <input type="text" class="form-control" id="editName" name="emri"> <!-- added name -->
                        </div>

                        <div class="form-group">
                            <label for="editSurname">Mbiemri</label>
                            <input type="text" class="form-control" id="editSurname" name="mbiemri"> <!-- added name -->
                        </div>

                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email"> <!-- added name -->
                        </div>

                        <div class="form-group">
                            <label for="editPhone">Telefoni</label>
                            <input type="text" class="form-control" id="editPhone" name="telefoni"> <!-- optional -->
                        </div>

                        <div class="form-group">
                            <label for="editRole">Roli</label>
                            <select class="form-control" id="editRole" name="roli"> <!-- added name -->
                                <option value="admin">Admin</option>
                                <option value="biletari">Biletari</option>
                                <option value="perdorues">Përdorues</option>
                            </select>
                        </div>

                        <input type="hidden" name="formAction" id="formAction" value="edit">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" form="editUserForm"
                        style="background-color: #8f793f !important; border: #8f793f;">
                        Edito
                    </button>
                </div>
            </div>
        </div>
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
            "pageLength": 10,
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


    $(document).ready(function () {
        $('.editUserBtn').on('click', function () {
            const userId = $(this).data('id');
            const name = $(this).data('name');
            const surname = $(this).data('surname');
            const email = $(this).data('email');
            const phone = $(this).data('phone');
            const role = $(this).data('role');

            // Populate modal fields
            $('#editUserId').val(userId);
            $('#editName').val(name);
            $('#editSurname').val(surname);
            $('#editEmail').val(email);
            $('#editPhone').val(phone);
            $('#editRole').val(role);

            // Show the modal
            $('#editUserModal').modal('show');
        });

        // Example Save (You can handle this via AJAX)
        $('#saveUserBtn').on('click', function () {
            const userData = {
                id: $('#editUserId').val(),
                name: $('#editName').val(),
                surname: $('#editSurname').val(),
                email: $('#editEmail').val(),
                phone: $('#editPhone').val(),
                role: $('#editRole').val()
            };

            console.log("Saving user data:", userData);

            // You can send this data via AJAX to a PHP file for update.
            $('#editUserModal').modal('hide');
        });
    });

    $(document).ready(function () {
        $('.editBtn').on('click', function () {
            const button = $(this);
            $('#formAction').val('update');
            $('#userId').val(button.data('id'));
            $('#emri').val(button.data('emri'));
            $('#mbiemri').val(button.data('mbiemri'));
            $('#email').val(button.data('email'));
            $('#username').val(button.data('username'));
            $('#roli').val(button.data('role'));

            $('#addUserModalLabel').text('Përditëso Përdoruesin');
            $('#submitUserBtn').text('Ruaj Ndryshimet');
        });

        $('#addUserModal').on('hidden.bs.modal', function () {
            $('#userForm')[0].reset();
            $('#formAction').val('insert');
            $('#addUserModalLabel').text('Shto Përdorues');
            $('#submitUserBtn').text('Shto');
        });
    });

</script>