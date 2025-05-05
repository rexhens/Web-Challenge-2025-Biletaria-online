<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

$query = "SELECT * FROM events";
$events_result = $conn->query($query);
?>

<?php
$pageTitle = 'Eventet';
$pageStyles = [
    '/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css',
    '/biletaria_online/assets/css/sb-admin-2.min.css',
    "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i",
    "/biletaria_online/assets/css/flatpickr.min.css",
    "https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>


    <style>
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
            /* 7 lines with 1.4em line height */
            line-height: 1.4em;
            max-width: 350px;
            /* required for text-overflow to work */
            white-space: normal;
            /* important: avoid nowrap */
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

        a.paginate_button:hover,
        a.paginate_button:disabled {
            background-color: #8f793f !important;
        }
    </style>



</head>

<body id="page-top">

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

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>

    <section id="users-section">
        <div class="card shadow border-0 rounded">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Eventeve</h5>
                <?php if(checkAdmin($conn)){ ?>
                <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'add-event.php'"
                    style="padding: 7px 20px;">Shto Event</button>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover mb-0 w-100" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Titulli</th>
                                <th>Salla</th>
                                <th>Datat</th>
                                <th>Ora</th>
                                <th>Bileta</th>
                                <th>Përshkrimi</th>
                                <th>Poster</th>
                                <th>Veprime</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;

                            while ($row = $events_result->fetch_assoc()) {

                                $datesQuery = $conn->prepare("SELECT * FROM event_dates WHERE event_id = ? ORDER BY event_date ASC");
                                $datesQuery->bind_param("i", $row['id']);
                                $datesQuery->execute();
                                $datesResult = $datesQuery->get_result();
                                $dates = [];
                                while ($date = $datesResult->fetch_assoc()) {
                                    $dates[] = $date['event_date'];
                                }

                                $groupedDates = groupDates($dates);
                                $dataDates = implode(',', $dates);

                                $posterUrl = "../../../includes/get_image.php?event_id=" . $row['id'];
                                ?>

                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['hall'] ?></td>
                                    <td><?php echo implode(', ', $groupedDates) ?></td>
                                    <td><?php echo $row['time'] ?></td>
                                    <td><?php echo $row['price'] ?> Lekë</td>
                                    <td>
                                        <div class="desc-col">
                                            <?php echo $row['description'] ?>
                                        </div>
                                    </td>
                                    <td><img src="<?php echo $posterUrl ?>" alt="Poster"
                                            style="width: 150px; height: auto; border-radius: 5px;"></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <div
                                            style="display: flex; flex-direction: column; justify-content: center; align-items: center; gap: 8px; width: 110px;">
                                            <?php if(checkAdmin($conn)){ ?>
                                            <button class="btn btn-sm btn-outline-secondary editShowBtn"
                                                style="width: 100%;" data-id="<?php echo $row['id'] ?>"
                                                data-title="<?php echo $row['title'] ?>"
                                                data-hall="<?php echo $row['hall'] ?>" data-dates="<?php echo $dataDates ?>"
                                                data-time="<?php echo $row['time'] ?>"
                                                data-description="<?php echo $row['description'] ?>"
                                                data-trailer="<?php echo $row['trailer'] ?>"
                                                data-price="<?php echo $row['price'] ?>"
                                                data-poster="<?php echo $posterUrl ?>">
                                                Edito
                                            </button>
                                            <?php } ?>
                                            <?php if(checkAdmin($conn)){ ?>
                                            <button class="btn btn-sm btn-outline-danger delete-btn" style="width: 100%;"
                                                data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['title'] ?>"
                                                data-toggle="modal" data-target="#deleteUserModal">Fshi</button>
                                            <?php } ?>
                                            <button class="btn btn-sm btn-outline-success"
                                                onclick="window.location.href = '/biletaria_online/views/client/events/event_details.php?id=<?php echo $row['id'] ?>'"
                                                style="width: 100%;">Më shumë info</button>
                                            <button class="btn btn-sm btn-outline-warning"
                                                    onclick="window.location.href = '/biletaria_online/views/client/reserve.php?id=<?php echo $row['id'] ?>'"
                                                style="width: 100%;">Rezervo</button>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    onclick="window.location.href = '/biletaria_online/views/admin/reservations/index.php?event_id=<?php echo $row['id'] ?>'"
                                                style="width: 100%;">Rezervimet</button>
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


    <!-- Edit Show Modal -->
    <div class="modal fade" id="editShowModal" tabindex="-1" aria-labelledby="editShowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editShowForm" method="POST" action="admin-edit-event.php" enctype="multipart/form-data"
                class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editShowModalLabel">Edito Shfaqjen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Edito">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="event_id" id="editShowId">

                    <div class="form-group">
                        <label for="editTitle">Titulli</label>
                        <input type="text" class="form-control" name="title" id="editTitle" required>
                    </div>

                    <div class="form-group">
                        <label for="editHall">Salla</label>
                        <select name="hall" id="editHall" class="form-control" required>
                            <option value="Shakespare">Shakespare</option>
                            <option value="Çehov">Çehov</option>
                            <option value="Bodrum">Bodrum</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editDates">Datat</label>
                        <input type="text" class="form-control" name="dates" id="editDates" required>
                    </div>

                    <div class="form-group">
                        <label for="editTime">Ora</label>
                        <input type="time" class="form-control" name="time" id="editTime" required>
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

                    <div class="form-group">
                        <label for="editPoster">Ndrysho posterin</label><br>
                        <img id="currentPoster" src="" alt="Posteri aktual"
                            style="width: 50%; height: auto; margin-bottom: 10px; border-radius: 5px;">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="editPoster" name="file-input"
                                accept="image/*">
                            <label class="custom-file-label" for="editPoster">Zgjidh një skedar</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" name="edit-event"
                        style="background-color: #8f793f; border: none;">
                        Ruaj Ndryshimet
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="delete_event.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmo Fshirjen e Eventit</h5>
                        <button type="button" class="close text-gray-700" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të fshini eventin <strong id="showToDeleteTitle"></strong>?
                        </p>
                        <input type="hidden" name="eventId" id="deleteShowId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="delete-event" class="btn btn-danger">Fshi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="/biletaria_online/assets/js/sb-admin-2.min.js"></script>

<script src="/biletaria_online/assets/js/flatpickr.min.js"></script>

<script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

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
                "searchPlaceholder": "Kërko event...",
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

    let initialFormData;

    $('.editShowBtn').on('click', function () {
        let editDatesPicker;

        $('#editShowId').val($(this).data('id'));
        $('#editTitle').val($(this).data('title'));
        $('#editHall').val($(this).data('hall'));
        $('#editTime').val($(this).data('time'));
        $('#editDescription').val($(this).data('description'));
        $('#editTrailer').val($(this).data('trailer'));
        $('#editPrice').val($(this).data('price'));
        $('#currentPoster').attr('src', $(this).data('poster'));

        const dateString = $(this).data('dates');
        const dateArray = dateString ? dateString.split(',') : [];

        if (editDatesPicker) {
            editDatesPicker.setDate(dateArray);
        } else {
            editDatesPicker = flatpickr("#editDates", {
                mode: "multiple",
                dateFormat: "Y-m-d",
                defaultDate: dateArray
            });
        }

        initialFormData = $('#editShowForm').serializeArray();

        $('#editShowModal').modal('show');
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
        let currentFormData = $('#editShowForm').serializeArray();

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

    $('#editShowForm').submit(function (e) {
        if (!isFormChanged()) {
            e.preventDefault();
            alert('Nuk ka asnjë ndryshim për të ruajtur.');
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll(".delete-btn");

        deleteButtons.forEach(button => {
            button.addEventListener("click", () => {
                const showId = button.getAttribute("data-id");
                const showTitle = button.getAttribute("data-name");

                document.getElementById("deleteShowId").value = showId;
                document.getElementById("showToDeleteTitle").textContent = showTitle;
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

</body>
</html>