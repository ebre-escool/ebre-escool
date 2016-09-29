<?php

use Illuminate\Database\Eloquent\Model;

if (! function_exists('editable_model_encode')) {

    /**
     * Encode Laravel model to json
     *
     * @param Model $model
     * @return stdClass
     */
    function editable_model_encode(Model $model)
    {
        $field = new stdClass();
        $field->model = get_class($model);
        $field->id = $model->{$model->getKeyName()};
        return $field;
    }
}

if (! function_exists('editable_field')) {

    /**
     * Encode field to json
     *
     * @param Model $model
     * @param $field_name
     * @return string
     */
    function editable_field(Model $model, $field_name)
    {
        $field = editable_model_encode($model);
        $field->name = $field_name;
        return json_encode($field);
    }
}

if (! function_exists('editable_model')) {

    /**
     * Encode model to json
     *
     * @param Model $model
     * @return string
     */
    function editable_model(Model $model)
    {
        $field = editable_model_encode($model);
        return json_encode($field);
    }

}
