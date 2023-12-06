<?php

include("..\\..\\database.php");

$first_name = null;
$middle_name = null;
$last_name = null;
$email = null;
$password = null;
$agreement = 0;

$error = array(
    "email" => null,
    "password" => null,
    "agreement" => null,
);

if (isset($_POST["register"])) {
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $agreement = $_POST["agreement"];
    $email = trim($_POST['email']);

    try {
        $queryUser = $connection->prepare("SELECT * FROM users WHERE email = :email");
        $queryUser->execute(["email" => $email]);

        if ($agreement) {
            if ($_POST["password"] == $_POST["confirm_password"]) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                if ($queryUser->rowCount() != 0) {
                    $error["email"] = "Email is already exist";
                } else {
                    $insertUser = $connection->prepare("INSERT INTO users (first_name, middle_name, last_name, email, password) VALUES (:first_name, :middle_name, :last_name, :email, :password)");
                    $insertUser->execute(["first_name" => $first_name, "middle_name" => $middle_name, "last_name" => $last_name, "email" => $email, "password" => $password]);

                    header("Location: login.php");
                }
            } else {
                $error["password"] = "Password and confirm password mismatch";
            }
        } else {
            $error["agreement"] = "User must agree to terms and agreement in order to use the feature";
        }
    } catch (PDOException $ERROR) {
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/style/register.css" />
    <title>Document</title>
</head>

<body style="background-color: #eaeaea">
    <nav>
        <a href="../../index.php" style="padding: 10px 10px; width: 100%">
            <img class="logo" src="../../assets/icons/logo-dark.svg" alt="" />
        </a>
    </nav>
    <form action="register.php" method="post">
        <div style="width: fit-content; margin: 0 auto; padding: 30px 0">
            <img style="width: 100%; height: 100%" src="../../assets/icons/logo-dark.svg" alt="logo" />
        </div>
        <h3>SIGN UP</h3>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="email" name="email" value="<?php echo $email ?>" class="form-control" id="floatingInput" placeholder="name@example.com" required />
            <label for="floatingInput" style="color: #0068a3">Email</label>
            <?php echo ($error["email"] != null) ? '<p style="margin: 3px 0 -22px 0; text-align: left; color: red">' . $error["email"] . '</p>' : "" ?>
        </div>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="text" name="first_name" value="<?php echo $first_name ?>" class="form-control" id="floatingInput" placeholder="name@example.com" required />
            <label for="floatingInput" style="color: #0068a3">First Name</label>
        </div>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="text" name="middle_name" value="<?php echo $middle_name ?>" class="form-control" id="floatingInput" placeholder="name@example.com" required />
            <label for="floatingInput" style="color: #0068a3">Middle Name</label>
        </div>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="text" name="last_name" value="<?php echo $last_name ?>" class="form-control" id="floatingInput" placeholder="name@example.com" required />
            <label for="floatingInput" style="color: #0068a3">Last Name</label>
        </div>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required />
            <label for="floatingPassword" style="color: #0068a3">Password</label>
            <?php echo ($error["password"] != null) ? '<p style="margin: 3px 0 -22px 0; text-align: left; color: red">' . $error["password"] . '</p>' : "" ?>
        </div>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="password" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Password" required />
            <label for="floatingPassword" style="color: #0068a3">Confirm Password</label>
        </div>
        <div style="width: fit-content; margin: 0 auto; max-width: 90%">
            <?php echo ($error["agreement"] != null) ? '<p style="margin: 3px 0 -22px 0; text-align: left; color: red">' . $error["agreement"] . '</p>' : "" ?>
            <label for="">
                <input type="checkbox" name="agreement" value="agree" required />
                <span style="font-size: 14px; text-align: justify">
                    Yes, I understand that by creating an account I agree and consent to Finance Web's Terms of Use,
                    including the <a href="">Privacy Policy</a> and <a href="">Cookie Policy</a>
                </span>
            </label>
        </div>
        <input type="submit" name="register" value="REGISTER" />
        <p>Don't have an account? <a href="login.php">Sign-Up</a> here</p>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
