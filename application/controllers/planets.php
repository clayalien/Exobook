<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planets extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		//All methods here are going to want the Planet model
		$this->load->model('Planet_Model');
	}

	public function index()
	{
		$this->random_planet();
	}

	public function random_planet()
	{
		$planets = $this->Planet_Model->get_imaged_planets();
		//Pick one
		shuffle($planets);
		$selected = $planets[0];

		//Get some finer details frm the exoplanet catalogue
		$planet = $this->Planet_Model->get_planet($selected->_id);

		$this->load->view('panel',$planet);
	}
	
	public function planet_of_the_day()
	{
		$planets = $this->Planet_Model->get_imaged_planets();
	
		//pick a random palnet, using the current date as a seed
		@mt_srand(date("Ymd"));
		$j = @mt_rand(0, count($planets)-1);
		
		//Reset the seed, so subsiquent calls to mt_rand are unpredictable again
		@mt_srand();

		$selected = $planets[$j];

		//Get some finer details frm the exoplanet catalogue
		$planet = $this->Planet_Model->get_planet($selected->_id);

		$this->load->view('panel',$planet);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */