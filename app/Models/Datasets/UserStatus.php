<?php

namespace App\Models\Datasets;

/**
 * Class UserStatus
 */
class UserStatus extends Dataset
{
    const ACTIVE = 11;

    const PUBLIC_RANGE = [10, 20];

    const INVISIBLE = 21;

    const INVISIBLE_RANGE = [20, 30];

    const BLOCKED = 31;

    static $data = [
        [
            'id' => self::ACTIVE,
            'name' => 'Active',
            'color' => '#8bc34a',
        ],[
            'id' => self::INVISIBLE,
            'name' => 'Invisible',
            'color' => '#ffc107',
        ],[
            'id' => self::BLOCKED,
            'name' => 'Blocked',
            'color' => '#ff4081',
        ]
    ];
}
