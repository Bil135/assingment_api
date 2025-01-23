<?php

    namespace App\Repositories;

    use App\Models\Translation;

    class TranslationRepository implements TranslationRepositoryInterface
    {
        public function create(array $data)
        {
            try {
                return Translation::create($data);
            }catch (\Exception $exception){
                return $exception->getMessage();
            }
        }

        public function update(int $id, array $data)
        {
            $translation = Translation::findOrFail($id);
            $translation->update($data);
            return $translation;
        }

        public function find(int $id)
        {
            try {
                $translation = Translation::findOrFail($id);
                return response()->json($translation);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Translation not found'], 404);
            }
        }

        public function search(array $filters)
        {
            $query = Translation::query();

            if (isset($filters['key'])) {
                $query->where('key', 'like', '%' . $filters['key'] . '%');
            }

            if (isset($filters['tags'])) {
                $query->where('tags', 'like', '%' . $filters['tags'] . '%');
            }

            if (isset($filters['content'])) {
                $query->whereRaw('LOWER(content) LIKE ?', ['%' . strtolower($filters['content']) . '%']);
            }

            return $query->get();
        }

        public function exportAll()
        {
            return Translation::all();
        }
    }
