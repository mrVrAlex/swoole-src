--TEST--
swoole_process_pool: enable coroutine
--CONFLICTS--
all
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc';
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$pool = new OpenSwoole\Process\Pool(1, SWOOLE_IPC_NONE, 0, true);
$counter = new OpenSwoole\Atomic(0);

$pool->on('workerStart', function (Swoole\Process\Pool $pool, int $workerId) use ($counter) {
    if ($counter->get() <= 5) {
        co::usleep(50000);
        $counter->add(1);
        echo "hello world\n";
    }
});

$pool->on("workerStop", function ($pool, $data) use ($counter) {
    echo "worker stop\n";
    if ($counter->get() > 5) {
        $pool->shutdown();
    }
});

$pool->start();
?>
--EXPECT--
hello world
worker stop
hello world
worker stop
hello world
worker stop
hello world
worker stop
hello world
worker stop
hello world
worker stop
