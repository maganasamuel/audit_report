<?php
if (! function_exists('ordinalNumber')) {
    function ordinalNumber($number)
    {
        return $number . (($j = abs($number) % 100) > 10 && $j < 14 ? 'th' : (@['th', 'st', 'nd', 'rd'][$j % 10] ?: 'th'));
    }
}
