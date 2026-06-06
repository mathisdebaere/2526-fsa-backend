<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    protected function perPage(Request $request, int $default = 18): int
    {
        return min(max(1, (int) $request->input('per_page', $default)), 100000);
    }

    protected function parseIncludes(Request $request, array $allowed): array
    {
        if (! $request->filled('include')) {
            return [];
        }

        return array_values(array_intersect(
            explode(',', $request->input('include')),
            $allowed
        ));
    }
}
