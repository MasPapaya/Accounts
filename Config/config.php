<?php

$config = array(
	'Accounts' => array(
		'facebook' => array(
//			'appId' => '209300562598963', app
			'appId' => '570401413051500',
//			'secret' => '3324210a5e0bcb2aac02e7b0bcf038ca',app
			'secret' => '47f1a1ce5a4b740d2e58363b533627e1',
//			'channelUrl' => 'http://schicklatinoamerica.com/AllAccessFest/channel.html'
			'channelUrl' => 'http://local.maspapaya.net/channel.html'
		),
		'google' => array(
			'setClientId' => '636754727800.apps.googleusercontent.com',
			'setClientSecret' => '0zMlRx0IQ7l0xh0p71hPU38G',
			'RedirectUri' => 'http://local.maspapaya.net/accounts/users/login_gplus',
			'DeveloperKey' => 'AIzaSyAt1iMyZJxALkdL-dT7f-oWcslgoi4VzQI'
		),
		'twitter' => array(
			'CONSUMER_KEY' => 'UaZC7F6SfzuBzE6h8O1O4A',
			'CONSUMER_SECRET' => 'tAQbi5pHQGjH997YNxlNFHHgjFfI9ZBoWMSMYa0fWqw',
//			'OAUTH_CALLBACK' => 'http://schicklatinoamerica.com/AllAccessFest/schick/SchickUsers/login_twitter',
			'OAUTH_CALLBACK' => 'http://local.maspapaya.net/schick/SchickUsers/login_twitter',
		),
		'recaptcha' => array(
			'Publickey' => '6LdV6OUSAAAAAORtUPATJ1sn1Y28oR8v3Dllsf2B',
			'PrivateKey' => '6LdV6OUSAAAAAMpF5H01lb0r-wSPS9Eoq0EQCNEe'
		)
	)
);