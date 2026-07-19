<?php

namespace App\Libraries;

use CodeIgniter\View\View;

#[\AllowDynamicProperties]
class CustomView extends View
{
    /**
     * The Session service instance.
     *
     * @var \CodeIgniter\Session\Session|null
     */
    public $session;
}
