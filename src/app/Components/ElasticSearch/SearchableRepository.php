<?php

namespace App\Components\ElasticSearch;

use Illuminate\Database\Eloquent\Collection;

interface SearchableRepository
{
    public function search(string $query = ""): Collection;
}
