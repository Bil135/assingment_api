<?php

    namespace Database\Factories;
    use App\Models\Translation;
    use Illuminate\Database\Eloquent\Factories\Factory;
    class TranslationFactory extends Factory
    {
        protected $model = Translation::class;

        public function definition():array
        {
            return [
                 'key' => $this->faker->word(),
                'content' => [
                    'en' => $this->faker->sentence,
                    'fr' => $this->faker->sentence,
                    'es' => $this->faker->sentence,
                ],
                'tags' => implode(',', $this->faker->words(3)),
            ];
        }
    }
