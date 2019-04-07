<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Shop</title>

	<style type="text/css">
		.container {
			display: flex;
			justify-content: space-around;
			padding: 2em;
			box-sizing: border-box;
		}
		  
		.container div {
			width: 20%;
		}

		.container h2 {
			color: green;
			text-align: center;
		}

		h1 {
			color: red;
		}

		@media(max-width: 500px) {
			.container {
				flex-direction: column;
			}
		}
	</style>
</head>

<body background-image: url('https://www.ubackground.com/_ph/21/416658223.jpg');>
	<header>
		<center><h1>Shop</h1></center>
	</header>
	<div class="container">
		<div>
			<h2>Add</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="id" name="id" required>
				<br><input type="text" placeholder="name" name="name" required>
				<br><input type="text" placeholder="price" name="price" required>
				<br><textarea name="description" placeholder="description" cols="18" rows="3"></textarea>
				<br><input type="submit" name="add" value="Add"> <input type="reset" name="clear" value="Clear">
			</form>
			<?php
				include('const.php');

				function isIdCorrect($inputId) {
					$numbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
					for($i = 0; $i < mb_strlen($inputId); $i++) {
						if (!in_array($inputId{$i}, $numbers)) {
							return false;
						}
					}
					return true;
				}
				function isIdUnical($inputId, $itemsArr) {
					if (isset($itemsArr)) { //secure from warrnings
						foreach ($itemsArr as $fields) {
							if ($fields[0] == $inputId) {
								return false; 
							}
						}
					}
					return true;
				}

				$file = fopen("src/file_shop.csv", 'r+') or die("Не удалось подключть файл");

				$itemsArr = [];
				for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
					$itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
				}

				if (isset($_POST['add'])) {
					if ((!isIdCorrect($_POST['id'])) or (!isIdUnical($_POST['id'], $itemsArr))) {
						echo "Status : Incorrect id..";
					} else {
						fputcsv($file, array($_POST['id'], $_POST['name'], $_POST['price'], $_POST['description']));
						echo "Status : Done!";
					}
				}

				fclose($file);
			?>
		</div>
		<div>
			<h2>Delete</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="id" name="idDelete" required>
				<br><input type="text" placeholder="name" name="nameDelete" required>
				<br><input type="submit" name="delete" value="Delete"> <input type="reset" name="clear" value="Clear">
			</form>
			<?php
				include('const.php');

				if (isset($_POST['delete'])) {
					$file = fopen("src/file_shop.csv", 'r+') or die("Не удалось подключть файл");
					$itemsArr = [];
					
					$isDeleted = false;
					for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
						if ($data[0] != $_POST['idDelete'] and $data[1] != $_POST['nameDelete']) {
							$itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
						} else {
							$isDeleted = true;
						}
					}
					
					fclose($file);

					$file = fopen("src/file_shop.csv", 'w+') or die("Не удалось подключть файл");
					if (isset($itemsArr)) {
						foreach ($itemsArr as $fields) {
							fputcsv($file, $fields);
						}
					}
					fclose($file);

					if ($isDeleted) {
						echo "Status : Done!";
					} else {
						echo "Status : Incorrect params..";
					}
				}
			?>
		</div>
		<div>
			<h2>List</h2>
			<hr/>
			<ul>
			<?php
				include('const.php');

				$file = fopen("src/file_shop.csv", 'r') or die("Не удалось подключть файл");
				$itemsArr = [];
				for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
					$itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
				}
				fclose($file);

				if (isset($itemsArr)) { //secure from warrnings
					foreach ($itemsArr as $fields) {
						echo "<li><a href='/2nd-lab.php?p=$fields[1]'>$fields[1]</a></li>";
					}
				}
			?>
			</ul>
		</div>
		<div>
			<h2>Info</h2>
			<hr/>
			<ul type="circle">
				<?php
					include('const.php');

					$file = fopen("src/file_shop.csv", 'r') or die("Не удалось подключть файл");
					$itemsArr = [];
					for($i=0; $data = fgetcsv($file, 1000,","); $i++) {
						$itemsArr[] = array($data[ID], $data[PRICE], $data[NAME], $data[DESCRIPTION]);
					}
					fclose($file);

					if (empty($_GET)) {
						echo "Choose any link..";
					} else {
						foreach ($itemsArr as $fields) {
							if ($fields[1] == $_GET['p']) {
								$nameFields = array("Id", "Name", "Price", "Description");
								for ($i = 0; $i < count($fields); $i++) {
									echo "<li><p>$nameFields[$i] : $fields[$i]</p></li>";
								}
								$newPrice = number_format((float)$fields[2] * 0.85, 2, '.', '');
								echo "<li><p>Without 15% : $newPrice$</p></li>";
								break;
							}
						}
					}
				?>
			</ul>
		</div>
	</div>
	<hr/>
	<hr/>
	<center><h1>File Manager</h1></center>
	<div class="container">
		<div>
		<h2>New File</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="File name" name="file-name" required>
				<br><textarea name="file-body" placeholder="File body" cols="18" rows="3"></textarea>
				<br><input type="submit" name="new-file" value="Add"> <input type="reset" name="clear" value="Clear">
			</form>
			<?php
			   if (isset($_POST['new-file'])) {
					$file_name = $_POST['file-name'];
					$file = fopen($file_name, 'w+');
					$flag = fwrite($file, $_POST['file-body']);
					if ($flag)
						echo 'File added.';
					else 
						echo 'Error..';
					fclose($file);
				}
			?>
		</div>
		<div>
		<h2>Delete File</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="File name" name="file-name" required>
				<br><input type="submit" name="delete-file" value="Delete"> <input type="reset" name="clear" value="Clear">
			</form>
			<?php
			   if (isset($_POST['delete-file'])) {
					$file_name = $_POST['file-name'];
					if (file_exists($file_name))
						$flag = unlink($file_name);
					if ($flag)
						echo 'File deleted.';
					else 
						echo 'Error..';
				}
			?>
		</div>

		<div>
		<h2>Remove file</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="Full path for file" name="file-name" required>
				<br><input type="text" placeholder="New directory" name="new-dir" required>
				<br><input type="submit" name="remove-file" value="Remove"> <input type="reset" name="clear" value="Clear">
			</form>
			<?php
			$hello = "hello";
			   if (isset($_POST['remove-file'])) {
					$old_file_name = realpath($_POST['file-name']);
					print_r($old_file_name);
					$new_file_name = $_POST['new-dir'] . "/" . basename($_POST['file-name']);
					print_r($new_file_name);

					if (file_exists($old_file_name)) {
						if (rename($old_file_name, $new_file_name))
							echo 'File removed.';
						else 
							echo 'Error..';
					}
				}
			?>
		</div>

		<div>
			<h2>Show / Remake</h2>
			<hr/>
			<form method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
				<br><input type="text" placeholder="Full path for file" name="file-name" required>
				<br><textarea name="file-body" placeholder="File body" cols="18" rows="3"><?php echo printFile(); ?></textarea>
				<br><input type="submit" name="print-file" value="Print"> <input type="submit" name="save-file" value="Save"> <input type="reset" name="clear" value="Clear">
			</form>
			<?php
				function printFile() {
					if ((isset($_POST['print-file'])) && (file_exists($_POST['file-name']))) {
						echo file_get_contents($_POST['file-name']);
					}
				}

				if (isset($_POST['save-file'])) {
					$file = fopen($_POST['file-name'], 'r+');
					fwrite($file, $_POST['file-body']);
					fclose($file);
				}
			?>
		</div>
	</div>
</body>
</html>