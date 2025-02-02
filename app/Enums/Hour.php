<?php

namespace App\Enums;

enum Hour: string
{
    case H1_MORNING = '1manana';
    case H2_MORNING = '2manana';
    case H3_MORNING = '3manana';
    case BR_MORNING = 'recreoM';
    case H4_MORNING = '4manana';
    case H5_MORNING = '5manana';
    case H6_MORNING = '6manana';

    case H1_AFTERNOON = '1tarde';
    case H2_AFTERNOON = '2tarde';
    case H3_AFTERNOON = '3tarde';
    case BR_AFTERNOON = 'recreoT';
    case H4_AFTERNOON = '4tarde';
    case H5_AFTERNOON = '5tarde';
    case H6_AFTERNOON = '6tarde';

    case H1_TUESDAY = '1martes';
    case H2_TUESDAY = '2martes';
    case H3_TUESDAY = '3martes';
    case BR_TUESDAY = 'recreomartes';
    case H4_TUESDAY = '4martes';
    case H5_TUESDAY = '5martes';
    case H6_TUESDAY = '6martes';

    public function getSchedule(): string
    {
        return match ($this) {
            self::H1_MORNING => '08:00 - 08:55',
            self::H2_MORNING => '08:55 - 09:50',
            self::H3_MORNING => '09:50 - 10:45',
            self::BR_MORNING => '10:40 - 11:15',
            self::H4_MORNING => '11:15 - 12:10',
            self::H5_MORNING => '12:10 - 13:05',
            self::H6_MORNING => '13:05 - 14:00',

            self::H1_AFTERNOON => '14:00 - 14:55',
            self::H2_AFTERNOON => '14:55 - 15:50',
            self::H3_AFTERNOON => '15:50 - 16:45',
            self::BR_AFTERNOON => '16:45 - 17:15',
            self::H4_AFTERNOON => '17:15 - 18:10',
            self::H5_AFTERNOON => '18:10 - 19:05',
            self::H6_AFTERNOON => '19:05 - 20:00',

            self::H1_TUESDAY => '15:00 - 15:45',
            self::H2_TUESDAY => '15:45 - 16:30',
            self::H3_TUESDAY => '16:30 - 17:15',
            self::BR_TUESDAY => '17:15 - 17:45',
            self::H4_TUESDAY => '17:45 - 18:30',
            self::H5_TUESDAY => '18:30 - 19:15',
            self::H6_TUESDAY => '19:15 - 20:00',
        };
    }
}