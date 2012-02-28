<?php 

require_once 'includes/filter-wrapper.php';

$errors = array ();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
	}

$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$release_date = filter_input(INPUT_POST, 'release_date', FILTER_SANITIZE_STRING);
$director = filter_input(INPUT_POST, 'director', FILTER_SANITIZE_STRING);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(empty($title)) {
		$errors['title'] = true;
	}
	
	if (empty($release_date)) {
		$errors['release_date'] = true;
	}
	
	if (empty($director)) {
		$errors['director'] = true;
	}
	
	
	
	if (empty($errors)) {
		require_once 'includes/db.php';
		
		$sql = $db->prepare('
			UPDATE movies
			SET title = :title, release_date = :release_date, director = :director
			WHERE id = :id
		');
		
		$sql->bindValue(':title', $title, PDO::PARAM_STR);
		$sql->bindValue(':release_date', $release_date, PDO::PARAM_STR);
		$sql->bindValue(':director', $director, PDO::PARAM_STR);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		
		$sql->execute();
		
		header('Location: index.php');
	}
}else {
	require_once 'includes/db.php';
	$sql = $db->prepare('
	SELECT id, title, release_date, director
	FROM movies
	WHERE id = :id
	');
	
	$sql->bindValue(':id', $id, PDO::PARAM_INT);
	
	$sql->execute();
	$results = $sql->fetch();
	$title = $results['title'];
	$release_date = $results['release_date'];
	$director = $results['director'];
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit a Movie</title>
	<link rel="stylesheet" href="css/general.css">
</head>

<body class="edit">

	<div class="wrapper">
	
	<h1>Edit Movie Information</h1>

		<form method="post" action="edit.php?id=<?php echo $id; ?>"> 
			<div class = "formfield">
				<label for="title">Movie Title<?php if (isset($errors['title'])) : ?> <strong>is required</strong><?php endif; ?></label>
				<input id="title" name="title" value="<?php echo $title; ?>" required>
			</div>
			<div class = "formfield">
				<label for="release_date">Release Date<?php if (isset($errors['release_date'])) : ?> <strong>is required</strong><?php endif; ?></label>
				<input id="release_date" name="release_date" value="<?php echo $release_date; ?>" required>
			   
			</div>
			 <div class = "formfield">
				<label for="director">Director<?php if (isset($errors['director'])) : ?> <strong>is required</strong><?php endif; ?></label>
				<input id="director" name="director" value="<?php echo $director; ?>" required>
			   
			</div>
			
			<button id="editsub" type="submit">Update</button>
		</form>
	</div>
</body>
</html>