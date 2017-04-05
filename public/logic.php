<?php
require('Form.php');
use DWA\Form;

$form = new Form($_GET);

# bring form values into useful variables
$tab = $form->get('tab', '');
$partySize = $form->get('partySize', '');
$quality = $form->get('quality', '');
$roundUp = $form->isChosen('roundUp');
$errors = false;

if ($form->isSubmitted()) {

  $errors = $form->validate([
    'tab' => 'required|min:0',
    'partySize' => 'required|min:1',
  ]);

  # quantify the tab
  $tab = floatval($tab);

  #quantify the party size
  $partySize = intval($partySize);

  # quantify the quality
  $tipFactor = 1.18;
  if ($quality == 'bad') {
    $tipFactor = 1.14;
  } elseif ($quality == 'excellent') {
    $tipFactor = 1.22;
  }

  # calculate the amount each person owes.
  $amount = $tab*$tipFactor/$partySize;

  # round up if necessary
  if ($roundUp == true) {
    $amount = ceil($amount);
  } else {
    $amount = round($amount, 2);
  }
}
