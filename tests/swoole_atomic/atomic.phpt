--TEST--
swoole_atomic: add/sub/get/cmpset
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$atomic = new OpenSwoole\Atomic(1);

Assert::same($atomic->add(199), 200);
Assert::same($atomic->sub(35), 165);
Assert::same($atomic->get(), 165);
Assert::assert($atomic->cmpset(165, 1));
Assert::assert(!$atomic->cmpset(1555, 0));
?>
--EXPECT--
