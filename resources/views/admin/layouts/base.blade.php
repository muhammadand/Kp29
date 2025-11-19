<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - @yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Custom styles for this template-->
    <link href="{{ asset('/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.service-categories.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>kategori service</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.service-items.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>service</span>
                </a>
            </li>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.laporan.transaksi') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Laporan</span>
                </a>
            </li>



            <!-- Nav Item - Produk -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Produk</span>
                </a>
            </li>

            <!-- Nav Item - Pesanan (Dropdown) -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders"
                    aria-expanded="true" aria-controls="collapseOrders">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Pesanan</span>
                </a>
                <div id="collapseOrders" class="collapse" aria-labelledby="headingOrders"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('admin.orders.index') }}">
                            pesanan kayu
                        </a>

                        <a class="collapse-item" href="{{ route('admin.service-orders.index') }}">Pesanan jasa</a>

                    </div>
                </div>
            </li>





            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

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

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">

                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>

                                <!-- Counter -->
                                <span id="alertCount" class="badge badge-danger badge-counter d-none">0</span>
                            </a>

                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Alerts Center</h6>

                                <div id="alertList"></div>

                                <a class="dropdown-item text-center small text-gray-500" href="#">
                                    Show All Alerts
                                </a>
                            </div>

                        </li>


                        <script>
                            document.addEventListener("DOMContentLoaded", function() {

                                $.ajax({
                                    url: "/admin/check-new-orders",
                                    type: "GET",
                                    success: function(orderRes) {

                                        $.ajax({
                                            url: "/admin/check-new-service-orders",
                                            type: "GET",
                                            success: function(serviceRes) {

                                                console.log("ORDER =", orderRes);
                                                console.log("SERVICE =", serviceRes);

                                                // Hitung total notifikasi
                                                let totalCount = orderRes.count + serviceRes.count;

                                                if (totalCount > 0) {
                                                    $("#alertCount").removeClass("d-none").text(totalCount);
                                                } else {
                                                    $("#alertCount").addClass("d-none");
                                                }

                                                let html = "";

                                                // ==============================
                                                // 🔥 Render Notifikasi Order Barang
                                                // ==============================
                                                orderRes.orders.forEach(order => {

                                                    let bgStyle = order.is_read == 0 ?
                                                        "background:#e9ecef;" :
                                                        "background:#ffeeba;";

                                                    html += `
                            <a onclick="markAsRead(${order.id}, 'order')" 
                                class="dropdown-item d-flex align-items-center"
                                style="${bgStyle} cursor:pointer;">

                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-shopping-bag text-white"></i>
                                    </div>
                                </div>

                                <div>
                                    <div class="small text-gray-500">${order.created_at}</div>
                                    <span class="font-weight-bold">
                                        Pesanan barang dari <b>${order.nama_pelanggan}</b>
                                    </span>
                                    <div>Produk: ${order.items[0].product.nama_produk}</div>
                                </div>

                            </a>
                        `;
                                                });

                                                // ==============================
                                                // 🔥 Render Notifikasi Order Service
                                                // ==============================
                                                serviceRes.orders.forEach(sv => {

                                                    let bgStyle = sv.is_read == 0 ?
                                                        "background:#e9ecef;" :
                                                        "background:#d4edda;"; // hijau soft

                                                    html += `
                            <a onclick="markAsRead(${sv.id}, 'service')" 
                                class="dropdown-item d-flex align-items-center"
                                style="${bgStyle} cursor:pointer;">

                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-tools text-white"></i>
                                    </div>
                                </div>

                                <div>
                                    <div class="small text-gray-500">${sv.created_at}</div>
                                    <span class="font-weight-bold">
                                        Order service dari <b>${sv.customer_name}</b>
                                    </span>
                                    <div>Layanan: ${sv.item.name}</div>
                                </div>

                            </a>
                        `;
                                                });

                                                $("#alertList").html(html);

                                            },
                                            error: function(err) {
                                                console.log("SERVICE AJAX ERROR:", err);
                                            }
                                        });

                                    },
                                    error: function(err) {
                                        console.log("ORDER AJAX ERROR:", err);
                                    }
                                });

                            });


                            // =====================================================
                            // 🔥 Tandai sebagai dibaca + Redirect
                            // =====================================================
                            function markAsRead(id, type) {

                                let url = type === "order" ?
                                    `/admin/orders/mark-read/${id}` :
                                    `/admin/service-orders/mark-read/${id}`;

                                let redirectUrl = type === "order" ?
                                    `/admin/orders/${id}` :
                                    `/admin/service-orders/${id}`;

                                $.ajax({
                                    url: url,
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}"
                                    },
                                    success: function() {
                                        window.location.href = redirectUrl;
                                    }
                                });
                            }
                        </script>










                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    {{ Auth::guard('admin')->user()->username ?? 'Admin' }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('assets/img/undraw_profile.svg') }}">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
                    @yield('content')
                </div>

            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>

        </div>

    </div>

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
                <div class="modal-body">
                    Pilih "Logout" di bawah jika kamu yakin ingin mengakhiri sesi ini.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
</body>

</html>
