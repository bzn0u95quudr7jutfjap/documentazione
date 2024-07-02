<?php

require_once __DIR__ . '/strings.php';

//*
function test($m, $f, $a, $c) {
  echo "[$f]: $m: " . ($c(fn () => $f(...$a)) ? 'OK' : 'ERR') . "\n";
}

test(
  'Corretto',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'b' => 'B'],
    '{', '}',
  ],
  function ($f) {
    return $f() === 'ABc';
  }
);

test(
  'Marcatore mancante',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A'],
    '{', '}',
  ],
  function ($f) {
    try {
      $f();
    } catch (ErrorException $e) {
      return $e->getCode() & 1;
    }
  }
);

test(
  'Marcatore inesistente',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'b' =>  'B', 'c' => 'C'],
    '{', '}',
  ],
  function ($f) {
    try {
      $f();
    } catch (ErrorException $e) {
      return $e->getCode() & 2;
    }
  }
);

test(
  'Marcatore mancante e inesistente',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'c' => 'C'],
    '{', '}',
  ],
  function ($f) {
    try {
      $f();
    } catch (ErrorException $e) {
      return $e->getCode() & (1 | 2);
    }
  }
);

test(
  'Marcatore non stringa',
  'str_replace_marker',
  [
    '{a}{b}c',
    ['a' => 'A', 'b' => [0]],
    '{', '}',
  ],
  function ($f) {
    try {
      $f();
    } catch (ErrorException $e) {
      return $e->getCode() & 4;
    }
  }
);

//*/
