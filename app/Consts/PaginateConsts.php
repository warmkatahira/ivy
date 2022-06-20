<?php

namespace App\Consts;

// usersで使う定数
class PaginateConsts
{
    public const PAGINATE_10 = 10;
    public const PAGINATE_50 = 50;
    public const PAGINATE_100 = 100;
    public const PAGINATE_300 = 300;
    public const PAGINATE_500 = 500;
    public const PAGINATE_LIST = [
        self::PAGINATE_10 => '10件',
        self::PAGINATE_50 => '50件',
        self::PAGINATE_100 => '100件',
        self::PAGINATE_300 => '300件',
        self::PAGINATE_500 => '500件',
    ];
}