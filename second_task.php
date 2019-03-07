<form method="POST" action="second_task.php"> 
    <br><input type="text" name="word" required>
    <br><input type="submit" name="enter" value="Send"> <input type="reset" name="Clear">
</form>

<?php
 
 if (isset($_POST['enter'])) {
    $inputLine = $_POST['word'];
}

$inputLine = strtolower($inputLine);

$arr = explode(" ", $inputLine);
 
$upperWords = [];
$redLetter = [];
$i = 0;
 
array_unshift($arr, "");
 
foreach($arr as $k => $v){
    if($i % 3 == 0){
        $v = mb_strtoupper($v);
        $upperWords[] = $v;
    }else{
        $upperWords[] = $v;
    }
    $i++;
}
 
foreach($upperWords as $k => $v){
    $v1 = preg_split('//u', $v, null, PREG_SPLIT_NO_EMPTY);
    if(isset($v1[2]))
        $v1[2] = preg_replace('~(.*+)~u', '<font color = "red">\1</font>', $v1[2]);
    $v1 = implode("", $v1);
    $redLetter[] = $v1;     
}
 
echo $inputLine = implode(" ", $redLetter);
echo '<br>Number of "о" и "О": ' . preg_match_all('~о~iu', $inputLine);

?>