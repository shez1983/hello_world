<?php

	 include_once('dbconn.php');
	 include_once('functions.php');
    
    $username = secure($_POST['username']);
	 $password = secure($_POST['password']);
		
	 $stmt = $db->prepare("
		  SELECT * 
		  FROM users
		  WHERE username = :username
		  AND password = :password
	 ");
		
	 $stmt->execute(
		array(
		  ':username' => $username, 
		  ':password' => sha1($password)
		  )
	 );
	 $row = $stmt->fetch(PDO::FETCH_ASSOC);
		
	 if (!$row) {
		  $return['error'] = "Invalid login!";	
	 } else {
		  if ( $row['authorised'] == 0 ){
				$return['error'] = "Not Authorised! Please ask your teacher to authorise you";
		  } elseif ($row['disabled'] == 1  ) {
				$return['error'] = "Account disabled! Please ask your teacher to enable your account";
		  } else {
				$_SESSION['user_id'] = $row['user_id'];
				$return['message'] = "TRUE";
		  }
	 }
	
    echo json_encode($return);
?>