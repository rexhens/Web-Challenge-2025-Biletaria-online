<?php
// Include database connection
include_once '../../../config/db_connect.php';

// Fetch users from the database
$query = "SELECT * FROM actors";
$actors_result = $conn->query($query);
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


    <style>
        button:focus {
            outline: none;
            box-shadow: #8f793f !important;
            border-color: transparent;
            /* optional */
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

    <div style="display: flex; justify-content: flex-start; width: 100%; gap: 3%;" id="wrapper">
        <?php include_once '../../sidebar.php'; ?>


        <section id="users-section" style="margin-top: 1%;">
            <div class="card shadow-sm border-0 rounded">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Aktoreve</h5>
                    <button class="btn btn-sm btn-primary-report" onclick="window.location.href = './add.php'">Shto
                        Aktor</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
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
                                        <td><?php echo date("d M Y", strtotime($row['birthday'])); ?></td>
                                        <td class="text-truncate" style="max-width: 200px;">
                                            <?php echo mb_strimwidth(strip_tags($row['description']), 0, 80, "..."); ?>
                                        </td>
                                        <td class="text-end">
                                            <button class="btn-sm btn-outline-secondary editUserBtn"
                                                data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"
                                                data-email="<?php echo $row['email'] ?>"
                                                data-birthday="<?php echo $row['birthday'] ?>"
                                                data-biography="<?php echo $row['description'] ?>">
                                                Edito</button>
                                            <button class="btn-sm btn-outline-danger deleteUserBtn"
                                                data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"
                                                data-toggle="modal" data-target="#deleteUserModal">Fshij</button>
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
    <!-- Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edito Aktorin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Mbyll">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form Fields -->
                    <form id="editUserForm" method="POST" action="edit.php">
                        <input type="hidden" id="editUserId" name="id"> <!-- Hidden field for actor ID -->

                        <div class="form-group">
                            <label for="editName">Emri</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="editBirthday">Datëlindja</label>
                            <input type="date" class="form-control" id="editBirthday" name="birthday" required>
                        </div>

                        <div class="form-group">
                            <label for="editDescription">Biografia</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="4"
                                required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" form="editUserForm"
                        style="background-color: #8f793f !important; border: #8f793f;">
                        Ruaj Ndryshimet
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
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmo Fshirjen</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të fshini nga lista aktorin <strong id="userToDeleteName"></strong>?
                        </p>
                        <input type="hidden" name="id" id="deleteUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="deleteUserSubmit" class="btn btn-danger">Fshij</button>
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
                "searchPlaceholder": "Kërko aktor...",
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
            const biography = $(this).data('biography');
            const birthday = $(this).data('birthday');

            // Populate modal fields
            $('#editUserId').val(userId);
            $('#editName').val(name);
            $('#editSurname').val(surname);
            $('#editEmail').val(email);
            $('#editBirthday').val(birthday);

            $('#editDescription').val(biography);

            // Show the modal
            $('#editUserModal').modal('show');
        });

        // Example Save (You can handle this via AJAX)
        $('#saveUserBtn').on('click', function () {
            const userData = {
                id: $('#editUserId').val(),
                name: $('#editName').val(),
                email: $('#editEmail').val(),
                birthdate: $('#editBirthday').val(),
                description: $('#editDescription').val(),
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