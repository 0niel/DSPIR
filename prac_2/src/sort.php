<?php
function shellSort($arr)
{
    $gap = round(count($arr) / 2);
    while ($gap > 0) {
        for ($i = 0; $i < count($arr); $i++) {
            $temp = $arr[$i];
            $j = $i;
            while ($j >= $gap && $arr[$j - $gap] > $temp) {
                $arr[$j] = $arr[$j - $gap];
                $j -= $gap;
            }
            $arr[$j] = $temp;
        }
        $gap = round($gap / 2.2);
    }
    return $arr;
}
$arr = explode(',', $_GET['arr']);
$arr = shellSort($arr);
echo "<pre>";
print_r($arr);
echo "</pre>";
?>