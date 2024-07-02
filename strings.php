<?php

function str_replace_marker($s, $a, $b, $e) {
  preg_match_all('/' . preg_quote($b) . '(.*?)' . preg_quote($e) . '/', $s, $g, PREG_OFFSET_CAPTURE);

  $k = array_keys($a);
  $k1 = array_column($g[1], 0);

  $c = fn ($e, $d, $m) => count($d) === 0 ? false : [$e, "$m:\n" . implode('', array_map(fn ($a) => "\t$a\n", $d))];
  if ($e = array_filter([
    $c(1, array_diff($k1, $k), "Mancano le sostituzioni per i seguenti marcatori"),
    $c(2, array_diff($k, $k1), "Vengono rimpiazzati dei marcatori inesistenti"),
    $c(4, array_keys(array_filter($a, fn ($a) => gettype($a) !== 'string')), "Le sostituzioni non sono stringhe"),
  ])) {
    $c = array_sum(array_column($e, 0));
    $e = implode("\n", array_column($e, 1)) . "\n\nTesto da rimpiazzare:\n\n$s";
    throw new ErrorException("$e\n\nstr_replace_marker_error", $c);
  }

  $g = array_map(fn ($i, $j) => [$i[0], $i[1], $j[0]], $g[0], $g[1]);
  usort($g, fn ($a, $b) => ($a[1] < $b[1]) ? 1 : -1);
  foreach ($g as $t) {
    [$r, $i, $k] = $t;
    $s = substr_replace($s, $a[$k], $i, strlen($r));
  }

  return $s;
}
