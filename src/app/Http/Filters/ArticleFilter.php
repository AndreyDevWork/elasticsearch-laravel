<?php

namespace App\Http\Filters;

use App\Components\ElasticSearch\SearchableRepository;
use App\Models\Article;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ArticleFilter implements SearchableRepository
{
    private $elasticsearch;

    public function __construct(ClientBuilder $clientBuilder)
    {
        $this->elasticsearch = $clientBuilder
            ::create()
            ->setHosts(["elasticsearch:9200"])
            ->build();
    }

    private function searchOnElasticsearch(string $query = ""): array
    {
        $model = new Article();
        $items = $this->elasticsearch->search([
            "index" => $model->getSearchIndex(),
            "body" => [
                "query" => [
                    "multi_match" => [
                        "fields" => ["title^5", "body"],
                        "query" => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    public function search(string $query = ""): Collection
    {
        $items = $this->searchOnElasticsearch($query);
        return $this->buildCollection($items);
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items["hits"]["hits"], "_id");
        return Article::findMany($ids)->sortBy(function ($article) use ($ids) {
            return array_search($article->getKey(), $ids);
        });
    }
}
