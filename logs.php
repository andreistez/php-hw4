<?php

include_once('model/logs.php');

$logs_files = getLogsFiles();
?>

<div class="logs">
	<?php
	foreach( $logs_files as $log ){
		?>
		<div class="log">
			<h2><?=$log?></h2>
			<a href="log.php?name=<?=$log?>">Read more</a>
		</div>
		<?php
	}
	?>
</div>

