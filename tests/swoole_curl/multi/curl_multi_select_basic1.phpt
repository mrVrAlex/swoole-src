--TEST--
swoole_curl/multi: Test curl_multi_select()
--CREDITS--
Ivo Jansch <ivo@ibuildings.com>
#testfest Utrecht 2009
--SKIPIF--
<?php require __DIR__ . '/../../include/skipif.inc'; ?>
<?php if (!extension_loaded("curl")) print "skip"; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../../include/bootstrap.php';

Swoole\Runtime::enableCoroutine(SWOOLE_HOOK_NATIVE_CURL);
co::run(function () {
    // create the multiple cURL handle
    $mh = curl_multi_init();
    echo curl_multi_select($mh)."\n";

    curl_multi_close($mh);
});
?>
--EXPECTF--
%r(0|-1)%r
