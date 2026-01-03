<!DOCTYPE html>
<?php
require './classes/DbConnector.php';
require './config/Security.php';

Security::configureSession();

if(isset($_SESSION['email'])){
    header("location:dashboard.php");
    exit();
}
?>

<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Login - Sentinel Safe</title>
        <link rel="stylesheet" href="css/login.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    </head>

    <body>
        <div class="row vh-100 g-0">
            <!--left side-->
            <div class="col-lg-6 position-relative d-none d-lg-block">
                <p class="text-white position-absolute top-50 start-50 translate-middle fs-1 fw-bold text-center">
                    <a href="index.php" class="sentinel-safe-link">Sentinel Safe</a>
                </p>
                <p class="text-white position-absolute top-50 start-50 translate-middle fs-5 text-center mt-5">Your Gateway to Home Security</p>
                <div class="bg-holder" alt="" style="background-image: url('images/dark.jpg');"></div>
            </div>

            <!--right side-->
            <div class="col-lg-6 d-flex align-items-center justify-content-center" style="padding: 20px">
                <div class="col-12 col-sm-8 col-lg-6">
                    <div class="text-center mb-5 mt-5">
                        <h3 class="fw-bold">Log In</h3>
                        <p class="text-secondary">Welcome back! Log in to Home Security System.</p>
                    </div>

                    <?php
                    // Display success message
                    if (isset($_SESSION['success_message'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo Security::escape($_SESSION['success_message']);
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                        unset($_SESSION['success_message']);
                    }
                    
                    // Display error message
                    if (isset($_SESSION['error_message'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                        echo Security::escape($_SESSION['error_message']);
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
                        unset($_SESSION['error_message']);
                    }
                    ?>

                    <!--form-->
                    <form action="loginProcess.php" method="POST">
                        <?php echo Security::csrfField(); ?>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                        </div>
                        <div class="form-check mb-3 d-flex justify-content-center">
                            <input class="form-check-input me-2" type="checkbox" name="checkbox" value="1" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Remember Me (30 days)
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3"> Log In</button>
                    </form>

                    <div class="text-center">
                        <small>Don't have an account? <a href="sign_up.php" class="fw-bold" style="text-decoration: none;">Sign Up</a></small>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

</html>
