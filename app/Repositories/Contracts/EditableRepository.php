<?php

namespace App\Repositories\Contracts;

/**
 * Interface EditableRepository
 *
 * @package App\Repositories\Contracts
 */
interface EditableRepository
{
    /**
     * Save data to database
     *
     * @param array $input
     * @return mixed
     */
    public function save(array $input);

    /**
     * Refresh/get current database value
     *
     * @param array $input
     * @return mixed
     */
    public function refresh(array $input);
}