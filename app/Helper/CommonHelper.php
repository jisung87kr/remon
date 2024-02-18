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

    static public function makeCustomOptionByModel($customOptions)
    {
        $result = [];
        foreach ($customOptions as $index => $customOption) {
            $result[] = [
              'id' => $customOption['id'],
              'name' => $customOption['label'],
              'value' => $customOption['option'],
            ];
        }

        return $result;
    }

    static public function toggleArrayQueryString($key, $value)
    {
        $currentMedia = request()->input($key, []);

        if (in_array($value, $currentMedia)) {
            $currentMedia = array_diff($currentMedia, [$value]);
        } else {
            $currentMedia[] = $value;
        }
        return $currentMedia;
    }
}
