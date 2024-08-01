<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BlogCategoryRepository implements BlogCategoryRepositoryInterface
{
    public function destroy($blogCategoryId)
    {
        $blogCategory = BlogCategory::findOrFail($blogCategoryId);
        return $blogCategory->delete();
    }

    public function all()
    {
        return BlogCategory::filtered()->get();
    }

    public function index()
    {
        return BlogCategory::filtered()->paginate();
    }

    public function indexOnline()
    {
        return BlogCategory::paginate();
    }

    public function show($blogCategoryId)
    {
        $blogCategory = BlogCategory::findOrFail($blogCategoryId);
        $blogCategory->load(["parent"]);
        return $blogCategory;
    }

    public function showOnline($blogCategoryId)
    {
        $blogCategory = BlogCategory::findOrFail($blogCategoryId);
        $blogCategory->load(["parent", "children"]);
        return $blogCategory;
    }

    public function store($data): Model|Builder
    {
        $blogCategory = new BlogCategory($data);

        if (Arr::has($data, 'parent.connect') and $parent = BlogCategory::find(Arr::get($data, 'parent.connect'))) {
            $blogCategory->parent()->associate($parent);
        }

        $blogCategory->save();
        $blogCategory->load(["parent"]);

        return $blogCategory;
    }

    public function update(array $data, int $blogCategoryId)
    {
        $blogCategory = BlogCategory::findOrFail($blogCategoryId);
        $blogCategory->fill($data);

        if (Arr::has($data, 'parent.connect')) {
            if ($parent = BlogCategory::find(Arr::get($data, 'parent.connect'))) {
                $blogCategory->parent()->associate($parent);
            } else {
                $blogCategory->parent()->dissociate();
            }
        }

        $blogCategory->load(["parent"]);
        return $blogCategory;
    }
}
