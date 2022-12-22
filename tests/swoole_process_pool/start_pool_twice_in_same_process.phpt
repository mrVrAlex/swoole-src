--TEST--
swoole_process_pool: start pool twice in the same process
--CONFLICTS--
all
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

use Swoole\Process\Pool;

$pool = new OpenSwoole\Process\Pool(1);

$pool->on("WorkerStart", function (Pool $pool, $workerId) {
    $pool->shutdown();
});

$pool->start();

$pool = new OpenSwoole\Process\Pool(1);

$pool->on("WorkerStart", function (Pool $pool, $workerId) {
    $pool->shutdown();
});

$pool->start();
echo "DONE\n";
?>
--EXPECT--
DONE
