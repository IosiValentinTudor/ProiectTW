<link rel="stylesheet" type="text/css" href="design2.css">
<?php
include('classes/DB.php');
include('classes/Login.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in');
}

if (isset($_GET['mid'])) {
        $message = DB::query('SELECT * FROM messages WHERE id=:mid AND (receiver=:receiver OR sender=:sender)', array(':mid'=>$_GET['mid'], ':receiver'=>$userid, ':sender'=>$userid))[0];
        echo '<h1>View Message</h1>';
        echo htmlspecialchars($message['body']);
        echo '<hr />';

        if ($message['sender'] == $userid) {
                $id = $message['receiver'];
        } else {
                $id = $message['sender'];
        }
        DB::query('UPDATE messages SET `read`=1 WHERE id=:mid', array (':mid'=>$_GET['mid']));
        ?>
        <form action="send-message.php?receiver=<?php echo $id; ?>" method="post">
                <textarea name="body" rows="8" cols="80"></textarea>
                <input type="submit" name="send" value="Send Message">
        </form>
        <a href="my-messages.php" class="button">My messages</a>
        <?php
} else {

?>
<h1>My Messages</h1>
<?php
$messages = DB::query('SELECT messages.*, users.username FROM messages, users WHERE receiver=:receiver AND users.id = messages.sender', array(':receiver'=>$userid));
foreach ($messages as $message) {

        if (strlen($message['body']) > 10) {
                $m = substr($message['body'], 0, 10)." ...";
        } else {
                $m = $message['body'];  
        }

        if ($message['read'] == 0) {
                echo "<a href='my-messages.php?mid=".$message['id']."'><strong>".$m."</strong></a> sent by ".$message['username'].'<hr />';
        } else {
                echo "<a href='my-messages.php?mid=".$message['id']."'>".$m."</a> sent by ".$message['username'].'<hr />';
        }

}
$messages = DB::query('SELECT messages.*, users.username FROM messages, users WHERE sender=:sender AND users.id = messages.sender', array(':sender'=>$userid));
foreach ($messages as $message) {

        if (strlen($message['body']) > 10) {
                $m = substr($message['body'], 0, 10)." ...";
        } else {
                $m = $message['body'];  
        }

        if ($message['read'] == 0) {
                echo "<a href='my-messages.php?mid=".$message['id']."'><strong>".$m."</strong></a> sent by you , ".$message['username'].'<hr />';
        } else {
                echo "<a href='my-messages.php?mid=".$message['id']."'>".$m."</a> sent by you , ".$message['username'].'<hr />';
        }

}

}
?>
<a href="send-message.php" class="button">Send a message to someone</a>
<br>
<a href="logout.php" class="button">Logout?</a>
