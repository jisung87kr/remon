<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            '제품' => ['생활', '서비스', '유아동', '디지털', '뷰티', '패션', '도서', '식품', '반려동물'],
            '지역' => [
                '서울'    => ['강남/논현', '강동/천호', '강서/목동', '건대/왕십리', '관악/신림', '교대/사당', '노원/강북', '명동/이태원', '관악/신림', '교대/사당', '노원/강복', '명동/이태원', '삼성/선릉', '송파/잠실', '수유/동대문', '신촌/이대', '압구정/신사', '여의도/영등포', '종로/대학로', '홍대/마포'],
                '경기-인천' => ['일산/파주', '용인/분당/수원', '인천/부천', '남양주/구리/하남', '안양/안산/광명'],
                '대전-충정' => ['대전', '충청'],
                '대구-경북' => ['대구', '경북'],
                '부산-경남' => ['부산', '경남'],
                '광주-전라' => ['광주', '전라'],
                '강원-제주' => ['강원', '제주'],
            ],
            '유형' => ['맛집', '뷰티', '숙박', '문화', '배달', '테이크아웃', '기타'],
            '캠페인 옵션' => [
                '대리인 가능',
                '재참여 가능',
                '예약없음',
            ]
        ];

        foreach ($category as $index => $item) {
            $dpeth1 = Category::factory()->create([
                'name' => $index
            ]);

            foreach ($item as $key => $value) {
                if(gettype($key) === 'integer'){
                    $dpeth1->categories()->create([
                        'type' => 'campaign',
                        'name' => $value,
                        'parent_id' => $dpeth1->id
                    ]);
                } else {
                    $depth2 = $dpeth1->categories()->create([
                        'name' => $key,
                        'parent_id' => $dpeth1->id
                    ]);

                    foreach ($value as $key2 => $value2) {
                        $depth2->categories()->create([
                            'name' => $value2,
                            'parent_id' => $depth2->id
                        ]);
                    }
                }
            }
        }
    }
}
