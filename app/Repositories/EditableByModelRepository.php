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
        $this->checkClassExists($input);
        $model = (new $input['model']);

        $this->checkIsEloquentModel($model);

        $this->checkColumnExists($input, $model);

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

    /**
     * Check class exists
     * @param $input
     * @throws ClassNotFoundException
     */
    private function checkClassExists($input)
    {
        if (!class_exists($input['model'])) {
            throw new ClassNotFoundException('Class: ' . $input['model'] . ' not found!');
        }
    }

    /**
     * Check model is a Laravel Eloquent model
     * @param $model
     * @return mixed
     * @throws NotEloquentModelException
     */
    private function checkIsEloquentModel($model)
    {
        if (!is_a($model, Model::class)) {
            throw new NotEloquentModelException('Class: ' .  get_class($model) . ' is not and Eloquent Model!');
        }
    }

    /**
     * @param $input
     * @param $model
     * @throws ColumnNotFoundException
     */
    private function checkColumnExists($input, $model)
    {
        $table = $model->getTable();
        if (!Schema::hasColumn($table, $input['fieldname'])) {
            throw new ColumnNotFoundException('Column ' . $input['fieldname'] . ' not found in table ' . $table);
        }
    }
}