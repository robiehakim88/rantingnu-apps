<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranting NU Pelem Apps</title>
    <!-- Font Awesome Icons (via CDN) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- AdminLTE CSS (via CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <!-- Bootstrap CSS (via CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    
      <!-- DataTables -->
      <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


      <!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            
        <!-- Bagian kanan navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Tombol Logout -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link btn btn-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </li>
    </ul>    
        </nav>


<!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/dashboard') }}" class="brand-link text-center">
                <span class="brand-text">Ranting NU Pelem</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Anggota -->
                        <li class="nav-item">
                            <a href="{{ url('/members') }}" class="nav-link {{ request()->is('members*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manajemen Anggota</p>
                            </a>
                        </li>
                        
                         <!-- Peran Anggota -->
                        <li class="nav-item">
                            <a href="{{ url('/roles') }}" class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-tag"></i>
                                <p>Peran Anggota</p>
                            </a>
                        </li>

                        <!-- Surat Menyurat -->
                        <li class="nav-item">
                            <a href="{{ url('/letters') }}" class="nav-link {{ request()->is('letters*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Surat Menyurat</p>
                            </a>
                        </li>
                        <!-- Rencana Anggaran Biaya -->
                        <li class="nav-item">
                            <a href="{{ url('/budgets') }}" class="nav-link {{ request()->is('budgets*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Perencanaan Anggaran</p>
                            </a>
                        </li>
                        <!-- Keuangan -->
                        <li class="nav-item">
                            <a href="{{ url('/finances') }}" class="nav-link {{ request()->is('finances*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money-bill"></i>
                                <p>Keuangan</p>
                            </a>
                        </li>

                        <!-- Kegiatan -->
                        <li class="nav-item">
                            <a href="{{ url('/events') }}" class="nav-link {{ request()->is('events*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar"></i>
                                <p>Kegiatan</p>
                            </a>
                        </li>

                       

                        <!-- Masjid dan Musholla -->
                        <li class="nav-item">
                            <a href="{{ url('/places') }}" class="nav-link {{ request()->is('places*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-mosque"></i>
                                <p>Masjid dan Musholla</p>
                            </a>
                        </li>

                        <!-- Anak Yatim Piatu -->
                        <li class="nav-item">
                            <a href="{{ url('/orphans') }}" class="nav-link {{ request()->is('orphans*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-child"></i>
                                <p>Anak Yatim Piatu</p>
                            </a>
                        </li>
                        
                        
                    </ul>
                </nav>
            </div>
        </aside>


        <!-- Konten Utama -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <h1 class="m-0">@yield('title')</h1>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2025 NU Ranting Pelem.</strong>
        </footer>
    </div>

   <!-- jQuery (via CDN) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AdminLTE JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    
    
    <!-- DataTables  & Plugins -->
<script src="https://adminlte.io/themes/v3/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/jszip/jszip.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/pdfmake/pdfmake.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/pdfmake/vfs_fonts.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    
    

</body>
</html>