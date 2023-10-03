<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

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
    $arInfoBlocks[$iblock['ID']] = '['.$iblock['ID'].'] '.$iblock['NAME'];
}

$arComponentParameters = [
    'GROUPS' => [
        'SEO_SETTINGS' => [
            'NAME' => 'Настройки SEO',
            'SORT' => 800
        ],
    ],
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

        'SECTION_ID' => [
            'PARENT' => 'BASE',
            'NAME' => 'Идентификатор раздела',
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["SECTION_ID"]}',
        ],

        'SECTION_CODE' => [
            'PARENT' => 'BASE',
            'NAME' => 'Символьный код раздела',
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["SECTION_CODE"]}',
        ],
        'ELEMENT_COUNT' => [
            'PARENT' => 'BASE',
            'NAME' => 'Количество элементов на странице',
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
            'DEFAULT' => '#SECTION_ID#/'
        ],

        'ELEMENT_URL' => [
            'PARENT' => 'URL_TEMPLATES',
            'NAME' => 'URL, ведущий на страницу с содержимым элемента',
            'TYPE' => 'STRING',
            'DEFAULT' => '#SECTION_ID#/#ELEMENT_ID#/'
        ],

        'SET_PAGE_TITLE' => [
            'PARENT' => 'SEO_SETTINGS',
            'NAME' => 'Устанавливать заголовок страницы',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_BROWSER_TITLE' => [
            'PARENT' => 'SEO_SETTINGS',
            'NAME' => 'Устанавливать заголовок окна браузера',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_META_KEYWORDS' => [
            'PARENT' => 'SEO_SETTINGS',
            'NAME' => 'Устанавливать мета-тег keywords',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
        'SET_META_DESCRIPTION' => [
            'PARENT' => 'SEO_SETTINGS',
            'NAME' => 'Устанавливать мета-тег description',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],

        'CACHE_TIME'  =>  ['DEFAULT' => 3600],
        'CACHE_GROUPS' => [
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ],
    ],
];

CIBlockParameters::AddPagerSettings(
    $arComponentParameters,
    'Элементы',
    false,
    true
);

CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
