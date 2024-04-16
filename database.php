<?php
$servername = "dt5.ehb.be";
$username "2324PROGPRGR02";
$password = "kEtUhDU5";
$dbName = "2324PROGPRGR02";

$con = mysqli_connect($servername, $username, $password, $dbName)

if(mysqli_connect_errno()){
    echo 'failed to connect';
    exit()
}
echo 'connection succesful'
?>