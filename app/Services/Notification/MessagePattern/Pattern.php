<?php

    namespace App\Services\Notification\MessagePattern;

    use Illuminate\Database\Eloquent\Model;

    class Pattern
    {

        protected string $pattern;

        public function __construct( $pattern )
        {
            $this->pattern = $pattern;
        }

        public function fill( $model ): string
        {
            $replacements = $this->findReplacements( $model );
            return strtr( $this->pattern , $replacements );
        }

        protected function findReplacements( $model , $prefix = '{' , $postfix = '}' ): array
        {
            $replacements = [];
            foreach ( $model->messageFields as $field ) {
                list( $nickName , $value ) = $this->getFieldValue( $model , $field );
                $replacements[ $prefix . $nickName . $postfix ] = $value;
            }
            if ( config( 'notification.fields' ) ) {
                foreach ( config( 'notification.fields' ) as $name => $field ) {
                    $replacements[ $prefix . $name . $postfix ] = $field;
                }
            }
            return $replacements;
        }

        protected function getFieldValue( Model $model , string $messageField ): array
        {
            $parts = explode( ' as ' , $messageField );
            if ( count( $parts ) == 2 and $this->isRelation( $parts[ 0 ] ) ) {
                list( $relation , $field ) = $this->splitRelationField( $parts[ 0 ] );
                $model->loadMissing( $relation );
                $key = $parts[ 1 ];
                $value = $model->$relation ? $model->$relation->$field : '';
            } else {
                $key = $messageField;
                $value = $model->$messageField;
            }
            return [ $key , $value ];
        }

        protected function isRelation( $field ): bool
        {
            return str_contains( $field , ':' );
        }

        protected function splitRelationField( $field ): array
        {
            $parts = explode( ':' , $field );
            $partsCount = count( $parts );
            return [ implode( '.' , array_slice( $parts , 0 , $partsCount - 1 ) ) , $parts[ $partsCount - 1 ] ];
        }

        public function getPattern(): string
        {
            return $this->pattern;
        }

    }
