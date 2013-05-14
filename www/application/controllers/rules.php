<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules extends PES_Controller {

	public function index()
	{
        $model = new PricingRuleModel();

        if (!empty($_POST['submit']))
        {
            $fields = $this->_prepareFields($_POST);

            if ($model->insert($fields))
            {
                rule_update_favicon($fields);
                $this->set_data('alert_success', 'New rule successfully created');
            }
        }

		$this
            ->set_data('rule_form', $this->_ruleForm())
            ->set_data('page_title', 'Pricing Rules')
            ->set_data('rules', $model->index());
	}

    public function edit($id)
    {
        $model = new PricingRuleModel();
        $row = $model->get($id);

        if (!$row)
        {
            $this->session->set_flashdata('alert_error', 'Unable to find the requested rule.');
            redirect('');
        }
        else
        {
            if (!empty($_POST['delete']))
            {
                if ($model->delete($id))
                {
                    rule_delete_favicon($id);
                    $this->session->set_flashdata('alert_info', 'Rule successfully deleted');
                    redirect('');
                }
            }
            elseif (!empty($_POST['submit']))
            {
                $fields = $this->_prepareFields($_POST);
                if ($model->update($id, $fields))
                {
                    $fields['_id'] = $id;
                    rule_update_favicon($fields);
                    $this->session->set_flashdata('alert_info', 'Rule successfully updated');
                    redirect('rules/edit/'.$id);
                }
            }

            $this
                ->set_data('rule_form', $this->_ruleForm($row))
                ->set_data('page_title', 'Edit "' . $row['name'] . '"')
                ->set_data('rule', $row);
        }
    }

    protected function _prepareFields($values) {

        $values['narrow_rule_is_regex'] = !empty($values['narrow_rule_is_regex']);
        $values['broad_rules'] = explode("\n", $values['broad_rules']);

        if (empty($values['severity']) OR $values['severity'] !== 'Email plus')
        {
            unset($values['extra_factor']);
            unset($values['new_extra_factor']);
        }
        else
        {
            if (empty($values['extra_factor']))
            {
                $values['extra_factor'] = $values['new_extra_factor'];
            }
            else
            {
                unset($values['new_extra_factor']);
            }
        }

        return $values;
    }

    protected function _ruleForm($rule = array())
    {
        $model = new PricingRuleModel();

        $extra_factors = $model->extraFactors();
        $options = count($extra_factors) ? array_to_assoc($extra_factors) : array();
        $options = array_merge(array(' - Select One - '), $options);

        $this->add_script('pages/rules_form.jquery.js');

        return $this->_partial('rule_form', array(
            'rule' => $rule,
            'extra_factors_options' => $options,
        ));
    }
}
