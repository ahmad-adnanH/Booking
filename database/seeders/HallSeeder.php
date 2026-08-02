<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $halls = [
            [
                'name'        => 'مدرج الخوارزمي',
                'hall_number' => 'A-101',
                'capacity'    => 150,
                'building'    => 'مبنى الهندسة والتكنولوجيا',
                'floor'       => 'الطابق الأرضي',
            ],
            [
                'name'        => 'قاعة الهيثم للمؤتمرات',
                'hall_number' => 'B-205',
                'capacity'    => 80,
                'building'    => 'مبنى العلوم الأساسية',
                'floor'       => 'الطابق الثاني',
            ],
            [
                'name'        => 'مختبر الشبكات والذكاء الاصطناعي',
                'hall_number' => 'C-102',
                'capacity'    => 35,
                'building'    => 'مبنى الحاسبات ومعلومات',
                'floor'       => 'الطابق الأول',
            ],
            [
                'name'        => 'مدرج الرازي',
                'hall_number' => 'M-301',
                'capacity'    => 200,
                'building'    => 'مبنى الكليات الطبية',
                'floor'       => 'الطابق الثالث',
            ],
            [
                'name'        => 'قاعة الندوات وورش العمل',
                'hall_number' => 'ADMIN-04',
                'capacity'    => 50,
                'building'    => 'المبنى الإداري المركزي',
                'floor'       => 'الطابق الأرضي',
            ],
        ];

        foreach ($halls as $hall) {
            Hall::create($hall);
        }
    }
}
