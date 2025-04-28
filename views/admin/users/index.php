<?php
// Include database connection
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';

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
      <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>

        <?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show fixed-top text-center rounded-5 m-0" role="alert"
                 style="z-index: 1050; top: 10px; right: 10px; left: auto; max-width: 500px; background-color: rgba(131, 173, 68); color: #224212;">
                Ndryshimet u kryen me sukses!
                <button type="button" class="close position-absolute end-0 me-3" data-dismiss="alert" aria-label="Close"
                        style="top: 50%; transform: translateY(-50%);">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <section id="users-section">
            <div class="card shadow border-0 rounded">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Përdoruesve</h5>
                    <button class="btn btn-sm btn-primary-report"
                            onclick="window.location.href = 'add-user.php'"
                            style="padding: 7px 20px;">Shto Përdorues</button>
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
                                <?php
                                $i = 1;
                                while ($row = $users_result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['name'] . ' ' . $row['surname'] ?></td>
                                        <td><?php echo $row['email'] ?></td>
                                        <td><?php echo $row['phone'] ?></td>
                                        <td><?php echo $row['role'] ?></td>

                                        <?php if ($row['status'] == 'active') { ?>
                                            <td><span class="badge badge-success">Aktiv</span></td>
                                        <?php } else { ?>
                                            <td><span class="badge badge-danger">Jo Aktiv</span></td>
                                        <?php } ?>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary editUserBtn"
                                                    style="width: 48%;"
                                                data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"
                                                data-surname="<?php echo $row['surname'] ?>"
                                                data-email="<?php echo $row['email'] ?>"
                                                data-phone="<?php echo $row['phone'] ?>"
                                                data-role="<?php echo $row['role'] ?>"
                                                data-status="<?php echo $row['status'] ?>">Edito</button>
                                            <?php if ($row['status'] == 'active') { ?>
                                                <button class="btn btn-sm btn-outline-danger deleteUserBtn"
                                                        style="width: 48%;"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-name="<?php echo $row['name'] . ' ' . $row['surname'] ?>"
                                                    data-toggle="modal" data-target="#deleteUserModal">Caktivizo</button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-outline-success activateUserBtn"
                                                        style="width: 48%;"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-name="<?php echo $row['name'] . ' ' . $row['surname'] ?>"
                                                    data-toggle="modal" data-target="#activateUserModal">Aktivizo</button>
                                            <?php } ?>
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
        </section>


    </div>
    <!-- Edit Modal -->
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
                                <option value="admin">Administrator</option>
                                <option value="ticketOffice">Biletari</option>
                                <option value="user">Përdorues</option>
                            </select>
                        </div>
                        <input type="hidden" name="formAction" id="formAction" value="edit">
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" form="editUserForm" name="edit-user"
                        style="background-color: #8f793f !important; border: #8f793f;">Edito
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="delete.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmo Caktivizimin</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të caktivizoni perdoruesin <strong id="userToDeleteName"></strong>?</p>
                        <input type="hidden" name="userId" id="deleteUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="deleteUserSubmit" class="btn btn-danger">Caktivizo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activate Confirmation Modal -->
    <div class="modal fade" id="activateUserModal" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="activate.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="activateUserModalLabel">Konfirmo Aktivizimin</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të aktivizoni perdoruesin <strong id="userToActivateName"></strong>?
                        </p>
                        <input type="hidden" name="userId" id="activateUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="activateUserSubmit" class="btn btn-success">Aktivizo</button>
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
                $('.dataTables_filter input').css({'padding-left': '40px'});
            }
        });
    });

    let initialFormData;

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

            initialFormData = $('#editUserForm').serializeArray();

            // Show the modal
            $('#editUserModal').modal('show');
        });
    });

    function isFormChanged() {
        let currentFormData = $('#editUserForm').serializeArray();

        for (let i = 0; i < initialFormData.length; i++) {
            if (initialFormData[i].value !== currentFormData[i].value) {
                return true;
            }
        }

        return false;
    }

    $('#editUserForm').submit(function (e) {
        if (!isFormChanged()) {
            e.preventDefault();
            alert('Nuk ka asnjë ndryshim për të ruajtur.');
        }
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
</script>

<script>
    if (window.history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('update');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
</script>