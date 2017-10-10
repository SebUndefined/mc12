<?php

namespace MC12\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MC12UserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
