--TEST--
swoole_curl/multi: curl_multi_close closed by cleanup functions
--SKIPIF--
<?php require __DIR__ . '/../../include/skipif.inc'; ?>
<?php
if (!extension_loaded('curl')) print 'skip';
?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../../include/bootstrap.php';

Swoole\Runtime::enableCoroutine(SWOOLE_HOOK_NATIVE_CURL);
co::run(function () {
    $mh = curl_multi_init();
    $array = array($mh);
    $array[] = &$array;

    curl_multi_add_handle($mh, curl_init());
    curl_multi_add_handle($mh, curl_init());
    curl_multi_add_handle($mh, curl_init());
    curl_multi_add_handle($mh, curl_init());
    echo "okey";
});
?>
--EXPECT--
okey
