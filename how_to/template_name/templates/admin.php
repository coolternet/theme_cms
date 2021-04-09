<!DOCTYPE html>
<html>

<head>
	<?php App::renderTemplate('head.php', $variables); ?>
	<link href="<?= App::getAsset('css/material.css') ?>" rel="stylesheet">
	<link href="<?= App::getAsset('css/bootstrap.min.css') ?>" rel="stylesheet">
	<link href="<?= App::getAsset('css/admin.css') ?>" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php App::trigger('head_admin'); ?>
</head>

<body class="tpl-admin admin grey lighten-3">
	<div id="admin-header" class="navbar-fixed">
		<nav class="blue-grey darken-3">
			<div class="nav-wrapper">
				<ul id="nav-mobile" class="show-on-medium-and-up">
					<li class="left">
						<a href="#" data-target="slide-out" class="sidenav-trigger">
							<i class="fa fa-bars fa-lg"></i>Menu
						</a>
					</li>
				</ul>
				<a href="<?= App::getURL('/') ?>"><?= App::getConfig('name') ?></a>
				<ul class="right hide-on-med-and-down">
					<?php if ($update_available): ?>
					<li>
						<a href="<?=$update_available ?: EVO_UPDATE_URL;?>" class="notification" title="Mise à jour">
							<i class="fa fa-tasks fa-lg fa-inverse"></i>Mise à jour
						</a>
					</li>
					<?php endif; ?>

					<?php if ($comments_nbr): ?>
					<li>
						<a href="index.php?page=comments" class="notification">
							<i class="fa fa-comment-dots fa-lg fa-inverse"></i> <?= __plural('Aucun commentaire|Un nouveau commentaire|%count% nouveaux commentaires', $comments_nbr) ?>
						</a>
					</li>
					<?php endif; ?>

					<?php if ($reports_nbr): ?>
					<li>
						<a href="index.php?page=reports" class="notification">
							<i class="fa fa-flag fa-lg fa-inverse"></i><?= __plural('Aucun signalement|Un nouveau signalement|%count% nouveaux signalements', $reports_nbr) ?>
						</a>
					</li>
					<?php endif; ?>

					<li class="admin_settings">
						<a href="<?= App::getURL('/') ?>"><i class="fa-fw fa-lg fa fa-sign-out-alt"></i> Retour au site</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>


	<div id="slide-out" class="blue-grey darken-4 sidenav sidenav-fixed">
		<div id="UserAcc">
			<div class="ui center aligned icon header">
				<?= get_avatar(App::getCurrentUser(), 64) ?>
				<?php App::renderTemplate('userdropdown.php', $variables); ?>
			</div>
		</div>
		<div class="hidden divider"></div>
		<?php include 'menu.php'; ?>
		<div class="hidden divider"></div>
		<div class="bottom center">
			Evo-CMS <?= EVO_VERSION ?>
		</div>
	</div>

	<div id="admin-wrapper">

	<!-- DEBUT CONTENU -->
		<div id="admin-page" class="en-container en-container-expand">
			<div class="alerts">
			<?php
				if (!empty($_success)) {
					echo '<div class="alert alert-success alert-dismissable auto-dismiss"><button type="button" class="close"
					data-dismiss="alert" aria-hidden="true">&times;</button>'.$_success.'</div>';
				}
				if (!empty($_warning)) {
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close"
					data-dismiss="alert" aria-hidden="true">&times;</button>'.$_warning.'</div>';
				}
				if (!empty($_notice)) {
					echo '<div class="alert alert-warning alert-dismissable"><button type="button" class="close"
					data-dismiss="alert" aria-hidden="true">&times;</button>'.$_notice.'</div>';
				}
			?>
			</div>
			<?= $_content ?>
		</div>
	<!-- FIN CONTENU -->


	<!-- DEBUT FOOTER -->
		<?php App::renderTemplate('footer.php', $variables); ?>
	<!-- FIN FOOTER -->

	</div><!-- admin-wrapper -->

	<script>
		if ((pos = window.location.href.indexOf('&')) > 1) {
			var page = window.location.href.substr(0, pos);
		} else {
			var page = null;
		}

		$('#admin-menu li').removeClass('active');

		$("#admin-menu a[href!='#']").each(function() {
		  if(this.href == window.location.href) {
				$('#admin-menu li').removeClass('active');
				$(this).parents('li').addClass('active');
				return false;
		  } else if(page && this.href.substr(0, page.length) == page) {
				$(this).parents('li').addClass('active');
		  }
		});

		if ($('#admin-menu li.active').length == 0) { // Last resort
			$("#admin-menu a[href!='#']").each(function() {
				if (this.href.indexOf('page=') > 0 && window.location.href.startsWith(this.href)) {
					$(this).parents('li').addClass('active');
				}
			});
		}

		$('[data-target="slide-out"]').click(function() {
			$('body').toggleClass('sidenav-open');
			$('.sidenav').toggleClass('open', $('body').hasClass('sidenav-open'));
			if ($('body').hasClass('sidenav-open')) {
				window.scrollTo(0, 0);
			}
			return false;
		});


		$('#admin-wrapper,#admin-header').click(function() {
			if ($('body').hasClass('sidenav-open')) {
				$('.sidenav').removeClass('open');
				$('body').removeClass('sidenav-open');
				return false;
			}
		});
	</script>
</body>
</html>
