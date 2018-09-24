<?php

namespace MiniFw\Lib;

use MiniFw\Model\BaseModel;

/**
 * Class ModelManager
 * @package MiniFw\Lib
 */
class ModelManager
{
    public static function getModelProperties(BaseModel $model, array $exclude = []): array
    {
        $result = [];
        $properties = get_object_vars($model);
        foreach (array_keys($properties) as $item) {
            if (!in_array($item, $exclude))
                $result[] = $item;
        }
        return $result;
    }
}