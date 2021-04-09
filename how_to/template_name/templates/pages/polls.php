<legend><?= __('polls.title') ?></legend>
<?php
if (empty($polls)) {
	echo '<div class="alert alert-warning text-center">'. __('polls.none') .'</div>';
	return;
}
?>
<table class="table table-hover">
	<thead>
        <tr>
			<th></th>
          	<th><?= __('poll.title') ?></th>
          	<th><?= __('poll.end') ?></th>
        	<th></th>
    	</tr>
    </thead>
	<tbody>
	<?php foreach($polls as $poll) { ?>
        <tr>
			<?php if ($poll['open']) { ?>
				<td><i class="fa fa-clock-o"></i></td>
			<?php } else { ?>
				<td><i class="fa fa-pie-chart"></i></td>
			<?php } ?>
          	<td><a href="<?=App::getURL('poll', $poll['poll_id'])?>"><?=html_encode($poll['name'])?></a></td>
          	<td><?=Format::today($poll['end_date'])?></td>
			<?php if ($poll['can_vote'] && $poll['open']) { ?>
				<td><i class="fa fa-check-square-o"></i></td>
			<?php } else { ?>
				<td><i class="fa fa-eye"></i></td>
			<?php } ?>
    	</tr>
	<?php } ?>
	</tbody>
</table>