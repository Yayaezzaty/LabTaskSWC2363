<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Delete a Record</title>
    </head>

    <body>

        <?php include("header.php"); ?>

        <h2>Delete a Record</h2>

        <?php
        // Check for a valid user ID, either through GET or POST
        if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
        } elseif ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
            $id = $_POST['id'];
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
            exit();
        }

        // Check if the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['sure'] == 'Yes') { // Delete the record
                // Make the query
                $q = "DELETE FROM pesakit1 WHERE ID_P=$id LIMIT 1";
                $result = @mysqli_query($connect, $q);

                if (mysqli_affected_rows($connect) == 1) { // If there was no problem
                    // Display a success message
                    echo '<h3>The record has been deleted.</h3>';
                } else {
                    // Display an error message
                    echo '<p class="error">The record could not be deleted. It may not exist or there was a system error.</p>';
                    echo '<p>' . mysqli_error($connect) . '<br />Query: ' . $q . '</p>';
                }
            } else {
                echo '<h3>The record has NOT been deleted.</h3>';
            }
        } else {
            // Retrieve the patient's data to confirm deletion
            $q = "SELECT FirstName_P FROM pesakit1 WHERE ID_P= $id";
            $result = @mysqli_query($connect, $q);

            if (mysqli_num_rows($result) == 1) {
                // Get the patient's name
                $row = mysqli_fetch_array($result, MYSQLI_NUM);
                echo "<h3>Are you sure you want to permanently delete $row[0]?</h3>";
                echo '<form action="delete_pesakit.php" method="post">
                        <input id="submit-yes" type="submit" name="sure" value="Yes">
                        <input id="submit-no" type="submit" name="sure" value="No">
                        <input type="hidden" name="id" value="' . $id . '">
                      </form>';
            } else {
                echo '<p class="error">This page has been accessed in error.</p>';
            }
        }

        mysqli_close($connect);
        ?>

    </body>
</html>
