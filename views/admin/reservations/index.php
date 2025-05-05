<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

$filter = isset($_GET['show_id']) ? ' WHERE show_id = ' . $_GET['show_id'] : '';
$filter = isset($_GET['event_id']) ? ' WHERE event_id = ' . $_GET['event_id'] : $filter;

$query = "SELECT * FROM reservations" . $filter;
$reservations_result = $conn->query($query);
?>

<?php
$pageTitle = 'Rezervimet';
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
                <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Rezervimeve</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Klienti</th>
                                <th>Email</th>
                                <th>Numri i cel</th>
                                <th>Shfaqja/Eventi</th>
                                <th>Salla</th>
                                <th>Data</th>
                                <th>Statusi</th>
                                <th>Veprime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($row = $reservations_result->fetch_assoc()) {
                                if(!empty($row['show_id'])) {
                                    $sql = 'SELECT title FROM shows WHERE id = ?';
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('i', $row['show_id']);
                                    if (!$stmt->execute()) {
                                        showError("Një problem ndodhi! Provoni më vonë!");
                                    }
                                    $result = $stmt->get_result()->fetch_assoc();
                                    if (!$result) {
                                        showError("Shfaqja nuk u gjet!");
                                    }
                                    $title = $result['title'];
                                } else if(!empty($row['event_id'])) {
                                    $sql = 'SELECT title FROM events WHERE id = ?';
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param('i', $row['event_id']);
                                    if (!$stmt->execute()) {
                                        showError("Një problem ndodhi! Provoni më vonë!");
                                    }
                                    $result = $stmt->get_result()->fetch_assoc();
                                    if (!$result) {
                                        showError("Eventi nuk u gjet!");
                                    }
                                    $title = $result['title'];
                                }
                                ?>
                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo htmlspecialchars($row['full_name']) ?></td>
                                    <td><?php echo htmlspecialchars($row['email']) ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']) ?></td>
                                    <td><?php echo $title ?? 'Error' ?></td>
                                    <td><?php echo htmlspecialchars($row['hall']) ?></td>
                                    <td><?php echo htmlspecialchars($row['show_date']) . " " . htmlspecialchars($row['show_time']) ?></td>

                                    <?php if ($row['paid']) { ?>
                                        <td><span class="badge badge-success">Paguar</span></td>
                                    <?php } else if (htmlspecialchars($row['expires_at']) < new DateTime()) { ?>
                                        <td><span class="badge badge-danger">Kaluar afati</span></td>
                                    <?php } else { ?>
                                        <td><span class="badge badge-danger">Pa Pguar</span></td>
                                    <?php }?>
                                    <td>
                                        <div
                                            style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 8px; width: 150px;">
                                            <button class="btn btn-outline-success pay-btn"
                                                    style="width: 100%; font-size: smaller"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-name="<?php echo $row['full_name']?>"
                                                    data-title="<?php echo $title?>"
                                                    data-toggle="modal"
                                                    data-target="#activateUserModal">Shëno 'Paguar'</button>
                                            <button class="btn btn-outline-danger delete-btn"
                                                    style="width: 100%; font-size: smaller"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-name="<?php echo $row['full_name']?>"
                                                    data-title="<?php echo $title?>"
                                                    data-toggle="modal"
                                                    data-target="#deleteUserModal">Anullo Rezervimin</button>
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


    <!-- Delete Modal -->

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="activateUserModal" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="pay.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmo Pagesën</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të shënoni paguar rezervimin e <strong id="userToPayName"></strong> për shfaqjen/eventin <strong id="showToPayName"></strong>?</p>
                        <input type="hidden" name="id" id="activateUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="pay" class="btn btn-success">Shëno 'Paguar'</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Activate Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="delete.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="activateUserModalLabel">Konfirmo Anullimin e Rezervimit</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të anulloni rezervimin e <strong id="userToDeleteName"></strong> për shfaqjen/eventin <strong id="showToDeleteName">?
                        </p>
                        <input type="hidden" name="id" id="deleteUserId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kthehu</button>
                        <button type="submit" name="delete" class="btn btn-danger">Anullo Rezervimin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="/biletaria_online/assets/js/sb-admin-2.min.js"></script>

<script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>
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
            },
            "initComplete": function () {
                $('.dataTables_filter input').wrap('<div class="position-relative"></div>');
                $('.dataTables_filter input').before('<span class="search-icon" style="position: absolute; top: 50%; left: 20px; transform: translateY(-50%);"><i class="fas fa-search"></i></span>');
                $('.dataTables_filter input').css({ 'padding-left': '40px' });
            }
        });
    });

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

    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".pay-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const userId = button.getAttribute("data-id");
                const userName = button.getAttribute("data-name");
                const title = button.getAttribute("data-title");

                document.getElementById("activateUserId").value = userId;
                document.getElementById("userToPayName").textContent = userName;
                document.getElementById("showToPayName").textContent = title;
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