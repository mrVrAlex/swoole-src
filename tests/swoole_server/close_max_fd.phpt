--TEST--
swoole_server: close_max_fd
--CONFLICTS--
all
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

use Swoole\Server;

$pm = new SwooleTest\ProcessManager;
$pm->parentFunc = function () use ($pm) {
    co::run(function () use ($pm) {
        go(function() use ($pm) {
            $client = new OpenSwoole\Coroutine\Client(SWOOLE_SOCK_TCP);
            Assert::assert($client->connect('127.0.0.1', $pm->getFreePort()));
            Assert::assert($client->send('test'));
            $client->recv();
            Co::sleep(2);
            $client->send('ping');
            Co::sleep(3);
            $pm->kill();
        });
        go(function() use ($pm) {
            $cli = new OpenSwoole\Coroutine\Http\Client('127.0.0.1', $pm->getFreePort());
            $cli->close();
        });
        go(function() use ($pm) {
            $client = new OpenSwoole\Coroutine\Client(SWOOLE_SOCK_TCP);
            Assert::assert($client->connect('127.0.0.1', $pm->getFreePort()));
            $client->send('test2');
            $client->close();
        });
    });
};
$pm->childFunc = function () use ($pm) {
    $server = new OpenSwoole\Server('127.0.0.1', $pm->getFreePort());
    $server->set([
        'worker_num' => 1,
        'log_level' => SWOOLE_LOG_ERROR,
    ]);

    $server->on('receive', function (Swoole\Server $serv, int $fd, int $rid, string $data) {
        var_dump($data);
        var_dump($serv->getClientList());
        Assert::true(!empty($serv->getClientList()));
        foreach ($serv->connections as $_fd) {
            var_dump("fd:{$_fd}");
        }
        $serv->send($fd, "Server: " . $data);
    });

    $server->on('Close', function ($server, $fd) {
        echo "Client:{$fd} Close.\n";
    });

    $server->start();
};
$pm->childFirst();
$pm->run();
?>
--EXPECT--
string(4) "test"
array(2) {
  [0]=>
  int(1)
  [1]=>
  int(2)
}
string(4) "fd:1"
string(4) "fd:2"
string(5) "test2"
array(2) {
  [0]=>
  int(1)
  [1]=>
  int(2)
}
string(4) "fd:1"
string(4) "fd:2"
Client:2 Close.
string(4) "ping"
array(1) {
  [0]=>
  int(1)
}
string(4) "fd:1"
Client:1 Close.
