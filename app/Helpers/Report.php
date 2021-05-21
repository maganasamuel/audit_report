<?php

namespace App\Helpers;

class Report {

    public $model;

    public $dateEnd;

    public $dateStart;

    public function __construct($model, $dateStart, $dateEnd)
    {
        $this->model = $model;

        $this->dateStart = $dateStart;

        $this->dateEnd = $dateEnd;
    }

    public function generate($relations)
    {
        return $this->model->{$relations}
            ->where('created_at','>=', '2021-05-21')
            ->where('created_at', '<=', '2021-05-22');

      
    }

}