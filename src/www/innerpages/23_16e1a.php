<?php
	require_once("../genclude.php");

	if(preg_match('/\/pages\/23.php$/', $_SERVER["HTTP_REFERER"])){
		recordVisit($testcase);
	}else{
	    echo 'you came from the wrong place';
	}
?>


