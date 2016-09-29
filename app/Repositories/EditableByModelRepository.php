<?php

namespace App\Repositories;

use App\Exceptions\ColumnNotFoundException;
use App\Repositories\Contracts\EditableRepository;
use App\Exceptions\ClassNotFoundException;
use App\Exceptions\NotEloquentModelException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Schema;

/**
 * Class EditableByModelRepository
 *
 * @package App\Repositories
 */
class EditableByModelRepository implements EditableRepository {

    /**
     * Save editable to database
     *
     * @param array $input
     */
    public function save(array $input)
    {
        try {
            $this->validate($input);
            $modelClass =  $input['model'];
            $model = $modelClass::findOrFail($input['tableid']);
            $model->{$input['fieldname']} = $input['content'];
            $model->save();
        } catch (\Exception $exception) {
            throw $exception;
//            $this->handleException($exception);
        }

    }

    /**
     * Validate input before execution of save
     *
     * @param $input
     * @throws ClassNotFoundException
     * @throws ColumnNotFoundException
     * @throws NotEloquentModelException
     */
    private function validate($input)
    {
        if ( !class_exists ( $input['model'] ) ) {
            throw new ClassNotFoundException('Class: ' . $input['model'] . ' not found!' );
        }
        if ( is_a($model = (new $input['model']), Model::class )) {
            $table = $model->getTable();
            if( ! Schema::hasColumn($table, $input['fieldname']) )
            {
                throw new ColumnNotFoundException('Column ' . $input['fieldname'] .  ' not found in table ' . $table );
            }
        } else {
            throw new NotEloquentModelException('Class: ' . $input['model'] . ' is not and Eloquent Model!' );
        }
    }

    /**
     * Handle exceptions.
     *
     * @param $exception
     * @return string
     */
    private function handleException($exception)
    {
        //TODO
        if ($exception instanceof ModelNotFoundException) {
            return "";
        }
        if ($exception instanceof ClassNotFoundException) {
            return "";
        }
        return "";
    }
}