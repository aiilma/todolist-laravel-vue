<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DeadlineFilter implements TaskFilterInterface
{
    public function apply(Builder $query, Request $request): Builder
    {
        if ($request->has('deadline')) {
            $query->where('deadline', '<=', $request->deadline);
        }
        return $query;
    }
}
