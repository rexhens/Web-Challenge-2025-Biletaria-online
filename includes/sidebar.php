
<link href="/biletaria_online/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link href="/biletaria_online/assets/css/sb-admin-2.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<!-- Scripts (in proper order) -->

<!-- jQuery (must come first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 with Popper included -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- sb-admin-2 (your custom template) -->
<script src="/biletaria_online/assets/js/sb-admin-2.min.js"></script>

<!-- jQuery Easing (if used in sb-admin-2) -->
<script src="/biletaria_online/assets/vendor/jquery-easing/jquery.easing.min.js"></script>



<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background-color: #8f793f !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/biletaria_online/views/admin/index.php">
        <div class=" sidebar-brand-text mx-3">Paneli i menaxhimit</div>
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
        <a class="nav-link" href="/biletaria_online/views/admin/index.php#graphs-section">
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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Menaxho Perdoruesit</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/users/add-user.php">Shto perdorues te
                    ri</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/users/index.php">Shiko te gjithe</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- Menaxho Shfaqjet -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShows" aria-expanded="true"
            aria-controls="collapseShows">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Menaxho Shfaqjet</span>
        </a>
        <div id="collapseShows" class="collapse" aria-labelledby="headingShows" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/shows/add-show.php">Shto Shfaqje</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/shows/index.php">Te gjitha Shfaqjet</a>
            </div>
        </div>
    </li>

    <!-- Menaxho Aktoret -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActors" aria-expanded="true"
            aria-controls="collapseActors">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Menaxho Aktoret</span>
        </a>
        <div id="collapseActors" class="collapse" aria-labelledby="headingActors" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/actors/index.php">Te gjithe Aktoret</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/actors/add.php">Shto nje Aktor te ri</a>
            </div>
        </div>
    </li>

    <!-- Menaxho Eventet -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvents" aria-expanded="true"
            aria-controls="collapseEvents">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Menaxho Eventet</span>
        </a>
        <div id="collapseEvents" class="collapse" aria-labelledby="headingEvents" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/events/add-event.php">Shto Event te ri</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/events/index.php">Te gjitha Eventet</a>
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