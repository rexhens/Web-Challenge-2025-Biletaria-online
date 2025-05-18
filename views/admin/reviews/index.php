<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

$query = "SELECT * FROM reviews ORDER BY id DESC";
$users_result = $conn->query($query);
?>

<?php
$pageTitle = 'Vlerësime & Komente';
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

        .info-container {
            position: fixed !important;
            top: 10px !important;
            right: 20px !important;
            padding: 10px !important;
            display: flex !important;
            flex-direction: column !important;
            gap: 10px !important;
            width: 500px !important;
            z-index: 2000 !important;
        }

        .errors {
            background-color: #F44336FF !important;
            color: #E4E4E4FF !important;
            border-radius: 5px !important;
            padding: 10px !important;
            box-shadow: 0 0 10px 6px rgba(0, 0, 0, 0.2) !important;
            opacity: 0 !important;
            display: none !important;
        }

        .errors.expose {
            display: block !important;
            opacity: 1 !important;
            animation: fadeIn 0.5s ease-in-out !important;
        }

        .errors p {
            margin-bottom: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</head>

<body id="page-top">

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>

    <?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
        <div class="info-container">
            <div class='errors expose' style='background-color: rgba(131, 173, 68) !important'>
                <p>Ndryshimet u kryen me sukses</p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['update']) && isset($_GET['message']) && $_GET['update'] === 'error'): ?>
        <div class="info-container">
            <div class='errors expose'>
                <p><?= urldecode($_GET['message']) ?></p>
            </div>
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
                                <th>Përdoruesi</th>
                                <th>Shfaqja</th>
                                <th>Vlerësimi</th>
                                <th>Komenti</th>
                                <th>Veprime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = $users_result->fetch_assoc()) {
                                $show = $conn->query("SELECT title FROM shows WHERE id = " . $row['show_id'])->fetch_assoc();
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

                                            <button class="btn btn-sm btn-outline-danger delete-btn"
                                                    style="width: 100%;"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-name="<?php echo $row['email']?>"
                                                    data-title="<?php echo $show['title']?>"
                                                    data-toggle="modal"
                                                    data-target="#deleteUserModal">Fshij
                                            </button>
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

    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="delete.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="activateUserModalLabel">Konfirmo Fshirjen</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të fshini vlerësimin dhe komentin e <strong id="userToDeleteName"></strong> për shfaqjen/eventin <strong id="showToDeleteName">?
                        </p>
                        <input type="hidden" name="id" id="deleteUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anullo</button>
                        <button type="submit" name="delete" class="btn btn-danger">Fshij</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="/biletaria_online/assets/js/flatpickr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            "pageLength": 10,
            "lengthChange": false,

            "language": {
                "search": "",
                "searchPlaceholder": "Kërko koment...",
                "paginate": {
                    "previous": "‹",
                    "next": "›"
                },
                "zeroRecords": "Asnjë rezultat i gjetur",
                "info": "Duke shfaqur _START_ deri _END_ nga _TOTAL_",
                "infoEmpty": "Nuk ka të dhëna"
            },
            "initComplete": function () {
                $('.dataTables_filter input').wrap('<div class="position-relative"></div>');
                $('.dataTables_filter input').before('<span class="search-icon" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%);"><i class="fas fa-search"></i></span>');
                $('.dataTables_filter input').css({ 'padding-left': '40px' });
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const userId = button.getAttribute("data-id");
                const userName = button.getAttribute("data-name");
                const title = button.getAttribute("data-title");

                document.getElementById("deleteUserId").value = userId;
                document.getElementById("userToDeleteName").textContent = userName;
                document.getElementById("showToDeleteName").textContent = title;
            });
        });
    });
</script>

    <script>
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('update');
            url.searchParams.delete('message');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    </script>

    <script>
        const elementsToHide = document.getElementsByClassName("expose");
        setTimeout(() => {
            Array.from(elementsToHide).forEach((el) => el.classList.remove("expose"))
        }, 5000);
    </script>

</body>

</html>