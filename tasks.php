<?php
session_start();
$c = mysqli_connect("localhost", "root", "", "tasks");
$id = $_SESSION["id"];

if($_SESSION["status"] != 1){
  header("Location: login.php");
}

if(@$_GET["action"] == "logout"){
    session_destroy();
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Headbook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
</head>
<body>

<div class="w-100 d-flex p-2 position-absolute">
    <a href="index.php?action=logout" class="btn btn-primary ms-auto btn-sm">Wyloguj</a>
</div>

<div class="w-100 p-5 mb-3 d-flex justify-content-center" style="background: whitesmoke;">
    <div style="width: fit-content;">
        <h1 class="mx-auto" style="width: fit-content;">TO-DO List</h1>
        <a href="index.php" class="btn btn-primary">Dodaj</a>
        <a href="tasks.php" class="btn btn-success">Zadania</a>
        <a href="tasks.php" class="btn btn-danger">Edytuj/Usuń</a>
    </div>
</div>


</body>
</html>