<footer class="footer-glass scroll-fade" id="futuristic-footer">
    <div class="footer-grid">
        <div class="footer-section">
            <h5>Na Kontaktoni</h5>
            <ul>
                <li><i class="fas fa-phone"></i>
                    <a href="tel:+355694567890">+355 67 227 0668</a>
                </li>
                <li><i class="fas fa-envelope"></i>
                    <a href="mailto:teatrimetropol@gmail.com" target="_blank">teatrimetropol@gmail.com</a>
                </li>
                <li><i class="fas fa-map-marker-alt"></i>
                    <a href="https://maps.app.goo.gl/UWvquKDm9JPSiSfZ9" target="_blank">Rruga Ded Gjo Luli, Tiranë 1001</a>
                </li>
            </ul>
        </div>

        <div class="footer-section" style="align-items:center;">
            <h5>Na Ndiqni</h5>
            <div class="social-icons">
                <a href="https://x.com/teatrimetropol" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/teatrimetropol/" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/channel/UCHzRxQOY9rj34hnWfg_vI3A" aria-label="YouTube" target="_blank"><i class="fab fa-youtube"></i></a>
                <a href="https://www.facebook.com/teatrimetropol/" aria-label="Facebook" target="_blank"><i class="fab fa-facebook"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h5>Eksploroni Teatrin</h5>
            <ul>
                <li><i class="fas fa-angle-right"></i> <a href="/biletaria_online/views/client/about.php">Rreth nesh</a></li>
                <li><i class="fas fa-angle-right"></i> <a href="/biletaria_online/views/client/actors/index.php">Aktorët</a></li>
                <li><i class="fas fa-angle-right"></i> <a href="/biletaria_online/views/client/shows/index.php">Shfaqjet</a></li>
                <li><i class="fas fa-angle-right"></i> <a href="/biletaria_online/views/client/events/index.php">Eventet</a></li>
                <li><i class="fas fa-angle-right"></i> <a href="/biletaria_online/views/client/apply_form.php">Aplikoni për sallë me qera</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; 2025 Teatri Metropol, #teatrijuaj.
    </div>

</footer>

<button onclick="topFunction()" id="movetop" title="Go to top">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</button>

<script>
    // Scroll-fade IntersectionObserver
    document.addEventListener('DOMContentLoaded', () => {
        const footer = document.getElementById('futuristic-footer');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        observer.observe(footer);
    });
</script>

<script>
    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
            document.getElementById("movetop").style.display = "block";
        } else {
            document.getElementById("movetop").style.display = "none";
        }
    }
    function topFunction() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }
</script>