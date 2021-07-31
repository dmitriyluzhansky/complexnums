<div style="text-align: center">
    <h1>Калькулятор комплексных чисел</h1>
    <form action="/complexnum/" method="POST">
        <input type="text" name="num1" placeholder="Число 1"><br>
        <select style="margin-top: 10px;" name="operation">
            <option value="plus">+</option>
            <option value="minus">-</option>
            <option value="multiplication">*</option>
            <option value="division">/</option>
        </select><br>
        <input style="margin-top: 10px;margin-bottom: 10px;" type="text" name="num2" placeholder="Число 2"><br>
        <label for="debug">Debug</label>
        <input type="checkbox" name="debug"><br>
        <button style="margin-top: 10px;">Вычислить</button>
    </form>


    <?php

    error_reporting(0);

    include 'ComplexsNumsCalc.php';

    if ($_POST) {

        $calc_result = ComplexsNumsCalc::complex_nums_calculation($_POST['num1'], $_POST['num2'], $_POST['operation']);
        $calc_test_result = ComplexsNumsCalc::test_calc();

    }


    ?>

    <h1>Результат:</h1>
    <h2>
    <?php
        if ($calc_result[0]=='ok'){
            print_r($calc_result[1]);
        } else {
            print_r($calc_result[1][0]);
        }
    ?>
    </h2>

</div>


<?php
if ($_POST['debug']) {
    echo '<pre>';
    echo '<br>';
    echo 'Статус вычислений:<br>';
    print_r($calc_result);
    echo '<br>';
    echo 'Тесты:<br>';
    print_r($calc_test_result);
}

?>