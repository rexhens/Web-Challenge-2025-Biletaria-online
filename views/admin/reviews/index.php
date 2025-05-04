<?php
// Include database connection
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

$query = "SELECT * FROM reviews";
$users_result = $conn->query($query);
?>

<?php
$pageTitle = 'Përdoruesit';
$pageStyles = [
    '/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css',
    '/biletaria_online/assets/css/sb-admin-2.min.css',
    "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i",
    "https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css",
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>

    <style>
        .dataTables_filter {
            display: none !important;
        }

        a.paginate_button:hover,
        a.paginate_button:disabled {
            background-color: #8f793f !important;
        }

        table.dataTable td,
        table.dataTable th {
            text-align: center;
            vertical-align: middle;
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
                <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Review-ve</h5>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Perdoruesi</th>
                                <th>Shfaqja</th>
                                <th>Vleresimi</th>
                                <th>Komenti</th>
                                <th>Veprime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = $users_result->fetch_assoc()) {
                                $show = $conn->query("SELECT * FROM shows WHERE id = " . $row['show_id'])->fetch_assoc();
                                ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php echo $show['title'] ?></td>
                                    <td><?php echo $row['rating'] ?></td>
                                    <td><?php echo $row['comment'] ?></td>
                                    <td>
                                        <div
                                            style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 8px; width: 110px;">


                                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                                                class="btn btn-sm btn-outline-danger" style="width: 100%;">
                                                Fshij
                                            </a>


                                        </div>
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

    <!-- 1. Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 2. Then load any plugins that depend on jQuery -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- 3. Then load your main template JS file -->
    <script src="/biletaria_online/assets/js/sb-admin-2.min.js"></script>

    <!-- 4. Optional: Other JS libraries -->
    <script src="/biletaria_online/assets/js/flatpickr.min.js"></script>


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
            "dom": 'rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 text-end"p>>',
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