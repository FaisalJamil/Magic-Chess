<?php

/**
 * This file serves a buffer for long polling
 * server to listen on. All activities are temporarily
 * stored here until the next message arrives
 * 
 */ 

if(isset($_GET['table']))
	$msg = $_GET['table'];
if(isset($_GET['player']))
	$msg = $_GET['player'];

if(isset($_REQUEST['func_name']) && isset($_REQUEST['evt']))
{
	$from =null;
	if(isset($_REQUEST['from']) && isset($_REQUEST['attacker'])){
		$from = array($_REQUEST['from'],$_REQUEST['attacker']);
	}
	$msg = json_encode(array('func_name'=>$_REQUEST['func_name'], 'obj'=>$_REQUEST['evt'], $from));
}
$memcache = new Memcache;

//Connect to Memcached.
$memcache->connect('localhost') or die ("Could not connect to Memcached server!");

if(isset($_REQUEST['flush'])){
	$memcache->flush();
	echo "memcache flushed";
}
else{
	$currentTime = time();
	$data = array($currentTime, $msg);
	$secondsToCache = 10;
	$memcache->set('newItem', $data, MEMCACHE_COMPRESSED, $secondsToCache);
} 
	