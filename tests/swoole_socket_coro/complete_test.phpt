--TEST--
swoole_socket_coro: complete test server&&client&&timeout(millisecond)
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
$pm = new ProcessManager;
$port = get_one_free_port();
$pm->parentFunc = function ($pid) use ($pm, $port) {
    $socket = new OpenSwoole\Coroutine\Socket(AF_INET, SOCK_STREAM, 0);
    Assert::isInstanceOf($socket, Swoole\Coroutine\Socket::class);
    Assert::same($socket->errCode, 0);
    go(function () use ($socket, $port) {
        Assert::assert($socket->connect('localhost', $port));
        $i = 0;
        while (true) {
            $socket->send("hello");
            $server_reply = $socket->recv(1024, 0.1);
            Assert::same($server_reply, 'swoole');
            co::usleep($i += 1000); // after 10 times we sleep 0.01s to trigger server timeout
            if ($i >= 10000) {
                break;
            }
        }
        co::usleep(500000);
        echo("client exit\n");
        $socket->close();
    });
    swoole_event_wait();
};

$pm->childFunc = function () use ($pm, $port) {
    $socket = new OpenSwoole\Coroutine\Socket(AF_INET, SOCK_STREAM, 0);
    Assert::assert($socket->bind('127.0.0.1', $port));
    Assert::assert($socket->listen(128));
    go(function () use ($socket, $pm) {
        $client = $socket->accept();
        Assert::isInstanceOf($client, Swoole\Coroutine\Socket::class);
        $i = 0;
        while (true) {
            $client_data = $client->recv(1024, 0.1);
            if ($client->errCode > 0) {
                Assert::same($client->errCode, SOCKET_ETIMEDOUT);
                break;
            } else {
                $i++;
                Assert::same($client_data, 'hello');
                $client->send('swoole');
            }
        }
        echo "$i\n";
        echo("sever exit\n");
        Co::usleep(1);
        $client->close();
        $socket->close();
    });
    swoole_event_wait();
};

$pm->childFirst();
$pm->run();
?>
--EXPECT--
10
sever exit
client exit
