<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Edit a Record</title>
    </head>

    <body>

        <?php include ("header.php"); ?>

        <h2>Edit a Record</h2>

        <?php
        // Look for a valid user ID, either through GET or POST
        if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
        } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
            $id = $_POST['id'];
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
            exit();
        }

        // If the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();

            // Validate FirstName
            if (empty($_POST['FirstName_P'])) {
                $errors[] = 'You forgot to enter the first name.';
            } else {
                $n = mysqli_real_escape_string($connect, trim($_POST['FirstName_P']));
            }

            // Validate LastName
            if (empty($_POST['LastName_P'])) {
                $errors[] = 'You forgot to enter the last name.';
            } else {
                $l = mysqli_real_escape_string($connect, trim($_POST['LastName_P']));
            }

            // Validate Insurance Number
            if (empty($_POST['InsuranceNumber'])) {
                $errors[] = 'You forgot to enter the insurance number.';
            } else {
                $in = mysqli_real_escape_string($connect, trim($_POST['InsuranceNumber']));
            }

            // Validate Diagnose
            if (empty($_POST['Diagnose'])) {
                $errors[] = 'You forgot to enter the diagnose.';
            } else {
                $d = mysqli_real_escape_string($connect, trim($_POST['Diagnose']));
            }

            // If no errors occurred
            if (empty($errors)) {
                // Check for duplicate insurance numbers
                $q = "SELECT ID_P FROM pesakit1 WHERE InsuranceNumber = '$in' AND ID_P != $id";
                $result = @mysqli_query($connect, $q);

                if (mysqli_num_rows($result) == 0) {
                    // Perform the update
                    $q = "UPDATE pesakit1 SET FirstName_P='$n', LastName_P='$l', InsuranceNumber='$in', Diagnose='$d' WHERE ID_P='$id' LIMIT 1";
                    $result = @mysqli_query($connect, $q);

                    if (mysqli_affected_rows($connect) == 1) {
                        // Record successfully updated
                        echo '<h3>The record has been edited successfully.</h3>';
                    } else {
                        // System error or no changes made
                        echo '<p class="error">The record could not be edited due to a system error, or no changes were made.</p>';
                        echo '<p>' . mysqli_error($connect) . '<br />Query: ' . $q . '</p>';
                    }
                } else {
                    // Insurance number already registered
                    echo '<p class="error">The insurance number has already been registered.</p>';
                }
            } else {
                // Display validation errors
                echo '<p class="error">The following errors occurred:<br />';
                foreach ($errors as $msg) {
                    echo " - $msg<br />\n";
                }
                echo '</p><p>Please try again.</p>';
            }
        }

        // Retrieve the patient's data
        $q = "SELECT FirstName_P, LastName_P, InsuranceNumber, Diagnose FROM pesakit1 WHERE ID_P=$id";
        $result = @mysqli_query($connect, $q);

        if (mysqli_num_rows($result) == 1) {
            // Fetch the patient's information
            $row = mysqli_fetch_array($result, MYSQLI_NUM);

            // Display the form with the current data
            echo '<form action="editPesakit.php" method="post">
            <p><label class="label" for="FirstName_P">First Name: </label>
            <input id="FirstName_P" type="text" name="FirstName_P" size="30" maxlength="30" value="' . $row[0] . '"></p>

            <p><label class="label" for="LastName_P">Last Name: </label>
            <input id="LastName_P" type="text" name="LastName_P" size="30" maxlength="30" value="' . $row[1] . '"></p>

            <p><label class="label" for="InsuranceNumber">Insurance Number: </label>
            <input id="InsuranceNumber" type="text" name="InsuranceNumber" size="30" maxlength="30" value="' . $row[2] . '"></p>

            <p><label class="label" for="Diagnose">Diagnose: </label>
            <input id="Diagnose" type="text" name="Diagnose" size="30" maxlength="30" value="' . $row[3] . '"></p>

            <p><input id="submit" type="submit" name="submit" value="Edit"></p>
            <input type="hidden" name="id" value="' . $id . '"/>
            </form>';
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
        }

        mysqli_close($connect);
        ?>

    </body>
</html>
