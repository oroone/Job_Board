<?php

//start session
session_start();

//connect to db
$mysqli = new mysqli('localhost', 'root', 'mysql','project_schema') or die(mysqli_error($mysqli));


$update = false;
$id = 0;
$firstname = '';
$lastname = '';
$username = '';
$email = '';
$password = '';
$age = '';
$gender = '';
$city = '';
$state = '';
$address = '';
$education= '';
$info = '';

//SAVE button
if(isset($_POST['save'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $address = $_POST['address'];
    $education= $_POST['education'];
    $info = $_POST['info'];


    $mysqli->query("INSERT INTO data (firstname, lastname,  age, gender, city, state, address, education, info) VALUES('$firstname', '$lastname', '$age', '$gender', '$city', '$state', '$address', '$education', '$info' )") or die($mysqli->error);

    //Confirmation if record has been SAVED
    $_SESSION['message'] = "Record has been saved!";
    $_SESSION['msg_type'] = "success";

    //redirect to index page
    header("location: pindex.php");
}

//DELETE button
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM data WHERE id=$id") or die($mysqli->error());

    //Confirmation if record has been DELETED
    $_SESSION['message'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";

    //redirect to index page
    header("location: pindex.php");
}

//EDIT button
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM data WHERE id=$id") or die($mysqli->error());
    $result2 = $mysqli->query("SELECT * FROM masterlogin WHERE id=$id") or die($mysqli->error());


    //check for record in database
    if (mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $age = $row['age'];
        $gender = $row['gender'];
        $city = $row['city'];
        $state = $row['state'];
        $address = $row['address'];
        $education= $row['education'];
        $info = $row['info'];
        
        $username = $row2['username'];
        $email = $row2['email'];
        $password = $row2['password'];
    }
}

//UPDATE button
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $address = $_POST['address'];
    $education= $_POST['education'];
    $info = $_POST['info'];

    $mysqli->query("UPDATE data SET firstname='$firstname', lastname='$lastname',  age='$age', gender='$gender', city='$city', state='$state', address='$address', education='$education', info='$info' WHERE id=$id") or die($mysqli->error);

    //Confirmation if record has been EDITED
    $_SESSION['message'] = "Record has been edited!";
    $_SESSION['msg_type'] = "warning";

    //redirect to index page
    header("location: pindex.php");
}
