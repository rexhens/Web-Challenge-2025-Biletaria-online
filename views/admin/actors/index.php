<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdmin($conn);

$query = "SELECT * FROM actors";
$actors_result = $conn->query($query);
?>

<?php
$pageTitle = 'Përdoruesit';
$pageStyles = [
    '/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css',
    '/biletaria_online/assets/css/sb-admin-2.min.css',
    "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i",
    "/biletaria_online/assets/css/flatpickr.min.css",
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
        button:focus {
            outline: none;
            border-color: transparent;
            /* optional */
        }

        table.dataTable td,
        table.dataTable th {
            text-align: center;
            vertical-align: middle;
        }

        .desc-col {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 8;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: calc(1.4em * 8);
            line-height: 1.4em;
            max-width: 350px;
            white-space: normal;
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


    <section id="users-section" style="margin-top: 1%;">
        <div class="card shadow border-0 rounded">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Aktoreve</h5>
                <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'add.php'"
                    style="padding: 7px 20px;">
                    Shto Aktor</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Emri</th>
                                <th>Email</th>
                                <th>Datëlindja</th>
                                <th>Biografia</th>
                                <th>Portreti</th>
                                <th class="text-end">Veprime</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <?php
                            $i = 1;
                            while ($row = $actors_result->fetch_assoc()) {
                                $posterUrl = "../../../includes/get_image.php?actor_id=" . $row['id'];
                                ?>
                                <tr>
                                    <td class="text-muted"><?php echo $i; ?></td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo date("d M Y", strtotime($row['birthday'])); ?></td>
                                    <td>
                                        <div class="desc-col">
                                            <?php echo $row['description'] ?>
                                        </div>
                                    </td>
                                    <td><img src="<?php echo $posterUrl ?>" alt="Poster"
                                            style="width: 150px; height: auto; border-radius: 5px;"></td>
                                    <td class="text-end">
                                        <div
                                            style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 8px; width: 110px;">
                                            <button class="btn btn-sm btn-outline-secondary editUserBtn"
                                                style="width: 100%;" data-id="<?php echo $row['id'] ?>"
                                                data-name="<?php echo $row['name'] ?>"
                                                data-email="<?php echo $row['email'] ?>"
                                                data-birthday="<?php echo $row['birthday'] ?>"
                                                data-biography="<?php echo $row['description'] ?>"
                                                data-poster="<?php echo $posterUrl ?>">
                                                Edito</button>
                                            <button class="btn btn-sm btn-outline-danger deleteUserBtn" style="width: 100%;"
                                                data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>"
                                                data-toggle="modal" data-target="#deleteUserModal">Fshij</button>
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
                    <form id="editActorForm" method="POST" action="edit.php" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" id="editBirthday" name="birthday" required>
                        </div>

                        <div class="form-group">
                            <label for="editDescription">Biografia</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="4"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="editPoster">Ndrysho portretin</label><br>
                            <img id="currentPoster" src="" alt="Portreti aktual"
                                style="width: 50%; height: auto; margin-bottom: 10px; border-radius: 5px;">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="editPoster" name="file-input"
                                    accept="image/*">
                                <label class="custom-file-label" for="editPoster">Zgjidh një skedar</label>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" form="editActorForm" name="edit-actor"
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="/biletaria_online/assets/js/sb-admin-2.min.js"></script>

<script src="/biletaria_online/assets/js/flatpickr.min.js"></script>
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
                "searchPlaceholder": "Kërko aktor...",
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
            let editDatesPicker;

            const userId = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const biography = $(this).data('biography');

            $('#editUserId').val(userId);
            $('#editName').val(name);
            $('#editEmail').val(email);
            $('#editDescription').val(biography);
            $('#currentPoster').attr('src', $(this).data('poster'));

            const dateString = $(this).data('birthday');

            if (editDatesPicker) {
                editDatesPicker.setDate(dateString);
            } else {
                editDatesPicker = flatpickr("#editBirthday", {
                    mode: "single",
                    dateFormat: "Y-m-d",
                    defaultDate: dateString
                });
            }

            initialFormData = $('#editActorForm').serializeArray();

            $('#editUserModal').modal('show');
        });
    });

    $('#editPoster').on('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (event) {
                $('#currentPoster').attr('src', event.target.result);
            };

            reader.readAsDataURL(file);
        }

        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    function isFormChanged() {
        let currentFormData = $('#editActorForm').serializeArray();

        for (let i = 0; i < initialFormData.length; i++) {
            if (initialFormData[i].value !== currentFormData[i].value) {
                return true;
            }
        }

        let currentFile = $('input[name="file-input"]')[0].files[0];
        if (currentFile) {
            return true;
        }

        return false;
    }

    $('#editActorForm').submit(function (e) {
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
</script>

<script>
    if (window.history.replaceState) {
        const url = new URL(window.location);
        url.searchParams.delete('update');
        window.history.replaceState({}, document.title, url.pathname + url.search);
    }
</script>

