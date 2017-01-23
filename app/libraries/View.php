<?php
/**
 * Copyright (c) 2017 AvikB, some rights reserved.
 *  Copyright under Creative Commons Attribution-ShareAlike 3.0 Unported,
 *  for details visit: https://creativecommons.org/licenses/by-sa/3.0/
 *
 * @Contributors:
 * Created by AvikB for noncommercial MusicBee project.
 *  Spelling mistakes and fixes from community members.
 *
 */

namespace App\Lib;

use App\Lib\Utility\LanguageManager;
use App\Lib\Utility\Template;
use App\Lib\Model;

class View
{
    protected $model;
    protected $template;

    public function __construct(Model $model = null, Template $template)
    {
        $this->model    = $model;
        $this->template = $template;
    }

    public function render(){}
}