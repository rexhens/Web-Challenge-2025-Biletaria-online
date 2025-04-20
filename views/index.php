<?php
/** @var mysqli $conn */
require "../config/db_connect.php";
require "../auth/auth.php";
require "../includes/functions.php";
?>

<?php
$pageStyles = [
    "../assets/css/style-starter.css",
    "../assets/css/shows.css"
];
require '../includes/header.php';
?>

	<section class="w3l-main-slider position-relative" id="home">
		<div class="companies20-content">
			<div class="owl-one owl-carousel owl-theme">
                <?php
                $now = $now = date('Y-m-d');
                $query = "
        SELECT s.*
        FROM shows s
        JOIN (
            SELECT show_id
            FROM show_dates
            GROUP BY show_id
            HAVING MAX(show_date) >= ?
        ) sd ON s.id = sd.show_id
    ";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $now);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows > 0){

                    while ($show = $result->fetch_assoc()) {
                        $datesQuery = $conn->prepare("SELECT show_date FROM show_dates WHERE show_id = ? ORDER BY show_date ASC");
                        $datesQuery->bind_param("i", $show['id']);
                        $datesQuery->execute();
                        $datesResult = $datesQuery->get_result();
                        $dates = [];
                        while ($row = $datesResult->fetch_assoc()) {
                            $dates[] = $row['show_date'];
                        }

                        $groupedDates = groupDates($dates);

                        $videoId = '';
                        $parsedUrl = parse_url($show['trailer']);
                        if (isset($parsedUrl['query'])) {
                            parse_str($parsedUrl['query'], $queryParams);
                            $videoId = $queryParams['v'] ?? '';
                        } elseif (isset($parsedUrl['path'])) {
                            $pathParts = explode('/', trim($parsedUrl['path'], '/'));
                            $videoId = end($pathParts);
                        }

                        $popupId = 'small-dialog' . $show['id'];

                        $bg_image = "https://img.youtube.com/vi/$videoId/maxresdefault.jpg";

                        ?>
                        <div class="item">
                            <li>
                                <div class="slider-info banner-view bg bg2" style="background: url('<?php echo $bg_image; ?>') no-repeat center;">
                                    <div class="banner-info">
                                        <h3><?php echo htmlspecialchars($show['title']); ?></h3>
                                        <p><?php echo implode(', ', $groupedDates); ?></p>
                                        <p class='show-description'><?php echo nl2br(htmlspecialchars($show['description'])); ?></p>
                                        <a href="#<?php echo $popupId; ?>" class="popup-with-zoom-anim play-view1">
									<span class="video-play-icon">
										<span class="fa fa-play"></span>
									</span>
                                            <h6>Shiko Trailerin</h6>
                                        </a>
                                        <div id="<?php echo $popupId; ?>" class="zoom-anim-dialog mfp-hide small-dialog">
                                            <iframe src="https://www.youtube.com/embed/<?php echo $videoId; ?>" allow="autoplay; fullscreen" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                    <?php }
                } else {
                    echo "<div class='errors show'>
             <p>Nuk ka shfaqje!</p>
          </div>";
                }
                ?>
			</div>
		</div>
	</section>

	<section class="w3l-grids">
		<div class="grids-main py-5">
			<div class="container py-lg-3">
				<div class="headerhny-title" style="margin-bottom: -20px;">
					<div class="w3l-title-grids">
						<div class="headerhny-left">
							<h3 class="hny-title">Sezoni i Ri</h3>
						</div>
						<div class="headerhny-right text-lg-right">
							<h4><a class="show-title" href="shows.php">Më shumë</a></h4>
						</div>
					</div>
				</div>
				<div class="owl-three owl-carousel owl-theme shows-container" id="shows-container"></div>
			</div>

		</div>
	</section>
	<!--grids-sec2-->
	<!--mid-slider -->
	<section class="w3l-mid-slider position-relative">
		<div class="companies20-content">
			<div class="owl-mid owl-carousel owl-theme">
				<div class="item">
					<li>
						<div class="slider-info mid-view bg bg2">
							<div class="container">
								<div class="mid-info">
									<span class="sub-text">Comedy</span>
									<h3>Jumanji: The Next Level</h3>
									<p>2019 ‧ Comedy/Action ‧ 2h 3m</p>
									<a class="watch" href="movies.html"><span class="fa fa-play"
											aria-hidden="true"></span>
										Watch Trailer</a>
								</div>
							</div>
						</div>
					</li>
				</div>
				<div class="item">
					<li>
						<div class="slider-info mid-view mid-top1 bg bg2">
							<div class="container">
								<div class="mid-info">
									<span class="sub-text">Adventure</span>
									<h3>Dolittle</h3>
									<p>2020 ‧ Family/Adventure ‧ 1h 41m</p>
									<a class="watch" href="movies.html"><span class="fa fa-play"
											aria-hidden="true"></span>
										Watch Trailer</a>
								</div>
							</div>
						</div>
					</li>
				</div>
				<div class="item">
					<li>
						<div class="slider-info mid-view mid-top2 bg bg2">
							<div class="container">
								<div class="mid-info">
									<span class="sub-text">Action</span>
									<h3>Bad Boys for Life</h3>
									<p>2020 ‧ Comedy/Action ‧ 2h 4m</p>
									<a class="watch" href="movies.html"><span class="fa fa-play"
											aria-hidden="true"></span>
										Watch Trailer</a>
								</div>
							</div>
						</div>
					</li>
				</div>
			</div>
		</div>
	</section>

