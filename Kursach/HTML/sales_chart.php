<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <title>График продаж</title>
    <link rel="stylesheet" href="../CSS/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .hero-info {
            color: #fff;
        }

        .chart-container {
            position: relative;
            margin: auto;
            height: 70vh; 
            width: 70vw;
            border: 2px solid #fff;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <header class="container">
            <div class="logo"></div>
            <a href="/Kursach/HTML/home.php"><img src="../img/logo.png" class="logo.png" width="150px" alt="Company Logo" /></a>
            <nav>
                <ul>
                    <span><a href="product_catalog.php">Каталог товаров</a></span>
                    <span><a href="cart.php">Корзина</a></span>
                    <span><a href="orders.php">Заказы</a></span>
                    <span class="admin"><a href="create_product.php">Добавить товар</a></span>
                    <span class="customers admin"><a href="clients.php">Клиенты</a></span>
                    <span class="customers admin"><a href="clients_order.php">Заказы клиентов</a></span>
                    <span class="user">Здравствуйте, Абдуллаев Абдулла Исламович</span>
                    <span><a href="sales_chart.php">График продаж</a></span>
                    <span class = "admin"><a href="sales_report.php">Отчет по продажам</a></span>
                </ul>
            </nav>
        </header>
        <div class="hero">
            <div class="hero-info">
                <h1>График продаж</h1>
                <?php
                require_once __DIR__ . '/../src/helpers.php';
                $pdo = getPDO();
                $user = currentUser();

                $stmt = $pdo->query("SELECT DATE(order_date) as order_date, SUM(quantity) as total_quantity FROM orders GROUP BY DATE(order_date)");
                $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $dates = [];
                $totalQuantities = [];
                $totalQuantity = 0;

                foreach ($orders as $order) {
                    $dates[] = $order['order_date'];
                    $totalQuantities[] = $order['total_quantity'];
                    $totalQuantity += $order['total_quantity'];
                }
                ?>
                <p>Общее количество заказов: <?php echo htmlspecialchars($totalQuantity); ?></p>
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($dates); ?>,
                    datasets: [{
                        label: 'Общее количество товаров',
                        data: <?php echo json_encode($totalQuantities); ?>,
                        borderColor: '#fff', 
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderWidth: 2,
                        fill: true,
                        pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(75, 192, 192, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Дата',
                                color: '#fff', 
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            ticks: {
                                color: '#fff', 
                                font: {
                                    size: 12
                                }
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)' 
                            }
                        },
                        y: {
                            title: {
                                display: false, 
                            },
                            ticks: {
                                color: '#fff', 
                                font: {
                                    size: 12
                                },
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)' 
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: '#fff',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 12
                            },
                            footerFont: {
                                size: 10
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
