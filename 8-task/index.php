<?php
require('connect_db.php');
require('oses.php');

function getOS($userAgent, $oses) {
    foreach($oses as $os=>$pattern){
        if(preg_match("/$pattern/i", $userAgent)) { 
            return $os;
        }
    }
    return 'Unknown'; 
}

$user_os = getOS($_SERVER['HTTP_USER_AGENT'], $oses);
echo "<h1>Your OS : $user_os</h1>";

$query = "insert into users_info (os) values ('$user_os');";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));

$os_arr = [];
foreach($oses as $os=>$pattern){
    $os_arr[$os] = 0;
}
$query = "select * from users_info;";
$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
while ($row = mysqli_fetch_assoc($result)) {
    $os_arr[$row['os']] += 1;
}
mysqli_free_result($result);

arsort($os_arr);

echo '
<table>
<thead>
    <tr>
        <th>OS</th>
        <th>Count</th>
    </tr>
</thead>';

foreach($os_arr as $os=>$count){
    echo "<tr><td>" . $os . "</td><td>" . $count . "</td>";
}
echo '</table>';

?>