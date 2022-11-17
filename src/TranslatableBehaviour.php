<?php

namespace zafarjonovich\Yii2Translatable;

use yii\base\Behavior;

class TranslatableBehaviour extends Behavior
{
    public const EVENT_ENCODE = 'TRANSLATABLE_EVENT_ENCODE';

    public const EVENT_DECODE = 'TRANSLATABLE_EVENT_DECODE';

    public $languages = [];

    public $attributes = [];

    public function events()
    {
        return [
            self::EVENT_ENCODE => 'encodeTranslation',
            self::EVENT_DECODE => 'decodeTranslation',
        ];
    }

    public function encodeTranslation()
    {
        foreach ($this->attributes as $attribute) {
            $this->encode($attribute);
        }
    }

    protected function encode($attribute)
    {
        $value = $this->owner->{$attribute};
        if (!is_array($value)) {
            $value = [];
        }

        $this->owner->{$attribute} = json_encode($value);
    }

    public function decodeTranslation()
    {
        foreach ($this->attributes as $attribute) {
            $this->decode($attribute);
        }
    }

    protected function decode($attribute)
    {
        $value = $this->owner->{$attribute};
        $value = json_decode($value,true);

        if ($value === null) {
            $value = [];
        }

        $this->owner->{$attribute} = $value;
    }
}