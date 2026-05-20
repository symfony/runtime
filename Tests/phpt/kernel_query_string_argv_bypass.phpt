--TEST--
Test that argv is ignored on web requests even when $_GET parses empty (QUERY_STRING gap)
--INI--
display_errors=1
register_argc_argv=1
--FILE--
<?php

// A real web request with QUERY_STRING="=+--env=prod+--no-debug":
// parse_str() drops the leading "=" token so $_GET is empty,
// but the web SAPI builds argv from the raw query and feeds attacker flags in.
$_GET = [];
$_SERVER['QUERY_STRING'] = '=+--env=prod+--no-debug';
$_SERVER['argc'] = 3;
$_SERVER['argv'] = ['=', '--env=prod', '--no-debug'];

require $_SERVER['SCRIPT_FILENAME'] = __DIR__.'/kernel.php';

?>
--EXPECTF--
OK Kernel (env=dev) foo_bar
