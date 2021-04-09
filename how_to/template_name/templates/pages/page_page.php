<div class="page">
	<h2 class="title"><?= html_encode($page['title']) ?>
		<?php if (has_permission('admin.page_edit')) { ?>
			<a title="Éditer" href="<?= App::getLocalURL('/admin/', ['page' => 'page_edit', 'id' => $page['id']]) ?>"><i class="fa fa-pencil-alt"></i></a>
		<?php } ?>
	</h2>
	<?= $page['content'] ?>
</div>