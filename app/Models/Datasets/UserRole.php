<?php

namespace App\Models\Datasets;

/**
 * Class UserRole
 */
class UserRole extends Dataset
{
    const USER = 1;
    const ADMIN = 10;

    static $data = [
        [
            'id'   => self::USER,
            'name' => 'User',
        ], [
            'id'   => self::ADMIN,
            'name' => 'Admin',
        ]
    ];
}
