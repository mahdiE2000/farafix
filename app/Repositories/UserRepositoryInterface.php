<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function destroy(int $userId);

    public function index();

    public function show(int $userId);

    public function changeRole(int $userId);

    public function showMyInfo();

    public function store(array $data);

    public function update(array $data, int $userId);
}
