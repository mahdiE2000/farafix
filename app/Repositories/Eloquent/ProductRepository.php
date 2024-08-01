<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\ProductVariation;
use App\Repositories\ProductRepositoryInterface;
use App\Services\Media\MediaHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ProductRepository implements ProductRepositoryInterface
{
    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);
        foreach ($product->variations as $item) {
            $item->delete();
        }
        return $product->delete();
    }

    public function index()
    {
        return Product::with([
            "category" => function ($q) {
                $q->with("ancestors");
            },
            "variations",
            "main_image"
        ])->filtered()->paginate();
    }

    public function indexOnline(): LengthAwarePaginator
    {
        return Product::with([
            "category" => function ($q) {
                $q->with("ancestors");
            },
            "variations",
            "main_image"
        ])->paginate();
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $product->load([
            "category" => function ($q) {
                $q->with("ancestors");
            },
            "variations",
            "main_image" ,
            "media"
        ]);
        return $product;
    }

    public function similarProducts($productId)
    {
        $product = Product::findOrFail($productId);
        $productCategoryId = $product->category ? $product->category->id : 0;
        $similarProducts = Product::query()
            ->whereHas(
                'category', function ($query) use ($productCategoryId) {
                $query->where('id', $productCategoryId);
            })
            ->with([
                "category" => function ($q) {
                    $q->with("ancestors");
                },
                "variations",
                "main_image"
            ])
            ->get();
        if ( ! $similarProducts->isEmpty()) {
            $similarProductsCount = $similarProducts->count();
            $similarSelectedProductsCount = min($similarProductsCount, 8);
            return $similarProducts->random($similarSelectedProductsCount);
        } else {
            return $similarProducts;
        }
    }

    public function showOnline($productId)
    {
        $product = Product::findOrFail($productId);
        $product->load([
            "category" => function ($q) {
                $q->with("ancestors");
            },
            "variations",
            "main_image" ,
            "media"
        ]);
        return $product;
    }

    public function store($data): Model|Builder
    {
        $product = Product::query()->create(Arr::except($data, "variations"));

        MediaHelper::storeMediaFor($product);

        if (Arr::has($data, "variations")) {
            foreach ($data[ "variations" ] as $variation) {
                $product->variations()->create($variation);
            }
        }

        $product->load([
            "category" => function ($q) {
                $q->with("ancestors");
            },
            "variations",
            "main_image"
        ]);
        return $product;
    }

    public function update(array $data, int $productId)
    {
        $product = Product::findOrFail($productId);
        $product->update($data);

        MediaHelper::storeMediaFor($product);

        if (Arr::has($data, "variations")) {
            foreach ($data[ "variations" ] as $variation) {
                ProductVariation::query()->create($variation);
            }
        }

        $product->load([
            "category" => function ($q) {
                $q->with("ancestors");
            },
            "variations",
            "main_image"
        ]);
        return $product;
    }
}
