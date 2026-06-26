<?php
$host='localhost';
$username='root';
$password='';
$database='clothing_store';

$conn=new mysqli($host,$username,$password,$database);

if($conn->connect_error){
    echo 'unsuccessful';
}
else{
}
?>