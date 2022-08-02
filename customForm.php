<?php
/**
 * @file
 * Contains \Drupal\customform\Form\customForm.
 */
namespace Drupal\customblock\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class customForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['music'] = array(
      '#type' => 'radios',
      '#title' => t('What kind of music do you like?'),
      '#options' => [
        'jazz' => 'Jazz',
        'rock' => 'Rock',
        'pop' => 'Pop',
        'metal' => 'Metal',
      ],
      '#required' => true,
    );


    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('submit'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $type = $form_state->getValues()['music'];

    $config = \Drupal::service('config.factory')->getEditable('music.settings');
    $value = $config->get($type) + 1;
    $config->set($type, $value)->save();

    \Drupal::messenger()->addMessage($this->t('The number of people that like <b>@name</b> is @count', array('@count' => $config->get($type), '@name' => $type)));
  }
}
