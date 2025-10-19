<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý doanh thu</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/css/custom-theme.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php include __DIR__ . '/topbar.php'; ?>
                <!-- End Topbar -->
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Doanh thu</h1>

                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Doanh thu
                                        tuần</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= array_sum(array_column($weekRevenue,'total')) ?>₫</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Doanh thu
                                        tháng</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= array_sum(array_column($monthRevenue,'total')) ?>₫</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Doanh thu năm
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= array_sum(array_column($yearRevenue,'total')) ?>₫</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Doanh thu</h1>

                    <canvas id="weekChart" height="100"></canvas>
                    <canvas id="monthChart" height="100" class="mt-4"></canvas>
                    <canvas id="yearChart" height="100" class="mt-4"></canvas>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End Main Content -->
        </div>
        <!-- End Content Wrapper -->
    </div>
    <!-- End Wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const weekData = {
        labels: [1, 2, 3, 4, 5, 6, 7],
        datasets: [{
            label: 'Doanh thu tuần (VNĐ)',
            data: [<?= implode(',', array_column($weekRevenue, 'total')) ?>],
            backgroundColor: 'rgba(78, 115, 223, 0.5)'
        }]
    };

    const monthData = {
        labels: [<?= implode(',', array_column($monthRevenue, 'day')) ?>],
        datasets: [{
            label: 'Doanh thu tháng (VNĐ)',
            data: [<?= implode(',', array_column($monthRevenue, 'total')) ?>],
            backgroundColor: 'rgba(28, 200, 138, 0.5)'
        }]
    };

    const yearData = {
        labels: [<?= implode(',', array_column($yearRevenue, 'month')) ?>],
        datasets: [{
            label: 'Doanh thu năm (VNĐ)',
            data: [<?= implode(',', array_column($yearRevenue, 'total')) ?>],
            backgroundColor: 'rgba(54, 185, 204, 0.5)'
        }]
    };

    new Chart(document.getElementById('weekChart'), {
        type: 'bar',
        data: weekData
    });
    new Chart(document.getElementById('monthChart'), {
        type: 'bar',
        data: monthData
    });
    new Chart(document.getElementById('yearChart'), {
        type: 'bar',
        data: yearData
    });
    </script>
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>