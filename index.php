<?php
session_start();
$c = mysqli_connect("localhost", "root", "", "tasks");

if($_SESSION["status"] != 1){
  header("Location: login.php");
}

if(@$_GET["action"] == "logout"){
    session_destroy();
    header("Location: index.php");
}

$id = $_SESSION["id"];

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

<div class="w-100 d-flex p-2">
    <a href="index.php?action=logout" class="btn btn-primary ms-auto btn-sm">Wyloguj</a>
</div>


<div class="col-8 offset-2 col-md-4 offset-md-4 card">
<div class="card-body">
<form method="post">
    <h4>Dodaj zadanie:</h4>
    <hr>
    <label class="form-label">Tytuł:</label>
    <input type="text" name="title" class="form-control" required>
    <br>
    <label class="form-label">Opis:</label>
    <textarea name="caption" class="form-control" required></textarea>
    <br>
    <div class="d-inline-flex">
        <span class="form-label">Priorytet <span class="text-muted small">(1 - największy):</span> </span>
        <div style="width: 10px;"></div>
        <select class="form-select form-select-sm" name="priority" style="width: 55px;">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>
    <div class="mt-2">
        <label class="form-label">Termin wykonania:</label>
        <input type="date" name="date"  min="<?php echo date("Y-m-d"); ?>" required>
    </div>
    <hr>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Dodaj</button>
    </div>
    </form>
    </div>
</div>

</body>
</html>