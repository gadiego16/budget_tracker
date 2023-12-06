<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Source+Sans+3&display=swap" rel="stylesheet" />
    <title>Document</title>
    <style>
        *,
        html,
        body {
            box-sizing: border-box;
            margin: 0;
            font-family: "Source Sans 3";
        }
    </style>
</head>

<body>
    <nav style="
                width: 100%;
                background-color: #ffffff;
                display: flex;
                justify-content: space-between;
                box-shadow: 0px 2px 3px 3px rgba(0, 0, 0, 0.2);
                position: relative;
                gap: 20px;
            ">
        <a href="index.php" style="padding: 10px 10px; width: 100%">
            <img style="width: 11vw" src="./assets/icons/logo-dark.svg" alt="" />
        </a>
        <a href="contact_us.php" style="width: 9%; margin: auto 0; text-decoration: none; color: #0068a3;">CONTACT US</a>
        <a href="" style="width: 6%; margin: auto 0; text-decoration: none; color: #0068a3;">ASSETS</a>
        <a href="" style="width: 7%; margin: auto 0; text-decoration: none; color: #0068a3;">SERVICES</a>
        <p style="text-align: justify; width: 6%; margin: auto;">
            <a style="text-decoration: none; color: #0068a3; font-weight: 600" href="pages/security/login.php">SIGN IN</a>
        </p>
        <p style="text-align: justify; width: 6%; margin: auto">
            <a style="text-decoration: none; color: #0068a3; font-weight: 600" href="pages/security/register.php">SIGN UP</a>
        </p>
    </nav>

    <main style="width: 100%; display: flex; flex-direction: row; background-color: #0068a3; z-index: 0">
        <img style="width: 50%" src="./assets/images/hero.svg" alt="" />
        <div style="width: 40%; margin: auto auto; display: flex; flex-direction: column; gap: 25px">
            <p style="color: #ffffff; font-family: Source Sans 3, sans-serif; font-size: 42px; font-weight: 500">
                Personal Finance Budget Management System
            </p>
            <p style="color: #ffffff; font-size: 18px">
                A Software as a Service (SaaS) Web Application that automates and tracks your daily expenses. Finance Web monitors your daily expenses and notify if there is over cap to the set expected amount.
            </p>
            <button style="
                        background-color: #ffffff;
                        border: none;
                        padding: 10px 20px;
                        width: fit-content;
                        border-radius: 5px;
                        font-weight: 500;
                        color: #0068a3;
                    ">
                Get Started
            </button>
        </div>
    </main>

    <article style="
                background-image: url('https://odoocdn.com/openerp_website/static/src/img/2016/components/arch_5.jpg');
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
            ">
        <div style="display: flex; flex-direction: row" class="container">
            <div style="width: 60%; height: fit-content; margin: auto">
                <p style="font-size: 42px; font-weight: 500; color: #0068a3">User-Friendly Interface</p>
                <p style="font-size: 18px; font-weight: 500">Consistent design and easy accessible features</p>
                <p style="width: 50%; font-size: 14px">
                    Our budget tracker app boasts an intuitive and easy-to-navigate interface, making it accessible
                    for users of all levels of financial expertise
                </p>
            </div>
            <div style="width: fit-content; margin: 50px auto">
                <img style="width: 30vw" src="./assets/images/mac.svg" alt="" />
            </div>
        </div>
    </article>

    <article style="background-color: #EAEAEA">
        <div class="container" style="display: flex; flex-direction: row">
            <div style="width: fit-content; margin: 50px auto">
                <img style="width: 30vw" src="./assets/images/customize-image.png" alt="" />
            </div>
            <div style="width: 60%; height: fit-content; margin: auto">
                <p style="
                            text-align: center;
                            font-size: 42px;
                            font-weight: 500;
                            margin-left: 115px;
                            color: #0068a3;
                        ">
                    Customizable Categories
                </p>
                <p style="
                            width: 50%;
                            text-align: left;
                            float: right;
                            margin-right: 155px;
                            font-size: 18px;
                            font-weight: 500;
                        ">
                    Easy to create category expenses
                </p>
                <p style="width: 50%; text-align: left; float: right; margin-right: 155px; font-size: 14px">
                    Tailor your budget categories to fit your unique financial goals and lifestyle, ensuring that
                    your budget is truly personalizedOur budget tracker app boasts an intuitive and easy-to-navigate
                    interface, making it accessible for users of all levels of financial expertise
                </p>
            </div>
        </div>
    </article>

    <article style="background-color: #EAEAEA">
        <div class="container" style="display: flex; flex-direction: row">
            <div style="width: 60%; height: fit-content; margin: auto">
                <p style="font-size: 42px; font-weight: 500; color: #0068a3">Budget Analysis</p>
                <p style="font-size: 18px; margin-top: 10px; font-weight: 500">
                    Automate expense and budget analysis
                </p>
                <p style="width: 50%; font-size: 14px">
                    Gain valuable insights into your spending habits with detailed expense breakdowns and charts,
                    helping you identify areas where you can save
                </p>
            </div>
            <div style="width: fit-content; margin: 50px auto">
                <img style="width: 50vw" src="./assets/images/expense-image.gif" alt="" />
            </div>
        </div>
    </article>

    <div style="width: 100%; background-color: #ffffff">
        <div class="container" style="padding-top: 100px">
            <p style="text-align: center; font-size: 42px; font-weight: 500; color: #0068a3">
                Take Control of your Finances
            </p>
            <p style="text-align: center; font-size: 18px; font-weight: 500">
                Budgeting Made Simple, Savings Made Easy.
            </p>
            <div style="margin: 90px 0 0 0; display: flex; justify-content: space-between; gap: 50px">
                <div style="width: fit-content">
                    <div style="
                                border: 1px solid #0068a3;
                                width: fit-content;
                                border-radius: 100%;
                                padding: 10px;
                                margin: 0 auto;
                            ">
                        <img style="width: 5vw" src="./assets/icons/monitor.svg" alt="" />
                    </div>
                    <p style="text-align: center; margin-top: 10px; font-size: 18px; font-weight: 500">MONITOR</p>
                    <p style="width: fit-content; text-align: center; font-size: 14px">
                        Never miss a bill or a savings goal deadline again, thanks to our customizable budget
                        reminders and notifications.
                    </p>
                </div>
                <div style="width: fit-content">
                    <div style="
                                border: 1px solid #0068a3;
                                width: fit-content;
                                border-radius: 100%;
                                padding: 10px;
                                margin: 0 auto;
                            ">
                        <img style="width: 5vw" src="./assets/icons/analyze.svg" alt="" />
                    </div>
                    <p style="text-align: center; margin-top: 10px; font-size: 18px; font-weight: 500">ANALYZE</p>
                    <p style="width: fit-content; text-align: center; font-size: 14px">
                        Get clear insights into your spending habits with detailed expense breakdowns and charts,
                        helping you identify areas where you can save and make better financial decisions.
                    </p>
                </div>
                <div style="width: fit-content">
                    <div style="
                                border: 1px solid #0068a3;
                                width: fit-content;
                                border-radius: 100%;
                                padding: 10px;
                                margin: 0 auto;
                            ">
                        <img style="width: 5vw" src="./assets/icons/goal.svg" alt="" />
                    </div>
                    <p style="text-align: center; margin-top: 10px; font-size: 18px; font-weight: 500">GOAL</p>
                    <p style="width: fit-content; text-align: center; font-size: 14px">
                        Set and track your financial goals with our app, whether it's saving for a vacation, paying
                        off debt, or building an emergency fund.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 30vh; width: 100%; background-color: #0068a3; padding-top: 10px; box-shadow: 0px 2px 3px 3px rgba(0, 0, 0, 0.2); position: relative;">
        <div style="display: flex; flex-direction: row; width: fit-content;  height: fit-content; margin:0 auto; padding: 80px 0; gap: 25px">
            <div>
                <p style="color: #ffffff; font-size: 35px">Invest for your future</p>
                <p style="color: #ffffff; margin: -20px 0 0 0; float: right">No credit card required</p>
            </div>
            <button style="
            display: flex;
            flex-direction: row;
            background-color: transparent;
            background-color: #ffffff;
            border: none;
            height: 6vh;
            border-radius: 3px;
            margin-top: 14px;
            padding: 0 10px;
            gap: 10px;
        ">
                <p style="margin: auto 0; height: fit-content; color: #0068a3; font-weight: 600;">Start Now - It's Free</p>
            </button>
        </div>

    </div>

    <footer style="height: 50vh; width: 100%; background-color: #EAEAEA;">
        <div style="width: fit-content; margin: 0 auto; padding: 20px 0">
            <img src="./assets/icons/logo-dark.svg" alt="">
        </div>
        <table style="width: 80%; margin-top: 40px; margin-left: auto; margin-right: auto">
            <tr style="width: 100%; display: flex; flex-direction: row">
                <td style="width: 33.33%; padding: 0 15px; display: flex; flex-direction: column">
                    <p style="font-size: 16px; font-weight: 600; width: 200px">Terms and Conditions</p>
                    <a href="" style="text-decoration: none; font-size: 14px;">Privacy</a>
                    <a href="" style="text-decoration: none; font-size: 14px;">Cookie Policy</a>
                </td>
                <td style="width: 33.33%; padding: 0 15px; display: flex; flex-direction: column">
                    <p style="font-size: 16px; font-weight: 600; width: 200px">About Us</p>
                    <a href="" style="text-decoration: none; font-size: 14px;">Contact Us</a>
                    <a href="" style="text-decoration: none; font-size: 14px;">Our Services</a>
                    <a href="" style="text-decoration: none; font-size: 14px;">Assets</a>
                </td>
                <td style="width: 33.33%;">
                    <p style="text-align: justify; padding: 0 15px; font-size: 14px">Finance Web is a digital tool designed to help users manage and monitor their financial resources effectively. It provides a platform for individuals, businesses, or organizations to create, plan, and track their budgets with the goal of optimizing their financial health and achieving their financial objectives.</p>
                </td>
            </tr>
        </table>
        <p style="font-size: 14px; font-weight: 600; text-align: center; margin-top: 40px">Website Proudly Created in PHP</p>
        <p style="font-size: 14px; font-weight: 600; text-align: center; margin-top: -10px">©2023. All Rights Reserved Finance Web</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
