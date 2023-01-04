<?php

namespace zafarjonovich\Yii2Translatable;

use common\models\LandingElement;
use yii\grid\Column;

class TranslatableColumn extends Column
{
    public $attribute;

    public $separator = "\n\n";

    protected function renderDataCellContent($model, $key, $index)
    {
        $data = $model->{$this->attribute};

        if (!is_array($data)) {
            $data = json_decode($data, true);
        }

        $lines = [];

        foreach ($data as $language => $value) {
            $lines[] = "$language: $value";
        }

        return implode($this->separator,$lines);
    }
}