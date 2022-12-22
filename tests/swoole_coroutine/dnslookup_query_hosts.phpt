--TEST--
swoole_coroutine: dnslookup query hosts
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

use Swoole\Coroutine;
use Swoole\Coroutine\System;


Co::run(function () {
    Assert::eq(System::dnsLookup('localhost', 3, AF_INET), '127.0.0.1');
});

?>
--EXPECT--
