tinyMCEPopup.requireLangPack();

var jbImagesDialog = {
	
	resized : false,
	iframeOpened : false,
	timeoutStore : false,
	
	init : function() {
//		document.getElementById("upload_target").src += '/' + tinyMCEPopup.getLang('jbimages_dlg.lang_id', 'english');
			tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<br />');
	},
	
	inProgress : function() {
		document.getElementById("upload_infobar").style.display = 'none';
		document.getElementById("upload_additional_info").innerHTML = '';
		document.getElementById("upload_form_container").style.display = 'none';
		document.getElementById("upload_in_progress").style.display = 'block';
		this.timeoutStore = window.setTimeout(function(){
			document.getElementById("upload_additional_info").innerHTML = tinyMCEPopup.getLang('jbimages_dlg.longer_than_usual', 0) + '<br />' + tinyMCEPopup.getLang('jbimages_dlg.maybe_an_error', 0) + '<br /><a href="#" onClick="jbImagesDialog.showIframe()">' + tinyMCEPopup.getLang('jbimages_dlg.view_output', 0) + '</a>';
		}, 20000);
	},
	
	showIframe : function() {
		if (this.iframeOpened == false)
		{
			document.getElementById("upload_target").className = 'upload_target_visible';
			tinyMCEPopup.editor.windowManager.resizeBy(0, 150, tinyMCEPopup.id);
			this.iframeOpened = true;
		}
	},
	
	uploadFinish : function(result) {
		
//					document.getElementById("upload_infobar").innerHTML = tinyMCEPopup.getLang('jbimages_dlg.upload_complete', 0);
					tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<img src="' + result.filename +'" alt="image text" />');
					tinyMCEPopup.close();
					//this.showIframe(); //Disable close and enable this for DEBUG
		
	}

};

tinyMCEPopup.onInit.add(jbImagesDialog.init, jbImagesDialog);
