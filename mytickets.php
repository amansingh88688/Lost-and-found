<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    if (!isset($_COOKIE['roll'])) {
        header('Location: index.php');
        session_unset();
        session_destroy();
        exit();
    } else {
        $_SESSION['loggedin'] = true;
        $_SESSION['roll'] = $_COOKIE['roll'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <title>My Tickets | Lost and Found Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- <script src="js/prevent_back.js"></script> -->
    <script src="js/delete_ticket.js"></script>
    <script src="js/mytickets.js"></script>

</head>

<body oncontextmenu="return false;" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    <header>
        <div id="logo">
            <h1>Lost<br>and<br>Found</h1>
        </div>
        <div id="navContainer">
            <div id="searchBar">
                <input type="search" id="searchItem" onsearch="search()" oninput="search()" class="search-input" placeholder="Search for lost items...">
                <span class="material-symbols-outlined">
                    search
                </span>
            </div>
            <div class="Filter">
                <button onclick="myFunction()" class="filterbtn">
                    Filter <span class="material-symbols-outlined">
                        filter_list
                    </span>
                </button>
                <div id="myFilter" class="Filter-content">
                    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
                    <a id="filterSevenDays" onclick="filterDays(7)">Last 7 Days</a>
                    <a id="filterThreeDays" onclick="filterDays(3)">Last 3 Days</a>
                </div>
            </div>

            <a href="lost.php" id="raiseTicketBtn">Raise Ticket<b> +</b></a>
            <a href="logout.php" id="logoutBtn">Log Out</a>
            <a href="home.php" id="logoutBtn">Home</a>
        </div>
    </header>

    <div class="removeFilterClass" id="removeFilter" onclick="removeFilters()">Remove Filter</div>


    <h1>Your Tickets</h1>

    <?php
    include 'dbconnect.php';
    $roll = $_SESSION['roll'];

    $display_sql = "SELECT * FROM `user_content` WHERE `roll` = '$roll' AND `approved` = 'yes' ORDER by `sno` DESC";

    $result_display = mysqli_query($con, $display_sql);

    if ($result_display) {
        if (mysqli_num_rows($result_display) > 0) {
            echo "<h1>Approved tickets</h1>";
            echo '<div id="itemList1">';

            while ($rows_data = mysqli_fetch_assoc($result_display)) {
                if ($rows_data['type'] == 'lost') {
                    echo '<div class="lostandfound">
                    <div class="lost"> 
            
                        <div class="status-box">Lost</div>
                        <img src="data:image/jpg;charset=utf8;base64,' . base64_encode($rows_data['image']) . '">
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="details-section">
                            <h3 class="details">Details:</h3>
                            <div class="info">
                                ' . $rows_data['item'] . ' <br>
                                ' . $rows_data['place'] . '
                                <br>' . $rows_data['date'] . '
                            </div>
                        </div>
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="contact-section">
                            <h3 class="contact">Contact:</h3>
                            <div class="cinfo">
                            ' . $rows_data['name'] . ', ' . $rows_data['roll'] . '<br>' . $rows_data['phone'] . '<br>Hostel - ' . $rows_data['hostel'] . '
                            </div>
                            <div> Uploaded on:
                            <span class="uploadedDate1">' . $rows_data['uploaded_date'] . '</span>
                            </div>
                            <div>
                    <button id="deleteTicket" onclick="deleteTicket(`Do you really want to delete this ticket?`, ' . $rows_data['sno'] . ')">
                        Delete Ticket
                    </button>
                </div>
                        </div>
                        <div class="arrow-container">
                            <div class="arr down">
                                <div></div>
                            </div> <!-- Add the down arrow here -->
                        </div>
                    </div>
                </div>';
                } else if ($rows_data['type'] == 'found') {
                    echo '<div class="lostandfound">
                    <div class="found"> 
            
                        <div class="status-box">Found</div>
                        <img src="data:image/jpg;charset=utf8;base64,' . base64_encode($rows_data['image']) . '">
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="details-section">
                            <h3 class="details">Details:</h3>
                            <div class="info">
                                ' . $rows_data['item'] . ' <br>
                                ' . $rows_data['place'] . '
                                <br>' . $rows_data['date'] . '
                            </div>
                        </div>
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="contact-section">
                            <h3 class="contact">Contact:</h3>
                            <div class="cinfo">
                            ' . $rows_data['name'] . ', ' . $rows_data['roll'] . '<br>' . $rows_data['phone'] . '<br>Hostel - ' . $rows_data['hostel'] . '
                            </div>
                            <div> Uploaded on:
                            <span class="uploadedDate1">' . $rows_data['uploaded_date'] . '</span>
                            </div>
                            <div>
                    <button id="deleteTicket" onclick="deleteTicket(`Do you really want to delete this ticket?`, ' . $rows_data['sno'] . ')">
                        Delete Ticket
                    </button>
                </div>
                        </div>
                    </div>
                </div>';
                }
            }
        }
        echo "</div>";
    } else {
        echo "<script>alert('Some error occured in displaying');</script>";
    }

    ?>

    <?php

    $roll = $_SESSION['roll'];
    $display_sql = "SELECT * FROM `user_content` WHERE `roll` = '$roll' AND `approved` = 'no'";

    $result_display = mysqli_query($con, $display_sql);

    if ($result_display) {
        if (mysqli_num_rows($result_display) > 0) {
            echo "<h1>Yet to be approved tickets</h1>";
            echo '<div id="itemList2">';

            while ($rows_data = mysqli_fetch_assoc($result_display)) {
                if ($rows_data['type'] == 'lost') {
                    echo '<div class="lostandfound">
                    <div class="lost"> 
            
                        <div class="status-box">Lost</div>
                        <img src="data:image/jpg;charset=utf8;base64,' . base64_encode($rows_data['image']) . '">
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="details-section">
                            <h3 class="details">Details:</h3>
                            <div class="info">
                                ' . $rows_data['item'] . ' <br>
                                ' . $rows_data['place'] . '
                                <br>' . $rows_data['date'] . '
                            </div>
                        </div>
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="contact-section">
                            <h3 class="contact">Contact:</h3>
                            <div class="cinfo">
                            ' . $rows_data['name'] . ', ' . $rows_data['roll'] . '<br>' . $rows_data['phone'] . '<br>Hostel - ' . $rows_data['hostel'] . '
                            </div>
                            <div> Uploaded on:
                            <span class="uploadedDate2">' . $rows_data['uploaded_date'] . '</span>
                            </div>
                            <div>
                    <button id="deleteTicket" onclick="deleteTicket(`Do you really want to delete this ticket?`, ' . $rows_data['sno'] . ')">
                        Delete Ticket
                    </button>
                </div>
                        </div>
                    </div>
                </div>';
                } else if ($rows_data['type'] == 'found') {
                    echo '<div class="lostandfound">
                    <div class="found"> 
            
                        <div class="status-box">Found</div>
                        <img src="data:image/jpg;charset=utf8;base64,' . base64_encode($rows_data['image']) . '">
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="details-section">
                            <h3 class="details">Details:</h3>
                            <div class="info">
                                ' . $rows_data['item'] . ' <br>
                                ' . $rows_data['place'] . '
                                <br>' . $rows_data['date'] . '
                            </div>
                        </div>
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="contact-section">
                            <h3 class="contact">Contact:</h3>
                            <div class="cinfo">
                            ' . $rows_data['name'] . ', ' . $rows_data['roll'] . '<br>' . $rows_data['phone'] . '<br>Hostel - ' . $rows_data['hostel'] . '
                            </div>
                            <div> Uploaded on:
                            <span class="uploadedDate2">' . $rows_data['uploaded_date'] . '</span>
                            </div>
                            <div>
                    <button id="deleteTicket" onclick="deleteTicket(`Do you really want to delete this ticket?`, ' . $rows_data['sno'] . ')">
                        Delete Ticket
                    </button>
                </div>
                        </div>
                        <div class="arrow-container">
                            <div class="arr down">
                                <div></div>
                            </div> <!-- Add the down arrow here -->
                        </div>
                    </div>
                </div>';
                }
            }
        }
        echo "</div>";
    } else {
        echo "<script>alert('Some error occured in displaying');</script>";
    }

    ?>

    <footer>
        <!-- Your footer content goes here -->
    </footer>

</body>

</html>