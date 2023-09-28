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

if(isset($_GET["done"])){
    //add veryficaton
    $task_id = $_GET["done"];
    $status = mysqli_query($c, "UPDATE `tasks` SET `status` = 1 WHERE `id` = '$task_id';");
}

if(isset($_GET["cancel"])){
    //add veryficaton
    $task_id = $_GET["cancel"];
    $status = mysqli_query($c, "UPDATE `tasks` SET `status` = 0 WHERE `id` = '$task_id';");
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
        <a href="edit.php" class="btn btn-danger">Edytuj/Usuń</a>
    </div>
</div>



    <?php
    if(@$_GET["displya"]=="mine"){
        $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `user_id` = '$id', `status`!=2;");
    }
    else{
        $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `status`!=2;");
    }

    if(mysqli_num_rows($query) == 0){
       ?>
        <div class="w-100 text-center">
        <h1>Jeszcze nic tutaj nie ma!</h1>
        <p>Stwórz zadanie w zakładce <a href="add.php" >DODAJ</a>!</p>
        </div>

       <?php
    }
    else {
    ?> 
    <div class="col-8 offset-2 col-md-6 offset-md-3 mt-5">
    <div class="btn-group btn-group-sm ms-md-5 my-2" role="group">
        <a href="index.php?display=mine" class="btn btn-success">Moje</a>
        <a href="index.php?display=all" class="btn btn-success">Wszystkie</a>
    </div>  
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
                <td scope="col">
                    <a class="btn btn-outline-secondary btn-sm p-0" style="height: 20px; width: 20px;" href="index.php?<?php 
                    if($task["status"] == 0) echo "done=";
                    else echo "cancel=";
                    echo $task["id"]; ?>"><?php if($task["status"] == 1){
                        ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                        <?php
                    } 
                    else echo "&nbsp;";?></a>
                </td>

                <td scope="col" style="padding: 5px 0px 0px 5px;">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo "collapse" . $task["id"]; ?>">
                        <?php echo $task["title"]; ?>
                    </button>
                    <div>
                        <div class="collapse collapse-horizontal my-2" id="<?php echo "collapse" . $task["id"]; ?>">
                            <div class="card card-body p-2" style="width: 200px; background: rgba(255,255,255,0.3);">
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