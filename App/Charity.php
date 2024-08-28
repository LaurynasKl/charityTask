<?php
class Charity
{

    public $id;
    public $name;
    public $email;

    private $charityFile;
    private $charityId;
    private $charitiesData = [];
    private $charitiesId;

    public function __construct($name)
    {
        $this->charityFile = __DIR__ . "/../data/$name.json";
        $this->charityId = __DIR__ . "/../data/$name-id.json";
        if (!file_exists($this->charityFile)) {
            file_put_contents($this->charityFile, json_encode([]));
            file_put_contents($this->charityId, json_encode(1));
        }
        $this->charitiesData = json_decode(file_get_contents($this->charityFile));
        $this->charitiesId = json_decode(file_get_contents($this->charityId));

        //     $this->id = $id;
        //     $this->name = $name;
        //     $this->email = $email;
    }
    public function __destruct()
    {
        file_put_contents($this->charityFile, json_encode($this->charitiesData));
        file_put_contents($this->charityId, json_encode($this->charitiesId));
    }



    public function showAll()
    {
        if ($this->charitiesData !== []) {
            foreach ($this->charitiesData as $charity) {
                echo "id: $charity->id \n";
                echo "name: $charity->name \n";
                echo "email: $charity->email \n\n";
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
        echo 'Charity representative email: ';
        $charity['email'] = trim(fgets(STDIN));
        echo 'Charity added';
        $this->charitiesData[] = $charity;
    }

    public function edit(){
        $this->showAll();
        echo "Select whitch charyti edit: ";
        $id = trim(fgets(STDIN));

        foreach ($this->charitiesData as $key => $charity) {
            if ($charity->id == $id) {  
                $editCharity = [];
                echo 'New charity name: ';
                $editCharity['name'] = trim(fgets(STDIN));
                echo 'New charity representative email: ';
                $editCharity['email'] = trim(fgets(STDIN));
                $editCharity['id'] = $id;

                $this->charitiesData[$key] = $editCharity;
            }
        }

    }

    public function delete(){
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


}
