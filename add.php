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

if(isset($_POST["title"])){
    $title = $_POST["title"];
    $caption = $_POST["caption"];
    $date = $_POST["date"];
    $priority = $_POST["priority"];
    
    $add = mysqli_query($c, "INSERT INTO `tasks` SET `user_id`='$id', `title`='$title', `caption`='$caption', `date`='$date', `priority`='$priority', `status` = 0;");
    header("Location:index.php");
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
    <a href="add.php?action=logout" class="btn btn-primary ms-auto btn-sm">Wyloguj</a>
</div>

<div class="w-100 p-5 mb-3 d-flex justify-content-center" style="background: whitesmoke;">
    <div style="width: fit-content;">
        <h1 class="mx-auto" style="width: fit-content;">TO-DO List</h1>
        <a href="add.php" class="btn btn-primary">Dodaj</a>
        <a href="index.php" class="btn btn-success">Zadania</a>
        <a href="edit.php" class="btn btn-danger">Edytuj/Usuń</a>
    </div>
</div>

<div class="col-8 offset-2 col-md-4 offset-md-4 mt-5">
<form method="post">
    <h4>Dodaj zadanie:</h4>
    <label class="form-label">Tytuł:</label>
    <input type="text" name="title" class="form-control" required>
    <br>
    <label class="form-label">Opis:</label>
    <textarea name="caption" class="form-control" required></textarea>
    <br>
    <div class="row">
        <div class="col-6">
            <span class="form-label">Priorytet: </span>
            <select class="form-select mt-2" name="priority" style="width: 60px;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>
        <div class="col-6">
            <label class="form-label">Termin: </label>
            <input type="date" class="form-control" name="date"  min="<?php echo date("Y-m-d"); ?>" required>
        </div>
    
    <div class="d-flex mt-4">
        <button class="btn btn-primary ms-auto" type="submit">Dodaj</button>
    </div>
    </form>
</div>

</body>
</html>