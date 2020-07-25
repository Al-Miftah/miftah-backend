<?php 

/**
 * Convert an money amount to lowest denomination
 *
 * @param integer $amount
 * @return float
 */
function lower_denomination(int $amount) {
    return (float)number_format($amount / 100, 2);
}