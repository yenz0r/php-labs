<?php

function printLink($name, $color) 
{
    echo ("<a style='background-color: $color; font-size: 40pt' href='/first_task.php?p=$name'>$name</a><br>");
}
 
$linkNameList = array(
    "first",
    "second",
    "third",
    "fourth",
    "fifth"
);

if (isset($_POST['enter'])) {
    array_push($linkNameList, $_POST['word']);
}

for ($i=0; $i < count($linkNameList); $i++) {
    if (empty($_GET)) {
        $color = 'green';
    } elseif ($linkNameList[$i] == $_GET['p']) {
        $color = 'red';
    } else {
        $color = 'white';
    }
    printLink($linkNameList[$i], $color);
}

?>

<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
    <br><input type="text" name="word" required>
    <br><input type="submit" name="enter" value="Send"> <input type="reset" name="Clear">
</form>