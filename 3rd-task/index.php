<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop</title>

    <style type="text/css">
        .container {
            display: flex;
            justify-content: space-around;
            padding: 2em;
            box-sizing: border-box;
        }
          
        .container div {
            width: 25em;
            height: 2em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <h2>Add</h2>
            <hr/>
            <form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
                <br><input type="text" placeholder="id" name="id" required>
                <br><input type="text" placeholder="name" name="name" required>
                <br><input type="text" placeholder="price" name="price" required>
                <br><textarea name="description" placeholder="description" cols="18" rows="3"></textarea>
                <br><input type="submit" name="add" value="Add"> <input type="reset" name="clear" value="Clear">
            </form>
            <?php
                function isIdCorrect($inputId) {
                    $numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    for($i = 0; $i < mb_strlen($inputId); $i++) {
                        if (!in_array($inputId{$i}, $numbers)) {
                            return false;
                        }
                    }
                    return true;
                }

                $file = fopen("/Users/egorpii/Sites/src/file_shop.csv", 'a') or die("Не удалось подключть файл");

                if (isset($_POST['add'])) {
                    if (!isIdCorrect($_POST['id'])) {
                        echo "Status : Incorrect id..";
                    } else {
                        fputcsv($file, array($_POST['id'], $_POST['name'], $_POST['price'], $_POST['description']));
                        echo "Status : Done!";
                    }
                }

                fclose($file);
            ?>
        </div>
        <div>
            <h2>Delete</h2>
            <hr/>
            <form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
                <br><input type="text" placeholder="id" name="idDelete" required>
                <br><input type="text" placeholder="name" name="nameDelete" required>
                <br><input type="submit" name="delete" value="Delete"> <input type="reset" name="clear" value="Clear">
            </form>
            <?php
                include('const.php');

                if (isset($_POST['delete'])) {
                    $file = fopen("/Users/egorpii/Sites/src/file_shop.csv", 'r+') or die("Не удалось подключть файл");
                    $itemsArr = [];
                    
                    $isDeleted = false;
                    for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
                        if ($data[0] != $_POST['idDelete'] and $data[1] != $_POST['nameDelete']) {
                            $itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
                        } else {
                            $isDeleted = true;
                        }
                    }
                    
                    fclose($file);

                    $file = fopen("/Users/egorpii/Sites/src/file_shop.csv", 'w+') or die("Не удалось подключть файл");
                    if (isset($itemsArr)) {
                        foreach ($itemsArr as $fields) {
                            fputcsv($file, $fields);
                        }
                    }
                    fclose($file);

                    if ($isDeleted) {
                        echo "Status : Done!";
                    } else {
                        echo "Status : Incorrect params..";
                    }
                }
            ?>
        </div>
        <div>
            <h2>List</h2>
            <hr/>
            <ul>
            <?php
                include('const.php');

                $file = fopen("/Users/egorpii/Sites/src/file_shop.csv", 'r') or die("Не удалось подключть файл");
                $itemsArr = [];
                for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
                    $itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
                }
                fclose($file);

                if (isset($itemsArr)) { //secure from warrnings
                    foreach ($itemsArr as $fields) {
                        echo "<li><a href='/2nd-lab.php?p=$fields[1]'>$fields[1]</a></li>";
                    }
                }
            ?>
            </ul>
        </div>
        <div>
            <h2>Info</h2>
            <hr/>
            <ul type="circle">
                <?php
                    include('const.php');

                    $file = fopen("/Users/egorpii/Sites/src/file_shop.csv", 'r') or die("Не удалось подключть файл");
                    $itemsArr = [];
                    for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
                        $itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
                    }
                    fclose($file);

                    if (empty($_GET)) {
                        echo "Choose any link..";
                    } else {
                        foreach ($itemsArr as $fields) {
                            if ($fields[1] == $_GET['p']) {
                                $nameFields = array("Id", "Name", "Price", "Description");
                                for ($i = 0; $i < count($fields); $i++) {
                                    echo "<li><p>$nameFields[$i] : $fields[$i]</p></li>";
                                }
                                $newPrice = number_format((float)$fields[2] * 0.85, 2, '.', '');
                                echo "<li><p>Without 15% : $newPrice$</p></li>";
                                break;
                            }
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>