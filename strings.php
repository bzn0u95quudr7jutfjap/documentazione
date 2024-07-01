<?php


function str_replace_marker($a, $s, $b, $e) {
  preg_match_all('/' . preg_quote($b) . '(.*?)' . preg_quote($e) . '/', $s, $g, PREG_OFFSET_CAPTURE);

  $e = [];
  $k = array_keys($a);
  $k1 = array_column($g[1], 0);

  if (($d = array_diff($k1, $k)) !== []) {
    $e[] = "Mancano le sostituzioni per i seguenti marcatori:\n" . implode('', array_map(fn ($a) => "\t$a\n", $d));
  }
  if (($d = array_diff($k, $k1)) !== []) {
    $e[] = "Vengono rimpiazzati dei marcatori inesistenti:\n" . implode('', array_map(fn ($a) => "\t$a\n", $d));
  }
  if (($d = array_keys(array_filter($a, fn ($a) => gettype($a) !== 'string'))) !== []) {
    $e[] = "Le sostituzioni non sono stringhe:\n" . implode('', array_map(fn ($a) => "\t$a\n", $d));
  }
  if ($e) {
    echo implode("\n", $e);
    die(1);
  }

  $g = array_map(fn ($i, $j) => [$i[0], $i[1], $j[0]], $g[0], $g[1]);
  usort($g, fn ($a, $b) => ($a[1] < $b[1]) ? 1 : -1);
  foreach ($g as $t) {
    [$r, $i, $k] = $t;
    $s = substr_replace($s, $a[$k], $i, strlen($r));
  }

  return $s;
}

/*
function test($msg, $a, $s, $b, $e) {
  echo "\n";
  echo $msg;
  echo "\n";
  echo str_replace_marker($a, $s, $b, $e);
  echo "\n";
  echo "\n";
}
//test("corretto",['a' => 'A', 'b' => 'B'], '{a}{b}c', '{', '}');
//test("marcatore mancante",['a' => 'A'], '{a}{b}c', '{', '}');
//test("marcatore inesistente",['a' => 'A', 'b' => 'B', 'c' => 'C'], '{a}{b}c', '{', '}');
//test("marcatore mancante e inesistente",['a' => 'A', 'c' => 'C'], '{a}{b}c', '{', '}');
//test("marcatore non stringa",['a' => 'A', 'b' => [0]], '{a}{b}c', '{', '}');
//*/