<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <title>Klinik Ajwa</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
        <?php
        // call file to connect to server
        include("header.php");
        ?>

        <?php
        // This query inserts a record in the clinic table
        // Has the form been submitted?
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $error = array(); // initialize an error array

            // Check for a Firstname
            if (empty($_POST['FirstName'])) {
                $error[] = 'You forgot to enter your first name.';
            } else {
                $n = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
            }

            // Check for a Lastname
            if (empty($_POST['LastName'])) {
                $error[] = 'You forgot to enter your last name.';
            } else {
                $l = mysqli_real_escape_string($connect, trim($_POST['LastName']));
            }

            // Check for specialization
            if (empty($_POST['Specialization'])) {
                $error[] = 'You forgot to enter your specialization.';
            } else {
                $s = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
            }

            // Check for a password
            if (empty($_POST['Password'])) {
                $error[] = 'You forgot to enter your password.';
            } elseif (strlen($_POST['Password']) < 6) {
                $error[] = 'Password should be at least 6 characters long.';
            } else {
                $p = mysqli_real_escape_string($connect, trim($_POST['Password']));
            }

            // If no errors, register the user in the database
            if (empty($error)) {
                // Prepare the query
                $q = "INSERT INTO doktor1 (FirstName, LastName, Specialization, Password) VALUES ('$n', '$l', '$s', '$p')";
                $result = @mysqli_query($connect, $q); // Run the query
                
                if ($result) { // If it runs successfully
                    echo '<h1>Thank you! Doctor has been registered successfully.</h1>';
                    exit();
                } else {
                    // Display system error
                    echo '<h1>System error</h1>';
                    // Debugging message
                    echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
                }
                mysqli_close($connect); // Close the database connection
                exit();
            } else {
                // Display form validation errors
                echo '<h1>Error!</h1><p class="error">The following error(s) occurred:<br />';
                foreach ($error as $msg) {
                    echo " - $msg<br />";
                }
                echo '</p><p>Please try again.</p>';
            }
        }
        ?>

        <h2>Register Doctor</h2>
        <h4>* Required field</h4>
        <form action="registerDoktor1.php" method="post">
            <p>
                <label class="label" for="FirstName">First Name: *</label>
                <input id="FirstName" type="text" name="FirstName" size="30" maxlength="150" value="<?php if (isset($_POST['FirstName'])) echo $_POST['FirstName']; ?>" />
            </p>

            <p>
                <label class="label" for="LastName">Last Name: *</label>
                <input id="LastName" type="text" name="LastName" size="30" maxlength="60" value="<?php if (isset($_POST['LastName'])) echo $_POST['LastName']; ?>" />
            </p>

            <p>
                <label class="label" for="Specialization">Specialization: *</label>
                <input id="Specialization" type="text" name="Specialization" size="30" maxlength="60" value="<?php if (isset($_POST['Specialization'])) echo $_POST['Specialization']; ?>" />
            </p>

            <p>
                <label class="label" for="Password">Password: *</label>
                <input id="Password" type="password" name="Password" size="30" maxlength="12" value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" />
            </p>

            <p>
                <input id="submit" type="submit" name="submit" value="Register" />
                <input id="reset" type="reset" name="reset" value="Clear All" />
            </p>
        </form>

        <p><br /><br /><br /></p>
    </body>
</html>
