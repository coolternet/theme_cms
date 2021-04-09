<?php
if ($topic['closed']) {
	echo '<div class="alert alert-warning">Cette discussion est close.</div>';
}

echo '<div class="card forum mb-4">';
echo '	<div class="card-header">';

echo '<div class="float-right"><form method="post"> ';
if ((!$topic['closed'] || $forum_moderator || has_permission('mod.forum_topic_close')) && has_permission('forum.write', $forum['id']))
	echo	'<a href="'.App::getURL('forums', ['topic'=>$topic['id'],'compose'=>1]).'">Répondre</a> ';

if ($forum_moderator || has_permission('mod.forum_topic_close')) {
	if ($topic['closed']) echo '<button class="btn btn-primary btn-sm" name="closed" value="0" title="Ouvrir"><i class="fa fa-lock-open"></i></button> ';
	else echo '<button class="btn btn-primary btn-sm" name="closed" value="1" title="Fermer"><i class="fa fa-lock"></i></button> ';
}

if ($forum_moderator || has_permission('mod.forum_topic_stick')) {
	if ($topic['sticky']) echo '<div class="btn-group"><button class="btn btn-info btn-sm active" name="sticky" value="0" title="Désépingler"><i class="fas fa-thumbtack"></i></button></div> ';
	else echo '<button class="btn btn-info btn-sm" name="sticky" value="1" title="Épingler"><i class="fas fa-thumbtack"></i></button> ';
}

if ($forum_moderator || has_permission('mod.forum_topic_redirect')) {
	echo '<a class="btn btn-warning btn-sm" name="redirect-topic" href="'.App::getURL('forums', ['edit'=>$topic['first_post_id']]).'" title="Créer une redirection">'.
		 '<i class="fas fa-location-arrow"></i></a> ';
}

if ($forum_moderator || has_permission('mod.forum_topic_move')) {
	echo '<button type="button" class="btn btn-warning btn-sm" name="move-topic" value="'.$topic['id'].'" title="Déplacer la discussion" onclick="$(\'#move-topic-container\').toggle();">'.
		 '<i class="fa fa-arrow-right"></i></button> ';
}

if ($forum_moderator || has_permission('mod.forum_topic_delete')) {
	echo '<button class="btn btn-danger btn-sm" name="delete-topic" value="'.$topic['id'].'" title="Supprimer la discussion" onclick="return confirm(\'Supprimer la discussion et ses messages?\');">'.
		 '<i class="fa fa-times"></i></button> ';
}
echo '		</form></div>';

if ($topic['redirect'])
echo'<i class="fa fa-location-arrow" title="Lien externe"></i> ';

if ($topic['closed'])
echo '<i class="fa fa-lock" title="Discussion close"></i> ';

if ($topic['sticky'])
echo'<i class="fa fa-thumbtack" title="Discussion épingler"></i> ';


echo html_encode($topic['subject']);
echo '	</div>';

if ($posts) {
	echo '<table class="table table-lists forum-topic"><tbody>';
	foreach($posts as $post) {
		echo '<tr id="msg'.$post['id'].'" class="topic-message">';
			echo '<td><a href="'.App::getURL('user', ['id'=>$post['poster_id']]).'"><strong class="group-color-'.$post['color'].'">' . html_encode($post['username'] ?: $post['poster']). '</strong><br>';
			echo get_avatar($post). '</a>';
			echo '<p>';
			echo '<span class="badge badge-primary label-usergroup">' . $post['gname'] . '</span>';

			if ($post['ban_reason']) {
				$reason = has_permission('mod.') ? html_encode($post['ban_reason']) : 'Ce membre est bannis.';
				echo '​<span class="badge badge-danger" title="'.$reason.'">Bannis</span>';
			}

			echo '</p>';
			echo '<dd class="user-meta">';

			if (!empty(COUNTRIES[$post['country']]))
				echo 'Pays: <span>'. COUNTRIES[$post['country']].' &nbsp;<img style="position:relative;top:-1px;" src="' . App::getAsset('img/flags/'.strtolower($post['country']).'.png') . '"> '. '</span><br>';

			if (isset($post['username'])) {
				echo 'Inscrit: <span>' . ($post['registered'] ? date('Y-m-d', $post['registered']) : 'Invité'). '</span><br>';
				echo 'Posts: <span>' . $post['num_posts']. '</span><br>';
			} else {
				if ($post['poster_id']) {
					echo 'Compte supprimé<br>';
				} else {
					echo 'Invité<br>';
				}
			}
			echo '</dd>';

			echo '<dd class="usercontacts">';
			echo Widgets::userAgentIcons($post['user_agent']);
			echo '</dd>';

			echo '</td>';
			echo '<td>';
				echo 	'<div class="header">&nbsp;<a href="'.App::getURL('forums', ['pid'=>$post['id']], 'msg'.$post['id']).'">' . Format::today($post['posted'], true).'</a>';
				if ($post['edited']) echo '<small> <i>(Édité '.Format::today($post['edited'], true).')</i></small>';
				echo '<span class="float-right">';

				if ( (has_permission() && App::getCurrentUser()->id == $post['poster_id']) || has_permission('mod.') ) {
					echo '&nbsp;<a onclick="return confirm(\'Sur?\');" href="'.App::getURL('forums', ['topic'=>$post['topic_id'],'delete-post'=>$post['id']]).'" style="color:red" title="Supprimer"><i class="fas fa-trash"></i></a> ';
					echo '&nbsp;<a href="'.App::getURL('forums', ['edit'=>$post['id']]).'" title="Editer"><i class="fa fa-pencil-alt"></i></a> ';
				}

				echo '&nbsp;<a href="" onclick="return report('.$post['id'].');" title="Signaler"><i class="fas fa-flag"></i></a> ';

				echo '&nbsp;<a href="'.App::getURL('forums', ['topic'=>$post['topic_id'],'quote'=>$post['id']]).'" title="Citer"><i class="fa fa-quote-right"></i></a>';

				echo '&nbsp;</span></div>';
				echo '<div class="comment">' . bbcode2html($post['message']) . '</div>';
				App::trigger('forum_before_post_signature', array($post));
			echo '</td>';
		echo '</tr>';
	}
	echo '</tbody></table>';
} else {
	echo 'Cette discussion est vide.';
}

echo '</div>';