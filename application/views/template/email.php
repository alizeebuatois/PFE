<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="<?php echo css_url('app'); ?>" />
	</head>
	<body>
		<div style="width:100%;height:100%;padding:35px;">
			<div class="row">
				<div class="columns large-12 panel radius">
					<p><a href="<?php echo base_url(); ?>"><?php echo img('banner.png','CVI','600px'); ?></a></p>
					<p>Bonjour<?php if (isset($fullName)) echo ' '.$fullName; ?>,</p>
					<p><?php echo $message; ?></p>
					<?php if (isset($sign)): ?>
					<p><?php echo $sign; ?></p>
					<?php else: ?>
					<p>Bonne journée, <br /><strong>L'équipe du Centre de Vaccinations Internationales</strong></p>
					<?php endif; ?>
				</div>
			</div>
			<?php if (!isset($sign)): ?>
			<div class="row">
				<div class="columns large-10 large-centered text-center">
					<small>Ce message a été envoyé automatiquement, merci de ne pas y répondre.<br /><a href="<?php echo base_url(); ?>"><?php echo base_url(); ?></a></small>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</body>
</html>