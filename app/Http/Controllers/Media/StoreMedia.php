<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Request\StoreMediaRequest;
use App\Models\FakeModel;
use App\Services\Responser;
use Illuminate\Http\Request;

class StoreMedia extends Controller
{
    public function __invoke(StoreMediaRequest $request)
    {
        $nameSpace = "App\\Models\\" . ucfirst($request->input('model_name'));

        if (! $nameSpace::isValidMediaCollection($request->input('collection_name'))) {
            return response()->json(
                Responser::error( [
                    "مشکل در دسته بندی" => 'دسته بندی ارائه شده تعریف نشده است.'
                ]),
                422
            );
        }

        $fakeModel = FakeModel::firstOrCreate([
            'batch_id' => $request->input('batch_id'),
            'model_name' => $request->input('model_name'),
        ]);
        if ($request->hasFile('file')) {
            $media = $fakeModel->addMedia($request->file('file'));
        } elseif($request->has('url')) {
            $media = $fakeModel->addMediaFromUrl($request->input('url'));
        } else {
            return Responser::error();
        }

        if (!empty($request->input('crop'))) {
            $media = $media->withCustomProperties(['crop' => $request->input('crop')]);
        }

        $media = $media->toMediaCollection($request->input('collection_name'));

        return response()->json(
            Responser::success(
                'فایل مورد نظر ذخیره شد.',
                null,
                ['id' => $media->id, 'url' => $media->getUrl()]
            )
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'batch_id' => 'required|max:50',
            'file' => 'required|mimes:jpeg,jpg,bmp,png,pdf'
        ], [
            'required' => trans('validations.required'),
            'max' => trans('validations.max', ['number' => 255]),
            'mimes' => trans('validations.mimes', ['types' => 'jpeg,jpg,bmp,png']),
        ]);
        $fakeModel = FakeModel::firstOrCreate(['batch_id' => $request->input('batch_id')]);
        $media = $fakeModel->addMedia($request->file('file'))->toMediaCollection('temp_files');

        return response()->json(
            Responser::success(
                'فایل با موفقیت بارگزاری گردید',
                null,
                ['id' => $media->id, 'url' => $media->getUrl()]
            )
        );
    }
}
