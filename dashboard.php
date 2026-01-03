<!DOCTYPE html>
<?php
require_once './classes/Visitor.php';
require_once 'classes/DbConnector.php';
require_once 'config/Security.php';
require_once 'config/Logger.php';

Security::configureSession();

// Check authentication
if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}

$name = $_SESSION['name'] ?? 'User';
$userId = $_SESSION['user_id'] ?? 0;

$dbcon = new DbConnector();
$con = $dbcon->getConnection();

// Get counts
$checkedInCount = Visitor::getCheckedInCount($con);
$checkedOutCount = Visitor::getCheckedOutCount($con);
$reportedCount = Visitor::getReportedCount($con);
$totalVisitorsCount = Visitor::getTotalVisitorsCountMonthly($con);
?>

<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Security Dashboard - Sentinel Safe</title>
        <!-- ======= Styles ====== -->

        <link href="css/dashboard.css" rel="stylesheet" type="text/css"/>
        <link href="css/maindash.css" rel="stylesheet" type="text/css"/>
        <link href="css/navbar.css" rel="stylesheet" type="text/css"/>



        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

    </head>



    <body>
        <!-- =============== Navigation ================ -->
        <div class="section">
            <div class="navigation">
                <ul>
                    <li>
                        <a href="dashboard.php">
                            <span class="icon" style="color: #2a2185;">
                                <ion-icon name="cash-outline"></ion-icon>                                
                            </span>
                            <img src="images/logo.png" alt="" style="width: 150px; height: 50px; margin-top: 20px"/>
                        </a>
                    </li>

                    <li>
                        <a href="dashboard.php">
                            <span class="icon">
                                <span class="material-symbols-outlined">dashboard</span>
                            </span>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="visitorData.php">
                            <span class="icon">
                                <ion-icon name="cash-outline"></ion-icon>
                            </span>
                            <span class="title">Visitors</span>
                        </a>
                    </li>

                    <li>
                        <a href="editVisitor.php">
                            <span class="icon">
                                <ion-icon name="card-outline"></ion-icon>
                            </span>
                            <span class="title">Edit</span>
                        </a>
                    </li>

                    <li>
                        <a href="settings.php">
                            <span class="icon">
                                <ion-icon name="settings-outline"></ion-icon>
                            </span>
                            <span class="title">Settings</span>
                        </a>
                    </li>

                    <li>
                        <a href="logout.php">
                            <span class="icon">
                                <ion-icon name="log-out-outline"></ion-icon>
                            </span>
                            <span class="title">Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ========================= Main ==================== -->
            <div class="main">
                <div class="topbar">
                    <div class="toggle">
                        <ion-icon name="menu-outline"></ion-icon>
                    </div>

                    <div>
                        <h2>Welcome,<?php echo " $name"; ?>!</h2>
                    </div>
                </div>

                <!-- show the currect month -->
                <div class="current-month" style="padding: 20px; margin-bottom: -20px; margin-left: 5px;">
                    <h3>Month: <?php echo date('F'); ?></h3>
                </div>

                <!-- ======================= Cards ================== -->
                <div class="cardBox">
                    <div class="card card-checkin">
                        <div>
                            <div class="numbers"><?php echo $checkedInCount; ?></div>
                            <div class="cardName">Checked In</div>
                        </div>
                    </div>
                    <div class="card card-checkout">
                        <div>
                            <div class="numbers"><?php echo $checkedOutCount; ?></div>
                            <div class="cardName">Checked Out</div>
                        </div>
                    </div>
                    <div class="card card-reported">
                        <div>
                            <div class="numbers"><?php echo $reportedCount; ?></div>
                            <div class="cardName">Reported</div>
                        </div>
                    </div>
                    <div class="card card-total">
                        <div>
                            <div class="numbers"><?php echo $totalVisitorsCount; ?></div>
                            <div class="cardName">Total Visitors</div>
                        </div>
                    </div>
                </div>

                <!-- ================ Recent transactions ================= -->
                <div class="transactions-container">
                    <div class="transactions recent">
                        <div class="cardHeader">
                            <h2>Recent Visitors</h2>
                            <a href="visitorData.php" class="btn">View All</a>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Time</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once './classes/DbConnector.php';
                                require_once 'classes/visitor.php';
                                try {
                                    $dbcon = new DbConnector();
                                    $con = $dbcon->getConnection();
                                    $visitors = Visitor::getRecentVisitors($con);
                                    if ($visitors === false) {
                                        echo "<tr><td colspan='5'>Error: Unable to fetch visitor data.</td></tr>";
                                    } elseif (empty($visitors)) {
                                        echo "<tr><td colspan='5'>No recent visitor records found.</td></tr>";
                                    } else {
                                        foreach ($visitors as $visitor) {
                                            $actionTaken = getFormattedAction($visitor['action_taken']);
                                            $statusClass = getStatusClass($actionTaken);
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($visitor['date']) . "</td>";
                                            echo "<td>" . htmlspecialchars($visitor['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($visitor['time']) . "</td>";
                                            echo "<td>" . htmlspecialchars($visitor['reason']) . "</td>";
                                            echo "<td><span class='status $statusClass'>" . htmlspecialchars($actionTaken) . "</span></td>";
                                            echo "</tr>";
                                        }
                                    }
                                } catch (Exception $e) {
                                    echo "<tr><td colspan='5'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                                    error_log("Error: " . $e->getMessage());
                                }

                                function getFormattedAction($action) {
                                    switch (strtolower($action)) {
                                        case 'checked_in':
                                            return 'Checked In';
                                        case 'checked_out':
                                            return 'Checked Out';
                                        case 'reported':
                                            return 'Reported';
                                        default:
                                            return $action;
                                    }
                                }

                                function getStatusClass($action) {
                                    switch ($action) {
                                        case 'Checked In':
                                            return 'checked-in';
                                        case 'Checked Out':
                                            return 'checked-out';
                                        case 'Reported':
                                            return 'reported';
                                        default:
                                            return 'other';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="recentCustomers">
                    <div class="cardHeader" style="display: flex; justify-content: center; align-items: center; margin-bottom: 30px;">
                        <h2>Generate a Report</h2>
                    </div>
                    <!-- PDF export button -->
                    <div style="text-align: center; margin-bottom: 30px;">
                        <form action="export_pdf.php" method="post">
                            <button type="submit" class="btn btn-primary">Export to PDF</button>
                        </form>
                    </div>


                </div>

            </div>


            <!-- =========== Scripts =========  -->
            <script src="js/js.js" type="text/javascript"></script>

            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>

</html>