<?php include 'header.php'; ?>
<?php 
Session::init();
$login = Session::get("userlogin");
if ($login) {
    header("Location:index.php"); 
}
 ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $userLogin = $cmr->userLogin($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Register</title>
    </head>
    <body>
    <!-- <?php var_dump($userLogin) ?> -->
    <main class="mb-5"> 
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <!-- back button -->
                    <a href="index.php" class="btn btn-secondary mt-3">Back</a>
                    <!-- register form -->
                    <h2 class="mb-4 mt-4">Login</h2>
                    <form class="row g-3" method="post">
                        <div class="col-md-6 mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="userEmail" id="userEmail" class="form-control" value="<?php if (isset($userLogin["emailValue"])) echo $userLogin["emailValue"]; ?>">
                            <?php if (isset($userLogin["email"])) echo $userLogin["email"]; ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <?php if (isset($userLogin["password"])) echo $userLogin["password"]; ?>
                        </div>
                        <?php if (isset($userLogin["submit"])) echo $userLogin["submit"]; ?>
                        <div class="col-12">
                            <p>Need an account? <a href="register.php">Register Here</a></p>
                        </div>
                        <div class="col-12">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    </body>
</html>