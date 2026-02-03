<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

    <!-- DASHBOARD -->
    <li class="nav-item">
        <a href="/dashboard/guru" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <!-- ABSENSI -->
    <li class="nav-item">
        <a href="/guru/absensi" class="nav-link">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>Absensi</p>
        </a>
    </li>
    
<li class="nav-item">
  <a href="<?= base_url('guru/absensi-hari-ini') ?>" class="nav-link">
    <i class="nav-icon fas fa-edit"></i>
    <p>Absensi Hari Ini</p>
  </a>
</li>

    <!-- DATA MURID -->
    <li class="nav-item">
        <a href="/guru/murid" class="nav-link">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>Data Murid</p>
        </a>
    </li>

    <!-- PROFIL -->
    <li class="nav-item">
        <a href="/guru/profil" class="nav-link">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>Profil Saya</p>
        </a>
    </li>

    <!-- LOGOUT -->
    <li class="nav-item mt-3">
        <a href="/logout" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
        </a>
    </li>

</ul>
</nav>
