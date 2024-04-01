<?php
include 'php/config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_GET['logout'])) {
   // Update user status to "Offline Now"
   $update_query = mysqli_query($conn, "UPDATE `user_form` SET status = 'Offline Now' WHERE id = '$user_id'");
   
   // Unset user_id and destroy session
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

$select = mysqli_query($conn, "SELECT email FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
if (mysqli_num_rows($select) > 0) {
   $fetch = mysqli_fetch_assoc($select);
   if ($fetch['email'] == "admin@gmail.com") {
      header('location:admin_interface.php');
   }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>


   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <div class="container">

      <div class="profile">
         <?php
         $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
         if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
         }
         if ($fetch['image'] == '') {
            echo '<img src="images/default-avatar.png">';
         } else {
            echo '<img src="uploaded_img/' . $fetch['image'] . '">';
         }
         ?>
         <h3><?php echo $fetch['firstname'] . " " . $fetch['middlename'] . " " . $fetch['lastname']; ?></h3>
         <h5><?php echo "Age: " . $fetch['age']; ?></h5>
         <a href="update_profile.php" class="btn">update profile</a>
         <a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">logout</a>

      </div>

   </div>

</body>

</html>
