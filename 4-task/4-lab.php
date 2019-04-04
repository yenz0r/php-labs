<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Site</title>
	<link href="sstyle.css" rel="stylesheet">
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
				$userChecker = new UserChecker();

				if (isset($_POST['send'])) {
					if (($emailEdittor->checkEmail($_POST['email'])) && ($userChecker->checkUserName($_POST['name']))) {
						$text = $_POST['name'] . $separateInfoCharacter . $_POST['email'] . $separateInfoCharacter . $emailEdittor->hideSpam($_POST['comment']) . $separateFileCharacter;
						file_put_contents($dataFile, $text, FILE_APPEND | LOCK_EX);
						echo "<p>Status: Success!</p>";
					} else {
						echo "<p>Status: Incorrect user data..</p>";
					}
				}
			?>  

		</div>

		<div>
			<h2>Display</h2>
			<hr/>  
			<?php
				if (filesize($dataFile) === 0) {
					echo "<p>Sorry, but your file is empty..</p>";
				} else {
					$filteredTextFromFile = file_get_contents($dataFile);

					$usersData = explode("$separateFileCharacter", $filteredTextFromFile);
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
							$userParams = explode($separateInfoCharacter, $userInfo);
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
					<option value="deleteName" selected>Name</option>
					<option value="deleteEmail">Email</option>
				</select>
				<br><br><input type="text" placeholder="Param" name="dataForDelete" required>
				<br><br><input type="submit" name="delete" value="Delete"> <input type="reset" name="clear" value="Clear">
			</form>

			<?php
				if(isset($_POST['deleteType'], $_POST['delete'])){
					$select = $_POST['deleteType'];
					switch ($select) {
						case 'deleteName':
							$indexDeleteParam = 0;
							break;
						case 'deleteEmail':
							$indexDeleteParam = 1;
							break;
						default:
							$indexDeleteParam = -1;
							break;
					}

					$filteredTextFromFile = file_get_contents($dataFile);
					$usersData = explode($separateFileCharacter, $filteredTextFromFile);
					array_pop($usersData);

					$resArr = [];

					$numOfDeletedComments = 0;

					if (isset($usersData)) { 
						foreach ($usersData as $userInfo) {
							$userParams = explode($separateInfoCharacter, $userInfo);
							if ($userParams[$indexDeleteParam] === $_POST['dataForDelete']) {
								$numOfDeletedComments++;
							} else {
								array_push($resArr, $userInfo);
							}
						}
					}

					foreach ($resArr as $item) {
						file_put_contents($dataFile, $item . $separateFileCharacter);
					}
					echo "<p>Status : deleted " . $numOfDeletedComments . " comment(s)</p>";
				}
			?>  
		</div>

		<div>
			<h2>Find</h2>
			<hr/>  
			<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
				<select name="findType">
					<option value="findName" selected>Name</option>
					<option value="findEmail">Email</option>
				</select>
				<br><br><input type="text" placeholder="findParam" name="dataForFind" required>
				<br><br><input type="submit" name="find" value="Find"> <input type="reset" name="clear" value="Clear">
			</form>

			<?php
				if (isset($_POST['findType'], $_POST['find'])) {
					if (filesize($dataFile) !== 0) {
						$select = $_POST['findType'];
						switch ($select) {
							case 'findName':
								$indexFindParam = 0;
								break;
							case 'findEmail':
								$indexFindParam = 1;
								break;
							default:
								$indexFindParam = -1;
								break;
						}
						
						$filteredTextFromFile = file_get_contents($dataFile);

						$usersData = explode($separateFileCharacter, $filteredTextFromFile);
						array_pop($usersData);

						$userIndex = 0;
						foreach ($usersData as $userInfo) {
							$userParams = explode($separateInfoCharacter, $userInfo);
							if ($userParams[$indexFindParam] === $_POST['dataForFind']) {
								echo "<h4>Index : $userIndex</h4>";
								echo "<li><em>Name</em> : $userParams[0]</li>";
								echo "<li><em>Email</em> : $userParams[1]</li>";
								echo "<li><em>Comment</em> : $userParams[2]</li>";
								$userIndex++;
							}
						}
					} else {
						echo "<p>Sorry, but your file is empty..</p>";
					}
				}	  
			?>  
		</div>
	</div>
</body>