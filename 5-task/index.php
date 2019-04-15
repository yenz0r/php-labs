<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="sstyle.css" rel="stylesheet">
    <title>Calendar</title>
</head>
<body>
    <header>
    <center><h1>MySql DataBase Manager</h1></center>
    </header>
    <div class="container">
        <div>
            <h2>Add News</h2>
            <hr/>
            <form method="POST" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>"> 
                <br><input type="date" name="calendar" required><br><br>
                <input type="radio" name="dayType" value="green" /> Free
                <input type="radio" name="dayType" value="red" /> Task
                <input type="radio" name="dayType" value="blue" /> Holiday<br>
                <br><textarea name="info" placeholder="Input your comment.." cols="40" rows="3"></textarea>
                <br><br><input type="submit" name="add" value="Add"> <input type="reset" name="clear" value="Clear">
            </form>
            <?php
                include_once('const.php');

                if (isset($_POST['add'])) {
                    $mysqli = new mysqli(HOST, USER, PASS, DB);

                    if ($mysqli->connect_errno) {
                        printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                        exit();
                    }

                    $imgUrl = "";
                    $dayType = "";

                    switch ($_POST['dayType']) {
                        case 'red':
                            $dayType = "task";
                            $imgUrl = "./src/red.jpg";
                            break;
                        case 'blue':
                            $dayType = "holiday";
                            $imgUrl = "./src/blue.png";
                            break;
                        case 'green':
                            $dayType = "free";
                            $imgUrl = "./src/green.jpg";
                            break;
                    }

                    $mysqli->query("insert into news values ('" . $_POST['calendar'] . "', '" . $_POST['info'] . "', '" . $imgUrl
                     . "' ,'" . $dayType . "');");
                }
            ?>
        </div>

        <div>
            <h2>Display Dates</h2>
            <hr/>  
            <?php 
                $mysqli = new mysqli(HOST, USER, PASS, DB);

                if ($mysqli->connect_errno) {
                    printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                    exit();
                }


                $checkArr = [];

                if ($result = $mysqli->query("select * from news")) {
                    while ($row = $result->fetch_assoc()) {
                        if (!in_array($row['date'], $checkArr)) {
                            $dateForLink = $row['date'];
                            $dayType = $row['dayType'];
                            echo "<li><a class='$dayStyle' href='./index.php?p=$dateForLink'>$dateForLink</a></li>";

                            array_push($checkArr, $row['date']);
                        }
                    }

                    $result->free();
                }
                $mysqli->close();
            ?>
        </div>

        <div>
            <h2>Display Info</h2>
            <hr/>  
            
            <?php
                if (empty($_GET)) {
                    echo "Choose any link..";
                } else {
                    $mysqli = new mysqli(HOST, USER, PASS, DB);
                    
                    if ($mysqli->connect_errno) {
                        printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                        exit();
                    }
                    
                    if ($result = $mysqli->query("select * from news where date='" . $_GET['p'] . "';")) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>Date : " . $row['date'] . "</li>";
                            echo "<li>Info : " . $row['info'] . "</li>";
                            echo "<li>Type : " . $row['dayType'] . "</li>";
                            echo "<p><img width='250' height='20' src= " . $row['img_url'] ."></p>";
                            echo "<hr/>";
                        }
                        $result->free();
                    }
                    $mysqli->close();
                }
            ?>

        </div>

        <div>
            <h2>Edit</h2>
            <hr/>  
            
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
				<select name="rowToUpdate">
					<option value="rowByDate" selected>Date</option>
                    <option value="rowByInfo">Info</option>
                    <option value="rowByType">Type</option>
                </select>

                <select name="fieldToUpdate">
					<option value="fieldByDate" selected>Date</option>
                    <option value="fieldByInfo">Info</option>
                    <option value="fieldByType">Type</option>
                </select>
                
                <br><br><input type="text" placeholder="valueRaw" name="valueRaw" required>
                <br><br><input type="text" placeholder="valueField" name="valueField" required>

				<br><br><input type="submit" name="update" value="Update"> <input type="reset" name="clear" value="Clear">
            </form>
            
            <?php
				if (isset($_POST['rowToUpdate'], $_POST['fieldToUpdate'], $_POST['update'])) {
                    
                    $rowToUpdate = "";
                    $select = $_POST['rowToUpdate'];
                    switch ($select) {
                        case 'rowByDate':
                            $rowToUpdate = "date";
                            break;
                        case 'rowByInfo':
                            $rowToUpdate = "info";
                            break;
                        case 'rowByType':
                            $rowToUpdate = "dayType";
                            break;
                    }
                    
                    $fieldToUpdate = "";
                    $select = $_POST['fieldToUpdate'];
                    switch ($select) {
                        case 'fieldByDate':
                            $fieldToUpdate = "date";
                            break;
                        case 'fieldByInfo':
                            $fieldToUpdate = "info";
                            break;
                        case 'fieldByType':
                            $fieldToUpdate = "dayType";
                            break;
                    }

                    $mysqli = new mysqli(HOST, USER, PASS, DB);
                    
                    if ($mysqli->connect_errno) {
                        printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                        exit();
                    }
                    
                    if ($result = $mysqli->query("update news set " . $fieldToUpdate . "='" . $_POST['valueField'] . "' where " . $rowToUpdate . "='" . $_POST['valueRaw'] . "';")) {
                        if ($fieldToUpdate == "dayType") {
                            switch ($_POST['valueField']) {
                                case 'task':
                                    $imgUrl = "./src/red.jpg";
                                    break;
                                case 'holiday':
                                    $imgUrl = "./src/blue.png";
                                    break;
                                case 'free':
                                    $imgUrl = "./src/green.jpg";
                                    break;
                            }
                            $mysqli->query("update news set img_url='" . $imgUrl . "' where " . $rowToUpdate . "='" . $_POST['valueRaw'] . "';");
                        }
                        echo "<p>Status : Done!</p>";
                    }

                    $mysqli->close();
                }
            ?>
        </div>
        <div>
            <h2>Delete</h2>
            <hr/>  

            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
				<select name="deleteRaw">
					<option value="deleteDate" selected>Date</option>
                    <option value="deleteInfo">Info</option>
                    <option value="deleteType">Type</option>
                    <option value="deleteAll">All</option>
                </select>
                <br><br><input type="text" placeholder="deleteParam" name="dataForDelete" >
				<br><br><input type="submit" name="delete" value="Delete"> <input type="reset" name="clear" value="Clear">
            </form>
            
            <?php
                if (isset($_POST['deleteRaw'], $_POST['delete'])) {
                    $fieldToDelete = "";

                    $select = $_POST['deleteRaw'];
                    switch ($select) {
                        case 'deleteDate':
                            $fieldToDelete = "date";
                            break;
                        case 'deleteInfo':
                            $fieldToDelete = "info";
                            break;
                        case 'deleteType':
                            $fieldToDelete = "dayType";
                            break;
                        case 'deleteAll':
                            $fieldToDelete = "all";
                            break;
                    }

                    $mysqli = new mysqli(HOST, USER, PASS, DB);
                    
                    if ($mysqli->connect_errno) {
                        printf("Соединение не удалось: %s\n", $mysqli->connect_error);
                        exit();
                    }
                    if ($fieldToDelete !== "all") {
                        $query = "delete from news where " . $fieldToDelete . "='" . $_POST['dataForDelete'] . "';";
                    } else {
                        $query = "delete from news;";
                    }
                    if ($result = $mysqli->query($query)) {
                        echo "<p>Status : Deleted!</p>";
                    }
                    
                }  
            ?>
        </div>
    </div>
</body>
</html>