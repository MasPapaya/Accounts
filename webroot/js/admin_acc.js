$(document).ready(function(){
	$('.date').datepicker({
		dateFormat:'yy-mm-dd',
		dayNames:['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
		dayNamesMin:['Do','Lu','Mar','Mier','Jue','Vie','Sab'],
		firstDay:1,
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		//monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Agos','Sep','Oct','Nov','Dic'],
		monthNamesShort:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		nextText:'Siguiente',
		prevText:'Atras',
		closeText:'Aceptar',
		currentText:'Fecha Actual',

		changeMonth:true,
		changeYear:true,
		yearRange: 'c-50:c+10',
		yearSuffix:'<br />Selector de Fecha'	   
	});
		
	
//   
//	$('.lightbox').lightbox();
		
	!function ($) {
		$(function(){
		  // carousel demo
		  $('#myCarousel').carousel();
		});
	  }(window.jQuery);
	  init();
});

function init(){
//		tinyMCE.init({
//			theme : "advanced",
//			language : "es",
//			selector : "textarea.tinymce-editor",
//			skin : "o2k7",
//			skin_variant : "silver",
//			width : "100%",
//			height: '200px',
//			setup : function(ed) {
//					ed.onChange.add(function(ed, e) {
//							$(".tinymce-editor").text(tinyMCE.activeEditor.getContent()+'');
////							$("#DocumentContent").text(tinyMCE.activeEditor.getContent()+'');
////							$("#FragmentContent").text(tinyMCE.activeEditor.getContent()+'');
////							$("#DealerInformation").text(tinyMCE.activeEditor.getContent()+'');
//					});
//			},
//			theme_advanced_buttons1: "bold,italic,underline,strikethrough,bullist,numlist"		
//			
////			plugins:"jbimages",
////			relative_urls : false,
////			theme_advanced_buttons4 : "jbimages"
//	});
}