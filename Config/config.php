<?php

$config = array(
	'Accounts' => array(
		'facebook' => array(
			'appId' => '670029796360306',
			'secret' => '422a2bb883dbcf1310eb2c801ff347a5',
			'channelUrl' => '//local.maspapaya.net/channel.html'
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
			'OAUTH_CALLBACK' => 'http://local.maspapaya.net/accounts/users/login_twitter',
		),
		'recaptcha' => array(
			'Publickey' => '6LdV6OUSAAAAAORtUPATJ1sn1Y28oR8v3Dllsf2B',
			'PrivateKey' => '6LdV6OUSAAAAAMpF5H01lb0r-wSPS9Eoq0EQCNEe'
		)
	)
);