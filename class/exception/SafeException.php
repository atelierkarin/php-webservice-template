<?php
/**
 * Created by PhpStorm.
 * User: cspang
 * Date: 2018/06/25
 * Time: 15:21
 */

namespace KarinP\TemplateWS\Exception;

use GraphQL\Error\ClientAware;

class SafeException extends \Exception implements ClientAware
{
    public function isClientSafe()
    {
        // TODO: Implement isClientSafe() method.
        return true;
    }

    public function getCategory()
    {
        // TODO: Implement getCategory() method.
        return 'ws';
    }
}