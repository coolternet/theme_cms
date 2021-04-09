<div class="float-right">
	<ol class="breadcrumb forum-navbar tools">
		<li><a href="<?= App::getURL('forums', ['id'=>@$forum['id'],'search'=>'recent']) ?>" title="Messages récents">Récents</a>
		<li><a href="<?= App::getURL('forums', ['id'=>@$forum['id'],'search'=>'noreply']) ?>" title="Sans réponse">Sans réponse</a>
		<li><a href="<?= App::getURL('forums', ['id'=>@$forum['id'],'search'=>'1']) ?>" title="Recherche">Recherche</a>
		<?php if (!has_permission()) { ?>
			<li><a href="<?= App::getURL('login', ['redir'=>$_SERVER['REQUEST_URI']]) ?>" title="Connexion">Connexion</a>
		<?php } ?>
	</ol>
	<?php
	if ($ptotal > 1) {
		echo '<div style="text-align:right;margin-top:-19px">Pages: ';
		foreach(Widgets::pagerAsList($ptotal, $pn, 8) as $i => $l) {
			if ($pn == $i)
				echo ' <strong>' . $i . '</strong>';
			else
				echo ' <a href="'.App::getURL('forums', @$forum['id']). (isset($topic) ? '&topic='.$topic['id'] : '') . '&pn='.$i.'">'.$l.'</a> ';
		}
		echo '</div>';
	}
	?>
</div>

<ol class="breadcrumb forum-navbar">
<?php
foreach(App::getCrumbs() as $i => $crumb) {
	if (strpos($crumb, 'topic=')) {
		$crumb = "<big><strong>$crumb</strong></big>";
	}
	if ($i === count(App::getCrumbs()) - 1) {
		echo '<li class="active">'.$crumb.'</li>';
	} else {
		echo '<li>'.$crumb.'</li>';
	}
}
?>
</ol>
