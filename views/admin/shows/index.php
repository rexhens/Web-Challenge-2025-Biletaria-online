<?php
// Include database connection
include_once '../../../config/db_connect.php';

// Fetch users from the database
$query = "SELECT * FROM shows";
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
        table.dataTable td,
        table.dataTable th {
            text-align: center;
            vertical-align: middle;
        }

        td.desc-col {
            max-width: 200px;
            max-height: 6em;
            /* ~4 lines if font-size is ~1.5em */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
            word-break: break-word;
            padding: 5px;
            line-height: 1.5em;
            position: relative;
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

    <div style="display: flex; justify-content: flex-start; width: 100%;" id="wrapper">
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
                        <a class="collapse-item" href=".././add-user.php">Shto perdorues te ri</a>
                        <a class="collapse-item" href="../../index.php">Shiko te gjithe</a>
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
                        <a class="collapse-item" href="../../add-show.php">Shto Shfaqje</a>
                        <a class="collapse-item" href="#">Te gjitha Shfaqjet</a>
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
                        <a class="collapse-item" href=".././actors/index.php">Te gjithe Aktoret</a>
                        <a class="collapse-item" href=".././actors/add.php">Shto nje Aktor te ri</a>
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
                    <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Shfaqjeve</h5>
                    <button class="btn btn-sm btn-primary-report" onclick="window.location.href = './add-user.php'">Shto
                        Shaqje</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Titulli</th>
                                    <th>Salla</th>
                                    <th>Zhaneri</th>
                                    <th>Ora</th>
                                    <th>Cmimi i biletes</th>
                                    <th>Prioriteti</th>
                                    <th>Pershkrimi</th>
                                    <th>Veprime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $users_result->fetch_assoc()) {
                                    $genre_id = $row['genre_id'];
                                    $genre = $conn->query("SELECT * FROM genres WHERE id = $genre_id");
                                    $genreData = $genre->fetch_assoc();
                                    ?>

                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['title'] ?></td>
                                        <td><?php echo $row['hall'] ?></td>
                                        <td><?php echo $genreData['genre_name'] ?></td>
                                        <td><?php echo $row['time'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <?php if ($row['priority'] == 1) { ?>
                                            <td><span class="badge badge-success">Aktiv</span></td>
                                        <?php } else { ?>
                                            <td><span class="badge badge-danger">Jo Aktiv</span></td>
                                        <?php } ?>
                                        <td class="desc-col"> <?php echo $row['description'] ?></td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <div
                                                style="display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <button class="btn btn-sm btn-outline-secondary editShowBtn"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-title="<?php echo $row['title'] ?>"
                                                    data-hall="<?php echo $row['hall'] ?>"
                                                    data-genre="<?php echo $row['genre_id'] ?>"
                                                    data-time="<?php echo $row['time'] ?>"
                                                    data-description="<?php echo $row['description'] ?>"
                                                    data-trailer="<?php echo $row['trailer'] ?>"
                                                    data-price="<?php echo $row['price'] ?>">
                                                    Edito
                                                </button>

                                                <?php if ($row['priority'] == 1) { ?>
                                                    <button class="btn-sm btn-outline-danger deleteUserBtn"
                                                        data-id="<?php echo $row['id'] ?>"
                                                        data-name="<?php echo $row['title'] ?>" data-toggle="modal"
                                                        data-target="#deleteUserModal">Hiq
                                                        Prioritet</button>
                                                <?php } else { ?>
                                                    <button class="btn-sm btn-outline-success activateUserBtn"
                                                        data-id="<?php echo $row['id'] ?>"
                                                        data-name="<?php echo $row['title'] ?>" data-toggle="modal"
                                                        data-target="#activateUserModal">Shto
                                                        Prioritet</button>
                                                <?php } ?>
                                            </div>
                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>


        <?php
        $genresQuery = "SELECT * FROM genres";
        $genresResult = mysqli_query($conn, $genresQuery);
        $genres = [];
        while ($row = mysqli_fetch_assoc($genresResult)) {
            $genres[] = $row;
        }
        ?>

    </div>

    <!-- Edit Show Modal -->
    <div class="modal fade" id="editShowModal" tabindex="-1" aria-labelledby="editShowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editShowForm" method="POST" action="edit_show.php" enctype="multipart/form-data"
                class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editShowModalLabel">Edito Shfaqjen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Mbyll">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="show_id" id="editShowId">

                    <div class="form-group">
                        <label for="editTitle">Titulli</label>
                        <input type="text" class="form-control" name="title" id="editTitle" required>
                    </div>

                    <div class="form-group">
                        <label for="editHall">Salla</label>
                        <select name="hall" id="editHall" class="form-control" required>
                            <option value="Shakespare">Shakespare</option>
                            <option value="Cehov">Cehov</option>
                            <option value="Bodrum">Bodrum</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editGenre">Zhanri</label>
                        <select name="genre_id" id="editGenre" class="form-control" required>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?= $genre['id'] ?>"><?= $genre['genre_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="editTime">Ora</label>
                        <input type="text" class="form-control" name="time" id="editTime" required>
                    </div>

                    <div class="form-group">
                        <label for="editDescription">Përshkrimi</label>
                        <textarea class="form-control" name="description" id="editDescription" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="editTrailer">Trailer</label>
                        <input type="text" class="form-control" name="trailer" id="editTrailer" required>
                    </div>

                    <div class="form-group">
                        <label for="editPrice">Çmimi</label>
                        <input type="number" class="form-control" name="price" id="editPrice" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #8f793f; border: none;">
                        Ruaj Ndryshimet
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Delete Modal -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="remove_priority.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmo Heqjen e Prioritetit</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të hiqni prioritetin e shfaqjes <strong id="userToDeleteName"></strong>
                            duke e bere ate te mos jete me e dukshme ne faqen kryesore te teatrit?
                        </p>
                        <input type="hidden" name="userId" id="deleteUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="deleteUserSubmit" class="btn btn-danger">Hiq prioritet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activate Confirmation Modal -->
    <div class="modal fade" id="activateUserModal" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="prioritaze.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="activateUserModalLabel">Konfirmo Shtimin e Prioritetit</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të shtoni prioritetin e shfaqjes <strong
                                id="userToActivateName"></strong>
                            duke e bere ate te jete e dukshme ne faqen kryesore te teatrit?
                        </p>
                        <input type="hidden" name="userId" id="activateUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="activateUserSubmit" class="btn btn-success">Shto Prioritet</button>
                    </div>
                </div>
            </form>
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

            $('#addUserModalLabel').text('Përditëso Shfaqjen');
            $('#submitUserBtn').text('Ruaj Ndryshimet');
        });

        $('#addUserModal').on('hidden.bs.modal', function () {
            $('#userForm')[0].reset();
            $('#formAction').val('insert');
            $('#addUserModalLabel').text('Shto Shfaqje');
            $('#submitUserBtn').text('Shto');
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".deleteUserBtn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const userId = button.getAttribute("data-id");
                const userName = button.getAttribute("data-name");

                document.getElementById("deleteUserId").value = userId;
                document.getElementById("userToDeleteName").textContent = userName;
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".activateUserBtn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const userId = button.getAttribute("data-id");
                const userName = button.getAttribute("data-name");

                document.getElementById("activateUserId").value = userId;
                document.getElementById("userToActivateName").textContent = userName;
            });
        });
    });

    document.querySelectorAll('.editShowBtn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('editShowId').value = this.dataset.id;
            document.getElementById('editTitle').value = this.dataset.title;
            document.getElementById('editHall').value = this.dataset.hall;
            document.getElementById('editGenre').value = this.dataset.genre;
            document.getElementById('editTime').value = this.dataset.time;
            document.getElementById('editDescription').value = this.dataset.description;
            document.getElementById('editTrailer').value = this.dataset.trailer;
            document.getElementById('editPrice').value = this.dataset.price;

            // Open the modal
            $('#editShowModal').modal('show');
        });
    });

</script>