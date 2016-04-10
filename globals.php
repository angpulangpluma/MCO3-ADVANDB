<?php
	/*
	* globals.php
	* @author MLDL
	* This file contains global constants.
	*/

	//change this value to obstain your constants
	$mem = 4;

	//define constants here
	switch($mem){
		case 1: {

		}; break; //darren
		case 2: {

		}; break; //ramon
		case 3: {

		}; break; //edward
		case 4:{
			define("DBPALAWAN", "palawan_info");
			define("DBMARINDU", "marinduque_info");
			define("DBUSER", "root");
			define("DBPASS", "admin");
		}; break; //marienne
	}
?>