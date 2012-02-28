<?php

require_once 'includes/filter-wrapper.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
	header('Location: index.php');
	exit;
}


require_once 'includes/db.php';


$sql = $db->prepare('
	SELECT id, title, director, release_date
	FROM movies
	WHERE id = :id
');


$sql->bindValue(':id', $id, PDO::PARAM_INT);


$sql->execute();


$results = $sql->fetch();


if (empty($results)) {
	header('Location: index.php');
	exit; 
}

?><!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $results['title']; ?> &middot; Movies</title>
	 <link rel="stylesheet" href="css/general.css">
</head>
<body class="single">
	
		<div class="wrapper">
			<h1><?php echo $results['title']; ?></h1>
			<p><strong>Release Date</strong> : <?php echo $results['release_date']; ?></p>
			
			<p><strong>Director :</strong> <?php echo $results['director']; ?></p>
		</div>
	
</body>
</html>













