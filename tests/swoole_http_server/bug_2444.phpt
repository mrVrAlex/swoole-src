--TEST--
swoole_http_server: bug #2444
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
$pm = new ProcessManager;
$pm->parentFunc = function () use ($pm) {
    go(function () use ($pm) {
        echo httpGetBody("http://127.0.0.1:{$pm->getFreePort()}/test") . PHP_EOL;
        $pm->kill();
    });
};
$pm->childFunc = function () use ($pm) {
    $server = new OpenSwoole\Http\Server('0.0.0.0', $pm->getFreePort(), SWOOLE_BASE);
    $server->set(['log_file' => '/dev/null']);
    $server->on('start', function () use ($pm) {
        $pm->wakeup();
    });
    $server->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) use ($pm) {
        switch ($request->server['request_uri']) {
            case '/test':
                $cli = new OpenSwoole\Coroutine\Http\Client('127.0.0.1', $pm->getFreePort());
                $cli->get('/');
                if (!Assert::assert($cli->statusCode === 200)) {
                    _error:
                    $response->status(500);
                    $response->end('ERROR');
                    return;
                }
                $cli->close();
                break;
        }
        $response->end('OK');
    });
    $server->start();
};
$pm->childFirst();
$pm->run();
?>
--EXPECT--
OK
