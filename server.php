<?php
	error_reporting(E_ALL);
	set_time_limit(0);
	ob_implicit_flush();

	$address = 'localhost';
	$port = 3939;
	if(($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP))==false){
		echo "socket_create() failed. reason: ".
			socket_strerror(socket_last_error())."\n";
	}

	if(!socket_set_option($sock, SOL_SOCKET, SO_REUSEADDR, 1)){
		echo socket_strerror(socket_last_error($sock));
		exit;
	}

	if(socket_bind($sock, $address, $port)===false){
		echo "socket_bind() failed. reason: ".
			socket_strerror(socket_last_error())."\n";
	}

	if(socket_listen($sock, 5)===false){
		echo "socket_listen() failed. reason: ".
			socket_strerror(socket_last_error())."\n";
	}

	do{
		if(($msgsock = socket_accept($sock))==false){
			echo "socket_accept() failed. reason: ".
			socket_strerror(socket_last_error())."\n";
			break;
		}
		//send instructions
		$msg = "\n welcome to the php test server. \n".
			"to quit, type 'quit'.".
			"to shut down the server type 'shutdown'.\n";
		socket_write($msgsock, $msg, strlen($msg));

		do{
			if(false===($buf=socket_read($msgsock, 2048, PHP_NORMAL_READ))){
				echo "socket_read() failed. reason: ".
			socket_strerror(socket_last_error())."\n";
				break 2;
			}
			if(!$buf = trim($buf))
				continue;
			if($buf=='quit')
				break;
			if($buf == 'shutdown'){
				socket_close($msgsock);
				break 2;
			}
			$talkback = "php: you said '$buf'.\n";
			socket_write($msgsock, $talkback, strlen($talkback));
			echo "$buf\n";
		} while(true);
		socket_close($msgsock);
	}while(true);

	socket_close($sock);


?>