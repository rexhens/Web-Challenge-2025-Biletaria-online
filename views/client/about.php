<?php
/** @var mysqli $conn */
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
?>

<?php
$pageTitle = "Rreth nesh";
$pageStyles = [
    '/biletaria_online/assets/css/style-starter.css',
    '/biletaria_online/assets/css/navbar.css',
    '/biletaria_online/assets/css/footer.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>

	<style>
    :root {
        --default-font: "Quicksand", sans-serif;
        --heading-font: "Russo One", sans-serif;
        --nav-font: "Afacad Flux", sans-serif;

        --background-color: #1B1B1B;
        --default-color: #785E5B;
        --heading2-color: #836e4f;
        --heading-color: #7C8598;
        --accent2-color: rgb(130, 152, 145);
        --accent-color: #8f793f;
        --surface-color: #c8bbb3;
        --text-color: #E4E4E4;
        --error-color: #f44336;
        --success-color: rgba(131, 173, 68);
    }

    body {
        background-color: #111;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        gap: 10px;
        font-family: var(--default-font);
        color: var(--text-color);
    }

    /* Theatre Carousel Image */
    .carousel-img {
      width: 640px;
      height: 480px;
      max-width: 100%;
      object-fit: cover;
      cursor: pointer;
    }

    /* Fullscreen Lightbox Overlay */
    #lightbox-overlay {
      position: fixed; top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: rgba(0,0,0,0.9);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; visibility: hidden;
      transition: opacity .4s ease, visibility .4s ease;
      z-index: 10000;
    }
    #lightbox-overlay.show { opacity:1; visibility:visible; }
    #lightbox-overlay img { max-width:90vw; max-height:90vh; object-fit:contain; }
    #lightbox-close { position:absolute; top:20px; right:30px; font-size:2rem; color:#fff; cursor:pointer; z-index:10001; }

    .hny-title {
        color: var(--text-color);
        font-family: var(--heading-font);
        margin-bottom: 20px;
    }

    .single-event-content p {
        color: var(--text-color);
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .single-event-content strong {
        color: var(--heading2-color);
    }

    .single-event-content ul {
        list-style-type: none;
        padding-left: 20px;
    }

    .single-event-content li {
        color: var(--text-color);
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .single-event-content li strong {
        color: var(--heading2-color);
    }

    /* Specific heading color changes */
    h3.hny-title, h6 {
        color: var(--text-color) !important;
    }

    h2 {
        color: var(--heading2-color) !important;
    }
</style>

</head>

<body class="w3l-ab-grids py-5">

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/navbar.php'; ?>

<div class="container py-lg-4" style="margin-top: 30px;">
    <div class="row ab-grids-sec align-items-center">
        <div class="col-lg-12 ab-left pl-lg-4 mt-lg-1 mt-1">
            <h3 class="hny-title">Mirë se vini në Teatrin Metropol – Shtëpia e Artit dhe Dialogut</h3>

            <div class="column mt-2">
                <div class="single-event-content">
                    <p><strong>Teatri Metropol</strong> është një qendër dinamike kulturore që synon të sjellë për publikun shqiptar dhe ndërkombëtar vepra teatrore me nivel të lartë artistik. I udhëhequr nga vlerat e gjithëpërfshirjes, dialogut konstruktiv dhe humanizmit universal, Metropoli është një hapësirë ku arti takon komunitetin dhe frymëzon reflektim, bashkëbisedim dhe rritje.</p>

                    <p><strong>Misioni ynë</strong> është të realizojmë shfaqje cilësore – shqiptare dhe botërore – që flasin me ndershmëri dhe forcë artistike për realitetin dhe shpirtin njerëzor. Vizioni ynë është të ndërtojmë një standard të ri në cilësinë e prodhimit artistik dhe trajnimit profesional të talenteve të reja, duke i shërbyer një audience të gjerë: fëmijë, të rinj dhe të rritur.</p>

                    <h6 style="margin-top: 12px; margin-bottom: 2px;">Platforma jonë artistike është e ndarë në tre shtylla:</h6>
                    <ul>
                        <li><strong>Teatri i të Rriturve:</strong> 6 premiera çdo vit, me produksione origjinale dhe bashkëpunime me artistë të jashtëm. Dy prej tyre janë të lëvizshme dhe çdo shfaqje jepet deri në 15 herë.</li>
                        <li><strong>Teatri i Fëmijëve:</strong> 4 premiera në vit, të krijuara me dashuri për publikun më të vogël, nga të cilat dy janë të lëvizshme dhe secila shfaqet deri në 20 herë.</li>
                        <li><strong>Teatri i të Rinjve:</strong> 2 premiera në vit të dedikuara moshës 14-18 vjeç, me një fokus të veçantë tek temat bashkëkohore dhe përfshirja aktive e të rinjve në botën e teatrit.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Theatre Image Carousel Section -->
<section class="w3l-theatre" id="theatre">
    <div class="container py-lg-4">
      <div class="text-center mb-4"><h2>Pamje nga Teatri</h2></div>
      <div class="carousel-width">
        <div class="owl-theatre owl-carousel owl-theme mb-lg-5">
          <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/1.jpg" alt="Theatre Image 1"></div>
          <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/2.jpg" alt="Theatre Image 2"></div>
          <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/3.jpg" alt="Theatre Image 3"></div>
          <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/4.jpg" alt="Theatre Image 4"></div>
          <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/5.jpg" alt="Theatre Image 5"></div>
          <div class="item"><img class="carousel-img" src="/biletaria_online/assets/img/about/6.jpg" alt="Theatre Image 6"></div>
        </div>
      </div>
    </div>
  </section>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/footer.php'; ?>

<script src="../../assets/js/jquery-3.3.1.min.js"></script>
<!-- stats -->
<script src="../../assets/js/jquery.waypoints.min.js"></script>
<script src="../../assets/js/jquery.countup.js"></script>
<script type="text/javascript" src='../../assets/js/swiper.min.js'></script>
<script>
	$('.counter').countUp();
</script>
<!--/theme-change-->
<script src="../../assets/js/theme-change.js"></script>
<script src="../../assets/js/owl.carousel.js"></script>
<!-- script for banner slider-->
<script>
	$(document).ready(function () {
		$('.owl-team').owlCarousel({
			loop: true,
			margin: 20,
			nav: false,
			responsiveClass: true,
			autoplay: false,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 2,
					nav: false
				},
				480: {
					items: 2,
					nav: true
				},
				667: {
					items: 3,
					nav: true
				},
				1000: {
					items: 4,
					nav: true
				}
			}
		})
	})
