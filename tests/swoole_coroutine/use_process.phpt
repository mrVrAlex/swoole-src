--TEST--
swoole_coroutine: user process
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$pm = new SwooleTest\ProcessManager();

const SIZE = 8192 * 5;
const TIMES = 10;
$pm->parentFunc = function () use ($pm) {
    $client = new OpenSwoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
    $client->set([
        "open_eof_check" => true,
        "package_eof" => "\r\n\r\n"
    ]);
    $r = $client->connect('127.0.0.1', $pm->getFreePort(), -1);
    if ($r === false) {
        echo "ERROR";
        exit();
    }
    $client->send("SUCCESS");
    for ($i = 0; $i < TIMES; $i ++) {
        $ret = $client->recv();
        Assert::same(strlen($ret), SIZE + 4);
    }
    $client->close();
    $pm->kill();
};

$pm->childFunc = function () use ($pm) {
    $serv = new OpenSwoole\Server('127.0.0.1', $pm->getFreePort());
    $serv->set([
        "worker_num" => 1,
        'log_file' => '/dev/null'
    ]);

    $proc = new OpenSwoole\Process(function ($process) use ($serv) {
       $data = json_decode($process->read(), true);
        for ($i = 0; $i < TIMES/2; $i ++) {
            go (function() use ($serv,$data, $i){
                //echo "user sleep start\n";
                co::usleep(10000);
                //echo "user sleep end\n";
                $serv->send($data['fd'], str_repeat('A', SIZE) . "\r\n\r\n");
                //echo "user process $i send ok\n";
            });
        }
        OpenSwoole\Event::wait();
    }, false, 1);

    $serv->addProcess($proc);
    $serv->on("WorkerStart", function (OpenSwoole\Server $serv) use ($pm) {
        $pm->wakeup();
    });
    $serv->on("Receive", function (OpenSwoole\Server $serv, $fd, $reactorId, $data) use ($proc) {
        $proc->write(json_encode([
            'fd' => $fd
        ]));
        for ($i = 0; $i < TIMES/2; $i ++) {
            go (function() use ($serv,$fd, $i){
                //echo "worker sleep start\n";
                co::usleep(10000);
                //echo "worker sleep end\n";
                $serv->send($fd, str_repeat('A', SIZE) . "\r\n\r\n");
                //echo "worker send $i ok\n";
            });
        }
    });
    $serv->start();
};

$pm->childFirst();
$pm->run();
?>
--EXPECT--
