<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

if ( ! function_exists( 'user' ) ) {
    function user(): ?Authenticatable
    {
        if ( $user = auth( 'api' )->user() ) {
            return $user;
        }
        return null;
    }
}

if ( ! function_exists( 'getLowerCaseName' ) ) {
    function getLowerCaseName($string): string
    {
        return strtolower(preg_replace('%([a-z])([A-Z])%', '\1_\2', $string));
    }
}

if ( ! function_exists( 'removeDirectory' ) ) {
    function removeDirectory( string $path ): void
    {
        $recursiveIterator = new RecursiveDirectoryIterator( $path , RecursiveDirectoryIterator::SKIP_DOTS );
        $files = new RecursiveIteratorIterator( $recursiveIterator , RecursiveIteratorIterator::CHILD_FIRST );
        foreach ( $files as $file ) {
            if ( $file->isDir() ) {
                rmdir( $file->getRealPath() );
            } else {
                unlink( $file->getRealPath() );
            }
        }
        rmdir( $path );
    }
}

if (!function_exists('getNamespaceMap')) {

    function getNamespaceMap(Model $model): string
    {
        return $model->getMorphClass();
    }

}
