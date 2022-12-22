--TEST--
swoole_process_pool: sysv msgqueue
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc';
if (function_exists('msg_get_queue') == false) {
    die("SKIP, no sysvmsg extension.");
}
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$pm = new ProcessManager;
const PROC_NAME = 'swoole_unittest_process_pool';

$pm->parentFunc = function ($pid) use ($pm) {
    for ($i = 0; $i < 5; $i++)
    {
        swoole_process::kill($pid, SIGUSR1);
        usleep(10000);
        Assert::assert(intval(shell_exec("ps aux | grep \"" . PROC_NAME . "\" |grep -v grep| awk '{ print $2}'")) > 0);
    }
    $pm->kill();
};

$pm->childFunc = function () use ($pm) {
    OpenSwoole\Util::setProcessName(PROC_NAME);

    Co::set(['log_level' => SWOOLE_LOG_ERROR]);

    $pool = new OpenSwoole\Process\Pool(2);

    $pool->on('workerStart', function (Swoole\Process\Pool $pool, int $workerId) use ($pm)
    {
        $pm->wakeup();
        swoole_timer::tick(1000, function () use ($workerId)
        {
            echo "sleep [$workerId] \n";
        });
        swoole_process::signal(SIGTERM, function () {
            swoole_event_exit();
        });
        swoole_event_wait();
    });

    $pool->start();
};

$pm->childFirst();
$pm->run();

?>
--EXPECT--
