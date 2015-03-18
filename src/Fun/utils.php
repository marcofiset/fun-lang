<?php

function array_max(array $array, callable $criteria)
{
    $maxItem = null;
    $maxValue = null;

    foreach ($array as $item) {
        $itemValue = $criteria($item);

        if (!$maxItem || $itemValue > $maxValue) {
            $maxItem = $item;
            $maxValue = $itemValue;
        }
    }

    return $maxItem;
}