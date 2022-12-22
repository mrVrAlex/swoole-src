--TEST--
swoole_coroutine/destruct: destruct1
--SKIPIF--
<?php require  __DIR__ . '/../../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../../include/bootstrap.php';

use Swoole\Coroutine as co;

co::run(function() {

    class T
    {
        function __construct()
        {

        }
        function test()
        {
            echo "call function\n";
        }

        function __destruct()
        {
            go(function () {
                echo "coro start\n";
                co::usleep(1000);
                echo "coro exit\n";
            });
        }
    }

    $t = new T();
    $t->test();
    unset($t);
    echo "end\n";

});

?>
--EXPECT--
call function
coro start
end
coro exit
