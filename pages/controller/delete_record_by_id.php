<?php

require("../../database.php");

session_start();

if (isset($_SESSION["isAuthenticated"])) {
    if (isset($_POST["delete_from_account"])) {
        $account_id = $_POST["account_id"];
        $deleted_at = date('Y-m-d H:i:s');

        $deleteAccount = $connection->prepare("UPDATE accounts SET deleted_at = :deleted_at WHERE account_id = :account_id");
        $deleteAccount->execute(["deleted_at" => $deleted_at, "account_id" => $account_id]);

        header("Location: ../account.php");
    }

    if (isset($_POST["delete_from_record"])) {
        $record_id = $_POST["record_id"];
        $deleted_at = date("Y-m-d H:i:s");

        $deleteRecord = $connection->prepare("UPDATE records SET deleted_at = :deleted_at WHERE record_id = :record_id");
        $deleteRecord->execute(["deleted_at" => $deleted_at, "record_id" => $record_id]);

        header("Location: ../records.php");
    }

    if (isset($_POST["delete_from_label"])) {
        $label_id = $_POST["label_id"];
        $deleted_at = date("Y-m-d H:i:s");

        $deleteRecord = $connection->prepare("UPDATE label SET deleted_at = :deleted_at WHERE label_id = :label_id");
        $deleteRecord->execute(["deleted_at" => $deleted_at, "label_id" => $label_id]);

        header("Location: ../settings/label.php");
    }
}
