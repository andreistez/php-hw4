<?php

include_once( 'model/logs.php' );

$log_name = $_GET['name'] ?? '';

if( ! $log_name ){
	echo '<h2>No log passed.</h2>';
}	else{
	$lines = getLogFileContent( $log_name );

	if( empty( $lines ) ){
		echo '<h2>Log name is incorrect. Please come back later.</h2>';
	}	else{
		echo '<style>td{padding: 5px}</style>';
		echo "<h2>$log_name:</h2><hr />";
		?>
		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Time</th>
					<th>IP</th>
					<th>URI</th>
					<th>Referer</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach( $lines as $num => $line ){
					$pretty = explode( '|', $line );
					?>
					<tr>
						<td><?=++$num?></td>
						<td><?=$pretty[0]?></td>
						<td><?=$pretty[1]?></td>
						<td><?=$pretty[2]?></td>
						<td><?=( $pretty[3] ?? '' )?></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
	}
}
?>

<hr>
<a href="logs.php">Move to logs page</a><br />
<a href="index.php">Move to main page</a>

