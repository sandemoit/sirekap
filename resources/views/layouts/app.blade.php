<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets') }}/css/sb-admin-2.min.css" rel="stylesheet">

    {{-- cusom in view --}}
    @stack('custom-css')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIREKAP SISWA</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Manajemen
            </div>

            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff_admin')
                <!-- Nav Item - Manajemen Siswa -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents"
                        aria-expanded="true" aria-controls="collapseStudents">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Manajemen Siswa</span>
                    </a>
                    <div id="collapseStudents" class="collapse" aria-labelledby="headingStudents"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Siswa:</h6>
                            <a class="collapse-item" href="{{ route('students') }}">Daftar Siswa</a>
                            <a class="collapse-item" href="{{ route('class') }}">Daftar Kelas</a>
                            <a class="collapse-item" href="{{ route('students.add') }}">Input Data Siswa</a>
                            <a class="collapse-item" href="{{ route('students.import') }}">Import Data Siswa</a>
                        </div>
                    </div>
                </li>
            @endif

            <!-- Nav Item - Kehadiran -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAttendance"
                    aria-expanded="true" aria-controls="collapseAttendance">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Kehadiran</span>
                </a>
                <div id="collapseAttendance" class="collapse" aria-labelledby="headingAttendance"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Kehadiran:</h6>
                        <a class="collapse-item" href="{{ route('kehadiran') }}">Input Kehadiran Siswa</a>
                        <a class="collapse-item" href="{{ route('kehadiran.import') }}">Import Kehadiran</a>
                        <a class="collapse-item" href="{{ route('kehadiran.rekap') }}">Rekap Kehadiran</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Penilaian -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAssessments"
                    aria-expanded="true" aria-controls="collapseAssessments">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Penilaian</span>
                </a>
                <div id="collapseAssessments" class="collapse" aria-labelledby="headingAssessments"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Penilaian:</h6>
                        <a class="collapse-item" href="{{ route('penilaian') }}">Input Nilai</a>
                        <a class="collapse-item" href="{{ route('penilaian.import') }}">Import Nilai</a>
                        {{-- <a class="collapse-item" href="#">Rekap Nilai</a> --}}
                    </div>
                </div>
            </li>

            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff_admin')
                <!-- Nav Item - Kejuaraan -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse"
                        data-target="#collapseCompetitions" aria-expanded="true" aria-controls="collapseCompetitions">
                        <i class="fas fa-fw fa-trophy"></i>
                        <span>Kejuaraan</span>
                    </a>
                    <div id="collapseCompetitions" class="collapse" aria-labelledby="headingCompetitions"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Kejuaraan:</h6>
                            <a class="collapse-item" href="{{ route('competition.add') }}">Input Kejuaraan</a>
                            <a class="collapse-item" href="{{ route('competition') }}">Daftar Kejuaraan</a>
                        </div>
                    </div>
                </li>
            @endif

            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'staff_admin')
                <!-- Nav Item - Laporan -->
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse"
                        data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
                        <i class="fas fa-fw fa-file-alt"></i>
                        <span>Laporan</span>
                    </a>
                    <div id="collapseReports" class="collapse" aria-labelledby="headingReports"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Laporan:</h6>
                            <a class="collapse-item" href="#">Laporan Kehadiran</a>
                            <a class="collapse-item" href="#">Laporan Nilai</a>
                        </div>
                    </div>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Pengaturan
                </div>
                <!-- Nav Item - Mata Pelajaran -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('subject') }}">
                        <i class="fas fa-fw fa-book-open"></i>
                        <span>Daftar Mata Pelajaran</span>
                    </a>
                </li>

                <!-- Nav Item - Manajemen Pengguna -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user-management') }}">
                        <i class="fas fa-fw fa-user-cog"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                </li>

                <!-- Nav Item - Pengaturan Umum -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('setting') }}">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Pengaturan Umum</span>
                    </a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.navigation')

                <!-- Begin Page Content -->

                <!-- Page Heading -->
                {{ $slot }}

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets') }}/js/sb-admin-2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets') }}/js/notifikasi.js"></script>
    <script>
        @if (Session::has('error'))
            var error = "{{ Session::get('error') }}";
        @elseif (Session::has('success'))
            var success = "{{ Session::get('success') }}";
        @endif
    </script>

    {{-- custom in view --}}
    @stack('custom-js')
</body>

</html>
