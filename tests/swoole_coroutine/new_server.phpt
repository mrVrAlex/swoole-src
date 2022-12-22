--TEST--
swoole_coroutine: new server
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
go(function () {
    $server = new OpenSwoole\Server('127.0.0.1');
    $server->on('receive', function () { });
    $server->start();
});
?>
--EXPECTF--
Warning: OpenSwoole\Server::start(): eventLoop has already been created, unable to start %s in %s on line %d
