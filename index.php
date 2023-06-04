<?php

include_once( 'model/articles.php' );

$articles = getAllArticles();
?>

<h1>All Articles:</h1>
<a href="add.php">add</a>

<div>
	<?php foreach( $articles as $article ): ?>
		<div>
			<strong><?=$article['title']?></strong>
			<em><?=$article['date_created']?></em>
			<div>
				<?=$article['title']?>
			</div>
			<hr>
		</div>
	<?php endforeach ?>
</div>

