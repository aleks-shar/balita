<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::IncludeModule('iblock')) {
    return;
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arInfoBlocks = [];
$arFilter = ['ACTIVE' => 'Y'];
if (!empty($arCurrentValues['IBLOCK_TYPE'])) {
    $arFilter['TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}
$rsIBlock = CIBlock::GetList(
    ['SORT' => 'ASC'],
    $arFilter
);
while ($iblock = $rsIBlock->Fetch()) {
    $arInfoBlocks[$iblock['ID']] = '[' . $iblock['ID'] . '] ' . $iblock['NAME'];
}

$arComponentParameters = [
    'PARAMETERS' => [
        'IBLOCK_TYPE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Выберите тип инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $arIBlockType,
            'REFRESH' => 'Y',
        ],
        'IBLOCK_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Выберите инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $arInfoBlocks,
        ],
        'CACHE_TIME' => ['DEFAULT' => 3600],
        'CACHE_GROUPS' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
    ],
];

CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
