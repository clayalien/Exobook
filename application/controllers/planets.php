<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planets extends CI_Controller {

	public function index()
	{
		$this->random_planet();
	}

	public function random_planet()
	{
		$skyhook = json_decode(  
			file_get_contents('http://exoapi.com/api/skyhook/planets/all?fields=[_id,image]')
		);
		$planets = $skyhook->response->results;
		
		//Only interested in planets that have images
		$filtered = array_filter($planets, array($this, 'has_image'));
		
		//Pick one
		shuffle($filtered);
		$selected = $filtered[0];

		//Get some finer details frm the exoplanet catalogue

		$this->load->model('Planet_Model');
		$planet = $this->Planet_Model->get_planet($selected->_id);

		$this->load->view('panel',$planet);
	}
	
	public function planet_of_the_day()
	{
		$skyhook = json_decode(  
			file_get_contents('http://exoapi.com/api/skyhook/planets/all?fields=[_id,image]')
		);
		$planets = $skyhook->response->results;
		
		//Only interested in planets that have images
		$filtered = array_values(array_filter($planets, array($this, 'has_image')));
	
		//pick a random palnet, using the current date as a seed
		@mt_srand(date("Ymd"));
		$j = @mt_rand(0, count($filtered)-1);
		
		//Reset the seed, so subsiquent calls to mt_rand are unpredictable again
		@mt_srand();

		$selected = $filtered[$j];

		//Get some finer details frm the exoplanet catalogue

		$this->load->model('Planet_Model');
		$planet = $this->Planet_Model->get_planet($selected->_id);


		$this->load->view('panel',$planet);
	}
	
	private function has_image($planet)
	{
		$trimmed = $planet->image;
		$trimmed = trim($trimmed);

		return($trimmed != '');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */