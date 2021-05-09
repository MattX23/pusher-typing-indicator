<?php

namespace App\Http\Transformers;

use App\Models\Transformable;
use Illuminate\Support\Collection;

abstract class Transformer
{
    /**
     * @param \Illuminate\Support\Collection $collection
     * @return \Illuminate\Support\Collection
     */
    public function transformCollection(Collection $collection): Collection
    {
        return $collection->map(function($item) {
            return $this->transform($item);
        });
    }

    /**
     * @param \App\Models\Transformable $message
     * @return array
     */
    abstract function transform(Transformable $message): array;
}
