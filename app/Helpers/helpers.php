<?php

if (!function_exists('format_inr')) {
    function format_inr($amount, $withSymbol = true)
    {
        $amount = number_format($amount, 2, '.', '');
        $exploded = explode('.', $amount);
        $beforeDecimal = $exploded[0];
        $afterDecimal = $exploded[1];

        $length = strlen($beforeDecimal);
        if ($length > 3) {
            $lastThree = substr($beforeDecimal, -3);
            $restUnits = substr($beforeDecimal, 0, $length - 3);
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $formatted = $restUnits . ',' . $lastThree;
        } else {
            $formatted = $beforeDecimal;
        }

        return ($withSymbol ? '₹' : '') . $formatted . '.' . $afterDecimal;
    }
}
