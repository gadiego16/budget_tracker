<?php

require("..\\database.php");

session_start();

if (isset($_SESSION["isAuthenticated"])) {
    $fetchAllRecords = $connection->prepare("SELECT * FROM records WHERE deleted_at IS NULL AND user_id = :user_id");
    $fetchAllRecords->execute(["user_id" => $_SESSION["user_id"]]);

    $fetchAllCategory = $connection->prepare("SELECT * FROM category WHERE deleted_at IS NULL AND user_id = :user_id");
    $fetchAllCategory->execute([
        "user_id" => $_SESSION["user_id"]
    ]);

    $fetchAllLabel = $connection->prepare("SELECT * FROM label WHERE deleted_at IS NULL");
    $fetchAllLabel->execute();

    $fetchAllAccount = $connection->prepare("SELECT * FROM accounts WHERE deleted_at IS NULL");
    $fetchAllAccount->execute();

    $fetchAvatar = $connection->prepare("SELECT avatar FROM users WHERE user_id = :user_id");
    $fetchAvatar->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));

    $record_id_by_modal_delete = 0;

    if (isset($_POST["record_submit"])) {
        $user_id = $_SESSION["user_id"];
        $record_type = $_POST["record_type"];
        $account_name = $_POST["account_name"];
        $amount = $_POST["amount"];
        $currency_type = $_POST["currency_type"];
        $category = $_POST["category"];
        $label = $_POST["label"];
        $record_date = $_POST["record_date"];
        $record_time = $_POST["record_time"];

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

        header("Location: records.php");
    }
} else {
    header("Location: ./security/login.php");
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Source+Sans+3&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style/dashboard.css" />
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/date-picker.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/modal.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/button.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/tabs.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/version/v2.0.1/dropdown.rtl.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/number-input.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/data-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <div style="display: flex; flex-direction: row">
        <div id="sidebar">
            <div style="width: fit-content; margin: 20px auto">
                <img src="../assets/icons/logo.svg" alt="" />
            </div>
            <div class="list">
                <a href="dashboard.php">
                    <i class="ti ti-layout-dashboard icon-sidebar"></i>
                    <p>Dashboard</p>
                </a>
                <a href="account.php">
                    <i class="ti ti-wallet icon-sidebar"></i>
                    <p>Accounts</p>
                </a>
                <a href="records.php">
                    <i class="ti ti-clipboard-text icon-sidebar"></i>
                    <p>Records</p>
                </a>
                <a href="analytic.php">
                    <i class="ti ti-chart-histogram icon-sidebar"></i>
                    <p>Analytics</p>
                </a>
            </div>
            <div style="width: fit-content; margin: 0 auto">
                <button onclick="onClose()" class="close-button">BACK</button>
            </div>
        </div>

        <div class="top-nav" style="height: 100vh">
            <nav id="navbar">
                <div style="display: flex; flex-direction: row; justify-content: space-between; width: 100%">
                    <div style="display: flex; flex-direction: row; width: fit-content">
                        <button id="menu_toggle" style="
                                    width: fit-content;
                                    background-color: transparent;
                                    border: none;
                                    padding: 1vh 10px;
                                ">
                            <img src="../assets/icons/menu.svg" alt="icon menu" />
                        </button>
                        <button id="modal-example-button" style="
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
                                <img src="<?php echo $image ?>" height="40" width="40" alt="" />&nbsp;
                            <?php } else { ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION["first_name"] . '+' . $_SESSION["last_name"] ?>" height="40" width="40" alt="" />&nbsp;
                            <?php } ?>
                            <span style="font-weight: 600"> <?php echo $_SESSION["first_name"] . " " . $_SESSION["last_name"] ?>
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
            <div class="disable-scrollbars" id="container">
                <ul class="breadcrumb">
                    <li style="display: flex; flex-direction: row; padding: 5px 0">
                        <i class="ti ti-checkup-list breadcrumb-list"></i>
                        <div style="height: fit-content; margin: auto 0">
                            <a class="margin-y-auto" href="#"><span style="font-size: 16px">Records</span></a>
                        </div>
                    </li>
                </ul>

                <div style="background-color: #ffffff; margin-top: 15px; border-radius: 5px; padding: 10px 15px">
                    <cds-table is-sortable>
                        <cds-table-header-title slot="title" style="color: #0068a3; font-weight: 600; margin-left: -14px">Record List</cds-table-header-title>
                        <cds-table-header-description slot="description"> </cds-table-header-description>
                        <cds-table-toolbar slot="toolbar">
                            <div style="display: flex; justify-content: space-between">
                                <select class="form-select" aria-label="Default select example" style="border-radius: 3px; width: 287px; height: 5vh">
                                    <option selected>Filter</option>
                                    <option value="Cash">Work</option>
                                </select>
                                <div style="display: flex; flex-direction: row; gap: 10px; margin: 5px 0">
                                    <button style="
                                                display: flex;
                                                flex-direction: row;
                                                background-color: transparent;
                                                background-color: #0068a3;
                                                border: none;
                                                height: 5vh;
                                                border-radius: 3px;
                                                padding: 0 10px;
                                                gap: 10px;
                                            ">
                                        <i class="ti ti-filter-check plus-icon-color"></i>
                                        <p style="margin: auto 0; height: fit-content; color: #ffffff">FILTER</p>
                                    </button>
                                </div>
                            </div>
                        </cds-table-toolbar>
                        <cds-table-head>
                            <cds-table-header-row>
                                <cds-table-header-cell>Record Type</cds-table-header-cell>
                                <cds-table-header-cell>Account Name</cds-table-header-cell>
                                <cds-table-header-cell>Category</cds-table-header-cell>
                                <cds-table-header-cell>Label</cds-table-header-cell>
                                <cds-table-header-cell>Amount</cds-table-header-cell>
                                <cds-table-header-cell>Actions</cds-table-header-cell>
                            </cds-table-header-row>
                        </cds-table-head>
                        <cds-table-body>
                            <?php foreach ($fetchAllRecords as $key => $value) { ?>
                                <cds-table-row>
                                    <cds-table-cell style="color: <?php echo $value["record_type"] == "Expense" ? "#FE3B2C" : "#00AA70" ?>"><?php echo $value["record_type"] ?></cds-table-cell>
                                    <cds-table-cell style="color: <?php echo $value["record_type"] == "Expense" ? "#FE3B2C" : "#00AA70" ?>"><?php echo $value["account_name"] ?></cds-table-cell>
                                    <cds-table-cell style="color: <?php echo $value["record_type"] == "Expense" ? "#FE3B2C" : "#00AA70" ?>"><?php echo $value["category"] ?></cds-table-cell>
                                    <cds-table-cell style="color: <?php echo $value["record_type"] == "Expense" ? "#FE3B2C" : "#00AA70" ?>"><?php echo $value["label"] ?></cds-table-cell>
                                    <cds-table-cell style="color: <?php echo $value["record_type"] == "Expense" ? "#FE3B2C" : "#00AA70" ?>">
                                        <?php echo $value["record_type"] == "Expense" ? "-" : "+" ?>
                                        <?php echo $value["currency_type"] . " " . $value["amount"] ?>
                                    </cds-table-cell>
                                    <cds-table-cell style="display: flex; flex-direction: row; gap: 5px">
                                        <form action="./controller/delete_record_by_id.php" method="post">
                                            <cds-modal id="modal-validate-delete">
                                                <div style="background-color: #ffffff; width: 50%; margin: 0 auto;">
                                                    <cds-modal-header>
                                                        <p style="font-size: 18px; font-weight: 600; color: #0068a3; margin: 0 30px">DELETE RECORD CONFIRMATION</p>
                                                    </cds-modal-header>
                                                    <cds-modal-body>
                                                        <input type="hidden" name="record_id" id="record_id">
                                                        <p style="font-weight: 400; margin: 0 30px; font-size: 16px">Do you want to delete the account name
                                                            <span style="font-weight: 600; color: #FE3B2C" id="account_name">
                                                                <!-- <?php echo $value["account_name"] ?> -->
                                                            </span>
                                                            with category of name
                                                            <span style="font-weight: 600; color: #FE3B2C" id="category">
                                                                <!-- <?php echo $value["category"] ?> -->
                                                            </span>
                                                            ?
                                                        </p>
                                                    </cds-modal-body>
                                                    <cds-modal-footer>
                                                        <button data-modal-close type="reset" style="width: 50%; background-color: #535353; border: 0; color: #ffffff">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" name="delete_from_record" style="width: 50%; background-color: #FE3B2C; border: 0; color: #ffffff">
                                                            Delete
                                                        </button>
                                                    </cds-modal-footer>
                                                </div>
                                            </cds-modal>
                                        </form>

                                        <button style="
                                                display: flex;
                                                flex-direction: row;
                                                background-color: transparent;
                                                background-color: #00AA70;
                                                border: none;
                                                height: 5vh;
                                                border-radius: 3px;
                                                padding: 0 10px;
                                                gap: 10px;
                                                margin: 10px 0;
                                            ">
                                            <i class="ti ti-edit plus-icon-color"></i>
                                            <p style="margin: auto 0; height: fit-content; color: #ffffff">
                                                EDIT
                                            </p>
                                        </button>

                                        <button onclick="onValidateDelete(<?php echo $value['record_id'] ?>, '<?php echo $value['category'] ?>', '<?php echo $value['account_name'] ?>')" style="
                                                display: flex;
                                                flex-direction: row;
                                                background-color: #FE3B2C;
                                                border: none;
                                                height: 5vh;
                                                border-radius: 3px;
                                                padding: 0 10px;
                                                gap: 10px;
                                                margin: 10px 0;
                                            ">
                                            <i class="ti ti-trash plus-icon-color"></i>
                                            <p style="margin: auto 0; height: fit-content; color: #ffffff">
                                                DELETE
                                            </p>
                                        </button>
                                    </cds-table-cell>
                                </cds-table-row>
                            <?php } ?>
                        </cds-table-body>
                    </cds-table>
                </div>
            </div>
        </div>
    </div>

    <form action="records.php" method="post">
        <cds-modal id="modal-example">
            <div style="background-color: #ffffff">
                <cds-modal-header>
                    <p style="font-size: 18px; font-weight: 600; color: #0068a3; margin: 0 30px">ADD RECORD</p>
                    <input type="hidden" name="record_type" id="record_type" value="Expense">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var typeRecord = document.getElementById("record_type");

        function setRecordType(type) {
            if (type === "Expense") {
                typeRecord.value = "Expense";
            } else {
                typeRecord.value = "Income"
            }
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

        document.getElementById("modal-example-button").addEventListener("click", () => {
            document.getElementById("modal-example").open = true;
        });

        function onValidateDelete(record_id, category, account_name) {
            console.log(record_id, category, account_name);
            document.getElementById("category").innerText = category;
            document.getElementById("account_name").innerText = account_name;
            document.getElementById("record_id").value = record_id;
            document.getElementById("modal-validate-delete").open = true;
        }
    </script>
</body>

</html>
