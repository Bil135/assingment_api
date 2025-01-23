<?php

    namespace Tests\Unit;

    use App\Models\Translation;
    use App\Repositories\TranslationRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    class TranslationRepositoryTest extends TestCase
    {
        use RefreshDatabase;

        protected $translationRepository;

        protected function setUp(): void
        {
            parent::setUp();

            $this->translationRepository = new TranslationRepository();
        }

        public function testCreateTranslation()
        {
            $data = [
                'key' => 'greeting',
                'content' => ['en' => 'hello', 'fr' => 'bonjour'],
                'tags' => 'mobile,web',
            ];

            $translation = $this->translationRepository->create($data);

            $this->assertDatabaseHas('translations', [
                'key' => 'greeting',
            ]);

            $this->assertEquals('hello', $translation->content['en']);
        }

        public function testUpdateTranslation()
        {
            $translation = Translation::factory()->create([
                'key' => 'greeting',
                'content' => ['en' => 'hello'],
                'tags' => 'mobile',
            ]);

            $data = [
                'content' => ['en' => 'hi'],
            ];

            $updatedTranslation = $this->translationRepository->update($translation->id, $data);

            $this->assertEquals('hi', $updatedTranslation->content['en']);
        }

        public function testFindTranslation()
        {
            $translation = Translation::factory()->create([
                'key' => 'greeting',
            ]);

            $foundTranslation = $this->translationRepository->find($translation->id);

            $this->assertEquals($translation->id, $foundTranslation->id);
        }

        public function testSearchTranslations()
        {
            Translation::factory()->create([
                'key' => 'greeting',
                'tags' => 'mobile',
            ]);

            $results = $this->translationRepository->search(['tags' => 'mobile']);

            $this->assertCount(1, $results);
        }

        public function testExportAllTranslations()
        {
            Translation::factory()->count(10)->create();

            $translations = $this->translationRepository->exportAll();

            $this->assertCount(10, $translations);
        }
    }
