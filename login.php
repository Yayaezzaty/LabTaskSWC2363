<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Klinik Ajwa</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>

        <?php
        // Call file to connect to the Klinik Ajwa server
        include ("header.php");
        ?>

        <?php
        // This section processes submissions from the login form
        // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Validate the ID
            if (!empty($_POST['ID'])) {
                $un = mysqli_real_escape_string($connect, $_POST['ID']);
            } else {
                $un = FALSE;
                echo '<p class="error">You forgot to enter your ID.</p>';
            }

            // Validate the password
            if (!empty($_POST['Password'])) {
                $p = mysqli_real_escape_string($connect, $_POST['Password']);
            } else {
                $p = FALSE;
                echo '<p class="error">You forgot to enter your password.</p>';
            }

            // If no problem occurred
            if ($un && $p) {
                // Retrieve the ID, FirstName, LastName, Specialization, and Password for the username and password combination
                $q = "SELECT ID, FirstName, LastName, Specialization, Password FROM Doktor1 WHERE (ID = '$un' AND Password = '$p')";

                // Run the query and assign it to the variable $result
                $result = mysqli_query($connect, $q);

                // Count the number of rows that match the username/password combination
                if (mysqli_num_rows($result) == 1) {
                    // Start the session, fetch the record and insert the values in the session
                    session_start();
                    $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    echo '<p>Login successful! Welcome ' . $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'] . '.</p>';

                    // Free the result set and close the connection
                    mysqli_free_result($result);
                    mysqli_close($connect);

                    // Cancel the rest of the script
                    exit();

                } else {
                    echo '<p class="error">The username and password entered do not match our records. Please try again or register if you don\'t have an account.</p>';
                }

            } else {
                // If there was a problem with the form submission
                echo '<p class="error">Please try again.</p>';
            }

            mysqli_close($connect);
        } // End of form submission
        ?>

        <h2 align="center">LOGIN</h2>

        <form action="login.php" method="post">
            <p><label class="label" for="ID">ID:</label>
            <input id="ID" type="text" name="ID" size="4" maxlength="6" value="<?php if (isset($_POST['ID'])) echo $_POST['ID']; ?>" /></p>

            <p><label class="label" for="Password">Password:</label>
            <input id="Password" type="password" name="Password" size="15" maxlength="60" value="<?php if (isset($_POST['Password'])) echo $_POST['Password']; ?>" /></p>

            <p><input id="submit" type="submit" name="submit" value="Login" /></p>
            <p><input id="reset" type="reset" name="reset" value="Reset" /></p>
        </form>

        <p align="center">Don't have an account? <a href="RegisterDoktor1.php">Sign up</a></p>

    </body>
</html>
