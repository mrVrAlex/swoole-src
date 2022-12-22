--TEST--
swoole_http_client_coro: http download 302
--SKIPIF--
<?php
require __DIR__ . '/../include/skipif.inc';
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

const FILE = '/tmp/download.html';

co::run(function () {
    $cli = new OpenSwoole\Coroutine\Http\Client(HTTPBIN_SERVER_HOST, HTTPBIN_SERVER_PORT);
    $cli->download('/absolute-redirect/1', FILE);
    Assert::contains(file_get_contents(FILE), 'Redirecting');
    if (((string)$cli->statusCode)[0] === '3') {
        $cli->download($cli->headers['location'], FILE);
    }
    if (Assert::contains(json_decode(file_get_contents(FILE), true)['url'], 'get')) {
        echo "OK\n";
    }
});
@unlink(FILE);

?>
--EXPECT--
OK
