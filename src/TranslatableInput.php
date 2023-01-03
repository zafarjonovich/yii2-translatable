<?php

namespace zafarjonovich\Yii2Translatable;

use yii\bootstrap4\Html;
use yii\bootstrap4\Tabs;
use yii\widgets\InputWidget;
use zafarjonovich\Yii2Translatable\TranslatableInputEnum;


class TranslatableInput extends InputWidget
{

    public $input = 'textInput';

    public $inputOptions = [];

    public $type;

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

    protected function initInput($language, $label, $options = [])
    {
        $field = $this->field->form->field($this->model, "{$this->attribute}[$language]",$options);

        if ($this->input == 'textInput') {
            $field->textInput($this->inputOptions);
        } else if ($this->input == 'textarea') {
            $field->textarea($this->inputOptions);
        } else {
            $field->widget($this->input, $this->inputOptions);
        }

        $field->label($label);
        return $field;
    }

    protected function getVertical()
    {
        $inputs = [];

        foreach ($this->getLanguages() as $language => $label) {
            $inputs[] = $this->initInput($language, $label);
        }

        return $inputs;

    }

    protected function getHorizantal()
    {
        $inputs = [];

        foreach ($this->getLanguages() as $language => $label) {
            $inputs[] = [
                'label' => $label,
                'content' => $this->initInput($language, $label,['template'=>'{input}{hint}{error}']),
            ];
        }
        return $inputs;

    }

    public function run()
    {
        parent::run();

        if ($this->type == TranslatableInputEnum::TYPE_HORIZANTAL) {

            return Tabs::widget([
                'options' => [
                    'class' => 'nav-tabs',
                    'style' => 'margin-bottom: 15px',
                ],
                'items' => $this->getHorizantal(),
            ]);
        } else {

            $inputs = $this->getVertical();

            return implode("\n", $inputs);
        }

    }
}