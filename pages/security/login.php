<?php
include("..\\..\\database.php");
include("..\\..\\cloudinary.php");

// use Cloudinary\Api\Upload\UploadApi;

// $upload = new UploadApi();

session_start();

$email = null;
$password = null;

$error = array(
    "email" => null,
    "password" => null
);


// if (isset($_POST["test_submit"])) {
//     $response = $upload->upload($_FILES["image"]["tmp_name"], [
//         "folder" => "budget_tracker",
//         "use_filename" => TRUE,
//         "overwrite" => TRUE
//     ]);

//     echo print_r($response["secure_url"]);
//     header("Location: " . $response["secure_url"]);
// }

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $queryUser = $connection->prepare("SELECT user_id, email, first_name, last_name, password FROM users WHERE email = :email");
    $queryUser->execute(["email" => $email]);
    $userData = $queryUser->fetch(PDO::FETCH_ASSOC);

    if ($queryUser->rowCount() > 0) {
        $isVerified = password_verify($password, $userData["password"]);
        if ($isVerified) {
            if ($userData) {
                $_SESSION["user_id"] = $userData["user_id"];
                $_SESSION["first_name"] = $userData["first_name"];
                $_SESSION["last_name"] = $userData["last_name"];
                $_SESSION["isAuthenticated"] = true;

                if ($_SESSION["isAuthenticated"]) {
                    header("Location: ../dashboard.php");
                }
            }
        } else {
            $error["password"] = "Password is incorrect";
        }
    } else {
        $error["email"] = "Email is incorrect";
    }
}

?>

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
    <link rel="stylesheet" href="../../assets/style/login.css" />
    <title>Document</title>
    <style></style>
</head>

<body style="background-color: #eaeaea">
    <nav>
        <a href="../../index.php" style="padding: 10px 10px; width: 100%">
            <img class="logo" src="../../assets/icons/logo-dark.svg" alt="" />
        </a>
    </nav>
    <form action="login.php" method="post">
        <div style="width: fit-content; margin: 0 auto; padding: 30px 0">
            <img style="width: 100%; height: 100%" src="../../assets/icons/logo-dark.svg" alt="logo" />
        </div>
        <h3>SIGN IN</h3>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="email" name="email" value="<?php echo $email ?>" class="form-control" id="floatingInput" placeholder="name@example.com" />
            <?php echo ($error["email"] != null) ? '<p style="margin: 3px 0 -22px 0; text-align: left; color: red">' . $error["email"] . '</p>' : "" ?>
            <label for="floatingInput" style="color: #0068a3">Email</label>
        </div>
        <div class="form-floating mb-3" style="max-width: 90%; margin: 0 auto">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" />
            <label for="floatingPassword" style="color: #0068a3">Password</label>
            <?php echo ($error["password"] != null) ? '<p style="margin: 3px 0 -22px 0; text-align: left; color: red">' . $error["password"] . '</p>' : "" ?>
        </div>
        <input name="login" type="submit" value="LOGIN" />
        <p>Don't have an account? <a href="register.php">Sign-Up</a> here</p>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
