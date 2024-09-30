<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>

    <body>

        <?php include ("header.php");?>

        <h2> Edit a record </h2>

        <?php
        //look for a valid user id, either through GET or POST
        if((isset ($_GET['id']))&& (is_numeric($_GET['id']))){
            $id = $_GET['id'];
        } elseif ((isset ($_POST['id']))&& (is_numeric($_POST['id']))){
            $id = $_POST['id'];
        }else{
            echo '<p class ="error">This page has been accessed in error.</p>';
            exit();

    
        }

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $error = array();

            //look for FirstNAme
            if(empty($_POST['FirstName'])){
                $error[] = 'You forgot to enter the First Name.';
            }else{
                $n = mysqli_real_escape_string($connect, trim($_POST['FirstName']));
            }
            //look for LastName
            if(empty($_POST['LastName'])){
                $error[] = 'You forgot to enter the Last Name.';
            }else{
                $l = mysqli_real_escape_string($connect, trim($_POST['LastName']));
            }
            //look for Specialization
            if(empty($_POST['Specialization'])){
                $error[] = 'You forgot to enter the Specialization.';
            }else{
                $s = mysqli_real_escape_string($connect, trim($_POST['Specialization']));
        }
        //look for Password
        if(empty($_POST['Password'])){
            $error[] = 'You forgot to enter the Password.';
        }else {
            $d= mysqli_real_escape_string($connect, trim($_POST['Password']));
        }

        //if no problem occured
        if(empty($error)) {

            $q = "SELECT ID FROM doktor1  WHERE Specialization = '$s' AND ID != $id";
            $result = @mysqli_query($connect, $q);

            if(mysqli_num_rows($result) == 0){
                $q = "UPDATE doktor1 SET FirstName='$n' , LastName = '$l', Specialization = '$s', Password ='$d' WHERE ID='$id' LIMIT 1";

                $result = @mysqli_query($connect, $q);  
                
                if(mysqli_affected_rows($connect) == 1){

                    echo ' <h3> The user has been edited</h3>';

                } else{
                    echo '<p class="error"> The user has not be edited due to the system error. We apologize for any convenience.</p>';
                    echo '<p>' .mysqli_error($connect). '<br/> query: '.$q. '</p>';
                }

            }else{
                echo '<p class="error"> The no ic has already been registered</p>';
            }
        }else{
            echo'<p class ="error"> The following error (s) occured: <br/>';
            foreach ($error as $msg)
            {
                echo " -$msg<br/> \n";
            }
            echo '</p><p>Please try again.</p>';
        }
    }

    $q = "SELECT FirstName, LastName, Specialization, Password FROM doktor1 WHERE ID=$id";
    $result = @mysqli_query($connect, $q);

    if(mysqli_num_rows($result) ==1){
        //get patient information
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        //create the form
        echo '<form action ="edit_doktor.php" method="post">
        <p><label class = "label" for ="FirstName" > First Name: </label>
        <input id = "FirstName" type ="text" name="FirstName" size="30" maxlength="30" value="'.$row[0].'"></p>

         <p><br><label class = "label" for ="LastName" > Last Name: </label>
        <input id = "LastName" type ="text" name="LastName" size="30" maxlength="30" value="'.$row[1].'"></p>

         <p><br><label class = "label" for ="Specialization" > Specialization: </label>
        <input id = "Specialization" type ="text" name="Specialization" size="30" maxlength="30" value="'.$row[2].'"></p>

         <p><br><label class = "label" for ="Password" > Password: </label>
        <input id = "Password" type ="text" name="Password" size="30" maxlength="30" value="'.$row[3].'"></p>

        <br><p><input id ="submit" type="submit" name="submit" value="Edit"></p>

         <br><input type="hidden"  name="id" value="'.$id.'"/>

         </form>';

    }else{
        echo '<p class="error"> This page has been acessed in error.</p>';
    }

    mysqli_close($connect);

    ?>
    </body>
    </html>




   