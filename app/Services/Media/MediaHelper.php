<?php

namespace App\Services\Media;

use App\Models\FakeModel;
use Illuminate\Database\Eloquent\Model;

class MediaHelper
{
    public static function moveMediaTo( $model )
    {
        request()->validate( [
            'file_batch_id' => 'nullable|string' ,
        ] );
        if ( $fakeModel = FakeModel::where( 'batch_id' , request( 'file_batch_id' ) )->first() ) {
            foreach ( $fakeModel->getMedia( 'temp_files' ) as $media ) {
                if ( str_starts_with( $media->mime_type , 'image' ) ) {
                    $media->move( $model , 'images' );
                } else {
                    $media->move( $model , 'files' );
                }
            }
            $fakeModel->delete();
        }
    }

    public static function storeMediaFor( Model $model , string $batchId = null )
    {
        if ( is_null( $batchId ) ) {
            $batchId = request()->input( 'file_batch_id' );
        }
        $modelName = getLowerCaseName(class_basename($model));
        if ( $fakeModel = FakeModel::where( 'batch_id' , $batchId )->where( 'model_name' , $modelName )->first() ) {
            foreach ( $fakeModel->media()->get() as $media ) {
                $media->move( $model , $media->collection_name );
            }
            $fakeModel->delete();
        }
    }

    public static function moveTinyMCEMediaTo( $model )
    {
        request()->validate( [
            'tinymce_batch_id' => 'nullable|string' ,
        ] );
        if ( $fakeModel = FakeModel::where( 'batch_id' , request( 'tinymce_batch_id' ) )->first() ) {
            foreach ( $fakeModel->getMedia( 'temp_files' ) as $media ) {
                if ( str_starts_with( $media->mime_type , 'image' ) ) {
                    $media->assign( $model , 'tinymce_images' );
                } else {
                    $media->assign( $model , 'tinymce_files' );
                }
            }
            $fakeModel->delete();
        }
    }

    public static function loadMedia( $model , ...$collections )
    {
        $model->loadMissing( [ 'media' => function ( $query ) use ( $collections ) {
            $query->select( '*' );
            if ( ! empty( $collections ) ) {
                $query->whereIn( 'collection_name' , $collections );
            }
        } ] );
        if ( $model->media ) {
            foreach ( $model->media as $media ) {
                $media->address = $media->getUrl();
            }
        }
    }
}
