<?php
/* SELECT * FROM zadania
WHERE przypisane_do = 'Twój_ID' OR przypisane_do IN (SELECT ID_uzytkownika FROM przypisanie_zadania WHERE przypisane_do = 'Twój_ID');
*/

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

if(isset($_GET["delete"])){
    $task_id = $_GET["delete"];
    $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `id` = '$task_id';");
    $task = mysqli_fetch_row($query);
    if($task[1]==$id){
        $delete = mysqli_query($c, "DELETE FROM `tasks` WHERE `id` = '$task_id';");
    }
    else {
        ?>
        <script>alert("nie hakuj")</script>
        <?php
    }

}

if(isset($_GET["edit"])){
    $task_id = $_GET["edit"];
    $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `id` = '$task_id';");
    $task = mysqli_fetch_row($query);
    if($task[1]==$id){
        $edit = $task_id;
    }
    else {
        ?>
        <script>alert("nie hakuj")</script>
        <?php
    }
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

    $query = mysqli_query($c, "SELECT * FROM `tasks` WHERE `user_id`='$id';");

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
    <div class=" col-12 col-md-10 offset-md-1"> 
        <table class="table table-striped table-hover">
        <thead>
            <tr>    
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Termin</th>
            <th scope="col" class="">Autor</th>
            <th scope="col" class="">Priorytet</th>
            <th scope="col">Edytuj</th>
            <th scope="col">Usuń</th>
            </tr>
        </thead>
    <?php
    }
    while($task = mysqli_fetch_array($query)){
        ?>
            <tr>
                <td scope="col">
                    <a class="btn btn-outline-secondary btn-sm p-0" style="height: 20px; width: 20px;"> <?php if($task["status"] == 1){
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

                <td scope="col" class=""><?php 
                $u_id = $task["user_id"];
                $q = mysqli_query($c, "SELECT * FROM `users` WHERE `id`='$u_id';");
                $author = mysqli_fetch_row($q);
                echo $author[1];
                ?></td>

                <td scope="col" class=""><?php echo $task["priority"]; ?></td>

                <td scope="col" <?php if($task["id"] == @$edit) echo "style=\"padding: 5px 0px 0px 5px;\""; ?>>
                    <a class="ms-3" href="edit.php?edit=<?php echo $task["id"]; ?>">
                    <?php
                    if($task["id"] == @$edit){
                        ?>
                        <input type="submit" value="edytuj" class="btn btn-primary btn-sm">
                        <?php
                    }
                    else {
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                        </svg>      
                        <?php
                    } 
                    ?>
                    
                    </a>
                </td>

                <td scope="col">
                <a class="ms-3 text-danger" href="edit.php?delete=<?php echo $task["id"]; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                    </svg>
                    </a>
                </td>
            </tr>
        <?php
    } 
    ?>
</div>

</body>
</html>