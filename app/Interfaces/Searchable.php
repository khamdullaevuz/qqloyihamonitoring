<?php

namespace App\Interfaces;

interface Searchable
{
    public const string SEARCH = 'search';
    public const string SEARCH_TYPE = 'search_type';

    public function searchFields(string $search): array;
}
