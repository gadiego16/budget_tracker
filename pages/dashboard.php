<?php
require("../database.php");

session_start();

$account_type = null;
$amount = null;
$currency_type = null;
$category = null;
$label = null;

$expense = 0;
$income = 0;
$array_labels = array();

$dataForPie = array();

if ($_SESSION["isAuthenticated"]) {
    $fetchAllCategory = $connection->prepare("SELECT * FROM category WHERE user_id = :user_id AND deleted_at IS NULL");
    $fetchAllCategory->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));

    $fetchAllLabel = $connection->prepare("SELECT * FROM label WHERE user_id = :user_id AND deleted_at IS NULL");
    $fetchAllLabel->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));

    $fetchAllAccount = $connection->prepare("SELECT * FROM accounts WHERE user_id = :user_id AND deleted_at IS NULL");
    $fetchAllAccount->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));

    $fetchAllRecords = $connection->prepare("SELECT * FROM records WHERE deleted_at IS NULL AND user_id = :user_id");
    $fetchAllRecords->execute(array("user_id" => $_SESSION["user_id"]));

    $fetchAllLabelForPie = $connection->prepare("SELECT category, SUM(amount) AS total_amount FROM records WHERE user_id = :user_id AND record_type = 'Expense' AND deleted_at IS NULL GROUP BY category");
    $fetchAllLabelForPie->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));


    $fetchAvatar = $connection->prepare("SELECT avatar FROM users WHERE user_id = :user_id");
    $fetchAvatar->execute(array(
        "user_id" => $_SESSION["user_id"]
    ));


    while ($records = $fetchAllRecords->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($records as $key => $value) {
            if ($value["record_type"] === "Expense") {
                $expense = $expense + (int)$value["amount"];
            } else if ($value["record_type"] === "Income")
                $income = $income + (int)$value["amount"];
        }
    }

    while ($labelData = $fetchAllLabelForPie->fetchAll(PDO::FETCH_ASSOC)) {
        foreach ($labelData as $key => $value) {
            array_push($array_labels, $value);
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

        header("Location: dashboard.php");
    }
} else {
    header("Location: ./security/login.php");
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Source+Sans+3&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/style/dashboard.css" />
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/date-picker.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/modal.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/button.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/tabs.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/version/v2.0.1/dropdown.rtl.min.js"></script>
    <script type="module" src="https://1.www.s81c.com/common/carbon/web-components/tag/v2/latest/number-input.min.js"></script>
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
            <!-- <div style="width: fit-content; margin: 0 auto">
                <button onclick="onClose()" class="close-button">BACK</button>
            </div> -->
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
                                <img src="<?php echo $image ?>" height="40" width="40" style="border-radius: 100%; object-fit: cover" alt="" />&nbsp;
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
                                <form action="./security/logout.php" method="post">
                                    <button style="background-color: transparent; border: none; margin: 0 0 0 10px" type="submit" name="logout">
                                        <i class="ti ti-logout-2"></i>&nbsp;Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="container">
                <ul class="breadcrumb">
                    <li style="display: flex; flex-direction: row">
                        <i class="ti ti-layout-dashboard breadcrumb-list"></i>
                        <div style="height: fit-content; margin: auto 0">
                            <a class="margin-y-auto" href="#"><span style="font-size: 16px">Dashboard</span></a>
                        </div>
                    </li>
                    <li style="display: flex; flex-direction: row">
                        <i class="ti ti-calendar-stats breadcrumb-list"></i>
                        <div style="height: fit-content; margin: auto 0">
                            <span style="font-size: 16px; font-weight: 600; color: #0068a3">Monthly</span>
                        </div>
                    </li>
                </ul>

                <div style="
                            display: flex;
                            justify-content: space-between;
                            background-color: #ffffff;
                            padding: 10px;
                            border-radius: 5px;
                        ">
                    <cds-date-picker style="display: flex; flex-direction: column">
                        <label for="" style="color: #0068a3">Date</label>
                        <cds-date-picker-input kind="single" size="sm" placeholder="mm/dd/yyyy" style="background-color: #ffffff; border-radius: 3px; border: 1px solid #afafaf">
                        </cds-date-picker-input>
                    </cds-date-picker>
                    <button style="
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
                        <i class="ti ti-filter-check plus-icon-color"></i>
                        <p style="margin: auto 0; height: fit-content; color: #ffffff">FILTER</p>
                    </button>
                </div>

                <table style="width: 100%">
                    <tr>
                        <th style="width: 50%; padding: 5px 10px 0 0; border-radius: 3px">
                            <div style="background-color: #ffffff; border-radius: 5px; padding: 5px 0; margin-top: 10px">
                                <p style="text-align: center; font-size: 18px; margin: 10px 0; font-weight: 500" for="">
                                    Balance Trend
                                </p>
                                <div class="wrapper">
                                    <canvas id="myChart" width="210" height="250"></canvas>
                                </div>
                            </div>
                        </th>
                        <th style="width: 50%; padding: 5px 0 0 10px; border-radius: 3px">
                            <div style="background-color: #ffffff; padding: 5px 0; border-radius: 5px;; margin-top: 10px;">
                                <p style="text-align: center; font-size: 18px; margin: 10px 0; font-weight: 500" for="">
                                    Expense Structure
                                </p>
                                <div class="wrapper">
                                    <canvas id="donutChart" width="100" height="200"></canvas>
                                </div>
                            </div>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <form action="dashboard.php" method="post">
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
                console.log(type);
            } else {
                typeRecord.value = "Income"
                console.log(type);
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

        const chart = new Chart(document.getElementById("myChart"), {
            type: "bar",
            data: {
                labels: ["EXPENSE", "INCOME"],
                datasets: [{
                    data: [<?php echo $expense ?>, <?php echo $income ?>],
                    backgroundColor: [
                        "#0068a3",
                        "#0068A3BA"
                    ],
                }],
            },
            options: {
                title: {
                    display: true,
                    text: "Balance Amount over Time",
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        display: false,
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            },
        });

        function shadeColor(color, percent) {
            var f = parseInt(color.slice(1), 16),
                t = percent < 0 ? 0 : 255,
                p = percent < 0 ? percent * -1 : percent,
                R = f >> 16,
                G = f >> 8 & 0xff,
                B = f & 0xff;
            return "#" + (0x1000000 | Math.round((R + t * p) << 16) | Math.round((G + t * p) << 8) | Math.round(B + t * p)).toString(16).slice(1);
        }

        let labels = JSON.parse('<?php echo json_encode($array_labels) ?>');
        console.table(labels);

        var data = {
            labels: labels.map(({
                    total_amount,
                    category
                }) =>
                category),
            datasets: [{
                data: labels.map(({
                    total_amount,
                    category
                }) => total_amount),
                backgroundColor: function(context) {
                    var index = context.dataIndex;
                    var baseColor = "#0068a3"; // Your default color
                    var decrementalValue = (index + 1) * 0.1; // Adjust the decremental value to control the color lightness
                    var decrementedColor = baseColor;
                    decrementedColor = shadeColor(decrementedColor, decrementalValue);
                    return decrementedColor;
                }, // Colors for each segment
            }, ],
        };

        // Configuration options
        var options = {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 50, // Adjust to change the size of the hole in the center (50% for a classic donut)
        };

        const piechart = new Chart(document.getElementById("donutChart"), {
            type: "doughnut",
            data: data,
            options: options,
        });
    </script>
</body>

</html>
