<?php


class ComplexsNumsCalc
{

    private static $calc_status = ''; // статус операции
    private static $errors = []; // ошибки
    private static $calc_result = ''; // результат операции
    private static $calc_operations = ['plus', 'minus', 'multiplication', 'division']; // операции

    //проверка комплексного числа на соответствие
    private static function check_num($complex_num)
    {

        $complex_num_pattern = '#^[-|\+]?[0-9]+[-|\+]+[0-9]+i#';

        if (preg_match($complex_num_pattern, $complex_num)) {
            return true;
        } else {
            self::$errors[] = 'неверый формат числа ' . $complex_num;
            return false;
        }

    }

    //разбираем комплексное число на дейст и мнимую части
    private static function destruct_num($complex_num)
    {
        $real_part_pattern = '#^[-|\+]?[0-9]+#';
        $image_part_pattern = '#[-|\+]+[0-9]+i#';

        preg_match($real_part_pattern, $complex_num, $real_part_arr);
        preg_match($image_part_pattern, $complex_num, $image_part_arr);


        $real_part = str_replace('+', '', $real_part_arr[0]); //действительная часть
        $image_part = str_replace(['+', 'i'], '', $image_part_arr[0]); //мнимая чать

        $result = [$real_part, $image_part];

        return $result;

    }


    //расчет
    public static function complex_nums_calculation($a, $b, $operation)
    {
        // проверяем оба числа на соответствие структуре
        if (self::check_num($a) && self::check_num($b)) {

            //проверяем тип операции
            if (in_array($operation, self::$calc_operations)) {

                $num1 = self::destruct_num($a);
                $num2 = self::destruct_num($b);

                self::$calc_result = self::$operation($num1, $num2);
                self::$calc_status = 'ok';


            } else {

                self::$calc_status = 'error';
                self::$errors[] = 'неверый тип операции ' . $operation;

            }


        } else {

            self::$calc_status = 'error';

        }

        //возвращаем или результат или ошибки с соотв статусом (error | ok)
        return self::$errors ? [self::$calc_status, self::$errors] : [self::$calc_status, self::$calc_result];


    }

    //сложение
    private static function plus($num1, $num2)
    {

        $result_real_part = ($num1[0] + $num2[0]);
        $result_image_part = ($num1[1] + $num2[1]);

        return self::return_operation($result_real_part, $result_image_part);
    }

    //вычитание
    private static function minus($num1, $num2)
    {
        $result_real_part = ($num1[0] - $num2[0]);
        $result_image_part = ($num1[1] - $num2[1]);

        return self::return_operation($result_real_part, $result_image_part);
    }

    //умножение
    private static function multiplication($num1, $num2)
    {

        $result_real_part = ($num1[0] * $num2[0] - $num1[1] * $num2[1]);
        $result_image_part = ($num1[1] * $num2[0] + $num1[0] * $num2[1]);

        return self::return_operation($result_real_part, $result_image_part);

    }


    //деление
    private static function division($num1, $num2)
    {

        $result_real_part = ($num1[0] * $num2[0] + $num1[1] * $num2[1]) / ($num2[0] * $num2[0] + $num2[1] * $num2[1]);
        $result_image_part = ($num1[1] * $num2[0] - $num1[0] * $num2[1]) / ($num2[0] * $num2[0] + $num2[1] * $num2[1]);

        return self::return_operation($result_real_part, $result_image_part);

    }


    //собираем результат вычислений
    private static function return_operation($result_real_part, $result_image_part)
    {
        $result_real_part = round($result_real_part, 5);
        $result_image_part = round($result_image_part, 5);

        if ($result_image_part == 0) {
            return $result = $result_real_part;
        } elseif ($result_image_part > 0) {
            return $result = $result_real_part . '+' . $result_image_part . 'i';
        } else {
            return $result = $result_real_part . $result_image_part . 'i';
        }

    }


    //тестируем основные операции
    public static function test_calc()
    {

        //очищаем ошибки если запускаем одновременно с расчетами
        self::$errors = [];

        $num1 = '23+96i';
        $num2 = '35-574i';

        //образцовые результаты
        $exemplary_results = ['plus' => '58-478i', 'minus' => '-12+670i', 'multiplication' => '55909-9842i', 'division' => '-0.16419+0.05008i'];

        //результаты тетсирования
        $test_results = [];


        foreach (self::$calc_operations as $operation) {

            $result_operation = self::complex_nums_calculation($num1, $num2, $operation)[1];

            if ($result_operation == $exemplary_results[$operation]) {

                $test_results[$operation] = 'ok';

            } else {

                $test_results[$operation] = 'wrong results';

            }

        }

        return $test_results;
    }

}
