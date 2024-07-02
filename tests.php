<?php

require_once __DIR__ . '/strings.php';

//*
function test($m, $f, $a, $c, $h) {
  try {
    $e = $c($f(...$a));
  } catch (ErrorException $e) {
    $e = $h($e);
  }
  echo "[$f]: $m: " . ($e ? 'OK' : 'ERR') . "\n";
}

test(
  'Corretto',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'b' => 'B'],
    '{', '}',
  ],
  fn ($a) => $a === 'ABc',
  fn () => false,
);

test(
  'Marcatore mancante',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A'],
    '{', '}',
  ],
  fn () => false,
  fn ($e) => $e->getCode() & 1,
);

test(
  'Marcatore inesistente',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'b' =>  'B', 'c' => 'C'],
    '{', '}',
  ],
  fn () => false,
  fn ($e) => $e->getCode() & 2,
);

test(
  'Marcatore mancante e inesistente',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'c' => 'C'],
    '{', '}',
  ],
  fn () => false,
  fn ($e) => $e->getCode() & (1 | 2),
);

test(
  'Marcatore non stringa',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'b' => [0]],
    '{', '}',
  ],
  fn () => false,
  fn ($e) => $e->getCode() & 4,
);

//*/
