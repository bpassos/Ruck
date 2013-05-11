<?php echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo form_open(); ?>
	
	<h1><?php echo $task['description']; ?></h1>
	<input class="inline-edit heading" type="text" name="description" value="<?php echo htmlspecialchars($task['description']); ?>">
	<!--
			<a href="/gtd/tasks/delete/<?php echo $task['id']; ?>" class="delete"><input type="checkbox"></a>
	-->		
		
	<p><?php echo $task['notes']; ?></p>
	<textarea name="notes" rows="5" class="inline-edit" placeholder="Add task notes"><?php echo $task['notes']; ?></textarea>

	<input class="date" type="hidden" name="due" id="due" value="" data-due="<?php if (isset($task['due'])) echo date('m/d/Y', strtotime($task['due'])); ?>">
	<div id="datepicker"></div>
	
	<label for="recurs">This task recurs:</label>
	<?php echo form_dropdown('recurs', $recurring_labels, $task['recurs'], 'id="recurs"'); ?>
	
	<label for="status_id">Status:</label>
	<?php echo form_dropdown('status_id', $statuses, $task['status_id'], 'id="status_id"'); ?>
	
	<label for="context_id">Context:</label>
	<?php echo form_dropdown('context_id', $contexts, $task['context_id'], 'id="context_id"'); ?>
	
	<label for="project_id">Project:</label>
	<?php echo form_dropdown('project_id', $projects, $task['project_id'], 'id="project_id"'); ?>

	<div class="buttons">
		<input type="hidden" name="id" value="<?php echo $task['id']; ?>">
		<button type="submit" class="btn save">Save Changes</button>
		<a href="/gtd/tasks/delete/<?php echo $task['id']; ?>" class="btn delete">Delete this task</a>
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
