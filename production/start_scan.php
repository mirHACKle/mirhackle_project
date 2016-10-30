<?php
	$cmd = "python scanner.py";

	$descriptorspec = array(
	   0 => array("pipe", "r"),   // stdin is a pipe that the child will read from
	   1 => array("pipe", "w"),   // stdout is a pipe that the child will write to
	   2 => array("pipe", "w")    // stderr is a pipe that the child will write to
	);
	flush();
	$process = proc_open($cmd, $descriptorspec, $pipes, realpath('./'), array());

	if (is_resource($process)) {
	    while ($s = fgets($pipes[1])) {
	        flush();
	    }
	}

	$finished = "finished";

	return $finished;
?>