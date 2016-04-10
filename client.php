<?php
	error_reporting(E_ALL);
	echo "<h2>TCP/IP Connection</h2>\n";

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

	$in = "HEAD / HTTP/1.1\r\n";
	$in .= "Host: www.example.com\r\n";
	$in .= "Connection: Close\r\n\r\n";
	$out = "";

	echo "Sending HTTP Head Request...";
	socket_write($socket, $in, strlen($in));
	echo "Ok.\n";

	echo "Reading response:\n\n";
	while($out = socket_read($socket, 2048)){
		echo $out;
	}

	echo "Closing socket....";
	socket_close($socket);
	echo "Ok.\n\n";
?>
