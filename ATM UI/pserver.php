<?php 
session_start();
?>
<?php 
$host="localhost"; // Host name
$username="root"; // Mysql username
$password=""; // Mysql password
$db_name="abc"; // Database name
$tbl_name="card"; // Table name


// Connect to server and select database.
$db=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect");
$errors=array();
$c=0;

if (isset($_POST['pbutton'])) {
  //data sanitization to prevent SQL injection
  $pname = mysqli_real_escape_string($db, $_POST['pname']);

  //error message if the input field is left blank
  if (empty($pname)) {
    
    array_push($errors, "PIN Required"); 

  }
  if (count($errors) == 0) {
  //checking for the errors
    $query = "SELECT * FROM $tbl_name WHERE pin='$pname' AND card_num='$_SESSION[fname]';";
    $results = mysqli_query($db, $query);

    // $results = 1 means that one user with the entered Card Number exists
    if (mysqli_num_rows($results) == 1 and $c<=3 ) {
      // Welcome message
      $_SESSION['success'] = "You have logged in!";
      header('location: options.html'); //page on which the user is sent to after logging in
    }
    else {
            if ($c<3){
                array_push($errors, "Incorrect PIN. Try Again."); 
                $c++;

                
            }
            else{
                array_push($errors, "Blocked"); 
            }
    }
  }
}
            
?>