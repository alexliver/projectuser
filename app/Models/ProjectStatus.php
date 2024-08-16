<?php

namespace App\Models;

enum ProjectStatus: string
{
    case InProgress = 'in_progress';
    case Finished = 'finished';
}
