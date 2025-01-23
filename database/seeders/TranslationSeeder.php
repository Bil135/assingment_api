<?php

    namespace Database\Seeders;

    use App\Models\Translation;
    use Illuminate\Database\Seeder;

    class TranslationSeeder extends Seeder
    {
        public function run()
        {
            Translation::factory()->count(20000)->create();
        }
    }
