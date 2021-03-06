<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projects extends Ruck_Controller {
	
	/**
	 * A single project view, showing all tasks associated with that project.
	 */
	public function index($id = NULL)
	{
		
		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run('projects/create') != FALSE)
		{
			# Form passes validation, update the task in the database.
			$this->Project->update($id);
		}

		$project = $this->Project->find($id);
		$tasks = $this->Task->get_tasks_by_project($id);

		# Set page title.
		$this->template->title('GTD', $project['name']);

		# Load the main content of the page.
		$this->template->build('project/detail', array(
			'project'			=> $project,
			'tasks'				=> $tasks->result(),
			'completed_tasks'   => $this->Task->get_completed_tasks($id),
			'parent_projects'	=> $this->Project->get_ancestor_projects($project['parent_project_id']),
			'child_projects'	=> $this->Project->get_child_projects_and_tasks($id),
		));

	}
	
	/**
	 * Ajax handler to re-order the tasks within a project after they have
	 * been rearranged. Returns the revised list of IDs so they can be used
	 * to update the links on the page.
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
				$task = $this->db->get_where('tasks', array(
					'id' => $id
				))->row_array();
				$task['id'] = NULL;
				$this->db->insert('tasks', $task);
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
	public function create($parent_project_id = NULL)
	{
		
		$this->load->library('form_validation');
		
		# Validate the new project form if submitted.
		if ($this->form_validation->run('projects/create') == FALSE)
		{

			# Set page title.
			$this->template->title('GTD', 'Create a new Project');
	
			# Load the main content of the page.
			$this->template->build('project/new', array(
				'projects'			=> $this->Project->fetch_projects_for_dropdown(),
				'parent_project_id'	=> $parent_project_id,
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
			'someday_maybe' => 0
		));
		redirect('/gtd/projects/' . $id);
	}
	
	function deactivate($id)
	{
		$this->db->where('id', $id)->update('projects', array(
			'someday_maybe' => 1
		));
		redirect('/gtd/projects/' . $id);
	}
	
	/**
	 * Delete a project. This process should really check whether there are any
	 * outstanding tasks assigned to this project and prompt the user to decide
	 * what to do with them before deleting.
	 */
	function delete($id = NULL, $redirect = NULL)
	{
		# Delete the project row.
		$this->Project->delete($id);
		
		# Redirect to the requested page, or back to the homepage.
		if (isset($redirect))
		{
			redirect('/gtd/projects/' . $redirect);
		}
		else
		{
			redirect('/gtd/');
		}
	}
	
	/**
	 * List all archived projects.
	 */
	function someday_maybe()
	{
		$this->template->build('project/someday-maybe', array(
			'projects' => $this->Project->get_someday_maybe_projects(),
		));
	}
	
	/**
	 * Placeholder Weekly Review page, listing all open projects with all tasks under them.
	 */
	function review()
	{
		# Set page title.
		$this->template->title('GTD', 'Weekly Review');

		$this->template->build('project/review', array(
			'projects' => $this->Project->get_projects_for_review(),
		));
	}

}
