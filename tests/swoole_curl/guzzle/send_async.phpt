--TEST--
swoole_curl/guzzle: send async
--SKIPIF--
<?php
require __DIR__ . '/../../include/skipif.inc';
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../../include/bootstrap.php';
require_once TESTS_LIB_PATH . '/vendor/autoload.php';

use Swoole\Runtime;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;



Runtime::enableCoroutine(SWOOLE_HOOK_NATIVE_CURL);

co::run(function () {
    $client = new Client();
    $response = $client->request('GET', 'https://api.github.com/repos/openswoole/swoole-src');

    echo $response->getStatusCode(), PHP_EOL; // 200
    echo $response->getHeaderLine('content-type'), PHP_EOL; // 'application/json; charset=utf8'

    // Send an asynchronous request.
    $request = new Request('GET', 'http://httpbin.org');
    $promise = $client->sendAsync($request)->then(function ($response) {
        echo 'I completed! ' . $response->getStatusCode() . PHP_EOL;
    });

    $promise->wait();
    echo 'Done' . PHP_EOL;
});
?>
--EXPECT--
200
application/json; charset=utf-8
I completed! 200
Done
