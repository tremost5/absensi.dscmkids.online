<nav class="mt-2">
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

    <!-- DASHBOARD -->
    <li class="nav-item">
        <a href="/dashboard/admin" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <!-- MANAJEMEN GURU -->
    <li class="nav-item">
        <a href="/dashboard/admin/guru" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Manajemen Guru</p>
        </a>
    </li>

    <!-- ABSENSI -->
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-clipboard-check"></i>
            <p>
                Absensi
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview ml-3">
            <li class="nav-item">
                <a href="/dashboard/admin/rekap-absensi" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rekap Absensi</p>
                </a>
            </li>
            <li class="nav-item">
    <a href="<?= base_url('dashboard/admin/statistik') ?>"
       class="nav-link <?= (uri_string() == 'dashboard/admin/statistik') ? 'active' : '' ?>">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>Statistik</p>
    </a>
</li>


        </ul>
    </li>

    <!-- EXPORT -->
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-export"></i>
            <p>
                Export Excel
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview ml-3">
            <li class="nav-item">
                <a href="/dashboard/admin/export-excel/mingguan" class="nav-link">
                    <p>Mingguan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/admin/export-excel/bulanan" class="nav-link">
                    <p>Bulanan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/dashboard/admin/export-excel/tahunan" class="nav-link">
                    <p>Tahunan</p>
                </a>
            </li>
        </ul>
    </li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-pdf"></i>
        <p>
            Export PDF
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('dashboard/admin/rekap-absensi/export-pdf?type=mingguan') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Mingguan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('dashboard/admin/rekap-absensi/export-pdf?type=bulanan') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bulanan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('dashboard/admin/rekap-absensi/export-pdf?type=tahunan') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Tahunan</p>
            </a>
        </li>
    </ul>
</li>


    <!-- BAHAN AJAR -->
    <li class="nav-item">
        <a href="/dashboard/admin/bahan-ajar" class="nav-link">
            <i class="nav-icon fas fa-upload"></i>
            <p>Upload Bahan Ajar</p>
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
