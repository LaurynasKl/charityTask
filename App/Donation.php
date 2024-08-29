<?php

class Donation
{

    public $id;
    public $donorName;
    public $amount;
    public $charityId;
    public $dateTime;

    private $donorData = [];
    public $charitiesData = [];

    private $donorId;
    private $donorFile;
    public $charityFile;



    public function __construct($charityName, $donationName)
    {

        $this->donorFile = __DIR__ . "/../data/$donationName.json";
        $this->donorId = __DIR__ . "/../data/$donationName-id.json";
        if (!file_exists($this->donorFile)) {
            file_put_contents($this->donorFile, json_encode([]));
            file_put_contents($this->donorId, json_encode(1));
        }

        $this->donorData = json_decode(file_get_contents($this->donorFile));
        $this->id = json_decode(file_get_contents($this->donorId));
    }

    public function __destruct()
    {
        file_put_contents($this->donorFile, json_encode($this->donorData));
        file_put_contents($this->donorId, json_encode($this->id));
    }

    public function addDonation()
    {
        $donation = [];
        $donation['id'] = $this->id;
        $this->id++;

        echo 'Donor name: ';
        $donation['name'] = trim(fgets(STDIN));

        echo "Amount: ";
        $donation['amount'] = (int)trim(fgets(STDIN));

        echo "\nAll charities\n";
        $this->showAll('charity');
        echo 'Select charity number: ';
        $donation['charityId'] = (int)trim(fgets(STDIN));

        $donation['time'] = date("Y-m-d G:i");
        $this->donorData[] = $donation;
    }

    public function showAll($name)
    {
        $charityFile = __DIR__ . "/../data/$name.json";
        if (file_exists($charityFile)) {
            $allCharities = json_decode(file_get_contents($charityFile));
        }
        if (!empty($allCharities)) {
            foreach ($allCharities as $value) {
                echo "Number: $value->id \n";
                echo "name: $value->name \n";
                echo "email: $value->email \n\n";
            }
        } else {
            echo 'nepavyko';
        }
    }

    public function allDonations($name)
    {
        $charityFile = __DIR__ . "/../data/$name.json";
        if (file_exists($charityFile)) {
            $allCharities = json_decode(file_get_contents($charityFile));
        }
        if (!empty($allCharities)) {
            foreach ($allCharities as $charity) {
            }
            foreach ($this->donorData as $donor) {
                echo "\n$donor->name donate $donor->amount eur to $charity->name at $donor->time\n";
            }
        }
    }
}
