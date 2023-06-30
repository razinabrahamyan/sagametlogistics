<?php

namespace App\Services\Contracts;

interface ProfileServiceContract
{
    public function saveProfile($request);

    public function getSavingAlertMessage();

    public function setSavingAlertMessage($savingAlertMessage);
}