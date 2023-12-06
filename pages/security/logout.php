<?php

session_start();

if (isset($_POST["logout"])) {
    session_unset();
    if (isset($_SESSION)) {
        header("Location: login.php");
    }
}
