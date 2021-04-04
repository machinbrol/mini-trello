<?php

require_once "autoload.php";
// pour une raison que j'ignore ça ne passe pas dans l'autoload
require_once "model/dao/UserDao.php";
require_once "model/dao/BoardDao.php";

class Validation {
    
    public static function str_longer_than(string $str, int $len): bool {
        return is_string($str) && mb_strlen($str, "utf-8") > $len;
    }

    public static function contains_capitals(string $str): bool {
        return strtolower($str)!==$str;
    }

    public static function contains_digits(string $str): bool {
        return preg_match('/\d/', $str) > 0;
    }

    public static function contains_non_alpha(string $str): bool {
        return preg_match('/[^A-Za-z0-9 ]/', $str) > 0;
    }

    public static function valid_email(string $str): bool {
        return filter_var($str, FILTER_VALIDATE_EMAIL) == $str;
    }

    public static function is_unique_email(string $email): bool {
        return is_null(UserDAO::get_by_email($email));
    }

    public static function is_same_password(string $passw1, string $passw2): bool {
        return strcmp($passw1, $passw2) == 0;
    }

    public static function is_unique_title(string $title): bool {
        return is_null(BoardDao::get_by_title($title));
    }

    public static function is_unique_column_title(Column $column): bool {
        return $column->is_unique_title_in_board();
    }

    // true si 1 seconde d'écart entre les dates
    public static function is_date_after(?Datetime $datet1, DateTime $datet0) {
        return is_null($datet1) || $datet0->diff($datet1)->s > 1;
    }

    // vrai si date 1 jour avant aujourd'hui
    public static function due_date_before(?Datetime $date, DateTime $dateNow) {
        return !is_null($date) && $dateNow->diff($date)->format("%r%a") < 0;
    }
}