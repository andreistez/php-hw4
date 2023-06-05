<?php

include_once( 'functions.php' );
include_once( 'model/articles.php' );
include_once( 'model/logs.php' );

writeLog();

$id		= isset( $_GET['id'] ) ? trim( $_GET['id'] ) : null;
$err	= checkIdError( $id );

if( $_SERVER['REQUEST_METHOD'] === 'POST' && ! $err && deleteArticle( $id ) ){
	echo "Article $id has been deleted!";
}	else {
	?>
	<form method="post">
		<fieldset>
			<legend>Are you sure you want to remove this article?</legend>
		</fieldset>

		<button>Submit</button>
	</form>

	<?php
	echo $err;
}
?>

<hr>
<a href="index.php">Move to main page</a>

