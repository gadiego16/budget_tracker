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
    <title>Document</title>
    <style>
        *,
        html,
        body {
            box-sizing: border-box;
            margin: 0;
            font-family: "Source Sans 3";

        }

        .form-control {
            border: none;
            border-bottom: 2px solid #0068a3;
            border-radius: 0;
            background-color: #eaeaea;
        }

        .form-control:focus {
            border: none;
            border-color: initial;
            box-shadow: none;
            border-bottom: 2px solid #0068a3;
            background-color: #eaeaea;
        }

        label::after {
            background-color: transparent !important;
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

    <div style="background-image: url('https://odoocdn.com/openerp_website/static/src/img/2016/components/arch_5.jpg');
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
                padding: 40px 0">
        <form style="width: 60%; margin: 0 0 0 10px;  padding: 0 100px;">
            <p style="font-size: 35px; font-weight: 600; color: #0068a3">Contact Us</p>
            <p>Fill in this form to get information about anything related to Finance Web, services, our company.</p>
            <div style="width: 100%;">
                <div class="form-floating mb-3" style="width: 100%;">
                    <input type="text" name="name" value="" class="form-control" id="floatingInput" required />
                    <label for="floatingInput" style="color: #0068a3">Name</label>
                </div>
                <div class="form-floating mb-3" style="width: 100%;">
                    <input type="number" name="name" value="" class="form-control" id="floatingInput" required />
                    <label for="floatingInput" style="color: #0068a3">Phone Number</label>
                </div>
                <div class="form-floating mb-3" style="width: 100%;">
                    <input type="email" name="name" value="" class="form-control" id="floatingInput" required />
                    <label for="floatingInput" style="color: #0068a3">Email</label>
                </div>
                <div class="form-floating mb-3" style="width: 100%;">
                    <input type="text" name="name" value="" class="form-control" id="floatingInput" required />
                    <label for="floatingInput" style="color: #0068a3">Subject</label>
                </div>
                <div class="form-floating mb-3" style="width: 100%">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" required></textarea>
                    <label for="floatingTextarea2" style="color: #0068a3">Message</label>
                </div>
                <p>
                    <i class="ti ti-info-circle-filled" style="color: #0068a3"></i>
                    We will handle your personal data as described in our <a href="">Privacy Policy</a>, to answer your question and provide information about our products and services.
                </p>
                <button type="submit" style="
                                    display: flex;
                                    flex-direction: row;
                                    background-color: transparent;
                                    background-color: #0068a3;
                                    border: none;
                                    height: 5vh;
                                    border-radius: 3px;
                                    padding: 5px 20px;
                                    gap: 10px;
                                ">
                    <p style="margin: auto 0; height: fit-content; color: #ffffff">SUBMIT</p>
                </button>
            </div>
        </form>
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
