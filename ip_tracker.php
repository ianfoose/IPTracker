#!/usr/bin/env php
<?php

date_default_timezone_set("America/New_York");

$currentIPFile = dirname(__FILE__).'/current_ip.txt';
$currentIP = file_get_contents($currentIPFile);
$rawIP = file_get_contents('http://ip6.me');
$ipLogFile = dirname(__FILE__).'/ip_log.txt';

if(!empty($rawIP)) {
	// Trim IP based on HTML formatting
	$pos = strpos($rawIP, '+3') + 3;
	$ip = substr($rawIP, $pos, strlen($rawIP));

	$pos = strpos($ip, '</');
	$ip = substr($ip, 0, $pos);

	if(!(empty($currentIP))) {
		if($currentIP != $ip) { // new ip
			sendEmail($ip);
		}
	} else { // empty new file
		sendEmail($ip);
	}

	file_put_contents(dirname(__FILE__).'/ip_log.txt', "$ip ".date('Y-m-d H:i:s')."\n", FILE_APPEND);
}

function sendEmail($ip) {
	file_put_contents(dirname(__FILE__).'/current_ip.txt', "$ip");

	$email = ''; # SET
	$password = ''; # SET

	require_once('swift_mailer/swift_required.php');

	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl') # check for SMTP
	->setUsername($email) 
	->setPassword($password); 

	$mailer = Swift_Mailer::newInstance($transport);

	$message = Swift_Message::newInstance('Log')
	->setFrom(array('network@fooseindustries.com' => 'Foose Industries'))
	->setTo(array($email))
	->setBody('Your new IP is '.$ip);

	$result = $mailer->send($message);
}
?>