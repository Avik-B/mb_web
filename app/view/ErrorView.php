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

namespace App\View;


use App\Lib\View;
use App\Lib\ForumHook;

class ErrorView extends View
{
    public function render()
    {
        //$this->template->setData("releasedata", $this->model->getReleasedata());
        $this->template->render();

    }
}