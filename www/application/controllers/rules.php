<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules extends PES_Controller {

	public function index()
	{
        $model = new PricingRuleModel();

        if (!empty($_POST['submit']))
        {
            if ($model->insert($_POST))
            {
                $this->set_data('alert_success', 'New rule successfully created');
            }
        }

		$this
            ->set_data('rule_form', $this->_partial('rule_form', array('rule' => array())))
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
                    $this->session->set_flashdata('alert_info', 'Rule successfully deleted');
                    redirect('');
                }
            }
            elseif (!empty($_POST['submit']))
            {
                if ($model->update($id, $_POST))
                {
                    $this->session->set_flashdata('alert_info', 'Rule successfully updated');
                    redirect('rules/edit/'.$id);
                }
            }

            $this
                ->set_data('rule_form', $this->_partial('rule_form', array('rule' => $row)))
                ->set_data('page_title', 'Edit "' . $row['name'] . '"')
                ->set_data('rule', $row);
        }
    }
}
