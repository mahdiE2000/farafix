<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductCategory;
use App\Repositories\ProductCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function destroy($productCategoryId)
    {
        $productCategory = ProductCategory::findOrFail($productCategoryId);
        return $productCategory->delete();
    }

    public function all()
    {
        return ProductCategory::filtered()->get();
    }

    public function index()
    {
        return ProductCategory::filtered()->paginate();
    }

    public function indexOnline()
    {
        return ProductCategory::paginate();
    }

    public function show($productCategoryId)
    {
        $productCategory = ProductCategory::findOrFail($productCategoryId);
        $productCategory->load(["parent"]);
        return $productCategory;
    }

    public function showOnline($productCategoryId)
    {
        $productCategory = ProductCategory::findOrFail($productCategoryId);
        $productCategory->load(["parent", "children"]);
        return $productCategory;
    }

    public function store($data): Model|Builder
    {
        $productCategory = new ProductCategory($data);

        if (Arr::has($data, 'parent.connect') and $parent = ProductCategory::find(Arr::get($data, 'parent.connect'))) {
            $productCategory->parent()->associate($parent);
        }

        $productCategory->save();
        $productCategory->load(["parent"]);

        return $productCategory;
    }

    public function update(array $data, int $productCategoryId)
    {
        $productCategory = ProductCategory::findOrFail($productCategoryId);
        $productCategory->fill($data);

        if (Arr::has($data, 'parent.connect')) {
            if ($parent = ProductCategory::find(Arr::get($data, 'parent.connect'))) {
                $productCategory->parent()->associate($parent);
            } else {
                $productCategory->parent()->dissociate();
            }
        }

        $productCategory->load(["parent"]);
        return $productCategory;
    }
}
