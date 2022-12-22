--TEST--
swoole_client_coro: timeout of udp client
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
$port = get_one_free_port();

Co::run(function () use ($port) {
    $cli = new OpenSwoole\Coroutine\Client(SWOOLE_SOCK_UDP);
    $cli->set([
        'timeout' => 0.2,
    ]);
    if (!Assert::assert($cli->connect('192.0.0.1', $port))) {
        return;
    }
    Assert::assert($cli->send("hello"));
    // default timeout
    $s = microtime(true);
    $ret = @$cli->recvfrom(1024, $peer);
    $s = microtime(true) - $s;
    Assert::assert($s > 0.2 && $s < 0.5, $s);
    Assert::eq($ret, false);
    Assert::eq($cli->errCode, SOCKET_ETIMEDOUT);
    $cli->close();
});

?>
--EXPECT--
