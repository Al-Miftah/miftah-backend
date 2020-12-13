<?php 

if (!function_exists('money_tolower')) {
    /**
    * Convert money amount to lowest denomination
    *
    * @param integer $amount
    * @return float
    */
    function money_tolower(int $amount) {
        return (float)number_format($amount / 100, 2);
    }
}