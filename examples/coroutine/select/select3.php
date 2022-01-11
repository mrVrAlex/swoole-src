<?php declare(strict_types = 1);

Co::set(['hook_flags' => SWOOLE_HOOK_ALL]);

function fetchUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

Co\run(function () {
    $chan1 = new chan(1);
    $chan2 = new chan(1);

    go(function() use ($chan1) {
        $content = fetchUrl('https://openswoole.com');
        var_dump(strlen($content));
        $chan1->push(['content' => $content, 'id' => 'chan1']);
    });

    go(function() use ($chan2) {
        $content = fetchUrl('https://openswoole.com');
        var_dump(strlen($content));
        $chan2->push(['content' => $content, 'id' => 'chan2']);
    });
    var_dump([$chan1, $chan2]);
    $i = 0;

    $start = time();
    $ret = co::select([$chan1, $chan2], [], 10);
    echo "select result:".var_export($ret, true)."\n";
    $cost = time() - $start;
    echo "SELECT DONE after $cost seconds\n";
    echo "waiting for shutdown..\n";
});