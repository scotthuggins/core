<?php

class purchases extends baseTable{
	
	public function __construct(){
		
		parent::__construct();
		
		//Place config options since the baseTable object sets defaults, we want to add and override.
		
		
		//config Property to set a default view mode for table or cards
		// Options: Table or 'Tiles'
		$this->config['defaultDataView'] = "Calendar";
		
		
	}
}
?>