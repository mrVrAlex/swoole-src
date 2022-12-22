--TEST--
swoole_socket_coro: construct parse arguments failed
--SKIPIF--
<?php
require __DIR__ . '/../include/skipif.inc';
skip_if_php_version_lower_than('7.2');
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
var_dump(new OpenSwoole\Coroutine\Socket());
?>
--EXPECTF--
Fatal error: Uncaught ArgumentCountError: OpenSwoole\Coroutine\Socket::__construct() expects at least 2 %s, 0 given in %s/tests/swoole_socket_coro/construct_parse_args_failed.php:3
Stack trace:
#0 %s/tests/swoole_socket_coro/construct_parse_args_failed.php(3): OpenSwoole\Coroutine\Socket->__construct()
#1 {main}
  thrown in %s/tests/swoole_socket_coro/construct_parse_args_failed.php on line 3
