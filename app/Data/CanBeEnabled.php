<?php


namespace App\Data;


use App\Models\Company;


trait CanBeEnabled
{
    public function enabledFactoryState()
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => true
            ];
        });
    }
    public function disabledFactoryState()
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => false
            ];
        });
    }
}
