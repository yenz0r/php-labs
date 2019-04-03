<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Site</title>
	<link href="style.css" rel="stylesheet">
</head>
<body>
<header>
	<center><h1>Regular expressions</h1></center>
	</header>
	<div class="container">
		<div>
			<h2>Form</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="name" name="name" required>
				<br><br><input type="text" placeholder="email" name="email" required>
				<br><br><textarea name="comment" placeholder="Input your comment.." cols="40" rows="3"></textarea>
				<br><br><input type="submit" name="send" value="Send"> <input type="reset" name="clear" value="Clear">
			</form>

			<?php
				include('defaults.php');
				$emailEdittor = new EmailEdittor();

				if (isset($_POST['send'])) {
					$text = $_POST['name'] . "|" . $_POST['email'] . "|" . $emailEdittor->hideSpam($_POST['comment']) . "\n";
				}
		
				file_put_contents($dataFile, $text, FILE_APPEND | LOCK_EX);
			?>  

		</div>

		<div>
			<h2>Display</h2>
			<hr/>  
			<?php
				if (filesize($dataFile) === 0) {
					echo "<h3>Sorry, but your file is empty..</h3>";
				} else {
					$filteredTextFromFile = file_get_contents($dataFile);

					$usersData = explode("\n", $filteredTextFromFile);
					array_pop($usersData);

					$userIndex = 0;

					if (isset($usersData)) { 
						echo '
						<table class="paleBlueRows">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Email</th>
								<th>Comment</th>
							</tr>
						</thead>';
						foreach ($usersData as $userInfo) {
							$userParams = explode("|", $userInfo);
							echo "<tr><td>$userIndex</td><td>$userParams[0]</td><td>$userParams[1]</td><td>$userParams[2]</td></tr>";
							$userIndex++;
						}
						echo '</table>';
					}  
				}    
			?>  
		</div>

		<div>
			<h2>Delete</h2>
			<hr/>  
			<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
				<select name="deleteType">
					<option value="deleteID" selected>Id</option>
					<option value="deleteName">Name</option>
					<option value="deleteEmail">Email</option>
				</select>
				<br><br><input type="text" placeholder="dataForDelete" name="dataForDelete" required>
				<br><br><input type="submit" name="delete" value="Delete"> <input type="reset" name="clear" value="Clear">
			</form>

			<?php
				$filteredTextFromFile = file_get_contents($dataFile);
				$usersData = explode("\n", $filteredTextFromFile);
				array_pop($usersData);

			?>  
		</div>
	</div>
</body>