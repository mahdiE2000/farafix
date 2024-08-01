<?php

namespace App\Repositories;

interface BlogCategoryRepositoryInterface
{
    public function destroy( int $blogCategoryId );

    public function all();

    public function index();

    public function indexOnline();

    public function show( int $blogCategoryId );

    public function showOnline( int $blogCategoryId );

    public function store( array $data );

    public function update( array $data , int $blogCategoryId );
}
