<<?php include 'user/inc/uheader.php'; ?>
<center>
 <h1>Applicant Message Platform</h1>

 <h3>
   <?php include 'user/inc/ufooter.php'; ?>
 <?php
 require_once "connection.php";
 session_start();

 if(!isset($_SESSION['user_login'])) //check unauthorize user not direct access in "user_home.php" page
 {
  header("location: index.php");
 }

 if(isset($_SESSION['admin_login'])) //check admin login user not access in "user_home.php" page
 {
  header("location: admin/admin_home.php");
 }

 if(isset($_SESSION['employee_login'])) //check employee login user not access in "employee_home.php" page
 {
  header("location: employee/employee_home.php");
 }

 if(isset($_SESSION['user_login']))
 {
 ?>
  Welcome,
 <?php
  echo $_SESSION['user_login'];
  //We list his messages in a table
//Two queries are executes, one for the unread messages and another for read messages
$sql1 = 'SELECT `Title`, `Sender`, `Recipient`, `Message`, `Timestamp`, `Id`, `RecipientRead` FROM `Messages` WHERE Recipient = :CurrentUser AND RecipientRead=0';
$req1 = $db->prepare($sql1);
$req1->bindParam(':CurrentUser', $_SESSION['user_login']);
$req1->execute();
$sql2 = 'SELECT `Title`, `Sender`, `Recipient`, `Message`, `Timestamp`, `Id`, `RecipientRead` FROM `Messages` WHERE Recipient = :CurrentUser AND RecipientRead=1';
$req2 = $db->prepare($sql2);
$req2->bindParam(':CurrentUser', $_SESSION['user_login']);
$req2->execute();
?>
<br />This is the list of your messages:<br />
<a href="new_message.php" class="link_new_pm">New PM</a><br />
<h3>Unread Messages(<?php echo intval($req1->rowCount()); ?>):</h3>
<table>
        <tr>
        <th class="title_cell">Title</th>
        <th>Participant</th>
        <th>Date of creation</th>
    </tr>
<?php
//We display the list of unread messages
while($dn1 = $req1->fetch(PDO::FETCH_OBJ))
{
  $sql3 = 'SELECT `id`, `email` FROM `masterlogin` WHERE email = :uemail';
  $req3 = $db->prepare($sql3);
  $req3->bindParam(':uemail', $_SESSION['user_login']);
  $req3->execute();
  while($dn3 = $req3->fetch(PDO::FETCH_OBJ))
  {
    ?>
            <tr>
            <td class="left"><a href="read_message.php?id=<?php echo $dn1->Id; ?>"><?php echo htmlentities($dn1->Title, ENT_QUOTES, 'UTF-8'); ?></a></td>
            <td><a href="profile.php?id=<?php echo $dn3->id; ?>"><?php echo htmlentities($dn1->Sender, ENT_QUOTES, 'UTF-8'); ?></a></td>
            <td><?php echo $dn1->Timestamp; ?></td>
        </tr><?php
  }
?>
<?php
}
//If there is no unread message we notice it
if(intval($req1->rowCount())==0)
{
?>
        <tr>
        <td colspan="4" class="center">You have no unread message.</td>
    </tr>
<?php
}
?>
</table>
<br />
<h3>Read Messages(<?php echo intval($req2->rowCount()); ?>):</h3>
<table>
        <tr>
        <th class="title_cell">Title</th>
        <th>Participant</th>
        <th>Date or creation</th>
    </tr>
<?php
//We display the list of read messages
while($dn2 = $req2->fetch(PDO::FETCH_OBJ))
{
  $sql3 = 'SELECT `id`, `email` FROM `masterlogin` WHERE email = :uemail';
  $req3 = $db->prepare($sql3);
  $req3->bindParam(':uemail', $_SESSION['user_login']);
  $req3->execute();
  while($dn3 = $req3->fetch(PDO::FETCH_OBJ))
  {
?>
        <tr>
        <td class="left"><a href="read_message.php?id=<?php echo $dn2->Id; ?>"><?php echo htmlentities($dn2->Title, ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><a href="profile.php?id=<?php echo $dn3->id; ?>"><?php echo htmlentities($dn2->Sender, ENT_QUOTES, 'UTF-8'); ?></a></td>
        <td><?php echo $dn2->Timestamp; ?></td>
    </tr>
<?php
  }
}
//If there is no read message we notice it
if(intval($req2->rowCount())==0)
{
?>
        <tr>
        <td colspan="4" class="center">You have no read message.</td>
    </tr>
<?php
}
?>
</table>
<?php
}
else
{
        echo 'You must be logged to access this page.';
}
?>
 </h3>
  <a href="logout.php">Logout</a>
</center>
