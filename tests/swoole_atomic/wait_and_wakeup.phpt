--TEST--
swoole_atomic: wait & wakeup
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$atomic = new OpenSwoole\Atomic(1);
var_dump($atomic->wakeup(), $atomic->get());

$atomic = new OpenSwoole\Atomic(0);
var_dump($atomic->wakeup(), $atomic->get());

$atomic = new OpenSwoole\Atomic(0);
var_dump($atomic->wait(1), $atomic->get());

$atomic = new OpenSwoole\Atomic(1);
var_dump($atomic->wait(1), $atomic->get());

?>
--EXPECT--
bool(true)
int(1)
bool(true)
int(1)
bool(false)
int(0)
bool(true)
int(0)
