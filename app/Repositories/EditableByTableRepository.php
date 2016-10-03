<?php

namespace App\Repositories;

use App\Repositories\Contracts\EditableRepository;

/**
 * Class EditableByTableRepository
 *
 * @package App\Repositories
 */
class EditableByTableRepository implements EditableRepository {

    /**
     * Save editable to database
     *
     * @param array $input
     */
    public function save(array $input)
    {
        // TODO: Implement save() method.
    }

    /**
     * Refresh/get current database value
     *
     * @param array $input
     * @return mixed
     */
    public function refresh(array $input)
    {
        // TODO: Implement refresh() method.
    }
}