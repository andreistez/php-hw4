<?php

include_once( 'model/articles.php' );
include_once( 'model/categories.php' );

$articles = getAllArticles();
?>

<h1>All Articles:</h1>
<a href="add.php">add</a>

<div>
	<?php foreach( $articles as $article ): ?>
		<div>
			<a href="article.php?id=<?=$article['id']?>"><strong><?=$article['title']?></strong></a>
			<em><?=$article['date_created']?></em>
			<h4>In categories: <?=implode( ', ', getArticleCategoriesField( $article['id'], 'name' ) )?></h4>
			<div>
				<?=$article['title']?>
			</div>
			<a href="edit.php?id=<?=$article['id']?>"><strong>EDIT</strong></a>
			<hr>
		</div>
	<?php endforeach ?>
</div>

