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
				echo $texte;
				}
			 ?>
				<p>
					<label> Ecrire ici en CKEDITOR :</label>

					<textarea class="ckeditor" name="test"><ol >
                    <li>Réhydratation orale et régime anti-diarrhéique adapté (riz, bananes…)<br/>  <span> </span>
                        <ol style='list-style-image: url(./PDF/fleche.jpg);'><br/>    
                            <li>TIORFANOR &reg;<br/>1 comprimé  à la 1ère diarrhée, puis 1 comprimé matin et soir  si la diarrhée persiste. 
                            </li><br/>

                        </ol><br/>
                    </li>
                    <li><b>Si la diarrhée est grave</b> : d'emblée sévère (fièvre, sang ou glaire dans les selles, très liquide…) ou persistante au-delà de 24 heures avec plus de 4 selles par jour : <b>Consultation médicale sur place</b>
                    </li>
                </ol></textarea>
				</p>

					<input type="submit" value="Tester"/>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo js_url('ckeditor/ckeditor'); ?>"></script>