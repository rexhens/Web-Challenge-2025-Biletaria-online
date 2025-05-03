<?php
/** @var mysqli $conn */
/*
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/config/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/auth/auth.php';
require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/functions.php';
*/
?>

<?php
$pageTitle = "Rreth nesh";
$pageStyles = [
    '/biletaria_online/assets/css/style-starter.css',
    '/biletaria_online/assets/css/navbar.css'
];
?>

<!DOCTYPE html>
<html lang="sq">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/biletaria_online/includes/header.php'; ?>
</head>

	<!-- /about-->
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


	<section class="w3l-clients" id="clients">
		<!-- /grids -->
		<!-- <div class="cusrtomer-layout py-5"> -->
		<div class="container py-lg-4">
			<!-- <div class="headerhny-title">
				<h3 class="hny-title">Our Testimonials</h3>
			</div> -->
			<!-- /grids -->
			<div class="testimonial-width">
				<div class="owl-clients owl-carousel owl-theme mb-lg-5">
					<div class="item">
						<div class="testimonial-content">
							<div class="testimonial">
								<blockquote>
									<q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
										voluptate rem ullam dolore!.</q>
								</blockquote>
								<div class="testi-des">
									<div class="test-img"><img src="../assets/images/team1.jpg" class="img-fluid" alt="/">
									</div>
									<div class="peopl align-self">
										<h3>Johnson smith</h3>
										<p class="indentity">Washington</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-content">
							<div class="testimonial">
								<blockquote>
									<q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
										voluptate rem ullam dolore!.</q>
								</blockquote>
								<div class="testi-des">
									<div class="test-img"><img src="../assets/images/team2.jpg" class="img-fluid" alt="/">
									</div>
									<div class="peopl align-self">
										<h3>Alexander leo</h3>
										<p class="indentity">Washington</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-content">
							<div class="testimonial">
								<blockquote>
									<q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
										voluptate rem ullam dolore!.</q>
								</blockquote>
								<div class="testi-des">
									<div class="test-img"><img src="../assets/images/team3.jpg" class="img-fluid" alt="/">
									</div>
									<div class="peopl align-self">
										<h3>Roy Linderson</h3>
										<p class="indentity">Washington</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-content">
							<div class="testimonial">
								<blockquote>
									<q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
										voluptate rem ullam dolore!.</q>
								</blockquote>
								<div class="testi-des">
									<div class="test-img"><img src="../assets/images/team4.jpg" class="img-fluid" alt="/">
									</div>
									<div class="peopl align-self">
										<h3>Mike Thyson</h3>
										<p class="indentity">Washington</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-content">
							<div class="testimonial">
								<blockquote>
									<q>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit beatae laudantium
										voluptate rem ullam dolore!.</q>
								</blockquote>
								<div class="testi-des">
									<div class="test-img"><img src="../assets/images/team2.jpg" class="img-fluid" alt="/">
									</div>
									<div class="peopl align-self">
										<h3>Laura gill</h3>
										<p class="indentity">Washington</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="testimonial-content">
							<div class="testimonial">
							
								<div class="testi-des">
									<div class="test-img"><img src="../assets/images/team3.jpg" class="img-fluid" alt="/">
									</div>
									<div class="peopl align-self">
										<h3>Smith Johnson</h3>
										<p class="indentity">Washington</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /grids -->
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

</body>
</html>