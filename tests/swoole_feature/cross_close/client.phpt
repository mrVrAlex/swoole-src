--TEST--
swoole_feature/cross_close: client
--SKIPIF--
<?php require __DIR__ . '/../../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../../include/bootstrap.php';
$pm = new ProcessManager();
$pm->parentFunc = function () use ($pm) {
    co::run(function () use ($pm) {
        $cli = new OpenSwoole\Coroutine\Client(SWOOLE_SOCK_TCP);
        Assert::assert($cli->connect('127.0.0.1', $pm->getFreePort()));
        Assert::assert($cli->connected);
        echo "RECV\n";
        go(function () use ($pm, $cli) {
            Co::usleep(1000);
            echo "CLOSE\n";
            $cli->close();
            $pm->kill();
            echo "DONE\n";
        });
        Assert::assert(!($ret = @$cli->recv(-1)));
        if ($ret === false) {
            Assert::same($cli->errCode, SOCKET_ECONNRESET);
        }
        echo "CLOSED\n";
        Assert::assert(!$cli->connected);
    });
};
$pm->childFunc = function () use ($pm) {
    co::run(function () use ($pm) {
        $server = new OpenSwoole\Coroutine\Socket(AF_INET, SOCK_STREAM, IPPROTO_IP);
        Assert::assert($server->bind('127.0.0.1', $pm->getFreePort()));
        Assert::assert($server->listen());
        go(function () use ($pm, $server) {
            if (Assert::assert(($conn = $server->accept()) && $conn instanceof OpenSwoole\Coroutine\Socket)) {
                switch_process();
                co::sleep(5);
                $conn->close();
            }
            $server->close();
        });
        $pm->wakeup();
    });
};
$pm->childFirst();
$pm->run();
?>
--EXPECT--
RECV
CLOSE
CLOSED
DONE
