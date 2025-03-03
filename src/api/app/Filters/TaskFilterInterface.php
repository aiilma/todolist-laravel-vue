<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface TaskFilterInterface
{
    public function apply(Builder $query, Request $request): Builder;
}
