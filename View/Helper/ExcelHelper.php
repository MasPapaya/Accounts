<?php
App::uses('Helper', 'View');
App::import('Vendor', 'PHPExcel', array('file' => 'excel/PHPExcel.php'));
App::import('Vendor', 'PHPExcelWriter', array('file' => 'excel/PHPExcel/Writer/Excel5.php'));

class ExcelHelper extends AccountsAppHelper {

	var $xls;
	var $reader;
	var $sheet;
	var $data;
	var $blacklist = array();

	function excelHelper() {
		
	}

	function loadFile($file) {
		$this->reader = new PHPExcel_Reader_Excel5();
		$this->xls = $this->reader->load("{$file}");

		$this->xls->setActiveSheetIndex(0);
		$this->sheet = $this->xls->getActiveSheet();
		$this->sheet->getDefaultStyle()->getFont()->setName('Verdana');
	}

	function newFile() {
		$this->xls = new PHPExcel();
		$this->sheet = $this->xls->getActiveSheet();
		$this->sheet->getDefaultStyle()->getFont()->setName('Verdana');
	}

	function changeCell($value = null, $cell = null) {
		$this->sheet->setCellValue($cell, $value);
	}

	function generate(&$data, $titles_header=NULL, $title = 'Report', $model='',$style_header = NULL) {
		$this->data = & $data;
		$this->_title($title);
		$this->_date();
		$this->_headers($titles_header,10,$style_header);
		$this->_rows($model,11);
		$this->_output($title);
		return true;
	}
	
	function generateWithImage(&$data, $titles_header=NULL, $title = 'Report', $model='',
								$style_header = NULL, $urlImage = '',$name_image='') {
		$this->data = & $data;
		$this->_title($title);
		$this->_date();
		$this->_headers($titles_header,23,$style_header);
		$this->_rowsTypeChart($model,24);
		$this->_saveImageFromUrl($urlImage);
		$this->_getImage($name_image);
		$this->_output($title);
		return true;
	}
	
	function _title($title) {
		$this->sheet->getStyle('A7')->getFont()->setSize(12);
		$this->sheet->getStyle('A7')->getFont()->getColor()->setRGB('464B4F');
		$this->sheet->getRowDimension('7')->setRowHeight(24);				
		
		$this->sheet->setCellValue('B7', $title);
		$this->sheet->getStyle('B7')->getFont()->setSize(12);
		$this->sheet->getStyle('B7')->getFont()->getColor()->setRGB('464B4F');
		$this->sheet->getRowDimension('7')->setRowHeight(24);				
	}
	
	function _date(){
		
		$this->sheet->getStyle('A8')->getFont()->setSize(8);
		$this->sheet->getStyle('A8')->getFont()->getColor()->setRGB('DD2F87');
		
		$this->sheet->setCellValue('B8', date('Y-m-d H:i:s'));
		$this->sheet->getStyle('B8')->getFont()->setSize(8);
		$this->sheet->getStyle('B8')->getFont()->getColor()->setRGB('DD2F87');
	}

	function _headers($titles_header=NULL, $row= 10,$style_header= NULL) {
		$i = 0;
		foreach ($titles_header as $field) {
			if (!in_array($field, $this->blacklist)) {
				$columnName = Inflector::humanize($field);
				if($style_header!=NULL){
					$this->_headerStyle($i, $row, $style_header);
				}
				$this->sheet->setCellValueByColumnAndRow($i++, $row, $columnName);
				
				
			}
		}
		
		
		
//		for ($j = 1; $j < $i; $j++) {
//			$this->sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($j))->setAutoSize(true);
//		}
	}
	
	function _headerStyle($column= 0, $row=0, $style_header = NULL){
		$this->sheet->getStyleByColumnAndRow($column, $row)->getAlignment()->setHorizontal('center');
		if(isset($style_header['bold'])){
			$this->sheet->getStyleByColumnAndRow($column, $row)->getFont()->setBold($style_header['bold']);
		}else{
			$this->sheet->getStyleByColumnAndRow($column, $row)->getFont()->setBold(false);
		}
		
		if(isset($style_header['color'])){
			$this->sheet->getStyleByColumnAndRow($column, $row)->getFont()->getColor()->setRGB($style_header['color']);
		}else{
			$this->sheet->getStyleByColumnAndRow($column, $row)->getFont()->getColor()->setRGB('000000');
		}
			
		if(isset($style_header['background_color'])){
			$this->sheet->getStyleByColumnAndRow($column, $row)->getFill()->getStartColor()->setRGB($style_header['background_color']);
		}else{
			$this->sheet->getStyleByColumnAndRow($column, $row)->getFill()->getStartColor()->setRGB('FFFFFF');
		}			
		
		$this->sheet->getStyleByColumnAndRow($column, $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->sheet->getStyleByColumnAndRow($column, $row)->getBorders()->getAllBorders()->setBorderStyle('thin');
		//$this->sheet->duplicateStyle($this->sheet->getStyle('A10'), 'A10:' . $this->sheet->getCellByColumnAndRow($cant_column, 10));
	}
		
	function _rows($model, $row_temp= 11) {
		$i = $row_temp;
		foreach ($this->data as $row) {
			$j = 0;
			foreach ($row[$model] as $field => $value) {

				if (!in_array($field, $this->blacklist)) {
					$this->sheet->setCellValueByColumnAndRow($j++, $i, $value);
					
					$this->sheet->getStyleByColumnAndRow($j-1, $i)->getBorders()->getAllBorders()->setBorderStyle('thin');
				}
			}
			$i++;
		}
	}
	
	function _rowsTypeChart($model, $row_temp= 11) {
		$j = 0;
		foreach ($this->data as $row) {
			
			$i = $row_temp;
			foreach ($row as $field => $value) {
			
				$this->sheet->setCellValueByColumnAndRow($j, $i, $value);
				$this->sheet->getStyleByColumnAndRow($j, $i)->getBorders()->getAllBorders()->setBorderStyle('thin');
				$i++;
			}
			$j++;
		}
	}
	
	
	function _saveImageFromUrl($link = ''){
		if(!empty($link)){
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch,CURLOPT_URL,$link);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$result=curl_exec($ch);

			curl_close($ch);

			$savefile = fopen(WWW_ROOT.'/templates/chart.png', 'w');
			fwrite($savefile, $result);
			fclose($savefile);
		}
	}
	
	function _getImage($name_image = ''){
		
		if(!empty($name_image)){			
			$this->sheet = new PHPExcel_Worksheet_Drawing();
			$this->sheet->setName('Chart');
			$this->sheet->setDescription('Chart');
			$this->sheet->setPath(WWW_ROOT.'/templates/'.$name_image);
			$this->sheet->setCoordinates('A10');
			$this->sheet->setOffsetX(0);
			//$this->sheet->setRotation(25);
			$this->sheet->getShadow()->setVisible(true);
			$this->sheet->getShadow()->setDirection(45);
			$this->sheet->setWorksheet($this->xls->getActiveSheet());
		}
	}

	function _output($title) {
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header('Content-Disposition: attachment;filename="' . $title . '.xls"');

		header('Cache-Control: max-age=0');
		$objWriter = new PHPExcel_Writer_Excel5($this->xls);
		$objWriter->setTempDir(TMP);
		$objWriter->save('php://output');
	}

}

?>