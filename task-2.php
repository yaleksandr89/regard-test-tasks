<?php

/**
 * Даны две модели Order и Manager
 *
 * Каждый Order имеет manager_id. Manager имеет id, firstName, lastName
 * Необходимо вывести 50 заказов (Order) + fullName менеджера с минимальным кол-вом запросов к бд.
 * Дополните класс Order.
 * Реализовать нужно без использование join.
 */


// Если я правильно понял это задание не требуется запускать.
// Нужно написать логику взаимодействия моделей с использованием ORM Eloquent. Поэтому Laravel устанавливать не стал, а только описал
// методы моделей (если требуется развернуть фреймворк - могу это сделать).
class Manager extends Model
{
    // Свойства модели
    protected int $id;          // Идентификатор менеджера
    protected string $firstName;   // Имя менеджера
    protected string $lastName;    // Фамилия менеджера

    protected array $fillable = [
        'firstName',
        'lastName',
    ];
}

class Order extends Model
{
    public function manager(): Manager
    {
        return $this->hasOne('App\Manager');
    }

    public static function getOrdersWithManagers(int $limit = 50): array
    {
        // Загружаем заказы вместе с менеджерами, ограничивая выборку 50 записями
        $orders = self::with('manager')->limit($limit)->get();

        // Формируем массив с результатами
        $result = [];
        foreach ($orders as $order) {
            // Проверяем наличие менеджера и формируем полное имя
            $fullName = $order->manager ?
                $order->manager->firstName.' '.$order->manager->lastName :
                'No Manager';

            // Добавляем информацию о заказе и имени менеджера в результирующий массив
            $result[] = [
                'order_id' => $order->id,
                'fullName' => $fullName,
            ];
        }

        return $result;  // Возвращаем сформированный массив
    }
}

$ordersWithManagers = Order::getOrdersWithManagers();
var_dump($ordersWithManagers);
