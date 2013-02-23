<h1>Your Next Tasks</h1>

<aside class="context-actions">
	<?php echo $template['partials']['contexts']; ?>
</aside>

<ul class="tasks">
	<?php foreach ($next_tasks as $task): ?>
		<li data-context-id="<?php echo $task->context_id; ?>">
			<a href="/gtd/tasks/delete/<?php echo $task->id; ?>/home"><input type="checkbox"></a>
			<a href="/gtd/tasks/detail/<?php echo $task->id; ?>"><?php echo $task->description; ?></a>
			<a href="/gtd/projects/<?php echo $task->project_id; ?>" class="pill project" title="<?php echo $task->project_name; ?>"><?php echo character_limiter($task->project_name, 20); ?></a>
		</li>
	<?php endforeach; ?>
</ul>
