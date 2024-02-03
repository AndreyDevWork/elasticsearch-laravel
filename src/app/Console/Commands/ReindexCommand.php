<?php

namespace App\Console\Commands;

use App\Models\Article;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "search:reindex";

    protected $description = "Indexes all articles to Elasticsearch";
    protected $client;
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ClientBuilder $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
        $this->client = $elasticsearch
            ::create()
            ->setHosts(["elasticsearch:9200"])
            ->build();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Indexing all articles. This might take a while...");
        foreach (Article::cursor() as $article) {
            $indexParams = [
                "index" => $article->getSearchIndex(),
                "id" => $article->getKey(),
                "body" => $article->toSearchArray(),
            ];

            $this->client->index($indexParams);
            $this->output->write(".");
        }
        $this->info('\nDone!');
    }
}
