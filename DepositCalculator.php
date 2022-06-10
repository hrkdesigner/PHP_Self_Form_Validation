<?php
session_start();
session_destroy();

$dayTime = array();
$error = false;
$email_checker = "";
$amount = $name = $rate = $monthOfPayment = $email = $phone = $postal = $new_error = "";
$name_error = $rate_error = $contact_error = $month_error = $amount_error = $postal_error = $phone_error = $rate_error = $email_error = "";


if (isset($_POST['submit'])) {

    $dayTime = array();
    $time = isset($_POST['time']);

    function ValidatePrincipal($amount)
    {
        if (empty($amount)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['amount_error'] = "Please insert your desired amount";
        } else {
            if ($amount <= 0 || !is_numeric($amount)) {
                $GLOBALS['error'] = true;
                return $GLOBALS['amount_error'] =  "Must be numeric/grater than zero";
            }
        }
    }

    function ValidateRate($rate)
    {
        if (empty($rate)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['rate_error'] = "Please insert your desired rate";
        } else {
            if ($rate < 0 || !is_numeric($rate)) {
                $GLOBALS['error'] = true;
                return $GLOBALS['rate_error'] = "Must be numeric and not negative";
            }
        }
    }
    function ValidateYears($monthOfPayment)
    {
        if (empty($monthOfPayment)) {
            $GLOBALS['error'] = true;
            $GLOBALS['month_error'] = "Please choose your desired month for payment";
            return;
        }
    }
    function ValidateName($name)
    {
        $name = trim($name);
        if (empty($name)) {
            $GLOBALS['error'] = true;
            $GLOBALS['name_error'] = "Name is Required";
            return;
        }
    }
    function ValidatePostal($postal)
    {
        if (empty($postal)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['postal_error'] = "Enter your postal code";
        }
       $reg = "/^[a-zA-Z][0-9][a-zA-Z] ?[0-9][a-zA-Z][0-9]$/";
        if(!preg_match($reg, $postal)){
            $GLOBALS['error'] = true;
            return $GLOBALS['postal_error'] = "Follow the rule | XnX nXn XnX";
        }
    }





    function ValidatePhone($phone)
    {
        if (empty($phone)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['phone_error'] = "Enter your phone number";
        }
        $reg = "/^[2-9][0-9]{2}[-][2-9][0-9]{2}[-][0-9]{4}$/";
        if(!preg_match($reg, $phone)){
            $GLOBALS['error'] = true;
            return $GLOBALS['phone_error'] = "Incorrect format | (000-000-0000)";
        }
        // $phone_checker = str_split($phone);
        // $firstNumber = implode("", array_slice($phone_checker, 0, 1));
        // $secondNumber = implode("", array_slice($phone_checker, 4, 1));
        // $firstCharacter = implode("", array_slice($phone_checker, 3, 1));
        // $secondCharacter = implode("", array_slice($phone_checker, 7, 1));
        // $numbers = array();
        // $charachters = array();
        // array_push($numbers, $firstNumber);
        // array_push($numbers, $secondNumber);
        // array_push($charachters, $firstCharacter);
        // array_push($charachters, $secondCharacter);
        // foreach ($charachters as $key) {
        //     if ($key != "-") {
        //         $GLOBALS['error'] = true;
        //         return $GLOBALS['phone_error'] = "Incorrect format | (000-000-0000)";
        //     }
        // }
        // foreach ($numbers as $key) {
        //     if ($key == 0 || $key == 1) {
        //         $GLOBALS['error'] = true;
        //         return $GLOBALS['phone_error'] = "First/Second 3 digits cannot 0 or 1";
        //     }
        // }

    }






    function ValidateEmail($email, $email_checker)
    {
        if (empty($email)) {
            $GLOBALS['error'] = true;
            return $GLOBALS['email_error'] = "Enter your email";
        }
        $reg = "/^[a-zA-Z\.\d]+[@][a-zA-Z\.]+\.[a-zA-Z]{2,4}$/";
        if(!preg_match($reg, $email)){
            $GLOBALS['error'] = true;
            return $GLOBALS['email_error'] = "No number | Domain between 2-4 letters";
        }
        // $email_checker = str_split($email);
        // $email_checker =  array_reverse(array_slice(array_reverse($email_checker), 0, 6));

        // $stringOfEmail = implode("", $email_checker);
        // if (stripos($stringOfEmail, ".") >= 4) {
        //     $GLOBALS['error'] = true;
        //     return $GLOBALS['email_error'] = "Domain must between 2 to 4 letters";
        // }

        // $x = array_search(".", $email_checker);
        // if (!$x) {
        //     $GLOBALS['error'] = true;
        //     return $GLOBALS['email_error'] = "Domain must between 2 to 4 letters";
        // }
    }

    $amount = ValidatePrincipal($_POST['amount']);
    $rate = ValidateRate($_POST['rate']);
    $monthOfPayment = ValidateYears($_POST['deposit']);
    $name = ValidateName($_POST['name']);
    $postal = ValidatePostal($_POST['code']);
    $phone = ValidatePhone($_POST['number']);
    $email = ValidateEmail($_POST['mail'], $email_checker);


    if (empty($_POST['contact'])) {
        $GLOBALS['error'] = true;
        $contact_error = "Choose your method of contact";
    }

    if (isset($_POST['contact']) && $_POST['contact'] == "phone") {
        $_SESSION["contact"] = "phone";
        if (!$time) {
            $GLOBALS['error'] = true;
            $new_error = "If you use phone, you have to use at least one preferred range of day time";
        } else {
            foreach ($_POST['time'] as $x) {
                array_push($dayTime, $x);
                $_SESSION[$x] = $x;
            }
        }
    }
    if (isset($_POST['contact']) && $_POST['contact'] == "email") {
        $_SESSION["contact"] = "email";
    }
}

