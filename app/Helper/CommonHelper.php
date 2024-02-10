<?php
namespace App\Helper;

class CommonHelper{
    static public function getRandomEnumCase($cases)
    {
        $count = count($cases) - 1;
        return $cases[rand(0, $count)];
    }

    static public function makeCasesWithLabel($cases)
    {
        $result = [];
        foreach ($cases as $index => $case) {
            $item = [
                'name' => $case->name,
                'value' => $case->value,
                'label' => $case->label(),
            ];
            $result[] = $item;
        }

        return $result;
    }
}
