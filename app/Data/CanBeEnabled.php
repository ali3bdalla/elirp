<?php

namespace App\Data;

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