<?php include('../includes/footer.php'); ?>
<!-- responsive tabs -->
<script src="../assets/js/jquery-1.9.1.min.js"></script>
<script src="../assets/js/functions.js"></script>
<script src="../assets/js/easyResponsiveTabs.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		//Horizontal Tab
		$('#parentHorizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion
			width: 'auto', //auto or any width like 600px
			fit: true, // 100% fit in a container
			tabidentify: 'hor_1', // The tab groups identifier
			activate: function (event) { // Callback function if tab is switched
				var $tab = $(this);
				var $info = $('#nested-tabInfo');
				var $name = $('span', $info);
				$name.text($tab.text());
				$info.show();
			}
		});
	});
</script>
<!--/theme-change-->
<script src="../assets/js/theme-change.js"></script>
<script src="../assets/js/owl.carousel.js"></script>
<!-- script for banner slider-->

<script>
	$(document).ready(function () {
		$('.owl-one').owlCarousel({
			stagePadding: 280,
			loop: true,
			margin: 20,
			nav: true,
			responsiveClass: true,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 1,
					stagePadding: 40,
					nav: false
				},
				480: {
					items: 1,
					stagePadding: 60,
					nav: true
				},
				667: {
					items: 1,
					stagePadding: 80,
					nav: true
				},
				1000: {
					items: 1,
					nav: true
				}
			}
		})
	})
</script>
<script>
	$(document).ready(function () {
		$('.owl-mid').owlCarousel({
			loop: true,
			margin: 0,
			nav: false,
			responsiveClass: true,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 1,
					nav: false
				},
				480: {
					items: 1,
					nav: false
				},
				667: {
					items: 1,
					nav: true
				},
				1000: {
					items: 1,
					nav: true
				}
			}
		})
	})
</script>
<!-- script for owlcarousel -->
<script src="../assets/js/jquery.magnific-popup.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Magnific Popup for the first time (this will initialize the first 2)
        $('.popup-with-zoom-anim').magnificPopup({
            type: 'inline',
            fixedContentPos: true,
            fixedBgPos: true,
            overflowY: 'auto',
            closeBtnInside: true,
            preloader: false,
            midClick: true,
            removalDelay: 300,
            mainClass: 'my-mfp-zoom-in'
        });
    });
</script>
<!-- disable body scroll which navbar is in active -->
<script>
	$(function () {
		$('.navbar-toggler').click(function () {
			$('body').toggleClass('noscroll');
		})
	});
</script>
<!-- disable body scroll which navbar is in active -->

<!--/MENU-JS-->
<script>
	$(window).on("scroll", function () {
		var scroll = $(window).scrollTop();

		if (scroll >= 80) {
			$("#site-header").addClass("nav-fixed");
		} else {
			$("#site-header").removeClass("nav-fixed");
		}
	});

	//Main navigation Active Class Add Remove
	$(".navbar-toggler").on("click", function () {
		$("header").toggleClass("active");
	});
	$(document).on("ready", function () {
		if ($(window).width() > 991) {
			$("header").removeClass("active");
		}
		$(window).on("resize", function () {
			if ($(window).width() > 991) {
				$("header").removeClass("active");
			}
		});
	});
</script>

<script>
    async function fetchFilteredShows() {
        const genre = "";
        const dateFilterValue = "available";

        try {
            // Fetch new shows
            const response = await fetch('filter_shows.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `show_time_filter=${encodeURIComponent(dateFilterValue)}&genre_id=${encodeURIComponent(genre)}`
            });

            const html = await response.text();
            const showsContainer = document.getElementById("shows-container");

            // Insert the new content into the container
            showsContainer.innerHTML = html;

            // Re-initialize the Owl Carousel after content is inserted
            setTimeout(() => {
                // Destroy any previous carousel instances before re-initializing
                if ($('.owl-three').hasClass('owl-loaded')) {
                    $('.owl-three').trigger('destroy.owl.carousel');
                }

                // Re-initialize the Owl Carousel with the new content
                $('.owl-three').owlCarousel({
                    stagePadding: 0,
                    loop: true,
                    margin: 20,
                    nav: true,
                    responsiveClass: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    autoplaySpeed: 1000,
                    autoplayHoverPause: false,
                    responsive: {
                        0: {
                            items: 1,
                            nav: false,
                            stagePadding: 0,
                        },
                        390: {
                            items: 1,
                            nav: false,
                            stagePadding: 30,
                        },
                        450: {
                            items: 1,
                            nav: false,
                            stagePadding: 40,
                        },
                        490: {
                            items: 1,
                            nav: true,
                            stagePadding: 75
                        },
                        550: {
                            items: 1,
                            nav: true,
                            stagePadding: 90
                        },
                        630: {
                            items: 1,
                            nav: true,
                            stagePadding: 120
                        },
                        700: {
                            items: 2,
                            nav: true,
                            stagePadding: 0
                        },
                        800: {
                            items: 2,
                            nav: true,
                            stagePadding: 40
                        },
                        900: {
                            items: 2,
                            nav: true,
                            stagePadding: 80
                        },
                        1000: {
                            items: 3,
                            nav: true
                        }
                    }
                });
            }, 100); // Timeout for DOM update
        } catch (error) {
            document.getElementById("shows-container").innerHTML = "<div class='errors show'><p>Gabim gjatë filtrimit!</p></div>";
        }
    }

    fetchFilteredShows();
</script>

<script src="../assets/js/bootstrap.min.js"></script>