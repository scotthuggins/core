<?php
class permissions extends baseTable {
	
	public function __construct(){
		
	
		parent::__construct();
		
		$this->config['defaultDataView'] = 'Table';	
	}
}

?>