<?php
require('../app/Form.php');
use DWA\Form;

$form = new Form($_GET);

# bring form values into useful variables
$tab = $form->get('tab', '');
$partySize = $form->get('partySize', '');
$quality = $form->get('quality', '');
$roundUp = $form->isChosen('roundUp');
$errors = false;

if ($form->isSubmitted()) {

  # quantify the tab
  $tab = floatval($tab);
  #quantify the party size
  $partySize = intval($partySize);
  # quantify the tipFactor (quality)
  $tipFactor = 1.18;
  if ($quality == 'bad') {
    $tipFactor = 1.14;
  } elseif ($quality == 'excellent') {
    $tipFactor = 1.22;
  }

  # validate the numeric data
  $validator = Validator::make(
    [
      'tab' => $tab,
      'partySize' => $partySize,
    ],
    [
      'tab' => 'required|numeric|min:0',
      'partySize' => 'required|numeric|integer|min:1',
    ]
  );
  if ($validator->fails())
  {
    $errors = $validator->messages();
  }
  else {
    $errors = false;
    # calculate the amount each person owes.
    $amount = $tab*$tipFactor/$partySize;

    # round up if necessary
    if ($roundUp == true) {
      $amount = ceil($amount);
    }
  }
}
