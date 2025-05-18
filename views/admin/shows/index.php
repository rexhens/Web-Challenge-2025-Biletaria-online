<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
redirectIfNotLoggedIn();
redirectIfNotAdminOrTicketOffice($conn);

$query = "SELECT * FROM shows ORDER BY id DESC";
$users_result = $conn->query($query);
?>

<?php
$pageTitle = 'Shfaqjet';
$pageStyles = [
    '/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css',
    '/biletaria_online/assets/css/sb-admin-2.min.css',
    "https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i",
    "https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css",
    "/biletaria_online/assets/css/flatpickr.min.css"
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

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/sidebar.php'; ?>


    <section id="users-section">
        <div class="card shadow border-0 rounded">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary" style="color: #8f793f !important;">Lista e Shfaqjeve</h5>
                <?php if(checkAdmin($conn)){ ?>
                <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'add-show.php'"
                    style="padding: 7px 20px;">Shto Shaqje</button>
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
                                <th>Zhaneri</th>
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

                            while ($row = $users_result->fetch_assoc()) {

                                $genre_id = $row['genre_id'];
                                $genre = $conn->prepare("SELECT * FROM genres WHERE id = ?");
                                $genre->bind_param("i", $genre_id);
                                $genre->execute();
                                $result = $genre->get_result();
                                $genreData = $result->fetch_assoc();

                                $datesQuery = $conn->prepare("SELECT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
                                $datesQuery->bind_param("i", $row['id']);
                                $datesQuery->execute();
                                $datesResult = $datesQuery->get_result();
                                $dates = [];
                                while ($date = $datesResult->fetch_assoc()) {
                                    $dates[] = $date['show_date'];
                                }

                                $groupedDates = groupDates($dates);
                                $dataDates = implode(',', $dates);

                                $posterUrl = "../../../includes/get_image.php?show_id=" . $row['id'];
                                ?>

                                <tr>
                                    <td><?php echo $i ?></td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['hall'] ?></td>
                                    <td><?php echo $genreData['genre_name'] ?></td>
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
                                                data-hall="<?php echo $row['hall'] ?>"
                                                data-genre="<?php echo $row['genre_id'] ?>"
                                                data-dates="<?php echo $dataDates ?>" data-time="<?php echo $row['time'] ?>"
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
                                                onclick="window.location.href = '/biletaria_online/views/client/shows/show_details.php?id=<?php echo $row['id'] ?>'"
                                                style="width: 100%;">Më shumë info</button>
                                            <button class="btn btn-sm btn-outline-warning"
                                                    onclick="window.location.href = '/biletaria_online/views/client/reserve.php?show_id=<?php echo $row['id'] ?>'"
                                                style="width: 100%;">Rezervo</button>
                                            <button class="btn btn-sm btn-outline-secondary"
                                                    onclick="window.location.href = '/biletaria_online/views/admin/reservations/index.php?show_id=<?php echo $row['id'] ?>'"
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


    <?php
    $genresQuery = "SELECT * FROM genres";
    $genresResult = mysqli_query($conn, $genresQuery);
    $genres = [];
    while ($row = mysqli_fetch_assoc($genresResult)) {
        $genres[] = $row;
    }
    ?>

    <!-- Edit Show Modal -->
    <div class="modal fade" id="editShowModal" tabindex="-1" aria-labelledby="editShowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editShowForm" method="POST" action="edit_show.php" enctype="multipart/form-data""
                  class=" modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editShowModalLabel">Edito Shfaqjen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Edito">
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
                            <option value="Çehov">Çehov</option>
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
                    <button type="submit" class="btn btn-primary" name="edit-show"
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
            <form method="POST" action="delete_show.php">
                <div class="modal-content">
                    <div class="modal-header text-red">
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmo Fshirjen e Shfaqjes</h5>
                        <button type="button" class="close text-gray-700" data-dismiss="modal" aria-label="Mbyll">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Jeni i sigurt që doni të fshini shfaqjen <strong id="showToDeleteTitle"></strong>?
                        </p>
                        <input type="hidden" name="showId" id="deleteShowId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                        <button type="submit" name="delete-show" class="btn btn-danger">Fshi</button>
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
                "searchPlaceholder": "Kërko shfaqje...",
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
        $('#editGenre').val($(this).data('genre'));
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