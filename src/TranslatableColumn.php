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
        $data = json_decode($model->{$this->attribute}, true);

        $lines = [];

        foreach ($data as $language => $value) {
            $lines[] = "$language: $value";
        }

        return implode($this->separator,$lines);
    }
}