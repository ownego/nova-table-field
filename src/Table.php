<?php

namespace Ownego\Table;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Table extends Field
{
    public $showOnIndex = false;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'table';

    /**
     * Table keys
     *
     * @param array $headers
     * @return Table
     */
    public function headers(array $headers)
    {
        return $this->withMeta([
            'headers' => $headers,
        ]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute], true);
        }
    }
}
