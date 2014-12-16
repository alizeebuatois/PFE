<div class="row">
	<div class="columns large-12 panel radius">
		<div class="row">
			<div class="columns large-6">
				<p>
					<strong>Consultation des voyageurs</strong>
					<br />2 boulevard Tonnellé
					<br />37044 Tours Cedex
					<br />Par téléphone au : 02 47 47 38 49
					<br />ou en remplissant le formulaire ci-contre.
				</p>
				<div class="hide-for-small">
					<?php echo img('contact-img.jpg','contact'); ?>
				</div>
			</div>
			<div class="columns large-6">
				<?php if( validation_errors() != '' ): ?>
				<div class="row">
					<div class="columns large-12">
						<div data-alert class="alert-box warning radius">
							<?php echo validation_errors(); ?>
							<a href="#" class="close">&times;</a>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<form method="post">					
					<input type="text" name="lastname" id="lastname" placeholder="Nom" value="<?php echo set_value('lastname'); ?>" />			
					<input type="text" name="firstname" id="firstname" placeholder="Prénom" value="<?php echo set_value('firstname'); ?>" />
					<input type="text" name="email" id="email" placeholder="Adresse e-mail" value="<?php echo set_value('email'); ?>" />				
					<input type="text" name="subject" id="subject" placeholder="Sujet" value="<?php echo set_value('subject'); ?>" />				
					<textarea name="message" id="message" placeholder="Votre message" rows="5"><?php echo set_value('message'); ?></textarea>			
					<input type="submit" value="Envoyer" class="custom-button-class" />
					<input type="reset" value="Reset" class="custom-button-class" />
					&nbsp;<span class="label secondary radius">Tous les champs sont obligatoires.</span>
				</form>
			</div>
		</div>	
	</div>
</div>