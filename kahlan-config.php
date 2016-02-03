<?php

$args = $this->args();
$args->argument('ff', 'default', 1);
$args->argument('reporter', 'default', 'verbose');
$args->argument('coverage', 'default', 4);
$args->argument('clover', 'default', 'clover.xml');

Kahlan\Matcher::register('toWrap', 'Arrgh\Matcher\ToWrap', 'Arrgh\Arry');
