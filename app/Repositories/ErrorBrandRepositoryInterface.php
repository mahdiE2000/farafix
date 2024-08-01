<?php

namespace App\Repositories;

interface ErrorBrandRepositoryInterface
{
    public function index();

    public function show( int $errorBrandId );
}
