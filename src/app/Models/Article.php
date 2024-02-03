<?php

namespace App\Models;

use App\Components\ElasticSearch\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    use HasFactory;
    use Searchable;
}
