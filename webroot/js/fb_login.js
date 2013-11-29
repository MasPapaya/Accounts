/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var at;

function connect() {
	FB.init({
//		appId: '636317959715475', // App ID from the app dashboard
		appId: appId, // App ID from the app dashboard
//		channelUrl: '//voulet.com/channel.html', // Channel file for x-domain comms
		channelUrl: channelUrl, // Channel file for x-domain comms
		status: true, // Check Facebook Login status
		xfbml: true  // Look for social plugins on the page
	});

	FB.login(function(response) {
		if (response.authResponse) {
			if (response.status == "connected") {
				at = response.authResponse.accessToken;
				if (at != '') {
					$('#UserLogAt').val(at);
					$('#fbform').submit();
				} else {
					console.log("Algo ha ocurrido, por favor vuelve a cargar la pagina");
				}
			} else {
				console.log('Error al logearse.');
			}
		} else {
			console.log('Error de respuesta del servidor de Facebook.');
		}
	}, {
		scope: 'email,user_birthday'
	});

}
$(document).ready(function() {
	$("#fb_login").click(function() {
		connect();
	});

});
