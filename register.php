<?php include 'header.php'; ?>

<?php 

    Session::init();
    $login = Session::get("userlogin");
    if ($login) {
        header("Location:index.php"); 
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $userReg = $cmr->userRegistration($_POST);
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
    <!-- <?php var_dump($userReg) ?> -->
    <main class="mb-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <?php if (isset($userReg["submit"])) echo $userReg["submit"]; ?>
                    <!-- back button -->
                    <a href="login.php" class="btn btn-secondary mt-3">Back</a>
                    <!-- register form -->
                    <h2 class="mb-4 mt-4">Register</h2>
                    
                    <form class="row g-3" action="" method="post">
                        <div class="col-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php if (isset($userReg["fnameValue"])) echo $userReg["fnameValue"]; ?>">
                            <?php if (isset($userReg["fname"])) echo $userReg["fname"]; ?>
                        </div>
                        <div class="col-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php if (isset($userReg["lnameValue"])) echo $userReg["lnameValue"]; ?>">
                            <?php if (isset($userReg["lname"])) echo $userReg["lname"]; ?>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="email">Email</label>
                            <input type="text" name="userEmail" id="userEmail" class="form-control" value="<?php if (isset($userReg["emailValue"])) echo $userReg["emailValue"]; ?>">
                            <?php if (isset($userReg["email"])) echo $userReg["email"]; ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <?php if (isset($userReg['password'])) echo $userReg['password']; ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                            <?php if (isset($userReg["confirm_password"])) echo $userReg["confirm_password"]; ?>
                        </div>
                        <?php if (isset($userReg["no_match"])) echo $userReg["no_match"]; ?>
                        <div class="col-12">
                            <a href="login.php"><button type="submit" name="register" class="btn btn-primary">Register</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    </body>
</html>