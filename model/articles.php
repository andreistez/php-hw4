<?php

include_once( 'db.php' );

function getAllArticles() : array
{
	$sql	= "SELECT * FROM articles ORDER BY date_created DESC";
	$query	= dbQuery( $sql );

	return $query->fetchAll();
}

function addArticle( array $fields ): bool
{
	$sql = "INSERT INTO articles (title, content) VALUES (:title, :content)";
	dbQuery( $sql, $fields );

	return true;
}

