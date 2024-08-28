<?php

require __DIR__ . '/App/Charity.php';
require __DIR__ . '/App/Donation.php';

echo "
Press 1 to View charities, 
Press 2 to Add charity, 
Press 3 to Edit charity, 
Press 4 to Delete charity
Press 5 to Donate to charity
Select: ";


// $charity = new Charity($id, $name, $email);
$charity = new Charity('charity');
$donation = new Donation('donation');


$veiksmas = trim(fgets(STDIN));

if ($veiksmas == 1) {
    $charity->showAll();
}

if ($veiksmas == 2) {
    $charity->add();
}

if ($veiksmas == 3) { 
    $charity->edit();
}

if ($veiksmas == 4) { 
    $charity->delete();
}
if ($veiksmas == 5) { 
    $donation->addDonation();
    // $donation->showAll();

}