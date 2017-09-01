<?php session_start(); ?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" type="text/css" href="style.css"
</head>

<body>

<p><a href="index.php">Go back and create a user</a></p>

<?php
if (filter_input(INPUT_POST, 'submit')){
	
	$un = filter_input(INPUT_POST, 'un')
		or die('Missing/illegal un parameter');
	$pw = filter_input(INPUT_POST, 'pw')
		or die('Missing/illegal pw parameter');
	// $pwhash = hent fra db;
	require_once('db_con.php');
	$sql = 'SELECT id, password FROM userid WHERE username=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('s', $un);
	$stmt->execute();
	$stmt->bind_result($uid, $pwhash);
	
	while($stmt->fetch()) {  }
	
	
	if (password_verify($pw, $pwhash)){
		echo 'Logged in as '.$un;
		$_SESSION['uid'] = $uid;
		$_SESSION['username'] = $un;
	}
	else {
		echo 'Forkert kombination af brugernavn/kodeord';
	}
}
?>

<p>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	<fieldset>
    	<legend>Login</legend>
    	<input name="un" type="text"     placeholder="Brugernavn" required /><br>
    	<input name="pw" type="password" placeholder="Kodeord"   required /><br>
    	<input name="submit" type="submit" value="Log ind" />
	</fieldset>
</form>
</p>

<hr>

<?php
	if(empty($_SESSION['uid'])) {
		echo 'Du skal være logget ind for at se indholdet';
	}
	else {
		echo 'Hej '.$_SESSION['username'].'<br>';
		echo 'Du er nu logget ind';
		echo '<form class="logud" id=login action="logout.php"><p>Husk at logge ud</p><button class="logud-button">Log ud</button> </form>';
	}
?>

</body>
</html>