if (isset($_POST['amount'])) {
    $amount = $_POST['amount'];
}
if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
if (isset($_POST['code'])) {
    $postal = $_POST['code'];
}
if (isset($_POST['number'])) {
    $phone = $_POST['number'];
}
if (isset($_POST['deposit'])) {
    $monthOfPayment = $_POST['deposit'];
}
if (isset($_POST['rate'])) {
    $rate = $_POST['rate'];
}
if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
}

if (isset($_POST['clear'])) {
    function clearData()
    {
        $GLOBALS['amount'] = $GLOBALS['name'] = $GLOBALS['rate'] = $GLOBALS['monthOfPayment'] = $GLOBALS['email'] = $GLOBALS['phone'] = $GLOBALS['postal'] = $GLOBALS['new_error'] = "";
        $GLOBALS['name_error'] = $GLOBALS['rate_error'] = $GLOBALS['contact_error'] = $GLOBALS['month_error'] = $GLOBALS['amount-error'] = $GLOBALS['postal_error'] = $GLOBALS['phone_error'] = $GLOBALS['rate_error'] = $GLOBALS['email_error'] = "";
    }

    clearData();
}

?>


<html>

<head>
    <title>Deposit Calculator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            padding: 20px auto;
            margin: 0;
            box-sizing: border-box;
            background-color: #fff;
            cursor: default;
            font-weight: 400;
        }

        h3 {
            text-align: center;
            padding-bottom: 20px;
        }

        span {
            display: flex;
            justify-content: center;
            font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
            font-size: 11px;
            font-weight: 900;
            text-align: center;
        }

        .xx {
            display: flex;
            justify-content: center;
            align-content: center;
        }

        .yy {
            display: flex;
            justify-content: space-between;
            align-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <?php if ($error == true || !isset($_POST['submit'])) : ?>
        <div class="container">
            <h2 class="text-left">Deposite Calculator</h2>
            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
                <div class="form-group row xx">
                    <label for="amount" class="col-sm-2 col-form-label">Principal Amount</label>
                    <div class="col-sm-5 yy">
                        <input type="text" name="amount" id="amount" class="form-control" value="<?= $amount ?>">
                        <?php $amount_error ? print("<P class='col-6 alert alert-danger m-1'>$amount_error</p>") : "" ?>
                    </div>

                </div>
                <div class="form-group row xx">
                    <label for="rate" class="col-sm-2 col-form-label">Interest Rate (%)</label>
                    <div class="col-sm-5 yy">
                        <input type="text" name="rate" id="rate" class="form-control" value="<?= $rate ?>">
                        <?php $rate_error ? print("<P class='col-6 alert alert-danger m-1'>$rate_error</p>") : "" ?>

                    </div>
                </div>
                <div class="form-group row xx">
                    <label for="deposit" class="col-sm-2 col-form-label">Month of deposit</label>
                    <div class="col-sm-5">
                        <select name="deposit" class="form-control">
                            <option value="1" <?= $monthOfPayment == '1' ? ' selected="selected"' : ''; ?>>1</option>
                            <option value="2" <?= $monthOfPayment == '2' ? ' selected="selected"' : ''; ?>>2</option>
                            <option value="3" <?= $monthOfPayment == '3' ? ' selected="selected"' : ''; ?>>3</option>
                            <option value="4" <?= $monthOfPayment == '4' ? ' selected="selected"' : ''; ?>>4</option>
                            <option value="5" <?= $monthOfPayment == '5' ? ' selected="selected"' : ''; ?>>5</option>
                            <option value="6" <?= $monthOfPayment == '6' ? ' selected="selected"' : ''; ?>>6</option>
                            <option value="7" <?= $monthOfPayment == '7' ? ' selected="selected"' : ''; ?>>7</option>
                            <option value="8" <?= $monthOfPayment == '8' ? ' selected="selected"' : ''; ?>>8</option>
                            <option value="9" <?= $monthOfPayment == '9' ? ' selected="selected"' : ''; ?>>9</option>
                            <option value="10" <?= $monthOfPayment == '10' ? ' selected="selected"' : ''; ?>>10</option>
                            <option value="11" <?= $monthOfPayment == '11' ? ' selected="selected"' : ''; ?>>11</option>
                            <option value="12" <?= $monthOfPayment == '12' ? ' selected="selected"' : ''; ?>>12</option>
                            <option value="13" <?= $monthOfPayment == '13' ? ' selected="selected"' : ''; ?>>13</option>
                            <option value="14" <?= $monthOfPayment == '14' ? ' selected="selected"' : ''; ?>>14</option>
                            <option value="15" <?= $monthOfPayment == '15' ? ' selected="selected"' : ''; ?>>15</option>
                            <option value="16" <?= $monthOfPayment == '16' ? ' selected="selected"' : ''; ?>>16</option>
                            <option value="17" <?= $monthOfPayment == '17' ? ' selected="selected"' : ''; ?>>17</option>
                            <option value="18" <?= $monthOfPayment == '18' ? ' selected="selected"' : ''; ?>>18</option>
                            <option value="19" <?= $monthOfPayment == '19' ? ' selected="selected"' : ''; ?>>19</option>
                            <option value="20" <?= $monthOfPayment == '20' ? ' selected="selected"' : ''; ?>>20</option>
                        </select>
                    </div>
                </div>
                <hr />
                <div class="form-group row xx">
                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-5 yy">
                        <input type="text" name="name" id="name" class="form-control" value="<?= $name ?>">
                        <?php $name_error ? print("<P class='col-6 alert alert-danger m-1'>$name_error</p>") : "" ?>
                    </div>
                </div>
                <div class="form-group row xx">
                    <label for="code" class="col-sm-2 col-form-label">Postal Code</label>
                    <div class="col-sm-5 yy">
                        <input type="text" name="code" id="code" class="form-control" value="<?= $postal ?>">
                        <?php $postal_error ? print("<P class='col-6 alert alert-danger m-1'>$postal_error</p>") : "" ?>
                    </div>
                </div>
                <div class="form-group row xx">
                    <label for="number" class="col-sm-2 col-form-label">Phone Number</label>
                    <div class="col-sm-5 yy">
                        <input type="text" name="number" id="number" class="form-control" value="<?= $phone ?>">
                        <?php $phone_error ? print("<P class='col-6 alert alert-danger m-1'>$phone_error</p>") : "" ?>
                    </div>
                </div>
                <div class="form-group row xx">
                    <label for="mail" class="col-sm-2 col-form-label">Email Address</label>
                    <div class="col-sm-5 yy">
                        <input type="text" name="mail" id="mail" class="form-control" value="<?= $email ?>">
                        <?php $email_error ? print("<P class='col-6 alert alert-danger m-1'>$email_error</p>") : "" ?>
                    </div>
                </div>
                <div class="form-group row xx">
                    <p class="col-md-2"><strong>Prefereed Contact Method: </strong> </p>
                    <div class="col-md-5 form-check">
                        <label class="form-check-label col-3"> <input class="m-1" type="radio" name="contact" value="phone" <?php if (isset($_SESSION['contact']) && $_SESSION['contact'] == "phone") echo ("checked = checked") ?>>Phone</label>
                        <label class="form-check-label col-3"><input class="m-1" type="radio" name="contact" value="email" <?php if (isset($_SESSION['contact']) && $_SESSION['contact'] == "email") echo ("checked = checked") ?>>Email</label>

                    </div>
                    <?php $contact_error ? print("<P class='col-6 alert alert-danger'>$contact_error</p>") : "" ?>
                    <?php $new_error ? print("<P class='col-6 alert alert-danger'>$new_error</p>") : "" ?>
                </div>
                <hr />
                <div class="form-group row xx">
                    <p class="col-md-4"><strong>If Phone is selected when we can contaact you? (use all the possibilities)</strong></p>
                    <div class="col-3">
                        <label class="checkbox-inline"> <input type="checkbox" class="checkbox-inline m-1" name="time[]" value="morning" <?php if (isset($_SESSION['morning'])) echo ("checked = checked") ?> />Morning</label>
                        <label class="checkbox-inline"><input type="checkbox" class="checkbox-inline m-1" name="time[]" value="afternoon" <?php if (isset($_SESSION['afternoon'])) echo ("checked = checked") ?> />Afternoon</label>
                        <label class="checkbox-inline"><input type="checkbox" class="checkbox-inline m-1" name="time[]" value="evening" <?php if (isset($_SESSION['evening'])) echo ("checked = checked") ?> />Evening</label>
                    </div>
                </div>
                <div class="form-group row xx">
                    <input type="submit" value="Calculate" name="submit" class="btn btn-primary m-1" />
                    <input type="submit" value="Clear" name="clear" class="btn btn-primary m-1" />
                </div>
            </form>
            <!-- <span>Designed by: hrkdesigner.github.io</span> -->
        </div>
    <?php elseif ($error == false) : ?>
        <div class="container">
            <h1 class="m-4">Thank you <?php (!$name ? print("Dear user") : print($name)) ?>, for using our deposit calculator!</h1>
            <?php

            if ($_POST['contact'] == "phone") {
                if (count($dayTime) == 2) {
                    print(" <p><strong>Our Customer service will call you tomorrow " . $dayTime[0] . " or " . $dayTime[1] . " at " . $phone . "</strong></p>");
                } else {
                    if (count($dayTime) == 3) {
                        print("<p><strong>Our Customer service will call you tomorrow " . $dayTime[0] . " , " . $dayTime[1] . " or " . $dayTime[2] . " at " . $phone . "</strong></p>");
                    } else {
                        print("<p><strong>Our Customer service will call you tomorrow " . $dayTime[0] . "  at " . $phone . "</strong></p>");
                    }
                }
            }
            if ($_POST['contact'] == "email") {
                print("<p><strong>Our Customer service will email you soon at" . $email . "</strong></p>");
            }
            print("<p><strong>The following is the result of your calculation</strong></p>");


            echo "<table class='table table-striped table-condensed table-bordered' border =\"1\" style='border-collapse: collapse'>";
            echo "<tr><th>Year</th><th>Princial at Year Start</th><th>Interest for the Year</th>
                    </tr> \n";
            for ($x = 1; $x <= $monthOfPayment; $x++) {
                $calculation =  $rate / 10;
                $term = 1 / $monthOfPayment;
                $total = $amount * $term * $calculation;
                echo "<tr> \n";
                for ($col = 1; $col <= 3; $col++) {
                    if ($col == 1) echo "<td>$x</td> \n";
                    elseif ($col == 2) echo "<td>" . round(($amount), 2) . "</td> \n";
                    else echo "<td>" . round($total, 2) . "</td> \n";
                }
                $amount += $total;
                echo "</tr>";
            }
            echo "</table>";
            echo ("<a href='DepositCalculator.php'>Back</a>");


            ?>

        </div>
    <?php endif; ?>
</body>

</html>