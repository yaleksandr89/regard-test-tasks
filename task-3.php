<?php

/**
 * Даны веса посылок $boxes и вес, который может увезти курьер $weight.
 * Курьер должен возить по 2 посылки, которые вместе по весу будут строго равны $weight.
 * Необходимо найти максимальное количество рейсов, которые курьер сможет сделать с учетом условий.
 */

function getResult(array $boxes, int $weight): int
{
    $count = 0;
    $boxCounts = array_count_values($boxes); // Подсчет частоты каждого веса

    foreach ($boxCounts as $boxWeight => $boxCount) {
        // Определяем вес, с которым нужно искать пару
        $complementWeight = $weight - $boxWeight;

        // Если текущий вес - это половина от веса, который мы ищем
        if ($boxWeight === $complementWeight) {
            // Считаем количество пар, используя сочетания
            $count += floor($boxCount / 2);
        } elseif (isset($boxCounts[$complementWeight])) {
            // Считаем пары и уменьшаем количество использованных коробок
            $pairs = min($boxCount, $boxCounts[$complementWeight]);
            $count += $pairs;

            // Убираем использованные коробки
            $boxCounts[$boxWeight] -= $pairs; // Уменьшаем также текущий вес
            $boxCounts[$complementWeight] -= $pairs; // Уменьшаем вес, с которым мы искали пару
        }
    }

    return $count; // Возвращаем количество рейсов
}


// Создаем объект и вызываем метод
$result = getResult([1, 2, 1, 5, 1, 3, 5, 2, 5, 5], 6);
var_dump($result); // Выводим результат: 3

$result = getResult([2, 4, 3, 6, 1], 5);
var_dump($result); // Выводим результат: 3
