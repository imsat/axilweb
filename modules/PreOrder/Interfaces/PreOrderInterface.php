<?php

namespace Modules\PreOrder\Interfaces;

interface PreOrderInterface
{
    public function list($request);

    public function create($request);

    public function delete($preOrder);
}
