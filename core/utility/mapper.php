<?php

/** 
 * The Sol mapper scans company and core dirs for sol formatted 
 * classes and keeps a map
 * 
 * The map is responsible for detecting a parent child path through
 * all entities and tables
 * 
 * 
 * 
 */
 


 
class map
{
    /**
     * An associative array where the key is a mapspace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @var array
     */
    protected $prefixes = array();

	/**
	 * An associative array where the key is the mapspace prefix (core or company)
	 * and the value is an array of classes in that name space
	 * 
	 * possible namespaces:
	 * 
	 * 		core_entities
	 * 		core_tables
	 * 		company_entities
	 * 		company_tables
	 * 
	 * 
	 * @var array
	 */
	public $map = array();
	
	
	/**
	 * associative multi level array used to define child and parent relationships
	 * 
	 */
	public $entity_map = array();


	/**
	 * Creates entity maps and stores on $this->entity_map;
	 * 
	 */
	public function createEntityMap(){
		
		$seed_entity = 'user';
		
		//parse entites starting from seed, open them
		$entity = new $seed_entity();
		
		//foreach($entity->config['associations'] as $entity_name => $relationship){
		//	$this->build($entity_name,$relationship,get_class($entity));
		//}
		
		foreach($entity->config['associations']['belongsTo'] as $entity_name){
			$this->build($entity_name,'belongsTo',get_class($entity));
		}
		foreach($entity->config['associations']['has'] as $entity_name){
			$this->build($entity_name,'has',get_class($entity));
		}


		
	}

	/**
	 * Recusive! Builds multi dim array from all entity
	 * assocations into single place
	 * 
	 * TODO: We can do error checking here
	 * Are to entities not assocated correctly etc.
	 *
	 * 
	 * 
	 */
	private function build($relative,$assoc,$entity){
		
		timer('map_build');
		//init the map array
		if (!isset($this->entity_map[$entity][$assoc])){
			$this->entity_map[$entity][$assoc] = array();
		}
		
		//detect recursion
		if (in_array($relative,$this->entity_map[$entity][$assoc])){
			return;
		}
		
		//add the value to this entity_map
		array_push($this->entity_map[$entity][$assoc],$relative);
		
		//recusively get more relationships from the relative
		$entity = new $relative();
		//foreach($entity->config['associations'] as $entity_name => $relationship){
		//	$this->build($entity_name,$relationship,get_class($entity));
		//}
		foreach($entity->config['associations']['belongsTo'] as $entity_name){
			$this->build($entity_name,'belongsTo',get_class($entity));
		}
		foreach($entity->config['associations']['has'] as $entity_name){
			$this->build($entity_name,'has',get_class($entity));
		}
	}

    /**
     * builds map from added name/map spaces
     *
     * @return void
     */
    public function register()
    {
    	//Scan directors from prefixes and populate arrays
    	foreach($this->prefixes as $prefix => $dir){
    		$this->map[$prefix] = $this->scanDir($dir);
		}
		
		
		//core_dir = core tables and entities
		$this->core_dir = array_merge($this->map['core_tables'], $this->map['core_entities']);
		sort($this->core_dir);
		
		//company_dir = company tables and entities
		$this->company_dir = array_merge( $this->map['company_tables'], $this->map['company_entities']);
		sort($this->company_dir);
		
		//all_entities = company and core entities only (singlular names);
		$this->all_entities = array_merge( $this->map['core_entities'], $this->map['company_entities']);
		sort($this->all_entities);
		
		//Create a single array containting all files
		$this->all_dir = array_merge($this->company_dir,$this->core_dir);	
		sort($this->all_dir);
    }
	
	/**
	 * Scans a directory and returns file names in an array
	 * 
	 * @param assoc array where values are directories to seach
	 * @return array 1:1 array of all files
	 */
	
	private function scanDir($dirs){
		
		$file_collection = array();
		
		//scan the dir into an array
		foreach($dirs as $dir){
			$files = array_slice(scandir($dir),2);
		
			//remove .php
			$files = array_map(function($e){
			    return pathinfo($e, PATHINFO_FILENAME);
			}, $files);
			
			//merge all the file names into single array
			$file_collection = array_merge($file_collection,$files);
		}
		sort($file_collection);
		return $file_collection;
	}

    /**
     * Adds a base directory for a namespace prefix.
     *
     * @param string $prefix The namespace prefix.
     * @param string $base_dir A base directory for class files in the
     * namespace.
     * @param bool $prepend If true, prepend the base directory to the stack
     * instead of appending it; this causes it to be searched first rather
     * than last.
     * @return void
     */
    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
        // normalize namespace prefix
        $prefix = trim($prefix, '\\');

		// normalize the base dir with forward slash
		$base_dir = str_replace("\\", "/", $base_dir);

        // initialize the namespace prefix array
        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }
		
		// initialize the map prefix array
        if (isset($this->map[$prefix]) === false) {
            $this->map[$prefix] = array();
        }

        // retain the base directory for the namespace prefix
        if ($prepend) {
            array_unshift($this->prefixes[$prefix], $base_dir);
        } else {
            array_push($this->prefixes[$prefix], $base_dir);
        }
    }

	
	/**
	 * Returns the map array
	 * 
	 * @return array assocative array, key is the mapspace and the values are the classes in that space
	 * 
	 */
	public function getMap()
	{
		return $this->map;
	}
	
}