<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	function fetch_project_statuses()
	{
		$statuses = array();
		$query = $this->db->select('id, name')->get_where('statuses', array(
			'type' => 'project'
		));
		foreach ($query->result() as $row)
		{
			$statuses[$row->id] = $row->name;
		}
		return $statuses;
	}
	
}
