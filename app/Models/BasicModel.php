<?php

namespace App\Models;

use App\Exceptions\FieldNotExistsException;
use App\Scopes\OrderByIdScope;
use Exception;
use Illuminate\Support\Arr;

trait BasicModel
{
    private int $pageSizeLimit = 48;

    protected static function boot()
    {
        parent::boot();

        if (! app()->runningInConsole()) {
            static::addGlobalScope( new OrderByIdScope );
        }
    }

    public function getPerPage()
    {
        $pageSize = (int) request( 'per_page' , $this->perPage );
        return min( $pageSize , $this->pageSizeLimit );
    }

    public function attributeExists( $attr ): bool
    {

        return array_key_exists( $attr , $this->attributes );
    }

    public function getField( $name )
    {
        $columnName = static::getColumn( $name );
        return $this->$columnName;
    }

    public function setField( $name , $value ): void
    {
        $columnName = static::getColumn( $name );
        $this->$columnName = $value;
    }

    public static function getColumnTable( $name ): string
    {
        return static::getTableName() . '.' . static::getColumn( $name );
    }

    public static function getColumn( $name )
    {
        $fieldName = Arr::get( static::$maps , $name );

        if ( is_null( $fieldName ) ) {
            throw new FieldNotExistsException( "field $name not exists" );
        }

        return $fieldName;
    }

    public function getTable()
    {
        return static::getTableName();
    }

    public function fieldValue( $name )
    {
        return $this->$name;
    }

    public function getAttributes()
    {

        return $this->attributes;
    }

    public function isLoaded( $relationName ): bool
    {
        return isset( $this->relations[ $relationName ] ) and $this->$relationName != null;
    }

    abstract public static function getTableName();
}
