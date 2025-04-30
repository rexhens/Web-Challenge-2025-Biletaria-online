
<!-- jQuery for dropdown box elements -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<style>
    .navbar-nav span {
        color: white !important;
        font-family: "Quicksand", sans-serif;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        font-weight: 600;
        z-index: 1000 !important;
    }

    .sidebar-brand-text {
        font-family: "Russo One", sans-serif;
        font-weight: bold;
    }

    body {
        margin-left: 6.5rem !important;
    }

    @media (min-width: 768px) {
        body {
            margin-left: 14rem !important;
        }
    }
</style>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background-color: #8f793f !important;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="/biletaria_online/views/admin/index.php">

        <!-- Show icon only on small screens -->
        <div class="d-block d-md-none">
            <i class="fas fa-tools"></i> <!-- Or another icon -->
        </div>

        <!-- Show text only on medium and larger screens -->
        <div class="sidebar-brand-text mx-3 d-none d-md-block">
            Paneli i menaxhimit
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="/biletaria_online/auth/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Dil</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/biletaria_online/views/admin/index.php#graphs-section">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Grafikët</span></a>
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
            <i class="fas fa-fw fa-wrench"></i>
            <span>Menaxho Përdoruesit</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/users/index.php">Të gjithë përdoruesit</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/users/add-user.php">Shto përdorues të ri</a>
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
                <a class="collapse-item" href="/biletaria_online/views/admin/shows/index.php">Të gjitha shfaqjet</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/shows/add-show.php">Shto shfaqje të re</a>
            </div>
        </div>
    </li>

    <!-- Menaxho Aktoret -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseActors" aria-expanded="true"
            aria-controls="collapseActors">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Menaxho Aktorët</span>
        </a>
        <div id="collapseActors" class="collapse" aria-labelledby="headingActors" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/actors/index.php">Te gjithë aktorët</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/actors/add.php">Shto aktor të ri</a>
            </div>
        </div>
    </li>

    <!-- Menaxho Eventet -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEvents" aria-expanded="true"
            aria-controls="collapseEvents">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Menaxho Eventet</span>
        </a>
        <div id="collapseEvents" class="collapse" aria-labelledby="headingEvents" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Veprime</h6>
                <a class="collapse-item" href="/biletaria_online/views/admin/events/index.php">Të gjitha eventet</a>
                <a class="collapse-item" href="/biletaria_online/views/admin/events/add-event.php">Shto event të ri</a>
            </div>
        </div>
    </li>


<!--
    <hr class="sidebar-divider d-none d-md-block">

    <div style="   display: flex;
                            align-items: center;
                            justify-content: center;">
        <button class="rounded-circle border-0" id="sidebarToggle" style="background: rgba(255, 255, 255, .2); padding: revert;"></button>
    </div>
-->
</ul>