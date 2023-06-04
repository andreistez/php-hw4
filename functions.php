<?php

function checkIdError( $id ): string
{
	return ( $id && ctype_digit( $id ) ) ? '' : 'ID is missing or incorrect';
}

