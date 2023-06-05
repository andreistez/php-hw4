<?php

include_once( 'model/articles.php' );
include_once( 'model/categories.php' );
include_once( 'functions.php' );
include_once( 'model/logs.php' );

writeLog();

$fields 	= [];
$success	= false;

if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
	$id		= isset( $_GET['id'] ) ? trim( $_GET['id'] ) : 0;
	$err	= checkIdError( $id );

	if( ! $id || ! ( $fields = getArticle( $id ) ) ){
		$err = 'Error while getting article.';
	}
}	else{
	$id			= isset( $_POST['id'] ) ? trim( $_POST['id'] ) : 0;
	$err		= checkIdError( $id );
	$fields['title']	= isset( $_POST['title'] ) ? trim( $_POST['title'] ) : '';
	$fields['content']	= isset( $_POST['content'] ) ? trim( $_POST['content'] ) : '';
	$fields['cats']		= $_POST['cats'];

	if( ! $fields['title'] || ! $fields['content'] ){
		$err = 'Please fill all fields';
	}	else{
		if( editArticle( $id, $fields ) ) $success = true;
		else $err = 'Error while editing an article.';
	}
}

if( $success ){
	echo "
		<h2>Thank you, article $id has been updated!</h2>
		<hr />
		<a href=\"article.php?id={$id}\">See updates</a>
	";
}	else{
	?>
	<form method="post">
		<fieldset>
			<label for="title">
				<input id="title" type="text" name="title" value="<?=$fields['title']?>" placeholder="Title" />
			</label>
			<label for="content">
				<textarea id="content" name="content" placeholder="Content"><?=$fields['content']?></textarea>
			</label>
			<label for="cats">
				<select name="cats[]" multiple id="cats">
					<?php
					$cats		= getArticleCategoriesField( $id );
					$all_cats	= getCategoriesList();

					if( ! empty( $all_cats ) ){
						foreach( $all_cats as $cat ){
							$selected = in_array( $cat['id'], $cats ) ? ' selected' : '';
							echo '<option value="' . $cat['id'] . '"' . $selected . '>' . $cat['name'] . '</option>';
						}
					}
					?>
				</select>
			</label>
			<input type="hidden" name="id" value="<?=$id?>" />
		</fieldset>

		<button>Submit</button>
	</form>

	<?php
	echo $err;
}
?>

<hr>
<a href="index.php">Move to main page</a>

