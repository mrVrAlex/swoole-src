--TEST--
swoole_http_server: http server callback use new object method
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

$pm = new ProcessManager;
$pm->parentFunc = function () use ($pm) {
    for ($i = MAX_CONCURRENCY_LOW; $i--;) {
        go(function () use ($pm) {
            $cli = new OpenSwoole\Coroutine\Http\Client('127.0.0.1', $pm->getFreePort());
            for ($i = MAX_REQUESTS_LOW; $i--;) {
                Assert::assert($cli->get('/'));
                Assert::same($cli->statusCode, 200);
                Assert::same($cli->body, 'Hello Swoole!');
            }
        });
    }
    swoole_event_wait();
    $pm->kill();
};

$pm->childFunc = function () use ($pm) {

    class TestCo
    {
        public function foo(swoole_http_request $request, swoole_http_response $response)
        {
            Co::usleep(1000);
            $cid = go(function () use ($response) {
                co::yield();
                $response->end('Hello Swoole!');
            });
            co::resume($cid);
            echo @$this->test;
        }
    }

    $http = new swoole_http_server('0.0.0.0', $pm->getFreePort(), SWOOLE_BASE);
    $http->set([
        'worker_num' => 1,
        'log_file' => '/dev/null'
    ]);
    $http->on('request', [new TestCo, 'foo']);
    $http->start();
};

$pm->childFirst();
$pm->run();
?>
--EXPECT--
