<?php

include_once( 'model/db.php' );
include_once( 'model/articles.php' );
include_once( 'model/categories.php' );
include_once( 'model/logs.php' );

writeLog();

$fields	= ['title' => '', 'content' => ''];
$err	= '';

if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
	$fields['title']	= trim( $_POST['title'] );
	$fields['content']	= trim( $_POST['content'] );
	$categories			= $_POST['cats'];

	if( $fields['title'] === '' || $fields['content'] === '' ){
		$err = 'Заполните все поля!';
	}	else{
		$article_id = addArticle( $fields, $categories );
		header( 'Location: article.php?id=' . $article_id );
	}
}
?>

<div class="form">
	<form method="post">
		Title:<br />
		<input type="text" name="title" value="<?=$fields['title']?>" /><br />
		Content:<br />
		<textarea name="content"><?=$fields['content']?></textarea><br />
		Categories:<br />
		<select name="cats[]" multiple>
			<?php
			foreach( getCategoriesList() as $cat )
				echo '<option value="' . $cat['id'] . '">' . $cat['name'] . '</option>';
			?>
		</select>
		<button>Send</button>
		<p><?=$err?></p>
	</form>
</div>

