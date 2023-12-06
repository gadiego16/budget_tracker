<?php

include("..\\..\\database.php");
include("..\\..\\cloudinary.php");

use Cloudinary\Api\Upload\UploadApi;

$upload = new UploadApi();

$account_type = null;
$amount = null;
$currency_type = null;
$category = null;
$label = null;

$expense = 0;
$income = 0;
$array_labels = array();


session_start();

if (isset($_SESSION["isAuthenticated"])) {
    $queryUsers = $connection->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $queryUsers->execute(["user_id" => $_SESSION["user_id"]]);

    $fetchAvatar = $connection->prepare("SELECT avatar FROM users WHERE user_id = :user_id");
    $fetchAvatar->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));

    $fetchAllAccount = $connection->prepare("SELECT * FROM accounts WHERE deleted_at IS NULL AND user_id = :user_id");
    $fetchAllAccount->execute([
        "user_id" => $_SESSION["user_id"]
    ]);

    $fetchAllCategory = $connection->prepare("SELECT * FROM category WHERE deleted_at IS NULL AND user_id = :user_id");
    $fetchAllCategory->execute([
        "user_id" => $_SESSION["user_id"]
    ]);

    $fetchAllLabel = $connection->prepare("SELECT * FROM label WHERE deleted_at IS NULL AND user_id = :user_id");
    $fetchAllLabel->execute([
        "user_id" => $_SESSION["user_id"]
    ]);

    if (isset($_POST["update_password"])) {
        $fetchPassword = $connection->prepare("SELECT password FROM users WHERE user_id = :user_id");
        $fetchPassword->execute(array(
            "user_id" => $_SESSION["user_id"]
        ));

        $isVerified = password_verify($_POST["password"], $fetchPassword->fetch(PDO::FETCH_ASSOC)["password"]);
        if ($isVerified && $_POST["new_password"] === $_POST["confirm_new_password"]) {
            $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
            $updatePassword = $connection->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
            $updatePassword->execute(array(
                "password" => $new_password,
                "user_id" => $_SESSION["user_id"]
            ));
        }
    }

    if (isset($_POST["record_submit"])) {
        $user_id = $_SESSION["user_id"];
        $record_type = $_POST["record_type"];
        $account_name = $_POST["account_name"];
        $amount = $_POST["amount"];
        $currency_type = $_POST["currency_type"];
        $category = $_POST["category"];
        $label = $_POST["label"];
        $record_date = $_POST["date"];
        $record_time = $_POST["time"];

        $createRecord = $connection->prepare("INSERT INTO records(
                user_id,
                record_type,
                account_name,
                amount,
                currency_type,
                category,
                label,
                record_date,
                record_time
            ) VALUES (
                :user_id,
                :record_type,
                :account_name,
                :amount,
                :currency_type,
                :category,
                :label,
                :record_date,
                :record_time
            )");

        $createRecord->execute([
            "user_id" => $user_id,
            "record_type" => $record_type,
            "account_name" => $account_name,
            "amount" => $amount,
            "currency_type" => $currency_type,
            "category" => $category,
            "label" => $label,
            "record_date" => $record_date,
            "record_time" => $record_time
        ]);

        header("Location: dashboard.php");
    }

    if (isset($_POST["update"])) {
        if ($_FILES["image"]["tmp_name"]) {
            $response = $upload->upload($_FILES["image"]["tmp_name"], [
                "folder" => "budget_tracker",
                'use_filename' => TRUE,
                'overwrite' => TRUE
            ]);

            if (isset($response)) {
                $updateUser = $connection->prepare("UPDATE users SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, avatar = :avatar WHERE user_id = :user_id");

                $updateUser->execute(array(
                    "first_name" => $_POST["first_name"],
                    "middle_name" => $_POST["middle_name"],
                    "last_name" => $_POST["last_name"],
                    "avatar" => $response["secure_url"],
                    "user_id" => $_SESSION["user_id"]
                ));

                header("Location: profile.php");
            }
        } else {
            $updateUser = $connection->prepare("UPDATE users SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name WHERE user_id = :user_id");

            $updateUser->execute(array(
                "first_name" => $_POST["first_name"],
                "middle_name" => $_POST["middle_name"],
                "last_name" => $_POST["last_name"],
                "user_id" => $_SESSION["user_id"]
            ));

            header("Location: profile.php");
        }
    }
} else {
    header("Location: ../security/login.php");
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
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Source+Sans+3&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/style/dashboard.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/button.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/data-table.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/date-picker.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/modal.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/number-input.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/tabs.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/version/v2.0.1/dropdown.rtl.min.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <div style="display: flex; flex-direction: row">
        <div id="sidebar" style="height: 100vh">
            <div style="width: fit-content; margin: 20px auto">
                <img src="../../assets/icons/logo.svg" alt="" />
            </div>
            <div class="list">
                <a href="../dashboard.php">
                    <i class="ti ti-layout-dashboard icon-sidebar"></i>
                    <p>Dashboard</p>
                </a>
                <a href="label.php">
                    <i class="ti ti-tag icon-sidebar"></i>
                    <p>Labels</p>
                </a>
                <a href="category.php">
                    <i class="ti ti-category-filled icon-sidebar"></i>
                    <p>Category</p>
                </a>
                <a href="currency.php">
                    <i class="ti ti-coins icon-sidebar"></i>
                    <p>Currencies</p>
                </a>
                <a href="profile.php">
                    <i class="ti ti-user-circle icon-sidebar"></i>
                    <p>Profile</p>
                </a>
            </div>
        </div>

        <div class="top-nav">
            <nav id="navbar">
                <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%">
                    <div style="display: flex; flex-direction: row; width: fit-content">
                        <button id="menu_toggle" style="
                                    width: fit-content;
                                    background-color: transparent;
                                    border: none;
                                    padding: 1vh 10px;
                                ">
                            <img src="../../assets/icons/menu.svg" alt="icon menu" />
                        </button>
                        <button onclick="openModal()" style="
                                    display: flex;
                                    flex-direction: row;
                                    background-color: transparent;
                                    background-color: #0068a3;
                                    border: none;
                                    height: 5vh;
                                    border-radius: 3px;
                                    margin: auto 0 auto 20px;
                                    padding: 0 10px;
                                    gap: 10px;
                                ">
                            <i class="ti ti-plus plus-icon-color"></i>
                            <p style="margin: auto 0; height: fit-content; color: #ffffff">CREATE</p>
                        </button>
                    </div>
                    <div class="dropdown" style="margin-right: 10px; height: fit-content; margin: auto 0">
                        <button style="background-color: transparent; border: none" class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                            $image = $fetchAvatar->fetch(PDO::FETCH_ASSOC)["avatar"];
                            if ($image !== null) { ?>
                                <img src="<?php echo $image ?>" height="40" width="40" alt="" style="object-fit: cover; border-radius: 50%; object-position: 20% 20%" />&nbsp;
                            <?php } else { ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION["first_name"] . '+' . $_SESSION["last_name"] ?>" height="40" width="40" alt="" />&nbsp;
                            <?php } ?>
                            <span style=" font-weight: 600"> <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="./settings/profile.php"><i class="ti ti-settings"></i>&nbsp;Settings</a>
                            </li>
                            <li>
                                <form action="../security/logout.php" method="post">
                                    <button style="background-color: transparent; border: none; margin: 0 0 0 10px" type="submit" name="logout">
                                        <i class="ti ti-logout-2"></i>&nbsp;Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="container" style="width: 85%">
                <ul class="breadcrumb">
                    <li style="display: flex; flex-direction: row; padding: 5px 0">
                        <i class="ti ti-checkup-list breadcrumb-list"></i>
                        <div style="height: fit-content; margin: auto 0">
                            <a class="margin-y-auto" href="#"><span style="font-size: 16px">Settings</span></a>
                        </div>
                    </li>
                    <li style="display: flex; flex-direction: row; padding: 5px 0">
                        <i class="ti ti-user-cog breadcrumb-list"></i>
                        <div style="height: fit-content; margin: auto 0">
                            <a class="margin-y-auto" href="#"><span style="font-size: 16px">Profile</span></a>
                        </div>
                    </li>
                </ul>

                <div style="background-color: #ffffff; margin-top: 15px; border-radius: 5px; padding: 10px 15px;  display: grid; grid-template-columns: auto auto;">
                    <div style=" border-right: 1px solid rgb(148 163 184)">
                        <?php while ($row = $queryUsers->fetch(PDO::FETCH_ASSOC)) { ?>
                            <form action="profile.php" method="post" enctype="multipart/form-data" style="margin: 0; width: fit-content;">
                                <p style="color: #0068a3; font-weight: 600; font-size: 18px">PROFILE</p>
                                <div style="margin: 10px 0">
                                    <div style="display: flex; flex-direction: column; width: 30vw">
                                        <?php if ($row["avatar"] === null) { ?>
                                            <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION["first_name"] . '+' . $_SESSION["last_name"] ?>" height="100" width="100" alt="" />
                                        <?php } else { ?>
                                            <div style="background-image: url('<?php echo $row["avatar"] ?>'); background-position: center; background-repeat: no-repeat; background-size: cover; width: 100px; height: 100px; border-radius: 10%;"></div>
                                        <?php } ?>
                                        <input type="file" style="margin: 10px 0;" name="image" accept="image/*" />
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type=" text" name="first_name" class="form-control" id="floatingInputFirstName" placeholder="name@example.com" value="<?php echo $row["first_name"] ?>" />
                                        <label for="floatingInputFirstName" style="color: #0068a3">First Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type=" text" name="middle_name" class="form-control" id="floatingInputMiddleName" placeholder="name@example.com" value="<?php echo $row["middle_name"] ?>" />
                                        <label for="floatingInputMiddleName" style="color: #0068a3">Middle Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type=" text" name="last_name" class="form-control" id="floatingInputLastName" placeholder="name@example.com" value="<?php echo $row["last_name"] ?>" />
                                        <label for="floatingInputLastName" style="color: #0068a3">Last Name</label>
                                    </div>
                                    <input name="update" type="submit" value="UPDATE PROFILE" />
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                    <div style="padding-left: 24px">
                        <p style="color: #0068a3; font-weight: 600; font-size: 18px; margin: 10px 0">UPDATE PASSWORD</p>
                        <form action="" method="post" style="width: fit-content;">
                            <div class="form-floating mb-3" style="width: 30vw">
                                <input type="password" name="password" class="form-control" id="floatingCurrentPassword" placeholder="Password" />
                                <label for="floatingPassword" style="color: #0068a3">Current Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="new_password" class="form-control" id="floatingNewPassword" placeholder="Password" />
                                <label for="floatingPassword" style="color: #0068a3">New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="confirm_new_password" class="form-control" id="floatingConfirmNewPassword" placeholder="Password" />
                                <label for="floatingPassword" style="color: #0068a3">Confirm New Password</label>
                            </div>
                            <input name="update_password" type="submit" value="UPDATE PASSWORD" />
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <form action="profile.php" method="post">
        <cds-modal id="modal-example">
            <div style="background-color: #ffffff">
                <cds-modal-header>
                    <p style="font-size: 18px; font-weight: 600; color: #0068a3; margin: 0 30px">ADD RECORD</p>
                    <input type="hidden" name="record_type" id="record_type">
                </cds-modal-header>
                <cds-modal-body>
                    <div style="padding: 0 30px">
                        <cds-tabs value="all" type="contained" style="margin: 0 auto">
                            <cds-tab id="tab-all" target="panel-all" value="all" onclick="setRecordType('Expense')">Expense</cds-tab>
                            <cds-tab id="tab-cloudFoundry" target="panel-cloudFoundry" value="cloudFoundry" onclick="setRecordType('Income')">
                                Income
                            </cds-tab>
                        </cds-tabs>
                    </div>
                    <div class="cds-ce-demo-devenv--tab-panels" style="border: 1px solid #0068a3; margin: 0 30px">
                        <div style="padding: 10px 20px">
                            <div>
                                <p style="color: #0068a3; font-size: 16px">Accounts</p>
                                <select name="account_name" class="form-select" aria-label="Default select example" style="border-radius: 3px">
                                    <?php while ($list = $fetchAllAccount->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?php echo $list["account_name"] ?>">
                                            <?php echo $list["account_name"] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div style="display: grid; grid-template-columns: auto auto; gap: 10px; margin-top: 5px">
                                <div>
                                    <p style="color: #0068a3; font-size: 16px">Amount</p>
                                    <div class="input-group mb-3">
                                        <input type="number" name="amount" class="form-control" aria-label="Amount (to the nearest dollar)" />
                                        <span class="input-group-text">-</span>
                                    </div>
                                </div>
                                <div>
                                    <p style="color: #0068a3; font-size: 16px">Currency</p>
                                    <select name="currency_type" class="form-select" aria-label="Default select example" style="border-radius: 3px">
                                        <option value="PHP">PHP</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: auto auto; gap: 10px; margin-top: 5px">
                                <div>
                                    <p style="color: #0068a3; font-size: 16px">Category</p>
                                    <select name="category" class="form-select" aria-label="Default select example" style="border-radius: 3px">
                                        <?php while ($list = $fetchAllCategory->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $list["category"] ?>">
                                                <?php echo $list["category"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div>
                                    <p style="color: #0068a3; font-size: 16px">Label</p>
                                    <select name="label" class="form-select" aria-label="Default select example" style="border-radius: 3px">
                                        <?php while ($list = $fetchAllLabel->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php echo $list["label"] ?>">
                                                <?php echo $list["label"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: auto auto; gap: 10px; margin-top: 5px">
                                <div>
                                    <p style="color: #0068a3; font-size: 16px">Date</p>
                                    <div class="input-group mb-3">
                                        <input type="date" name="record_date" class="form-control" aria-label="Amount (to the nearest dollar)" />
                                    </div>
                                </div>
                                <div>
                                    <p style="color: #0068a3; font-size: 16px">Time</p>
                                    <div class="input-group mb-3">
                                        <input type="time" name="record_time" class="form-control" aria-label="Amount (to the nearest dollar)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </cds-modal-body>
                <cds-modal-footer>
                    <button data-modal-close type="reset" style="width: 50%; background-color: #535353; border: 0; color: #ffffff">
                        Close
                    </button>
                    <button type="submit" name="record_submit" style="width: 50%; background-color: #0068a3; border: 0; color: #ffffff">
                        Save
                    </button>
                </cds-modal-footer>
            </div>
        </cds-modal>
    </form>

    <script>
        var typeRecord = document.getElementById("record_type");

        function setRecordType(type) {
            if (type === "Expense") {
                typeRecord.value = "Expense";
            } else {
                typeRecord.value = "Income"
            }
        }

        function onValidateDelete(account_id, account_name) {
            document.getElementById("modal-validate-delete").open = true;
            document.getElementById("account_id").value = account_id;
            document.getElementById("account_name").innerHTML = account_name;
        }

        document.getElementById("menu_toggle").addEventListener("click", () => {
            document.getElementById("sidebar").classList.toggle("active");
            document.getElementById("navbar").classList.toggle("active");
            document.getElementById("container").classList.toggle("active");
        });

        function onClose() {
            document.getElementById("sidebar").classList.toggle("active");
            document.getElementById("navbar").classList.toggle("active");
        }

        // document.getElementById("modal-profile-button").addEventListener("click", () => {
        //     document.getElementById("modal-example").open = true;
        // });

        function openModal() {
            document.getElementById("modal-example").open = true;
        }
    </script>
</body>

</html>
