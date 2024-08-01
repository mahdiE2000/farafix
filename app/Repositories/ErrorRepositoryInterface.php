<?php

namespace App\Repositories;

interface ErrorRepositoryInterface
{
    public function destroy( int $errorId );

    public function all();

    public function index();

    public function indexOnline();

    public function show( int $errorId );

    public function showOnline( int $errorId );

    public function showOnlineByName( string $errorName );

    public function store( array $data );

    public function update( array $data , int $errorId );
}
