<?php

if (empty($forums)) {
	echo '<div class="alert alert-warning">Il n\'y a aucun forum.</div>';
} else {
	foreach ($forums as $c) {
		echo '<div class="card mb-4">';
		echo '	<div class="card-header">' . html_encode($c['name']) . '</div>';
		echo '<table class="table table-lists forum-topics forum-forums">';
		echo '<thead><tr><td colspan="2">Forums</td><td>Sujets</td><td>Messages</td><td>Dernier message</td></tr></thead>';
		echo '<tbody>';

		foreach ($c['forums'] as $forum) {
			if ($forum['last_post'] > $last_visit && (!isset($topic_read[$forum['last_topic_id']]) || $topic_read[$forum['last_topic_id']] != $forum['last_post']))
				echo '<tr class="new">';
			else
				echo '<tr>';

			echo '<td class="forum-icon"><i class="fa-lg '.$forum['icon'].'"></i></td>';

			if ($forum['redirect']) {
				echo '<td class="forum-name"><em>Lien: </em>';
				echo '<a href="'.$forum['redirect'].'">' . html_encode($forum['name']) . '</a>';
				if ($can_redirect) {
					echo ' <a href="'.App::getURL('forums', ['id'=>$forum['id'], 'force'=>'1']).'" title="Ignorer la redirection"><i class="fa fa-eye"></i></a>';
				}
				echo '<br><span class="forum-description">' . bbcode2html($forum['description']) . '</span></td>';
				echo '<td class="num-posts">-</td>';
				echo '<td class="num-posts">-</td>';
				echo '<td class="last-post">---</td>';
			} else {
				echo '<td class="forum-name">';
				echo '<a href="'.App::getURL('forums', $forum['id']).'">' . html_encode($forum['name']) . '</a>';
				echo '<br><span class="forum-description">' . bbcode2html($forum['description']) . '</span></td>';
				echo '<td class="num-posts">' . $forum['num_topics'] . '</td>';
				echo '<td class="num-posts">' . $forum['num_posts']  . '</td>';

				echo '<td class="last-post">';

				if ($forum['tredirect'])
					echo '<em>Lien: </em><a href="'.App::getURL('forums', ['topic'=>$forum['last_topic_id']]).'">' . Format::truncate($forum['subject'], 22) . '</a><br>'.
							'<small>'. Format::today($forum['last_post'], true) .' par '.forum_user_link($forum['last_poster_id'], $forum['last_poster']).'</small>';
				elseif ($forum['subject'] !== null)
					echo '<a href="'.App::getURL('forums', ['pid'=>$forum['last_post_id']], '#msg'.$forum['last_post_id']).'">' . Format::truncate($forum['subject'], 28) . '</a><br>'.
							'<small>'. Format::today($forum['last_post'], true) .' par '.forum_user_link($forum['last_poster_id'], $forum['last_poster']).'</small>';
				else
					echo 'Ce forum est vide.';

				echo '</td>';
			}
		}
		echo '</tbody></table>';
		echo '</div>';
	}
}
