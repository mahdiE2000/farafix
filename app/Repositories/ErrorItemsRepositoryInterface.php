<?php

namespace App\Repositories;

interface ErrorItemsRepositoryInterface
{
    public function destroy( int $errorItemId );

    public function index();

    public function indexOnline();

    public function show( int $errorItemId );

    public function showOnline( int $errorItemId );

    public function store( array $data );

    public function update( array $data , int $errorItemId );
}
