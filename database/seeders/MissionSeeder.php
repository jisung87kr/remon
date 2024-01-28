<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $missionData = [
            '키워드' => [
                [
                    'option_name' => '키워드',
                    'option_value' => '제목 키워드',
                    'additional_price' => 5000,
                    'extra_name1' => null,
                    'extra_value1' => null,
                    'extra_name2' => null,
                    'extra_value2' => null,
                ],
                [
                    'option_name' => '키워드',
                    'option_value' => '본문 키워드',
                    'additional_price' => 5000,
                    'extra_name1' => '선택키워드 개수',
                    'extra_value1' => 1,
                    'extra_name2' => '언급 횟수',
                    'extra_value2' => 5,
                ],
            ],
            '글자수' => [
                [
                    'option_name' => '글자수',
                    'option_value' => '30',
                    'additional_price' => 10000,
                    'extra_name1' => null,
                    'extra_value1' => null,
                    'extra_name2' => null,
                    'extra_value2' => null,
                ],
                [
                    'option_name' => '글자수',
                    'option_value' => '500',
                    'additional_price' => 12000,
                    'extra_name1' => null,
                    'extra_value1' => null,
                    'extra_name2' => null,
                    'extra_value2' => null,
                ],
                [
                    'option_name' => '글자수',
                    'option_value' => '800',
                    'additional_price' => 13000,
                    'extra_name1' => null,
                    'extra_value1' => null,
                    'extra_name2' => null,
                    'extra_value2' => null,
                ],
            ],
            '이미지' => [
                [
                    'option_name' => '장수',
                    'option_value' => '15',
                    'additional_price' => 10000,
                    'extra_name1' => null,
                    'extra_value1' => null,
                    'extra_name2' => null,
                    'extra_value2' => null,
                ],
                [
                    'option_name' => '장수',
                    'option_value' => '30',
                    'additional_price' => 20000,
                    'extra_name1' => null,
                    'extra_value1' => null,
                    'extra_name2' => null,
                    'extra_value2' => null,
                ],
            ],
            '링크삽입' => [],
            '동영상첨부' => [],
            '릴스등록' => [],
            '해시태그' => [],
        ];

        foreach ($missionData as $index => $item) {
            $mission = Mission::factory()->create([
                'name' => $index,
            ]);

            if(empty($item)){
                $mission->options()->create([
                    'mission_id'       => $mission->id,
                    'option_name'      => $mission->name,
                    'option_value'     => null,
                    'additional_price' => $mission->price,
                ]);
            } else {
                foreach ($item as $key => $value) {
                    $mission->options()->create([
                        'mission_id'       => $mission->id,
                        'option_name'      => $value['option_name'],
                        'option_value'     => $value['option_value'],
                        'additional_price' => $value['additional_price'],
                        'extra_name1'      => $value['extra_name1'],
                        'extra_value1'     => $value['extra_value1'],
                        'extra_name2'      => $value['extra_name2'],
                        'extra_value2'     => $value['extra_value2'],
                    ]);
                }
            }
        }
    }
}
