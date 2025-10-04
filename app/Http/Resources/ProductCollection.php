<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public $collects = ProductResource::class;

    public function toArray($request): array
    {
        $data = $this->collection->map(function ($resource) use ($request) {
            return $resource instanceof ProductResource
                ? $resource->toArray($request)
                : (new ProductResource($resource))->toArray($request);
        })->all();

        $paginator = $this->resource instanceof LengthAwarePaginator ? $this->resource : null;

        return [
            'data' => $data,
            'meta' => $paginator ? [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ] : [
                'current_page' => 1,
                'per_page' => count($data),
                'total' => count($data),
                'last_page' => 1,
            ],
            'links' => $paginator ? [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ] : [
                'first' => null,
                'last' => null,
                'prev' => null,
                'next' => null,
            ],
        ];
    }
}
