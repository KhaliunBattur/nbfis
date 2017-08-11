<?php

use Illuminate\Database\Seeder;

class ReferenceTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Support\ReferenceText::create([
            'text' => 'Сарын орлого',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Ажилчдын цалингийн зардал',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Байрны түрээс',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Оффисийн түрээсийн зардал',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Бараа материалын зардал',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Байгууллагын бензений зардал',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Тог цахилгаан',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Байрны мөнгө',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Утас',
            'type' => 'budged'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Бусад',
            'type' => 'budged'
        ]);

        //

        \App\Support\ReferenceText::create([
            'text' => 'Банкний хадгаламж',
            'type' => 'assets'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Байр',
            'type' => 'assets'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Амины орон сууц',
            'type' => 'assets'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Авто машин',
            'type' => 'assets'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Газар',
            'type' => 'assets'
        ]);

        \App\Support\ReferenceText::create([
            'text' => 'Бусад',
            'type' => 'assets'
        ]);
    }
}
