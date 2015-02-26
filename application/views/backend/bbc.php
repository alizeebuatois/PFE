<div class="row">
	<?php require_once(__DIR__.'/backend-nav.php'); ?>
	<div class="columns large-9">
		<div class="panel radius">
			<h5>BBCode</h5>

			<form method="post" action="">

							<?php 
			if (!empty($_POST))
				{
				$texte = $_POST['test'];
				$texte2 = $_POST['test2'];
				echo $texte;
				echo "<br />";
				echo $texte2;
				}
			 ?>
				<p>
					<label> Ecrire ici en CKEDITOR :</label>

					<textarea class="ckeditor" name="test"></textarea>

					<textarea class="ckeditor" name="test2"></textarea>

					<input type="submit" value="Tester"/>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo js_url('ckeditor/ckeditor'); ?>"></script>