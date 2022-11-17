<?php

namespace zafarjonovich\Yii2Translatable;

trait GetTranslationTrait
{
    public function getTranslation($attribute,$default = 'en')
    {
        $value = $this->{$attribute};
        if (!is_array($value)) {
            $value = json_decode($value,true);
        }
        return $value[\Yii::$app->language] ?? $value[$default] ?? $value;
    }
}