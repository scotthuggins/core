<?php
class companies extends baseTable {
	
	public function __construct(){
		$this->config['defaultDataView'] = 'table';	
	
		parent::__construct();
	}
}

?>