<?php

include 'ComplexsNumsCalc.php';

$calc_result = ComplexsNumsCalc::complex_nums_calculation('23+96i','35-574i','plus');
$calc_test_result = ComplexsNumsCalc::test_calc();

echo '<pre>';
print_r($calc_result);
print_r($calc_test_result);




?>