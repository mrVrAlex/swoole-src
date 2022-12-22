--TEST--
swoole_channel_coro: pop timeout 1
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

co::run(function() {

    $c1 = new chan();

    go(function () use ($c1) {
        $ret = $c1->pop(1);
        echo "pop ret:".var_export($ret,true)." error:".$c1->errCode."\n";

    });

});

?>
--EXPECTF--
pop ret:false error:-1
