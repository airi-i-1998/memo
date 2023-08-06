<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MemoType extends Enum
{
    const MEMO = 1;
    const RICHMEMO = 2;
}
