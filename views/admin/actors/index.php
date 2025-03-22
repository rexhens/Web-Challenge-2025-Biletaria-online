<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="../../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <link rel="stylesheet" href='../../../assets/css/actors.css'>
    <title>Actors Page</title>
    <style>
        body{
                background-color: rgb(17 24 39 / var(--tw-bg-opacity, 1));
        }
        .team .member {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100%;
            background-color: #2d3748;
            /* Dark background similar to the form */
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .container a {
            display: inline-block;
            padding: 12px 24px;
            background-color: #fbbf24;
            /* Gold background similar to the form button */
            color: #2d3748;
            /* Dark text */
            font-weight: 600;
            font-size: 16px;
            text-transform: uppercase;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            margin-top: 20px;
        }

        /* Add button hover effect */
        .container a:hover {
            background-color: #f59e0b;
            /* Darker shade of gold */
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        /* Matching card text color */
        .team .member h4,
        .team .member span,
        .team .member p {
            color: #fff;
            /* White text for better contrast */
        }

        .team .member img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        .team .member-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            margin-top: 16px;
        }

        .team .member h4,
        .team .member span,
        .team .member p {
            margin: 0 0 8px;
        }

        .team .member .social {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: auto;
        }

        .team .member .social a {
            text-decoration: none;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            border-radius: 5px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .team .member .social .edit-btn {
            background-color: rgba(14, 21, 16, 0.4);
            color: white;
            border: 2px solid rgba(14, 21, 16, 0.4);
        }

        .team .member .social .edit-btn:hover {
            background-color: white;
            color: #000;
            box-shadow: 0 4px 10px rgba(238, 162, 162, 0.4);
            transform: scale(1.1);
        }

        .team .member .social .delete-btn {
            background-color: rgba(49, 70, 127, 0.4);
            color: white;
            border: 2px solid #444;
        }

        .team .member .social .delete-btn:hover {
            background-color: white;
            color: #444;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        /* Ensures consistent height for the cards */
        .card-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .team .member .social a.edit-btn,
        .team .member .social a.delete-btn {
            display: inline-block !important;
            width: 48%;
        }


        /* Responsive Button Layout */
        @media (max-width: 768px) {
            .team .member .social {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .team .member .social .edit-btn,
            .team .member .social .delete-btn {
                width: 100%;
                max-width: 120px;
            }
        }

        .hidden {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            overflow: hidden !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>

<body>

    <section id="team" class="team section">
        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Actors Page</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <!-- Search Bar -->
        <div class="container">
            <input type="text" id="search" class="form-control" placeholder="Search actors..."
                onkeyup="searchActors()" />
            <a href="add.php">Add</a>
        </div>

        <div class="container">
            <div class="big-container">
                <?php
                require_once '../../../config/db_connect.php';
                $result = $conn->query('SELECT * FROM actors');
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-lg-4 col-md-6 d-flex card-container" data-aos="fade-up" data-aos-delay="100">
                            <div class="member">
                                <img src="get_image.php?id=<?php echo $row['id']; ?>" class="img-fluid" alt="">
                                <div class="member-content">
                                    <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                    <span><?php echo "I lindur me: " . htmlspecialchars($row['birthdate']); ?></span>
                                    <p><?php echo htmlspecialchars($row['biography']); ?></p>
                                    <div class="social">

                                        <a class="edit-btn" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>

                                        <a class="delete-btn" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="<?php echo $row['id']; ?>">
                                            Fshij
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div><!-- End Team Member -->
                        <?php
                    }
                } else {
                    echo "No actors found.";
                }
                ?>
            </div>
        </div><!-- End container -->
    </section><!-- /Team Section -->
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Jepni konfirmimin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Jeni i sigurt qe doni ta hiqni nga faqja e teatrit kete aktor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mbrapa</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger ">Fshij</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchActors() {
            let input = document.getElementById('search').value.toLowerCase();
            let actors = document.querySelectorAll('.card-container');

            actors.forEach(function (actor) {
                let name = actor.querySelector('h4').textContent.toLowerCase();
                if (name.indexOf(input) > -1) {

                    actor.classList.remove("hidden");
                } else {

                    actor.classList.add("hidden");
                }
            });
        }
        document.addEventListener("DOMContentLoaded", function () {
            let deleteButtons = document.querySelectorAll(".delete-btn");
            let confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            let deleteModalElement = document.getElementById("deleteModal");
            let deleteModal = new bootstrap.Modal(deleteModalElement, { keyboard: false });

            deleteButtons.forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent default link behavior
                    let actorId = this.getAttribute("data-id");
                    confirmDeleteBtn.href = `delete.php?id=` + actorId;

                    // Ensure the modal is fully initialized before showing
                    deleteModalElement.removeAttribute("aria-hidden");
                    deleteModalElement.style.display = "block";
                    deleteModal.show();
                });
            });

            // Ensure modal is properly hidden when closed
            deleteModalElement.addEventListener("hidden.bs.modal", function () {
                deleteModalElement.setAttribute("aria-hidden", "true");
                deleteModalElement.style.display = "none";
            });
        });



    </script>

</body>

</html>