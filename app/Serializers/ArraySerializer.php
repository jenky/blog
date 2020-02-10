<?php

namespace App\Serializers;

use League\Fractal\Serializer\ArraySerializer as BaseArraySerializer;

class ArraySerializer extends BaseArraySerializer
{
    public function mergeIncludes($transformedData, $includedData)
    {
        $includedData = array_map(function ($include) {
            return (isset($include['data']) && is_array($include['data'])) ? $include['data'] : $include;
        }, $includedData);

        return parent::mergeIncludes($transformedData, $includedData);
    }
}
