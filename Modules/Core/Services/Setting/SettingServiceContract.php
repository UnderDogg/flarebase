<?php
namespace Modules\Core\Services\Setting;
interface SettingServiceContract
{

    public function getCompanyName();

    public function updateOverall($requestData);

    public function getSetting();
}
