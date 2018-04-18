<?php

declare(strict_types=1);

namespace Facile\DoctrineDDM;

class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider->getDependencyConfig(),
        ];
    }
}
