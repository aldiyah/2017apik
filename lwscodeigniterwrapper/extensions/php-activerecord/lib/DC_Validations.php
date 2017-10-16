<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DC_Validations
 *
 * @author morpheus
 */
require 'Validations.php';

class DC_Validations extends Validations {

//    private $ci_error_messages = array();
    private $ci_form;

    public function __construct(AR_model $model)
    {
        Reflections::instance()->add(get_class($model))->get(get_class($model));
        parent::__construct($model);
        $this->ci_form = &load_class('Form_validation');
    }

    public function validate()
    {
        $rules = $this->klass->getStaticPropertyValue("rules");
        if (is_array($rules) && count($rules) > 0)
        {
            foreach ($rules as $rule)
            {
                if (count($rule) == 0)
                    continue;
                $attr = $rule[0];
                $rule_param = explode("|", $rule[1]);
                $this->_validate($attr, $rule_param);
            }
        }

        $model_reflection = Reflections::instance()->get($this->model);

        if ($model_reflection->hasMethod('validate') && $model_reflection->getMethod('validate')->isPublic())
            $this->model->validate();

        $this->record->clear_model();
        return $this->record;
    }

    private function _validate($attribute, $rules)
    {
        $var = $this->model->$attribute;
        $this->ci_form->_execute(array(
            'field' => $attribute,
            'is_array' => FALSE,
            'label' => $this->model->get_label($attribute)
        ), $rules, $var);
        
        $error = $this->ci_form->error($attribute);
        if ($error != '')
        {
            $this->record->add($attribute, $error);
        }
    }
}

/** End of DC_Validations **/