//function signinCallback(authResult) {
//
//	if (authResult['access_token']) {
//		// Autorizado correctamente
//		// Oculta el botón de inicio de sesión ahora que el usuario está autorizado, por ejemplo:
//		document.getElementById('signinButton').setAttribute('style', 'display: none');
//	} else if (authResult['error']) {
//		// Se ha producido un error.
//		// Posibles códigos de error:
//		//   "access_denied": el usuario ha denegado el acceso a la aplicación.
//		//   "immediate_failed": no se ha podido dar acceso al usuario de forma automática.
//		// console.log('There was an error: ' + authResult['error']);
//	}
//
//}

var at;

function signinCallback(authResult) {

	if (authResult['access_token']) {
		at = authResult['access_token'];
//		alert(String(at));
//		alert(authResult['access_token']);
		document.getElementById('signinButton').setAttribute('style', 'display:none');
		if (at != '') {
			$('#UserLogAt_google').val(at);
//			$('#gplusform').submit();

		} else {
			console.log("¡Algo ha ocurrido!, por favor recarge la pagina");
		}
	} else if (authResult['error']) {

		console.log('There was an error: ' + authResult['error']);
	}

}



/**Funcion para recuperar el email Google+ **/

function loginFinishedCallback(authResult) {
	if (authResult) {
		if (authResult['error'] == undefined) {
			gapi.auth.setToken(authResult); // Almacena el token recuperado.
			toggleElement('signin-button'); // Oculta el inicio de sesión si se ha accedido correctamente.
			getEmail();					 // Activa la solicitud para obtener la dirección de correo electrónico.
		} else {
			console.log('An error occurred');
		}
	} else {
		console.log('Empty authResult');  // Se ha producido algún error
	}
}

function getEmailCallback(obj) {
	var el = document.getElementById('email');
	var email = '';

	if (obj['email']) {
		email = 'Email: ' + obj['email'];
	}

	//console.log(obj);   // Sin comentario para inspeccionar el objeto completo.

	el.innerHTML = email;
	toggleElement('email');
}

function toggleElement(id) {
	var el = document.getElementById(id);
	if (el.getAttribute('class') == 'hide') {
		el.setAttribute('class', 'show');
	} else {
		el.setAttribute('class', 'hide');
	}
}

/**FIn de la funcion**/