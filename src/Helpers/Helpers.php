<?php

namespace src\Helpers;

use DateTime;
use DateInterval;

class Helpers
{
    public static function redirect(string $url = null): void
    {
        header('HTTP/1.1 302 Found');

        $location = ($url ? self::generateUrl($url) : self::generateUrl());

        header("Location: {$location}");
        exit();
    }

    public static function summarizeText(string $text, int $limit, string $suffix = '...'): string
    {
        $cleanText = self::sanitizeString(trim(strip_tags($text)));
        if (mb_strlen($text) <= $limit) {
            return $cleanText;
        }

        $shortText = mb_substr($cleanText, 0, $limit);
        return $shortText . $suffix;
    }

    public static function sanitizeString(string $string): string
    {
        return str_replace(["'", "\""], "", stripslashes(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS)));
    }

    public static function formatString(string $string): string
    {
        return self::sanitizeString(preg_replace('/[\'"\\\\]/', '', $string));
    }

    public static function calculateElapsedTime(string $date): string
    {
        $currentTimestamp = strtotime(date('Y-m-d H:i:s'));
        $timestamp = strtotime($date);
        $difference = $currentTimestamp - $timestamp;

        $seconds = round($difference);
        $minutes = round($difference / 60);
        $hours = round($difference / 3600);
        $days = round($difference / 86400);
        $weeks = round($difference / 604800);
        $months = round($difference / 2419200);
        $years = round($difference / 29030400);

        $formattedTime = match (true) {
            $seconds <= 60 => 'New',
            $minutes <= 60 => $minutes . 'm',
            $hours <= 23 => $hours . 'h',
            $days <= 7 => $days . 'd',
            $weeks <= 4 => $weeks . 'w',
            $months <= 12 => $months . 'mo',
            default => $years . 'y'
        };

        return $formattedTime;
    }

    public static function simpleElapsedTime(string $date): string
    {
        $currentTimestamp = strtotime(date('Y-m-d H:i:s'));
        $timestamp = strtotime($date);
        $difference = $currentTimestamp - $timestamp;

        $seconds = round($difference);
        $minutes = round($difference / 60);
        $hours = round($difference / 3600);
        $days = round($difference / 86400);
        $weeks = round($difference / 604800);
        $months = round($difference / 2419200);
        $years = round($difference / 29030400);

        $formattedTime = match (true) {
            $seconds <= 60 => 'Agora',
            $minutes <= 60 => 'Há ' . $minutes . ' min',
            $hours <= 23 => 'Há ' . $hours . ' h',
            $days <= 7 => 'Há ' . $days . ' d',
            $weeks <= 4 => 'Há ' . $weeks . ' s',
            $months <= 12 => 'Há ' . $months . ' m',
            default => 'Há ' . $years . ' a'
        };

        return $formattedTime;
    }

    public static function validateEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = explode("@", $email)[1];
        if (!checkdnsrr($domain, "MX")) {
            return false;
        }

        return true;
    }

    public static function isLocalhost(): bool
    {
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME');
        return $server === 'localhost';
    }

    public static function generateUrl(string $url = null): string
    {
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $environment = ($server === 'localhost' ? URL_DESENVOLVIMENTO : URL_ONLINE);

        if (str_starts_with($url, '/')) {
            return $environment . $url;
        }

        return $environment . '/' . $url;
    }

    public static function getFormattedDate(): string
    {
        $dayOfMonth = date('d');
        $dayOfWeek = date('w');
        $month = date('n') - 1;
        $year = date('Y');

        $daysOfWeek = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
        $months = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        return $daysOfWeek[$dayOfWeek] . ', ' . $dayOfMonth . ' de ' . $months[$month] . ' de ' . $year;
    }

    public static function formatDate(string $date): string
    {
        $parts = explode("-", $date);
        $day = $parts[2];
        $dateTime = new DateTime($date);
        $dayOfWeek = $dateTime->format("w");
        $month = intval($parts[1]) - 1;
        $year = $parts[0];

        $daysOfWeek = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        $months = [
            'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'
        ];

        return $daysOfWeek[$dayOfWeek] . ', ' . $day . ' de ' . $months[$month] . ' de ' . $year;
    }

    public static function validateCPF(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/^(\d)\1*$/', $cpf)) {
            return false;
        }

        for ($i = 9, $j = 0, $sum = 0; $i > 0; $i--, $j++) {
            $sum += $cpf[$j] * $i;
        }
        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($cpf[9] != $digit1) {
            return false;
        }

        for ($i = 10, $j = 0, $sum = 0; $i > 1; $i--, $j++) {
            $sum += $cpf[$j] * $i;
        }
        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($cpf[10] != $digit2) {
            return false;
        }

        return true;
    }

    public static function validateCNPJ(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/^(\d)\1*$/', $cnpj)) {
            return false;
        }

        $sum = 0;
        $multiplier = 5;
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $multiplier;
            $multiplier = ($multiplier == 2) ? 9 : $multiplier - 1;
        }
        $remainder = $sum % 11;
        $digit1 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($cnpj[12] != $digit1) {
            return false;
        }

        $sum = 0;
        $multiplier = 6;
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $multiplier;
            $multiplier = ($multiplier == 2) ? 9 : $multiplier - 1;
        }
        $remainder = $sum % 11;
        $digit2 = ($remainder < 2) ? 0 : 11 - $remainder;

        if ($cnpj[13] != $digit2) {
            return false;
        }

        return true;
    }

    public static function validateCEP(string $cep): bool
    {
        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return false;
        }

        return true;
    }

    public static function validatePassword(string $password): bool
    {
        if (strlen($password) < 8) {
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }

        if (!preg_match('/\d/', $password)) {
            return false;
        }

        return true;
    }

    public static function formatNumber(float $value): string
    {
        return number_format($value, 2, ',', '.');
    }

    public static function getUserLanguage(): string
    {
        $preferredLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $languages = explode(',', $preferredLanguages);
        return $languages[0];
    }

    public static function formatTime(string $time): string
    {
        $dateTime = new DateTime($time);
        return $dateTime->format('H:i');
    }

    public static function formatDateSimple(string $date): string
    {
        $dateTime = new DateTime($date);
        return $dateTime->format('d/m/Y');
    }

    public static function getDayOfWeek(string $date): string
    {
        $dateTime = new DateTime($date);
        $dayOfWeek = $dateTime->format('w');

        return match ($dayOfWeek) {
            '0' => 'Domingo',
            '1' => 'Segunda-feira',
            '2' => 'Terça-feira',
            '3' => 'Quarta-feira',
            '4' => 'Quinta-feira',
            '5' => 'Sexta-feira',
            '6' => 'Sábado',
            default => '',
        };
    }
}
