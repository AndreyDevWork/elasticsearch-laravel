<?php

namespace App\Components\ElasticSearch;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchObserver
{
    private $elasticsearch;

    public function __construct(ClientBuilder $clientBuilder)
    {
        $this->elasticsearch = $clientBuilder
            ::create()
            ->setHosts(["elasticsearch:9200"])
            ->build();
    }

    public function saved($model)
    {
        $this->elasticsearch->index([
            "index" => $model->getSearchIndex(),
            "id" => $model->getKey(),
            "body" => $model->toSearchArray(),
        ]);
    }

    public function deleted($model)
    {
        $this->elasticsearch->delete([
            "index" => $model->getSearchIndex(),
            "id" => $model->getKey(),
        ]);
    }
}
