<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StatusFilter implements TaskFilterInterface
{
    public function apply(Builder $query, Request $request): Builder
    {
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        return $query;
    }
}
