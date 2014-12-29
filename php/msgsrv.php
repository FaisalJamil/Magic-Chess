<?php 
/**
This file acts as a long polling server, it 
responds only when it has some new activity.
It informs the clients as soon as a new 
change is detected. 

 */
	$memcache = new Memcache;
	//Connect to Memcached.
	$memcache->connect('localhost') or die ("Could not connect to Memcached server!");

	$last = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
	$cachedValue = $memcache->get('newItem'); 
	$current = $cachedValue[0];

	while( $current <= $last) {
		usleep(100000);
		$cachedValue = $memcache->get('newItem');
		$current = $cachedValue[0];
	}
	
	$response = array();
	$response['msg'] = $cachedValue[1];
	$response['timestamp'] = $current;
	echo json_encode($response);	
?>