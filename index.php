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

// if(isset($_GET["done"])){
//     //add veryficaton
//     $id = $_GET["done"];
//     $status = mysqli_query($c, "UPDATE FROM `tasks` WHERE `id` = ");
// }

// if(isset($_GET["cancel"])){

//     //add veryficaton
//}
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
    <style>

    </style>
</head>
<body>


<div class="w-100 d-flex p-2 position-absolute">
    <a href="index.php?action=logout" class="btn btn-primary ms-auto btn-sm">Wyloguj</a>
</div>

<div class="w-100 p-5 mb-3 d-flex justify-content-center" style="background: whitesmoke;">
    <div style="width: fit-content;">
        <h1 class="mx-auto" style="width: fit-content;">TO-DO List</h1>
        <a href="add.php" class="btn btn-primary">Dodaj</a>
        <a href="index.php" class="btn btn-success">Zadania</a>
        <a href="index.php" class="btn btn-danger">Edytuj/Usuń</a>
    </div>
</div>

<div class="col-8 offset-2 col-md-6 offset-md-3 mt-5">
    <div class="btn-group btn-group-sm ms-md-5 my-2" role="group">
        <a href="index.php?display=mine" class="btn btn-success">Moje</a>
        <a href="index.php?display=all" class="btn btn-success">Wszystkie</a>
    </div>  

    <?php
    if(@$_GET["displya"]=="mine"){
        $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `user_id` = '$id', `status`!=2;");
    }
    else{
        $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `status`!=2;");
    }

    if(mysqli_num_rows($query) == 0){
       
    }
    else {
    ?> 
        <table class="table table-striped table-hover">
        <thead>
            <tr>    
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Termin</th>
            <th scope="col" class="d-none d-lg-table-cell">Autor</th>
            <th scope="col" class="d-none d-lg-table-cell">Priorytet</th>
            </tr>
        </thead>
    <?php
    }
    while($task = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td scope="col"></td>
                <td scope="col">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample">
                        <?php echo $task["title"]; ?>
                    </button>
                    <div>
                        <div class="collapse collapse-horizontal my-2" id="collapseWidthExample">
                            <div class="card card-body p-2" style="width: 150px;">
                            <?php echo $task["caption"]; ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td scope="col"><?php echo $task["date"]; ?></td>
                <td scope="col" class="d-none d-lg-table-cell"><?php 
                $u_id = $task["user_id"];
                $q = mysqli_query($c, "SELECT * FROM `users` WHERE `id`='$u_id';");
                $author = mysqli_fetch_row($q);
                echo $author[1];
                ?></td>
                <td scope="col" class="d-none d-lg-table-cell"><?php echo $task["priority"]; ?></td>
            </tr>
        <?php
    } 
    ?>
</div>

</body>
</html>