<?php

include_once( 'db.php' );

function getAllArticles() : array
{
	$sql	= "SELECT * FROM articles ORDER BY date_created DESC";
	$query	= dbQuery( $sql );

	return $query->fetchAll();
}

function addArticle( array $fields, array $categories = [] ): bool
{
	dbQuery( "INSERT INTO articles (title, content) VALUES (:title, :content)", $fields );
	$article_id = dbInstance()->lastInsertId();

	if( ! empty( $categories ) ){
		foreach( $categories as $category_id )
			dbQuery(
				"INSERT INTO articles_categories VALUES (:article_id, :category_id)",
				[
					'article_id'	=> $article_id,
					'category_id'	=> $category_id
				]
			);
	}

	return true;
}

function getCategoriesList(): array
{
	$sql	= "SELECT id, name FROM categories ORDER BY name";
	$query	= dbQuery( $sql );

	return $query->fetchAll();
}

function getArticleCategories( int $article_id ): array
{
	$sql = "
		SELECT categories.name
		FROM articles_categories
			JOIN categories
			ON category_id=categories.id
		WHERE article_id=$article_id
		ORDER BY categories.name
	";
	$cats = dbQuery( $sql )->fetchAll();

	if( empty( $cats ) ) return [];

	return array_map( fn( $item ) => $item['name'], $cats );
}

