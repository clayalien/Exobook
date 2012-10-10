<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Model object to represent a planet. Note that this is an xml model rather than a db model. In the future, it might be best to
   set up a system to cache planets in a db because fetching them can be slow.
 */
class Planet_Model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}
	
	function get_imaged_planets()
	{
		$skyhook = json_decode(  
			file_get_contents('http://exoapi.com/api/skyhook/planets/all?fields=[_id,image]')
		);
		$planets = $skyhook->response->results;
		
		//Only interested in planets that have images
		return array_values((array_filter($planets, array($this, 'has_image'))));
	}
	
	function get_planet($id)
	{
		$planet = simplexml_load_file("https://raw.github.com/hannorein/open_exoplanet_catalogue/master/data/$id.xml");

		//Some of the xml files returned from the open exoplanet catalogue have second, empty tags, such as:
		//<image>KOI961</image>
		//<image />
		//This will make $planet->image return a string in some cases, and an array in others, which plays havok in views
		//The simplist way around this is to just cut them out.

		$this->flatten($planet,'name');
		$this->flatten($planet,'description');
		$this->flatten($planet,'image');
		$this->flatten($planet,'imagedescription');

		return $planet;
	}
	
	/*
		Flatten out the empty and duplicate tags
	*/
	private function flatten($xml, $field)
	{
		//Do nothing to all ready flattened fields
		if (is_string($xml->{$field})){
			return;
		}
		//Appending empty string to force string cloning
		$flat = $xml->{$field}[0].'';
		unset($xml->{$field});
		$xml->{$field} = $flat;
		
	}
	
	private function has_image($planet)
	{
		$trimmed = $planet->image;
		$trimmed = trim($trimmed);

		return($trimmed != '');
	}
}	