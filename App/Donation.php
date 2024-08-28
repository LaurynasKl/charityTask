<?php

class Donation
{

    public $id;
    public $donorName;
    public $amount;
    public $charityId;
    public $dateTime;

    private $donorData = [];
    private $donorId;
    private $donorFile;

    
    public function __construct($name) {
        
        $this->donorFile = __DIR__ . "/../data/$name.json";
        $this->donorId = __DIR__ . "/../data/$name-id.json";
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

    public function addDonation() {
        $donation = [];
        $donation['id'] = $this->id;
        $this->id++;
        // echo 'Donor name: ';
        // $donation['name'] = trim(fgets(STDIN));

        // echo "Amount: ";
        // $donation['amount'] = (int)trim(fgets(STDIN));

        echo "\n";
        $this->showAll('charity');
        echo 'Select charity number: ';
        $donation['charityId'] = (int)trim(fgets(STDIN));
        
        $this->donated('charity');

        $donation['time'] = date('d');
        $this->donorData[] = $donation;
        
    }
    
    
    public function showAll($name){
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
        }
        else {
            echo 'nepavyko';
        }
    }


    public function donated($name) {
        $charityFile = __DIR__ . "/../data/$name.json";
        $donorArray = $this->donorData[0];
        // var_dump($donorArray->id);

        if (file_exists($charityFile)) {
            $allCharities = json_decode(file_get_contents($charityFile));
        }
        foreach ($allCharities as $key => $charity) {
            if ($charity->id == $donorArray->charityId) {
                
                $charity->amount += $donorArray->amount;
            }
        }
        file_put_contents($charityFile, json_encode($allCharities));
    }



}