<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends Ruck_Controller {
	
	/**
	 * A single project view, showing all tasks associated with that project.
	 */
	public function index($id = NULL)
	{
		
		$project = $this->Project->find($id);
		$tasks = $this->Task->get_tasks_by_project($id);

		# Set page title.
		$this->template->title('GTD', $project['name']);

		# Load the main content of the page.
		$this->template->build('project/detail', array(
			'project'		=> $project,
			'tasks'			=> $tasks->result(),
		));

	}
	
	/**
	 * Ajax handler to re-order the tasks within a project after they have
	 * been rearranged.
	 */
	function order()
	{
		$new_order = $this->input->post('new_order');
		if (isset($new_order))
		{
			// We have a list of re-arranged IDs.
			// What we want to do is retrieve the Todo items, duplicate them,
			// insert them in the new order, then delete the originals.
			$new_ids = array();
			foreach ($new_order as $id)
			{
				// TODO: I'm sure there must be a simpler/more efficient way to do this...
				$task = $this->db->get_where('tasks', array(
					'id' => $id
				))->row();
				$data = array(
					'description'	=> $task->description,
					'notes'			=> $task->notes,
					'project_id'	=> $task->project_id,
					'status_id'		=> $task->status_id,
					'context_id'	=> $task->context_id,
					'due'			=> $task->due,
					'created_at'	=> $task->created_at,
					'updated_at'	=> $task->updated_at,
				);
				$this->db->insert('tasks', $data);
				$new_ids[] = $this->db->insert_id();
				$this->db->delete('tasks', array(
					'id' => $id
				));
			}
			echo implode(',', $new_ids);
		}
	}
	
	/**
	 * Creating a new project.
	 */
	public function create()
	{
		
		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run() == FALSE)
		{

			# Set page title.
			$this->template->title('GTD', 'Create a new Project');
	
			# Load the main content of the page.
			$this->template->build('project/new', array(
				'statuses'	=> $this->Status->fetch_statuses('project'),
				'projects'	=> $this->Project->fetch_projects_for_dropdown(),
			));
			
		}
		else
		{
			
			# Form passes validation, insert the new project into the database.
			$project_id = $this->Project->insert_new();
			
			# Redirect to the new Project's page.
			redirect('/gtd/projects/' . $project_id);
			
		}

	}
	
	function activate($id)
	{
		$this->db->where('id', $id)->update('projects', array(
			'status_id' => 3
		));
		redirect('/gtd/projects/' . $id);
	}
	
	function deactivate($id)
	{
		$this->db->where('id', $id)->update('projects', array(
			'status_id' => 4
		));
		redirect('/gtd/projects/' . $id);
	}
	
	/**
	 * Delete a project. This process should really check whether there are any
	 * outstanding tasks assigned to this project and prompt the user to decide
	 * what to do with them before deleting.
	 */
	function delete($id = NULL)
	{
		# Delete the project row.
		$this->Project->delete($id);
		
		# Redirect to the master page.
		redirect('/gtd/');
	}

}
