<?php

namespace App\Repositories;

interface BlogRepositoryInterface
{
    public function destroy( int $blogId );

    public function index();

    public function indexOnline();

    public function show( int $blogId );

    public function similarBlogs( int $blogId );

    public function showOnline( int $blogId );

    public function store( array $data );

    public function update( array $data , int $blogId );
}
