--TEST--
swoole_http_server: bug get request data after response end
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';
$pm = new ProcessManager;
$pm->initRandomData(1);
$pm->parentFunc = function () use ($pm) {
    co::run(function () use ($pm) {
        echo httpGetBody("http://127.0.0.1:{$pm->getFreePort()}/", ['data' => $pm->getRandomData()]) . PHP_EOL;
    });
    $pm->kill();
};
$pm->childFunc = function () use ($pm) {
    $http = new OpenSwoole\Http\Server('127.0.0.1', $pm->getFreePort(), SWOOLE_BASE);
    $http->set(['log_file' => '/dev/null']);
    $http->on('workerStart', function () use ($pm) {
        $pm->wakeup();
    });
    $http->on("request", function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
        $response->end('OK');
        switch_process();
        Assert::notEmpty($request->rawContent());
        Assert::notEmpty($request->getData());
    });
    $http->start();
};
$pm->childFirst();
$pm->run();
?>
--EXPECT--
OK
