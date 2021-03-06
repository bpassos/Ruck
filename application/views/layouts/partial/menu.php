<div class="dropdown">
	<a href="/gtd/" id="home" class="dropdown-header">RUCK</a>
	<ul class="actions">
		<li><a href="/gtd/tasks/inbox" accesskey="q" id="quick-capture"><u>Q</u>uick Capture</a></li>
		<li><a href="/gtd/projects/create" accesskey="p" id="new-project" class="new-project">New <u>P</u>roject</a></li>
		<li><a href="/gtd/tasks/create" accesskey="t" id="new-task" class="new-task">New <u>T</u>ask</a></li>
		<li><a href="/gtd/contexts" accesskey="c" id="new-context" class="new-context">New <u>C</u>ontext</a></li>
		<li><a href="/gtd/projects/review" accesskey="w" id="weekly-review" class="weekly-review"><u>W</u>eekly Review</a></li>
	</ul>
</div>

<ul class="menu">
	<li<?php if ($current_page == 'process_inbox') echo ' class="selected"'; ?>>
		<a href="/gtd/tasks/process_inbox">
			<span class="count"><?php echo $inbox_count; ?></span>
			<strong>Inbox</strong>
			To be processed
		</a>
	</li>
	<li<?php if ($current_page == 'calendar') echo ' class="selected"'; ?>>
		<a href="/gtd/calendar">
			<?php if ($calendar_count['overdue'] > 0): ?>
				<span class="count overdue"><?php echo $calendar_count['overdue']; ?></span>
			<?php endif; ?>
			<span class="count<?php if ($calendar_count['overdue'] > 0) echo ' blunt'; ?>"><?php echo $calendar_count['due']; ?></span>
			<strong>Calendar</strong>
			Due today or tomorrow
		</a>
	</li>
	<li<?php if ($next_actions == '') echo ' class="selected"'; ?>>
		<a href="/gtd/">
			<span class="count"><?php echo $next_actions_count; ?></span>
			<strong>Next Actions</strong>
			What you should be doing
		</a>
	</li>
	<li<?php if ($current_page == 'waiting_for') echo ' class="selected"'; ?>>
		<a href="/gtd/waiting_for">
			<span class="count"><?php echo $waiting_for_count; ?></span>
			<strong>Waiting For</strong>
			Other people's business
		</a>
	</li>
	<li<?php if ($current_page == 'someday_maybe') echo ' class="selected"'; ?>>
		<a href="/gtd/projects/someday_maybe">
			<strong>Someday/Maybe</strong>
			Future projects
		</a>
	</li>
</ul>
