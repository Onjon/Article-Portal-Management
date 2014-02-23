<?php
session_start();
if( !isset( $_SESSION[ 'access' ] ) ) {
    die();
}
?>
<?php
if( $_SESSION[ 'access' ] == "admin" ) {
?>
<ul id="nav">
    <li class="i_house"><a href="index.php"><span>Dashboard</span></a></li>
    <li><a href="adduser.php"><span>Create User</span></a></li>
    <li><a href="updateuser.php"><span>Update User</span></a></li>
    <li><a href="showarticle.php"><span>Show All Article</span></a></li>
    <li><a href="payment.php"><span>Payment</span></a></li>
    <li><a href="change.php"><span>Change Password</span></a></li>
    <li class="i_admin_user"><a href="logout.php"><span>Logout</span></a></li>
</ul>
<?php
}
else {
?>
<ul id="nav">
    <li class="i_house"><a href="userhome.php"><span>Dashboard</span></a></li>
    <li><a href="create.php"><span>Create Article</span></a></li>
    <li><a href="show.php"><span>Show Article</span></a></li>
    <li><a href="income.php"><span>Payment</span></a></li>
    <li><a href="showcity.php"><span>Show City</span></a></li>
    <li><a href="changepass.php"><span>Change Password</span></a></li>
    <li class="i_admin_user"><a href="logout.php"><span>Logout</span></a></li>
</ul>
<?php
}
?>