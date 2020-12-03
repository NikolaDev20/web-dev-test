<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static APPROVED()
 * @method static static WAITING()
 * @method static static DECLINED()
 */
final class CommentStatus extends Enum
{
    
    const WAITING = 0;
    const APPROVED = 1;
    const DECLINED = 2;
}
