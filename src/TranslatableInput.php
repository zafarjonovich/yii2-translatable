<?php

namespace zafarjonovich\Yii2Translatable;

use yii\bootstrap4\Html;
use yii\widgets\InputWidget;

class TranslatableInput extends InputWidget
{
    public $input = 'textInput';

    public $inputOptions = [];

    protected function getLanguages()
    {
        if (!$this->model->hasProperty('languages')) {
            throw new \Exception('Model must set ' . TranslatableBehaviour::class);
        }
        return $this->model->languages;
    }

    protected function getInputName($language)
    {
        return "$this->attribute[$language]";
    }

    protected function initInput($language,$label)
    {
        $field = $this->field->form->field($this->model,"{$this->attribute}[$language]");

        if ($this->input == 'textInput') {
            $field->textInput($this->inputOptions);
        } else if ($this->input == 'textarea') {
            $field->textarea($this->inputOptions);
        } else {
            $field->widget($this->input,$this->inputOptions);
        }

        $field->label($label);
        return $field;
    }

    public function run()
    {
        parent::run();

        $inputs = [];

        foreach ($this->getLanguages() as $language => $label) {
            $inputs[] = $this->initInput($language,$label);
        }

        return implode("\n",$inputs);
    }
}