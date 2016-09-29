<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use stdClass;

trait Editable {

    /**
     * Encode Laravel model to json
     *
     * @param Model $model
     * @return stdClass
     */
    protected function editable_model_encode(Model $model)
    {
        $field = new stdClass();
        $field->table = $model->getTable();
        $field->id = $model->{$model->getKeyName()};
        return $field;
    }

    /**
     * Encode field to json
     *
     * @param Model $model
     * @param $field_name
     * @return string
     */
    public static function editable_field(Model $model, $field_name)
    {
        $editable = new static;
        $field = $editable.editable_model_encode($model);
        $field->name = $field_name;
        return json_encode($field);
    }

    /**
     * Encode model to json
     *
     * @param Model $model
     * @return string
     */
    public static function editable_model(Model $model)
    {
        $editable = new static;
        $field = $editable.editable_model_encode($model);
        return json_encode($field);
    }
}