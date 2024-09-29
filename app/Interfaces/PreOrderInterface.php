<?php

namespace App\Interfaces;

interface PreOrderInterface
{
    public function list($request);

    public function create($request);

    public function delete($preOrder);
}
