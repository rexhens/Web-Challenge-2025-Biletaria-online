<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";


$query = "SELECT * FROM shows";
$users_result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require '../includes/links.php'; ?>
    <meta property="og:image" content="../assets/img/metropol_icon.png">
    <link rel="icon" href="../assets/img/metropol_icon.png">
    <title>Teatri Metropol | Menaxho Shfaqje</title>

    <!-- Styles -->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="../assets/css/flatpickr.min.css">

    <!-- Scripts (in proper order) -->

    <!-- jQuery (must come first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 with Popper included -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- sb-admin-2 (your custom template) -->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- jQuery Easing (if used in sb-admin-2) -->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../assets/js/flatpickr.min.js"></script>

    <style>
        table.dataTable td,
        table.dataTable th {
            text-align: center;
            vertical-align: middle;
        }

        .desc-col {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 7;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: calc(1.4em * 7); /* 7 lines with 1.4em line height */
            line-height: 1.4em;
            max-width: 350px;       /* required for text-overflow to work */
            white-space: normal; /* important: avoid nowrap */
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

<?php if (isset($_GET['update']) && $_GET['update'] === 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show fixed-top text-center rounded-5 m-0" role="alert" style="z-index: 1050; top: 10px; right: 10px; left: auto; max-width: 500px; background-color: rgba(131, 173, 68); color: #224212;">
        Ndryshimet u kryen me sukses!
        <button type="button" class="close position-absolute end-0 me-3" data-dismiss="alert" aria-label="Close" style="top: 50%; transform: translateY(-50%);">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

    <div style="display: flex; justify-content: flex-start; width: 100%;" id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background-color: #8f793f !important;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin/index.php">

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
                        <a class="collapse-item" href="../../add-user.php">Shto perdorues te ri</a>
                        <a class="collapse-item" href="index.php">Shiko te gjithe</a>
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
                        <a class="collapse-item" href="add-show.php">Shto Shfaqje</a>
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
                        <a class="collapse-item" href="admin/actors/index.php">Te gjithe Aktoret</a>
                        <a class="collapse-item" href="admin/actors/add.php">Shto nje Aktor te ri</a>
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
                    <button class="btn btn-sm btn-primary-report" onclick="window.location.href = 'add-show.php'">Shto Shaqje</button>
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
                                    <th>Çmimi i biletës</th>
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

                                    $posterUrl = "get_image.php?show_id=" . $row['id'];
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
                                        <td><img src="<?php echo $posterUrl ?>" alt="Poster" style="width: 100%; height: auto; border-radius: 5px;"></td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <div
                                                style="display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                <button class="btn btn-sm btn-outline-secondary editShowBtn"
                                                    data-id="<?php echo $row['id'] ?>"
                                                    data-title="<?php echo $row['title'] ?>"
                                                    data-hall="<?php echo $row['hall'] ?>"
                                                    data-genre="<?php echo $row['genre_id'] ?>"
                                                    data-dates="<?php echo $dataDates ?>"
                                                    data-time="<?php echo $row['time'] ?>"
                                                    data-description="<?php echo $row['description'] ?>"
                                                    data-trailer="<?php echo $row['trailer'] ?>"
                                                    data-price="<?php echo $row['price'] ?>"
                                                    data-poster="<?php echo $posterUrl ?>">
                                                    Edito
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                        data-id="<?php echo $row['id'] ?>"
                                                        data-name="<?php echo $row['title'] ?>" data-toggle="modal"
                                                        data-target="#deleteUserModal">Fshi</button>
                                                <button class="btn btn-sm btn-outline-success" onclick="window.location.href = 'show_details.php?id=<?php echo $row['id'] ?>'">Më shumë info</button>
                                                <button class="btn btn-sm btn-outline-warning">Rezervo</button>
                                                <button class="btn btn-sm btn-outline-secondary">Rezervimet</button>
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

    </div>

    <!-- Edit Show Modal -->
    <div class="modal fade" id="editShowModal" tabindex="-1" aria-labelledby="editShowModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editShowForm" method="POST" action="edit_show.php" enctype="multipart/form-data""
                  class="modal-content">
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
                        <img id="currentPoster" src="" alt="Posteri aktual" style="width: 50%; height: auto; margin-bottom: 10px; border-radius: 5px;">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="editPoster" name="file-input" accept="image/*">
                            <label class="custom-file-label" for="editPoster">Zgjidh një skedar</label>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anulo</button>
                    <button type="submit" class="btn btn-primary" name="edit-show" style="background-color: #8f793f; border: none;">
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

    $('#editShowForm').submit(function(e) {
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