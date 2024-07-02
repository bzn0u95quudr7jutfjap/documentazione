<?php

//*
function test($msg, $a, $s, $b, $e) {
  echo "\n\n[$msg]" . implode('', array_map(fn () => '=', range(0, 67))) . "\n";
  ob_start(fn ($a) => implode('', array_map(fn ($a) => "[$msg]: $a\n", explode("\n", $a))));
  try {
    echo str_replace_marker($s, $a, $b, $e);
  } catch (Exception $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
  }
  ob_end_flush();
  echo "[$msg]" . implode('', array_map(fn () => '=', range(0, 67))) . "\n\n";
}
test("corretto", ['a' => 'A', 'b' => 'B'], '{a}{b}c', '{', '}');
test("marcatore mancante", ['a' => 'A'], '{a}{b}c', '{', '}');
test("marcatore inesistente", ['a' => 'A', 'b' => 'B', 'c' => 'C'], '{a}{b}c', '{', '}');
test("marcatore mancante e inesistente", ['a' => 'A', 'c' => 'C'], '{a}{b}c', '{', '}');
test("marcatore non stringa", ['a' => 'A', 'b' => [0]], '{a}{b}c', '{', '}');
//*/
