--TEST--
swoole_process: setaffinity
--SKIPIF--
<?php
require __DIR__ . '/../include/skipif.inc';
skip_if_no_process_affinity();
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
$r = Swoole\Process::setaffinity([0]);
Assert::assert($r);
if (OpenSwoole\Util::getCPUNum() > 1) {
    $r = Swoole\Process::setaffinity([0, 1]);
    Assert::assert($r);
}
echo "SUCCESS";
?>
--EXPECT--
SUCCESS
