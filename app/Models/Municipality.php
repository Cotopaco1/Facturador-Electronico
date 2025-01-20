<?php

namespace App\Models;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model implements Searchable
{
    //
    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->name);
    }
}
