<?php
/**
 * Loads app keys into the application. Setup config via $config[], get config via $_ENV['config'][]
 */
class Config{
	public static function load(){
		
		$keypath = __DIR__ . '/config';
		$keys_loaded = false;

		$_APP = [];
		
		//see if "config folder" exists
		if(file_exists($keypath) AND is_dir($keypath)){
        
			foreach(new DirectoryIterator($keypath) as $file){
				//ignore dots and non-php extensions and this file itself
				if($file->isDot() OR $file->getExtension() != 'php') continue;
				
				$keys_loaded = true;
                
				include_once($file->getPathname());
			}
		}
		if($keys_loaded){
			foreach($config as $key => $value){
               
				$_APP['config'][$key] = $value;
			}
            
            return $_APP;
			unset($config);
		}
	}
}