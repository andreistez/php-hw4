<?php

require_once 'functions.php';
require_once 'model/articles.php';
require_once 'model/categories.php';
include_once( 'model/logs.php' );

writeLog();

$id		= trim( $_GET['id'] );
$err	= '';

if( ! $id || ( $err = checkIdError( $id ) ) ){
	echo '<h1>' . ( $err ?: 'Error! No such article.' ) . '</h1>';
	die();
}

if( ! $article = getArticle( $id ) ){
	echo '<h1>Error! Can\'t fetch article.</h1>';
	die();
}
?>

<article>
	<h1><?=$article['title']?></h1>
	<div><?=$article['date_created']?></div>
	<hr />
	<div>
		<?=$article['content']?>
		<h4>In categories: <?=implode( ', ', getArticleCategoriesField( $id, 'name' ) )?></h4>
	</div>
</article>

<hr>
<a href="edit.php?id=<?=$id?>">EDIT</a><br />
<a href="delete.php?id=<?=$id?>">DELETE</a><br />
<a href="index.php">Move to main page</a>

