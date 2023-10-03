<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('iblock')) {
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

$arInfoBlockSections = [
    '-' => '[=Выберите=]',
];
$arFilter = [
    'SECTION_ID' => false,
    'ACTIVE' => 'Y',
];

if (!empty($arCurrentValues['IBLOCK_TYPE'])) {
    $arFilter['IBLOCK_TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}

if (!empty($arCurrentValues['IBLOCK_ID'])) {
    $arFilter['IBLOCK_ID'] = $arCurrentValues['IBLOCK_ID'];
}
$result = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    $arFilter
);
while ($section = $result->Fetch()) {
    $arInfoBlockSections[$section['ID']] = '[' . $section['ID'] . '] ' . $section['NAME'];
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
            'REFRESH' => 'Y',
        ],
        'POPULAR_SECTIONS' => [
            'PARENT' => 'BASE',
            'NAME' => 'Выберите разделы инфоблока для выборки популярных элементов',
            'TYPE' => 'LIST',
            'VALUES' => $arInfoBlockSections,
            'MULTIPLE' => 'N',
            'REFRESH' => 'Y',
        ],
        'ELEMENT_COUNT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Максимальное количество элементов в разделе',
            'TYPE' => 'STRING',
            'DEFAULT' => '3',
        ],
        'USE_CODE_INSTEAD_ID' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'Использовать символьный код вместо ID',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SECTION_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на страницу с содержимым раздела',
            'TYPE' => 'STRING',
            'DEFAULT' => '#SECTION_CODE#/',
        ],
        'ELEMENT_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на страницу с содержимым элемента',
            'TYPE' => 'STRING',
            'DEFAULT' => '#SECTION_CODE#/#ELEMENT_CODE#/',
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
