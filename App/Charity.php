<?php
class Charity
{

    public $id;
    public $name;
    public $email;

    private $charityFile;
    // private $id;
    private $charitiesData = [];
    private $charitiesId;

    public function __construct($name)
    {
        $this->charityFile = __DIR__ . "/../data/$name.json";
        $this->id = __DIR__ . "/../data/$name-id.json";
        if (!file_exists($this->charityFile)) {
            file_put_contents($this->charityFile, json_encode([]));
            file_put_contents($this->id, json_encode(1));
        }
        $this->charitiesData = json_decode(file_get_contents($this->charityFile));
        $this->charitiesId = json_decode(file_get_contents($this->id));
    }
    public function __destruct()
    {
        file_put_contents($this->charityFile, json_encode($this->charitiesData));
        file_put_contents($this->id, json_encode($this->charitiesId));
    }



    public function showAll()
    {
        if ($this->charitiesData !== []) {
            foreach ($this->charitiesData as $charity) {
                echo "id: $charity->id \n";
                echo "name: $charity->name \n";
                echo "email: $charity->email \n";
            }
        } else {
            echo 'No charity';
        }
    }

    public function add()
    {
        $charity = [];

        $charity['id'] = $this->charitiesId;
        $this->charitiesId++;

        echo 'Charity name: ';
        $charity['name'] = trim(fgets(STDIN));
        $this->nameValidation($charity);

        echo 'Charity representative email: ';
        $charity['email'] = trim(fgets(STDIN));
        $this->emailValidation($charity);

        $this->charitiesData[] = $charity;
        echo 'Charity added';
    }

    public function edit()
    {
        $this->showAll();
        echo "Select whitch charyti edit: ";
        $id = trim(fgets(STDIN));

        foreach ($this->charitiesData as $key => $charity) {
            if ($charity->id == $id) {
                $editCharity = [];
                $editCharity['id'] = (int)$id;

                echo 'New charity name: ';
                $editCharity['name'] = trim(fgets(STDIN));
                $this->nameValidation($editCharity);

                echo 'New charity representative email: ';
                $editCharity['email'] = trim(fgets(STDIN));
                $this->emailValidation($editCharity);

                $this->charitiesData[$key] = $editCharity;
                echo 'Charity edited';
            }
        }
    }

    public function delete()
    {
        $this->showAll();
        echo "Select whitch charyti delete: ";
        $id = trim(fgets(STDIN));

        foreach ($this->charitiesData as $key => $charity) {
            if ($charity->id == $id) {
                unset($this->charitiesData[$key]);
                $this->charitiesData = array_values($this->charitiesData);
                echo 'Charity deleted';
            }
        }
    }


    public function nameValidation($charity)
    {
        $letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $searchName = $charity['name'];
        foreach ($this->charitiesData as $key => $value) {
            if ($value->name == $searchName) {
                echo 'This name is used';
                exit;
            }
        }
        if (strtoupper($searchName[0]) !== $searchName[0]) {
            echo 'The first letter must be uppercase.';
            exit;
        }
        if (strlen($charity['name']) <= 3) {
            echo 'Name is to short';
            exit;
        } else if (strlen($charity['name']) >= 20) {
            echo 'Name is to long';
            exit;
        }
    }


    public function emailValidation($charity)
    {
        $searchEmail = $charity['email'];
        foreach ($this->charitiesData as $key => $value) {
            if ($value->email == $searchEmail) {
                echo 'This email is used';
                exit;
            }
       
        }
        if (!filter_var($charity['email'], FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email address';
            exit;
        }
    }
}
