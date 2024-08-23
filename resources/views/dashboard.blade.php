<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard Penampungan Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* Tambahkan gaya untuk sidebar */
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .sb-sidenav {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }
        .sb-sidenav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            display: block;
        }
        .sb-sidenav a:hover {
            background-color: #495057;
        }
        .sb-main {
            margin-left: 250px;
            padding: 1rem;
            flex: 1;
        }
        .sb-nav-fixed {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Sidebar -->
    <div class="sb-sidenav">
        <h2>Sidebar</h2>
        <a href="#" id="homeLink">Home</a>
        <a href="#" id="organikLink">Organik</a>
        <a href="#" id="anorganikLink">Anorganik</a>
        <!-- Tambahkan link lain sesuai kebutuhan -->
    </div>

    <!-- Konten utama -->
    <div class="sb-main">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Selamat Datang Di!</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard Penampung Sampah Pintar</li>
                </ol>

                <!-- Div untuk menampilkan gambar SVG -->
                <div id="dashboardSVGContainer" style="text-align: center;">
                    <img src="{{ asset('assets/img/person.png') }}" alt="Diagram Kepenuhan Tong Sampah"
                        style="width: 100%; max-width: 600px; display: block; margin: 0 auto;">
                </div>

                <!-- Div untuk menampilkan diagram Organik -->
                <div id="organikDiagramContainer" style="display: none;">
                    <h2>Diagram Kepenuhan Tong Sampah Organik</h2>
                    <canvas id="organikDiagram" style="width: 500px; height: 500px;"></canvas>
                </div>

                <!-- Div untuk menampilkan diagram Anorganik -->
                <div id="anorganikDiagramContainer" style="display: none;">
                    <h2>Diagram Kepenuhan Tong Sampah Anorganik</h2>
                    <canvas id="anorganikDiagram" style="width: 500px; height: 500px;"></canvas>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Vania Fikri Rahmadani 2024</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms & Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script>
        // Variabel untuk menyimpan instance chart
        var organikChart = null;
        var anorganikChart = null;

        // Fungsi untuk mengatur tampilan diagram yang sesuai
        function showDiagram(diagramType) {
            if (diagramType === 'organik') {
                document.getElementById('dashboardSVGContainer').style.display = 'none'; // Sembunyikan gambar SVG
                document.getElementById('anorganikDiagramContainer').style.display = 'none'; // Sembunyikan diagram Anorganik
                document.getElementById('organikDiagramContainer').style.display = 'block';

                // Hapus chart jika sudah ada
                if (organikChart) {
                    organikChart.destroy();
                }

                renderOrganikDiagram();
            } else if (diagramType === 'anorganik') {
                document.getElementById('dashboardSVGContainer').style.display = 'none'; // Sembunyikan gambar SVG
                document.getElementById('organikDiagramContainer').style.display = 'none'; // Sembunyikan diagram Organik
                document.getElementById('anorganikDiagramContainer').style.display = 'block';

                // Hapus chart jika sudah ada
                if (anorganikChart) {
                    anorganikChart.destroy();
                }

                renderAnorganikDiagram();
            }
        }

        // Event listener untuk klik pada link di sidebar
        document.getElementById('organikLink').addEventListener('click', function(event) {
            event.preventDefault();
            showDiagram('organik');
        });

        document.getElementById('anorganikLink').addEventListener('click', function(event) {
            event.preventDefault();
            showDiagram('anorganik');
        });

        // Fungsi untuk mengambil data Organik dari API
        function fetchOrganikData() {
            return fetch('/api/organik-data')
                .then(response => response.json())
                .catch(error => console.error('Error fetching organik data:', error));
        }

        // Fungsi untuk mengambil data Anorganik dari API
        function fetchAnorganikData() {
            return fetch('/api/anorganik-data')
                .then(response => response.json())
                .catch(error => console.error('Error fetching anorganik data:', error));
        }

        // Render diagram Organik
        function renderOrganikDiagram() {
            fetchOrganikData().then(data => {
                var ctx = document.getElementById('organikDiagram').getContext('2d');
                organikChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        }

        // Render diagram Anorganik
        function renderAnorganikDiagram() {
            fetchAnorganikData().then(data => {
                var ctx = document.getElementById('anorganikDiagram').getContext('2d');
                anorganikChart = new Chart(ctx, {
                    type: 'bar',
                    data: data,
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        }
    </script>
</body>
</html>
