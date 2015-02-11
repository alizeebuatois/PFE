<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>markItUp! Universal markup editor</title>


	<!-- markItUp! toolbar settings -->


	<!-- jQuery -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>

	<!-- markItUp! -->

	<script src="ckeditor.js"></script>
	<link rel="stylesheet" href="sample.css">


</head>
<body>

	<div id = "conteneur">
		<h1>Ecrivons du bbcode</h1>
			<p> Code récupéré : </p>

						<?php 
			if (!empty($_POST))
				{
				$texte = $_POST['test'];
				echo $texte;
				}
			 ?>
			
			<form method="post" action="index.php">

				<p>
					<label> Ecrire ici en BBCode</label>

					<textarea class="ckeditor" name="test"></textarea>
				</p>

					<input type="submit" value="Tester"/>


			</form>
	</div>
</body>

</html>
