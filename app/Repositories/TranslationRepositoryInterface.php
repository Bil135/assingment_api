<?php

    namespace App\Repositories;

    interface TranslationRepositoryInterface
    {
        public function create(array $data);
        public function update(int $id, array $data);
        public function find(int $id);
        public function search(array $filters);
        public function exportAll();
    }
