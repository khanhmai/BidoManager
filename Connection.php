<?php $currentFolder = 'TrackingAdmin';?>

<?php
function getConnection(){
    $server = "localhost";
    $username = "bammobic";
    $password = "abcmtk123";
    $database = "bidomanager";
    $connection = mysql_connect($server, $username, $password);
    
    if(!$connection){
        echo '<p>Có lỗi xảy ra</p>';
        exit();
    }            
    if(!mysql_select_db($database)){
        echo '<p>Cannot Connect to database</p>';
        exit();
    }    
    mysql_query("SET character_set_results=utf8", $connection);    
    return $connection;
}
?>

<?php
function getUser($username, $password){
    $connection = getConnection();
    
    $query = "Select * FROM User Where `username` = $username AND `password` = $password";
    
    $result = mysql_query($query);
    
    $row = mysql_fetch_array($result);
    
    if(is_null($row))
        return -1;
    
    return $row['Id'];
    
    mysql_close($connection);
}
?>