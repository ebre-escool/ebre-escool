<?php

namespace App\Repositories\Contracts;

/**
 * Interface EditableRepository
 *
 * @package App\Repositories
 */
interface EditableRepository
{
    public function save(array $input);
}