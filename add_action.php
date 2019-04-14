<?php
    include 'connect.php'

    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $jobtitle = $_POST['jobtitle'];

    $query_insert = "INSERT INTO user (username, fullname, jobtitle) VALUES (?, ?, ?)";
    $query = $connect->prepare($query_insert);
    $query->bindValue(1, $username);
    $query->bindValue(2, $fullname);
    $query->bindValue(3, $jobtitle);
    $query->execute();

    header("index.php")
?>