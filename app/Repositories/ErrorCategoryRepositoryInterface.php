<?php

namespace App\Repositories;

interface ErrorCategoryRepositoryInterface
{
    public function index();

    public function all();

    public function show( int $errorCategoryId );

    public function store( $data );

    public function destroy(int $errorCategoryId);
}
