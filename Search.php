<?php
    require "header.php";
    error_reporting(0);
    $user="root";
    $password="usbw";
    $database="movies"; /*This DB must exist on the server */
    $host = "localhost:3307";
    $conn=mysqli_connect($host, $user, $password, $database)or die("Cannot connect");

    echo "<b>Search</b>";
    //make a table with the drop down boxes for genre rating and so on
    //titles will be more of a contains sort of search
if (!isset($_POST['search'])) {
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class='centre'>
    <label for="Title">Title</label>
    <input type="Title" name="Title" id = "Title"/>
    <label for="Genre">Genre</label>
    <input type="Genre" name="Genre" id = "Genre"/>
    <label for="Rating">Rating</label>
    <input type="Rating" name="Rating" id = "Rating"/>
    <label for="Year">Year</label>
    <input type="Year" name="Year" id = "Year"/><br>
    <input type="radio" name="radio" value=">=">Greater<br>
    <input type="radio" name="radio" value="<=">Less<br>
    <input type="radio" name="radio" value="=">Equal<br>
    <button type="search" name="search" id="search">search</button>
    </form>
    <?php
} else {
    $First = true;
    $Qry = "SELECT * FROM `movies` WHERE";
    if ($_POST['Title'] != null) {
        $Title = $_POST['Title'];
        if (preg_match("/^[A-Za-z0-9' -]+$/", $Title)) {
            $Qry.= " `Title` LIKE '%$Title%'";
            $First = false;
        } else {
            echo "Incorrect Characters entered in Title";
        }
    }
    if ($_POST['Genre'] != null && $First == true) {
        $Genre = $_POST['Genre'];
        if (preg_match("/^[A-Za-z0-9' -]+$/", $Genre)) {
            $Qry.= "`Genre` LIKE '%$Genre%'";
            $First = false;
        } else {
            echo "Incorrect Characters entered in Genre";
        }
    }
    if ($_POST['Genre'] != null && $First == false) {
        $Genre = $_POST['Genre'];
        if (preg_match("/^[A-Za-z0-9' -]+$/", $Genre)) {
            $Qry.= "AND `Genre` LIKE '%$Genre%'";
            $First = false;
        } else {
            echo "Incorrect Characters entered in Genre";
        }
    }
    if ($_POST['Rating'] != null && $First == true) {
        $Rating = $_POST['Rating'];
        if (preg_match("/^[A-Za-z0-9' -]+$/", $Rating)) {
            $Qry .= "`Rating` LIKE '%$Rating%'";
            $First = false;
        } else {
            echo "Incorrect Characters entered in Rating";
        }
    }
    if ($_POST['Rating'] != null && $First == false) {
        $Rating = $_POST['Rating'];
        if (preg_match("/^[A-Za-z0-9' -]+$/", $Rating)) {
            $Qry .= "AND `Rating` LIKE '%$Rating%'";
            $First = false;
        } else {
            echo "Incorrect Characters entered in Rating";
        }
    }
    if ($_POST['Year'] != null && $First == true) {
        $Year = $_POST['Year'];
        if (preg_match("/^[0-9]+$/", $Year)) {
            if (isset($_POST['radio'])) {
                $selectedVal = $_POST['radio'];
                $Qry .= "`Year` $selectedVal '$Year'";
            } else {
                $Qry .= "`Year` = '$Year'";
            }
            $First = false;
        } else {
            echo "Incorrect characters entered in Year";
        }
    }
    if ($_POST['Year'] != null && $First == false) {
        $Year = $_POST['Year'];
        if (preg_match("/^[0-9]+$/", $Year)) {
            if (isset($_POST['radio'])) {
                $selectedVal = $_POST['radio'];
                $Qry .= "AND `Year` $selectedVal '$Year'";
            } else {
                $Qry .= "AND `Year` = '$Year'";
            }
            $First = false;
        } else {
            echo "Incorrect characters entered in Year";
        }
    }
    //echo $Qry;
    $res = mysqli_query($conn, $Qry);
    //Only display once the Search button has been clicked
    if (mysqli_num_rows($res) > 0 ) {
        ?>
        <table style=width:100%>
        <tr><th>Results</th><tr>
        <tr>
        <th>Title</th>
        <th>Studio</th>
        <th>Status</th>
        <th>Sound</th>
        <th>Versions</th>
        <th>Price</th>
        <th>Rating</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Aspect</th>
        </th>
        <?php

        while ($display=mysqli_fetch_assoc($res)) {
            // the ID remains "hidden" but we use this as the identifier
            // only the name is displayed
            echo "<tr>
            <td>$display[Title]</td>
            <td>$display[Studio]</td> 
            <td>$display[Status]</td>
            <td>$display[Sound]</td>
            <td>$display[Versions]</td>
            <td> $display[RecRetPrice]</td>
            <td>$display[Rating]</td>
            <td> $display[Year]</td>
            <td>$display[Genre]</td>
            <td> $display[Aspect]</td>
            </tr>";

            $VC = $display['ViewCount'];
            $VC += 1;
            $Qry2 ="UPDATE `movies` SET `ViewCount` = $VC WHERE `ID` = $display[ID]";
            mysqli_query($conn, $Qry2);
        }
        echo "</table>";

    } else {
        echo "Your search terms do not exist";
    }
    mysqli_close($conn);

}
require "footer.php";

?>