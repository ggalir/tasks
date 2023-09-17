<?php
session_start();
$c = mysqli_connect("localhost", "root", "", "tasks");


if(isset($_POST["login"]) && isset($_POST["password"])){
  $login = $_POST["login"];
  $password = $_POST["password"];
  $q = mysqli_query($c, "SELECT * FROM `users` WHERE `login`='$login';");
  $a = mysqli_fetch_row($q);

  $id = $a[0];
  $hash = $a[2];
  $salt = $a[3];

  if (hash('sha256', $password . $salt) == $hash){
          $_SESSION["id"] = $id;
          $_SESSION["status"] = 1;
      header("Location: index.php");
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
</head>
<body>

    <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-5">Zaloguj się</h3>
            <form method="post">
            <div class="form-outline mb-4">
              <input required type="text" class="form-control form-control-lg" name="login"/>
              <label class="form-label">Login</label>
            </div>

            <div class="form-outline mb-4">
              <input required type="password" name="password" class="form-control form-control-lg" />
              <label class="form-label">Hasło</label>
            </div>

            <button class="btn btn-primary btn-lg btn-block" type="submit">Zaloguj</button>

            <div class="text-center my-2">
                <p>Nie posiadasz konta?<a href="register.php">Stwórz je!</a></p>
            </div>
            </from>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
<?php
if(@$_GET["status"] == 1){
  echo "<script defer>alert(\"Konto zostało utworzone! Zaloguj się!\");</script>";
}
?>