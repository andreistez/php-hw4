<?php

include_once( 'db.php' );

function getAllArticles() : array
{
	return dbQuery( "SELECT * FROM articles ORDER BY date_created DESC" )->fetchAll();
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

function getArticle( int $article_id ): ?array
{
	if( ! $article_id ) return null;

	$article = dbQuery( "SELECT * FROM articles WHERE id=$article_id" )->fetch();

	return is_array( $article ) ? $article : null;
}

function editArticle( int $article_id, array $fields ): bool
{
	dbQuery( "UPDATE articles SET title='{$fields['title']}', content='{$fields['content']}' WHERE id=$article_id" );
	dbQuery( "DELETE FROM articles_categories WHERE article_id=$article_id" );

	if( ! empty( $fields['cats'] ) ){
		foreach( $fields['cats'] as $cat )
			dbQuery(
				"INSERT INTO articles_categories VALUES (:article_id, :category_id)",
				[
					'article_id'	=> $article_id,
					'category_id'	=> $cat
				]
			);
	}

	return true;
}

function deleteArticle( int $id ): bool
{
	if( ! $id ) return false;

	dbQuery( "DELETE FROM articles WHERE id=:id", ['id' => $id] );
	dbQuery( "DELETE FROM articles_categories WHERE article_id=:id", ['id' => $id] );

	return true;
}

