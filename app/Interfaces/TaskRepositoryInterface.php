<?php

namespace App\Interfaces;

interface TaskRepositoryInterface
{
    public function get(array $request = []);
    public function create(array $details);
}
