<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>
	<fieldset>
		<legend>Create a new project</legend>
		<ol>
			<li>
				<label for="name">Task description</label>
				<?php echo form_input(array(
					'name'			=> 'description',
					'id'			=> 'description',
					'value'			=> htmlspecialchars($task['description']),
					'maxlength'		=> 255,
					'size'			=> 50,
					'autofocus'		=> 'autofocus',
					'placeholder'	=> 'Enter a brief description of this single task',
				)); ?>
			</li>
			<li>
				<label for="notes">Task notes</label>
				<?php echo form_textarea(array(
					'name'			=> 'notes',
					'id'			=> 'notes',
					'value'			=> $task['notes'],
					'placeholder'	=> '(optional) Enter the details of this task and any other notes or discussion you need to refer to later.',
				)); ?>
			</li>
			</li>
			<li class="concealed">
				<label for="due">Due date:</label>
				<a href="#datepicker">Click to set a due date</a>
				<input type="hidden" name="due" id="due" value="<?php echo date('m/d/Y', strtotime($task['due'])); ?>">
				<div id="datepicker"></div>
			</li>
			<li class="horizontal">
				<label for="recurs">This task recurs:</label>
				<?php echo form_hidden('recurs', $task['recurs']); ?>
				<ul class="form-options">
					<?php foreach ($recurring_labels as $id => $name): ?>
						<li><a href="#" data-value="<?php echo $id; ?>" data-field="recurs"<?php if ($id == $task['recurs']) echo ' class="selected"'; ?>><?php echo $name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="horizontal">
				<label for="status_id">Status:</label>
				<?php echo form_hidden('status_id', $task['status_id']); ?>
				<ul class="form-options">
					<?php foreach ($statuses as $id=>$name): ?>
						<li><a href="#" data-value="<?php echo $id; ?>" data-field="status_id"<?php if ($id == $task['status_id']) echo ' class="selected"'; ?>><?php echo $name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li class="horizontal">
				<label for="context_id">Context:</label>
				<?php echo form_hidden('context_id', $task['context_id']); ?>
				<ul class="form-options">
					<?php foreach ($contexts as $id => $name): ?>
						<li><a href="#" data-value="<?php echo $id; ?>" data-field="context_id"<?php if ($id == $task['context_id']) echo ' class="selected"'; ?>><?php echo $name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</li>
			<li>
				<label for="project_id">Project:</label>
				<?php echo form_dropdown('project_id', $projects, $task['project_id'], 'id="project_id"'); ?>
			</li>
		</ol>

	</fieldset>
	
	<div class="buttons">
		<input type="hidden" name="id" value="<?php echo $task['id']; ?>">
		<button type="submit" class="btn new-task">Save Changes</button>
		<a href="/gtd/tasks/delete/<?php echo $task['id']; ?>" class="btn delete-task">Delete this task</a>
	</div>

</form>

<?php
$created_at = new DateTime($task['created_at']);
$now = new DateTime(date('Y-m-d'));
$diff = $created_at->diff($now);
if ($diff->y)
{
	$datestamp = $diff->format('%y years, %m months, %d days');
}
else if ($diff->m)
{
	$datestamp = $diff->format('%m months, %d days');
}
else
{
	$datestamp = $diff->format('%d days');
}
?>
<p class="datestamp"><?php echo $datestamp; ?></p>
