<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIK)
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

/*
|--------------------------------------------------------------------------
| REGISTER GURU
|--------------------------------------------------------------------------
*/
$routes->get('register-guru', 'AuthRegister::form');
$routes->post('register-guru', 'AuthRegister::store');

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/
$routes->get('forgot', 'AuthForgot::index');
$routes->post('forgot/email', 'AuthForgot::email');
$routes->post('forgot/wa', 'AuthForgot::wa');

/*
|--------------------------------------------------------------------------
| OTP WHATSAPP
|--------------------------------------------------------------------------
*/
$routes->get('forgot-wa', 'AuthOtp::request');
$routes->post('send-otp', 'AuthOtp::send');
$routes->get('verify-otp', 'AuthOtp::verify');
$routes->post('verify-otp', 'AuthOtp::check');
$routes->get('reset-password-wa', 'AuthOtp::resetForm');
$routes->post('reset-password-wa', 'AuthOtp::resetSave');

/*
|--------------------------------------------------------------------------
| DASHBOARD (LOGIN)
|--------------------------------------------------------------------------
*/
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'Dashboard::index');
    $routes->get('admin', 'Dashboard::admin', ['filter' => 'role:2']);
    $routes->get('guru', 'Dashboard::guru', ['filter' => 'role:3']);
    $routes->get('superadmin', 'Dashboard::superadmin', ['filter' => 'role:1']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN (ROLE 2) – TANPA INPUT ABSENSI
    |--------------------------------------------------------------------------
    */
    $routes->group('admin', ['filter' => 'role:2'], function ($routes) {

        // REALTIME
        $routes->get('guru/online-json', 'Dashboard::guruOnlineJson');

        // MANAGEMENT GURU
        $routes->get('guru', 'AdminGuru::index');
        $routes->get('guru/create', 'AdminGuru::create');
        $routes->post('guru/store', 'AdminGuru::store');
        $routes->get('guru/toggle/(:num)', 'AdminGuru::toggle/$1');

        // REKAP ABSENSI (READ ONLY)
        $routes->get('rekap-absensi', 'AdminAbsensi::index');
        $routes->get('rekap-absensi/export-pdf', 'AdminAbsensi::exportPdf');
        $routes->get('statistik-absensi', 'AdminAbsensi::statistik');
        $routes->get('statistik', 'Admin\Statistik::index');

        // EXPORT
        $routes->get('export-excel/mingguan', 'AdminAbsensi::exportMingguan');
        $routes->get('export-excel/bulanan', 'AdminAbsensi::exportBulanan');
        $routes->get('export-excel/tahunan', 'AdminAbsensi::exportTahunan');

        // BAHAN AJAR
        $routes->get('bahan-ajar', 'AdminMateri::index');
        $routes->post('bahan-ajar/upload', 'AdminMateri::upload');
        $routes->get('bahan-ajar/edit/(:num)', 'AdminMateri::edit/$1');
        $routes->post('bahan-ajar/update/(:num)', 'AdminMateri::update/$1');
        $routes->get('bahan-ajar/delete/(:num)', 'AdminMateri::delete/$1');
        $routes->post('bahan-ajar/update-ajax/(:num)', 'AdminMateri::updateAjax/$1');
    });
});

/*
|--------------------------------------------------------------------------
| GURU (ROLE 3) – SATU-SATUNYA INPUT ABSENSI
|--------------------------------------------------------------------------
*/
$routes->group('guru', ['filter' => ['auth', 'role:3']], function ($routes) {

    // DASHBOARD AJAX
    $routes->get('status', 'Guru\Dashboard::ajaxStatus');

    // ======================
    // ABSENSI (FINAL JINAK)
    // ======================

    // STEP 1
    $routes->get('absensi', 'Absensi::step1');

    // STEP 2 (GET)
    $routes->get('absensi/tampilkan', 'Absensi::tampilkan');

    // SIMPAN (GET+POST DITERIMA, CONTROLLER YANG ATUR)
    $routes->match(['get','post'], 'absensi/simpan', 'Absensi::simpan');

    // ABSENSI HARI INI (EDIT ≤ 1 JAM)
    $routes->get('absensi-hari-ini', 'Absensi::hariIni');
    $routes->post('absensi-hari-ini/simpan', 'Absensi::simpanEditHariIni');

    // OPTIONAL
    $routes->get('absensi/dobel', 'Absensi::dobel');
    $routes->post('absen', 'Absensi::ajaxAbsen');

    // MURID
    $routes->get('murid', 'GuruMurid::index');
    $routes->get('murid/create', 'GuruMurid::create');
    $routes->post('murid/store', 'GuruMurid::store');

    // PROFIL
    $routes->get('profil', 'GuruProfil::index');
    $routes->post('profil/update', 'GuruProfil::update');

    // MATERI
    $routes->get('materi', 'GuruMateri::index');

    // AUDIT (READ ONLY)
    $routes->get('audit-log', 'AdminAudit::index');
});