</script>


<script>
	var swiper = new Swiper('.swiper-container', {
		effect: 'coverflow',
		grabCursor: true,
		centeredSlides: true,
		slidesPerView: 'auto',
		coverflowEffect: {
			rotate: 50,
			stretch: 0,
			depth: 100,
			modifier: 1,
			slideShadows: true,
		},
		pagination: {
			el: '.swiper-pagination',
		},
	});
</script>
<script>
	$(document).ready(function () {
		$('.owl-three').owlCarousel({
			loop: true,
			margin: 20,
			nav: false,
			responsiveClass: true,
			autoplay: true,
			autoplayTimeout: 5000,
			autoplaySpeed: 1000,
			autoplayHoverPause: false,
			responsive: {
				0: {
					items: 2,
					nav: false
				},
				480: {
					items: 2,
					nav: true
				},
				667: {
					items: 3,
					nav: true
				},
				1000: {
					items: 6,
					nav: true
				}
			}
		})
	})
</script>
<!-- for tesimonials carousel slider -->
<script>
	$(document).ready(function () {
		$(".owl-clients").owlCarousel({
			loop: true,
			margin: 40,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: true
				},
				736: {
					items: 2,
					nav: false
				},
				1000: {
					items: 3,
					nav: true,
					loop: false
				}
			}
		})
	})
</script>
<!-- script for owlcarousel -->
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
<script src="../../assets/js/bootstrap.min.js"></script>

<script>
  $(function() {
    // Initialize Owl Carousel
    $('.owl-theatre').owlCarousel({
      loop: true,
      margin: 20,
      responsiveClass: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplaySpeed: 1000,
      autoplayHoverPause: false,
      responsive: {
        0: { items: 1, nav: true },
        480: { items: 1, nav: true },
        667: { items: 2, nav: false },
        1000: { items: 3, nav: true, loop: false }
      }
    });

    // Lightbox functionality
    $(document).delegate('.carousel-img', 'click', function() {
      var src = $(this).attr('src');
      $('#lightbox-img').attr('src', src);
      $('#lightbox-overlay').addClass('show');
    });

    // Close lightbox
    $('#lightbox-close, #lightbox-overlay').on('click', function(e) {
      if (e.target.id === 'lightbox-overlay' || e.target.id === 'lightbox-close') {
        $('#lightbox-overlay').removeClass('show');
      }
    });
  });
</script>

<!-- Lightbox Overlay -->
<div id="lightbox-overlay">
  <span id="lightbox-close">&times;</span>
  <img id="lightbox-img" src="" alt="Full Screen Image">
</div>

</body>
</html>