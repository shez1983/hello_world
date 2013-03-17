<?php
	if ( isset( $_SESSION['user_id'] ) ){
		echo TRUE;
	} else { 
		echo FALSE;
	}
?>