<?php

function getCategoriesList(): array
{
	$sql	= "SELECT id, name FROM categories ORDER BY name";
	$query	= dbQuery( $sql );

	return $query->fetchAll();
}

function getArticleCategories( int $article_id ): array
{
	$sql = "
		SELECT categories.id, categories.name
		FROM articles_categories
			JOIN categories
			ON category_id=categories.id
		WHERE article_id=$article_id
		ORDER BY categories.name
	";

	return dbQuery( $sql )->fetchAll();
}

function getArticleCategoriesField( int $article_id, string $field = 'id' ): array
{
	$cats = getArticleCategories( $article_id );

	return array_map( fn( $item ) => $item[ $field ], $cats );
}

