<?php

namespace App\Http\Controllers\ImportExcel;

use App\Models\ErrorBrand;
use App\Imports\ExcelImport;
use Illuminate\Http\Request;
use App\Models\ErrorCategory;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Console\Commands\ImportBrands;


class StoreBrand extends Controller
{
    public function storeBrand(Request $request)
    {

        $file = $request->file('excel');
        $array = Excel::toArray(new ExcelImport, $file);

        foreach ($array[0] as $index => $subArray) {
                    if($index != 0)
                    {
                        $categoryName = $subArray[0];
                        $brandIds = [];
                        foreach($subArray as $index => $brand) {
                            if($index != 0 and $brand !== null) {
                                $brand = ErrorBrand::updateOrCreate(['name' => $brand], [
                                    'name' => $brand,
                                    'name_en' => $brand
                                ]);

                                $brandIds[] = $brand->id;
                            }
                        }
                        if($categoryName != null)
                        {
                            $category = ErrorCategory::query()->updateOrCreate([
                                'name' => $categoryName,
                                'name_en' => $categoryName
                            ]);
                            $category->errorBrands()->sync($brandIds);
                        }
                    }
            }
    }

}
