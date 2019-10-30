<?php

/*
 * This file is part of the https://github.com/petruchek/problem.appjobs
 *
 * @author Val Petruchek <petruchek@gmail.com>
 */

require_once(__DIR__."/class.job_matcher.php");

$matcher = new Job_Matcher(["bike","driver's license"]);

$handle = fopen ("php://stdin", "r");

while (true)
{
	if (! ($s = trim(fgets($handle, 1024))) )
		break;

	$matcher->incoming_company($s);
}
fclose($handle);

print_r($matcher->get_matches());
