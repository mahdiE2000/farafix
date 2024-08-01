<?php

namespace App\Repositories;

interface ProductCategoryRepositoryInterface
{
    public function destroy( int $productCategoryId );

    public function all();

    public function index();

    public function indexOnline();

    public function show( int $productCategoryId );

    public function showOnline( int $productCategoryId );

    public function store( array $data );

    public function update( array $data , int $productCategoryId );
}
