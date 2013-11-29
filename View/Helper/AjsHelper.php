<?php

/* /app/View/Helper/ButtonHelper.php */
App::uses('AccountsAppHelper', 'View/Helper');

class AjsHelper extends AppHelper {

	public $helpers = array('Html', 'Session', 'Paginator', 'Js' => array('Jquery'), 'Form','Time');

	public function button($icon, $url, $class, $update) {
		return $this->Js->link('<i class="' . $icon . '"></i>', $url, array('escape' => FALSE, 'class' => 'btn ' . $class, 'update' => $update));
	}

	public function numbers() {
		$nums = $this->Paginator->prev('«', array('tag' => 'li'), null, array('class' => 'prev disabled ', 'tag' => 'li','disabledTag'=>'a'));
		$nums .= $this->Paginator->numbers(array('tag' => 'li', 'currentTag' => 'a', 'separator' => '', 'currentClass' => 'active'));
		$nums .= $this->Paginator->next('»', array('tag' => 'li'), null, array('class' => 'next disabled', 'tag' => 'li','disabledTag'=>'a'));
		return '<div class="pagination"><ul>' . $nums . '</ul></div>';
	}

	public function button_text($icon, $texto, $url, $class, $update) {
		return $this->Js->link('<i class="' . $icon . '"></i> ' . $texto, $url, array('escape' => FALSE, 'class' => 'btn ' . $class, 'update' => $update));
	}

	public function link($texto, $url, $class, $update) {
		return $this->Js->link($texto, $url, array('escape' => FALSE, 'class' => $class, 'update' => $update));
	}

	public function submit($texto, $url) {
		/// return $this->Js->submit($texto, $url,array('escape' => FALSE,'class' => $class,'update' =>  $update));
		return $this->Js->submit($texto, $url);
	}
		
	public function link_button($title, array $url, $update ,array $options_btn = null, $scrollto = false ) {
		if (empty($url)) {
			return false;
		}
		$id = rand(0, 9999999999);
				if($scrollto){
					$script = '
							$("#link_button_' . $id . '").bind("click",function(){				
									$.ajax({
											url:"' . $this->Html->url($url) . '",
											dataType:"html",
											//type:"POST",
											success:function (data, textStatus) {
													$("' . $update . '").html(data);													
													$("body").scrollTo($("' . $update . '").offset().top,500,{axis:"y"});
											}
									});
							});
					';
				}else{
					$script = '
							$("#link_button_' . $id . '").bind("click",function(){				
									$.ajax({
											url:"' . $this->Html->url($url) . '",
											dataType:"html",
											//type:"POST",
											success:function (data, textStatus) {
													$("' . $update . '").html(data);
											}
									});
							});
					';
				}
		$this->Js->buffer($script,true);
		return $this->Form->button($title, array_merge(array('id' => 'link_button_' . $id), $options_btn));
	}

	
	public function delete($title, array $url, array $options_bnt, array $options_js = null) {
		if (empty($url)) {
			return false;
		}
		$options_js_default = array(
			'update' => '#primary-ajax',
			'confirm' => __('Are you sure you want to delete the record.')
		);
		$options_js = array_merge($options_js_default, $options_js);
		$id = rand(0, 9999999999);
		$script = '
			$("#link-' . $id . '").bind("click",function(){				
				if(confirm("' . $options_js['confirm'] . '")){
						$.ajax({
							url:"' . $this->Html->url($url) . '",
							dataType:"html",
							type:"POST",
							success:function (data, textStatus) {
								$("' . $options_js['update'] . '").html(data);
							}
						});
					}
			});
		';

		$this->Js->buffer($script,true);
		return $this->Form->button($title, array_merge(array('id' => 'link-' . $id), $options_bnt));
	}

	public function jwplayer($title,$url_file)
	{
		//file: "http://content.bitsontherun.com/videos/lWMJeVvV-364767.mp4",
		$id_content_file = 'link_file_'.rand(0, 999999999999);
		$id_content_jwplayer = 'link_jwplayer_'.rand(0, 999999999999);
		$script = '
			 jwplayer("'.$id_content_file.'").setup({
				primary:"flash",
				src:"'.$this->webroot.'js/jwplayer/jwplayer.flash.swf",				
				file: "'.$url_file.'",
				width: 700,
				height: 400
				//image: "http://www.todo-sobre.com/mercedes-benz-slk/wallpapers/wallpapers-de-mercedes-benz-slk-1.jpg"				
			});		  
		';
		$this->Js->buffer($script,true);		
		$content_jwplayer = '<div id="'.$id_content_jwplayer.'" class="hide"><div id="'.$id_content_file.'">'.__('Loading the player',true).'...</div></div>';
		return $content_jwplayer.$this->Html->link($title,'lightbox[width]=705&lightbox[height]=400#'.$id_content_jwplayer, array('escape' => FALSE, 'class' => 'lightbox btn'));
	}
	
	public function jwplayer_front($url_file,$identificador = null)
	{
		//file: "http://content.bitsontherun.com/videos/lWMJeVvV-364767.mp4",
		
		$id_content_file = ($identificador != null)? 'jwplayer_'.$identificador : 'jwplayer_'.rand(0,999999999);
		$script = '
			 jwplayer("'.$id_content_file.'").setup({
				primary:"flash",
				src:"'.$this->webroot.'js/jwplayer/jwplayer.flash.swf",				
				file: "'.$url_file.'",
				width: 960,
				height: 566
				//image: "http://www.todo-sobre.com/mercedes-benz-slk/wallpapers/wallpapers-de-mercedes-benz-slk-1.jpg"				
			});		  
		';
		$this->Js->buffer($script,true);
		return '<div id="'.$id_content_file.'">'.__('Loading the player',true).'...</div>';
	}
	
	public function __date($date){
		$months = array(
			'January'	=>__('January'),
			'February'	=>__('February'),
			'March'		=>__('March'),
			'April'		=>__('April'),
			'May'		=>__('May'),
			'June'		=>__('June'),
			'July'		=>__('July'),
			'August'	=>__('August'),
			'September' =>__('September'),
			'October'	=>__('October'),
			'November'	=>__('November'),
			'December'	=>__('December'),
		);
		
		$month = $this->Time->format('F',$date);
		$day = $this->Time->format('j',$date);
		$year = $this->Time->format('Y',$date);	
		return $months[trim($month)].' '.$day.' '.__('of').' '.$year;
	}
		
	public function rang($data,$space = true){
		if($space){
			switch ($data){
				case $data <= (20):
					return __('Very Low').'&nbsp;&nbsp;';
					break;
				case $data <= (40):
					return  __('Low').'&nbsp;';
					break;
				case $data <= (60):
					return  __('Medium').'&nbsp;&nbsp;';
					break;
				case $data <= (80):
					return  __('Medium High').'&nbsp;&nbsp;';
					break;
				case $data <= (100):
					return __('High').'&nbsp;&nbsp;';
					break;
			}
		}else{
			switch ($data){
				case $data <= (20):
					return __('Very Low');
					break;
				case $data <= (40):
					return  __('Low');
					break;
				case $data <= (60):
					return  __('Medium');
					break;
				case $data <= (80):
					return  __('Medium High');
					break;
				case $data <= (100):
					return __('High');
					break;
			}
		}

	}
}