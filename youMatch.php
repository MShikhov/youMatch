<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'Кирсанов Глеб Артемович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
function getPartsFromFullname($fullname)
{
    $myArr = explode(' ', $fullname);
    return ['surname' => $myArr[0], 'name' => $myArr[1], 'patronymic' => $myArr[2]];
}
function  getFullnameFromParts($myArr)
{
    $fullname = $myArr[0] . ' ' . $myArr[1] . ' ' . $myArr[2];
    return $fullname;
}
function  getShortName($myArr)
{
    $myArr['surname'] = mb_substr($myArr['surname'], 0, 1);
    $shortName = $myArr['name'] . ' ' . $myArr['surname'] . '. ';
    return $shortName;
}

function getGenderFromName($fullname)
{
    $arrName = getPartsFromFullname($fullname);
    $surname = $arrName['surname'];
    $name = $arrName['name'];
    $patronymic = $arrName['patronymic'];
    $genderValue = 0;
    if (mb_substr($patronymic, -2) == 'ич') {
        $genderValue += 1;
    } else {
        $genderValue -= 1;
    }
    if (mb_substr($surname, -2) == 'ов' || mb_substr($surname, -2) == 'ев') {
        $genderValue += 1;
    } else {
        $genderValue -= 1;
    }
    if ($genderValue >= 0) {
        $gender = 1;
    } else {
        $gender = -1;
    }
    return $gender;
}

function getGenderDescription($example_persons_array)
{
    $count = count($example_persons_array);
    $males = 0;
    $females = 0;
    $unknown = 0;
    foreach ($example_persons_array as $key => $user) {
        $fullName = $user['fullname'];
        $gender = getGenderFromName($fullName);
        if ($gender == 1) {
            $males++;
        } else if ($gender == -1) {
            $females++;
        } else {
            $unknown++;
        }
    }
    $malesPercent = round(($males / $count) * 100, 1);
    $femalesPercent = round(($females / $count) * 100, 1);
    $unknownPercent = 100 - $malesPercent - $femalesPercent;
    echo <<<HEREDOCLETTER
Гендерный состав аудитории: 
Мужчины - {$malesPercent}% 
Женщины - {$femalesPercent}% 
Не удалось определить - {$unknownPercent}% \n

HEREDOCLETTER;
}
getGenderDescription($example_persons_array);
function getManPartner($example_persons_array)
{

    $randNum = rand(0, count($example_persons_array) - 1);
    $person_one = $example_persons_array[$randNum]['fullname'];


    if (getGenderFromName($person_one) == 1) {
        $man = $person_one;
    } else {
        do {
            $man = getGenderFromName($person_one);
        } while (getGenderFromName($person_one) != 1);
    }

    $a = getPartsFromFullname($man);
    $b = getShortName($a);
    return $b;
}

function getWomanPartner($example_persons_array)
{
    $randNum = rand(0, count($example_persons_array) - 1);

    $person_two = $example_persons_array[$randNum]['fullname'];

    if (getGenderFromName($person_two) != 1) {
        $woman = $person_two;
    } else {
        do {
            $woman = getGenderFromName($person_two);
        } while (getGenderFromName($person_two) == -1);
    }

    $a = getPartsFromFullname($woman);
    $b = getShortName($a);
    return $b;
}
function getPerfectPartner($example_persons_array)
{
    $ts = getManPartner($example_persons_array);
    $kts = getWomanPartner($example_persons_array);
    $gg = rand(50, 100);
    echo <<<HEREDOCLETTER
{$ts} {$kts} =
Идеально на {$gg}%
HEREDOCLETTER;
}
getPerfectPartner($example_persons_array);
