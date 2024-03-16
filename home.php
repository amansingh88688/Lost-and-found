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
    <link rel="stylesheet" href="css/home.css?v=<?php echo time(); ?>">
    <title>Home | Lost and Found Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="js/prevent_back.js"></script>
    <script src="js/home.js"></script>

</head>

<body oncontextmenu="return false;" onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    <header>
        <div id="logo">
            <h1>Lost<br>and<br>Found</h1>
        </div>
        <div id="navContainer">
            <div id="searchBar">
                <input type="search" onsearch="search()" oninput="search()" id="searchItem" class="search-input" placeholder="Search for lost/found items...">
                <span class="material-symbols-outlined" id="searchBtn">
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
                    <!-- <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()"> -->
                    <a id="filterSevenDays" onclick="filterDays(7)">Last 7 Days</a>
                    <a id="filterThreeDays" onclick="filterDays(3)">Last 3 Days</a>
                </div>
            </div>

            <a href="lost.php" id="raiseTicketBtn">Raise Ticket<b> +</b></a>
            <a href="mytickets.php" id="myticket">My Tickets</a>
            <a href="logout.php" id="logoutBtn">Logout</a>
        </div>
    </header>

    <div class="removeFilterClass" id="removeFilter" onclick="removeFilters()">Remove Filter</div>

    <?php
    include 'dbconnect.php';
    echo '<div id="itemList">';
    $display_sql = "SELECT * FROM `user_content` WHERE `approved` = 'yes' ORDER by `sno` DESC";

    $result_display = mysqli_query($con, $display_sql);

    if ($result_display) {
        if (mysqli_num_rows($result_display) > 0) {
            while ($rows_data = mysqli_fetch_assoc($result_display)) {
                if ($rows_data['type'] == 'lost') {
                    echo '<div class="lostandfound">
                    <div class="lost"> 
            
                        <div class="status-box">Lost</div>
                        <div class="image-box">
                            <img src="data:image/jpg;charset=utf8;base64,' . base64_encode($rows_data['image']) . '">
                        </div>
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="details-section">
                            <h3 class="details">Details:</h3><br>
                            <div class="info">
                               <b>Item :</b> ' . $rows_data['item'] . ' <br>
                               <b>Location :</b>  ' . $rows_data['place'] . ' <br>
                               <b>Time :</b> ' . $rows_data['date'] . '
                            </div>
                        </div>
                        <div class="vertical-line">
                        </div>
                        <div class="contact-section">
                            <h3 class="contact">Contact:</h3> <br>
                            <div class="cinfo">
                            <b>Name : </b>' . $rows_data['name'] . ', ' . $rows_data['roll'] . '<br> 
                            <b>Contact : </b><a target="blank" href="https://wa.me/' . $rows_data['phone'] . '">' . $rows_data['phone'] . '</a><br>
                            <b>Hostel :</b> ' . $rows_data['hostel'] . '
                            </div>
                            <div> <b>Uploaded on :</b>
                            <span class="uploadedDate">' . $rows_data['uploaded_date'] . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
                } else if ($rows_data['type'] == 'found') {
                    echo '<div class="lostandfound">
                    <div class="found"> 
            
                        <div class="status-box">Found</div>
                        <div class="image-box">
                            <img src="data:image/jpg;charset=utf8;base64,' . base64_encode($rows_data['image']) . '">
                        </div>
                        <div class="vertical-line"></div> <!-- Add a vertical line separator -->
                        <div class="details-section">
                            <h3 class="details">Details:</h3><br>
                            <div class="info">
                                <b>Item :</b> ' . $rows_data['item'] . ' <br>
                                <b>Location : </b>' . $rows_data['place'] . ' <br>
                                <b>Time : </b>' . $rows_data['date'] . '
                            </div>
                        </div>
                        <div class="vertical-line">
                        </div>
                        <div class="contact-section">
                            <h3 class="contact">Contact:</h3> <br>
                            <div class="cinfo">
                            <b>Name : </b>' . $rows_data['name'] . ', ' . $rows_data['roll'] . '<br>
                            <b>Contact : </b><a target="blank" href="https://wa.me/' . $rows_data['phone'] . '">' . $rows_data['phone'] . '</a> <br>
                            <b>Hostel : </b> ' . $rows_data['hostel'] . '
                            </div>
                            <div> <b>Uploaded on :</b>
                            <span class="uploadedDate">' . $rows_data['uploaded_date'] . '</span>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            }
        }
        echo "</div>";
    } else {
        echo "<script>alert('Some error occured!');</script>";
    }

    ?>
    </div>

    <footer>
        <!-- Your footer content goes here -->
    </footer>

</body>

</html>

<!-- to add down arrow for commnents, paste it after 100th line -->
<!-- same as after 127th line for found -->
<!-- <div class="arrow-container">
    <div class="arr down">
        <div></div>
    </div>
</div> -->
