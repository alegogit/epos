<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    var $username   = '';
    var $password = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	 
	function get_profile()
    {
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('ID',$id);
        $query = $this->db->get('users');
        return $query->row();
    }
	
	function get_restaurant()
    {
		$session_data = $this->session->userdata('logged_in');
		$id = $session_data['id'];
		$this->db->where('users_restaurants.USER_ID',$id);
          //$query = $this->db->get('restaurants');
          $query = $this->db->select('*')
                              ->from('restaurants')
                              ->join('users_restaurants', 'restaurants.ID = users_restaurants.RESTAURANT_ID')
                              ->get('');
        return $query->row();
    }

	function get_announcements()
	{
		$query = $this->db->get('announcements');
		return $query->result();
	}
	
	function get_latest_promotions()
	{
		$this->db->where('TYPE','PROMO');
		$this->db->order_by('DATE', 'DESC');
		$query = $this->db->get('promos_local_services',2);
		return $query->result();
	}
	
	function get_latest_services()
	{
		$this->db->where('TYPE','LOCAL_SERVICES');
		$this->db->order_by('DATE', 'DESC');
		$query = $this->db->get('promos_local_services',2);
		return $query->result();
	}
	
    function insert_entry()
    {
        $this->title   = $_POST['title']; // please read the below note
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->insert('entries', $this);
    }

    function update_entry()
    {
        $this->title   = $_POST['title'];
        $this->content = $_POST['content'];
        $this->date    = time();

        $this->db->update('entries', $this, array('id' => $_POST['id']));
    }

}