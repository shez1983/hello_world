<?php
    //echo "1";
	if ( isset( $_SESSION['user_id'] ) ){
        //echo "2";
		$return['message'] =  "TRUE";
	} else {
        //echo "3";
		$return['message'] =  "FALSE";
	}
    //echo "4";
    
    echo json_encode($return);
?>