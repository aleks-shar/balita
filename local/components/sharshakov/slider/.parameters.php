<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);


if (!Loader::includeModule('highloadblock'))
{
    return;
}

$arHlBlocksList = [];

$hlblockIterator = HL\HighloadBlockTable::getList();
while ($hlblock = $hlblockIterator->fetch())
{
    $arHlBlocksList[$hlblock['ID']] = '[' . $hlblock['ID'] . '] ' . $hlblock['NAME'];
}

if (!empty($arCurrentValues['HL_BLOCK']))
{
    $hlblockId = $arCurrentValues['HL_BLOCK'];
    $hlblock = HL\HighloadBlockTable::getById($hlblockId)->fetch();
    $hlEntity = HL\HighloadBlockTable::compileEntity($hlblock);
    $hlFields = $hlEntity->getFields();
    foreach ($hlFields as $fieldName => $field)
    {
        $arHlBlocksFields[$fieldName] = $fieldName;
    }
}

$arComponentParameters = [
    "GROUPS" => [],
    "PARAMETERS" => [
        'HL_BLOCK' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHARSHAKOV_HL_BLOCK_LIST'),
            'TYPE' => 'LIST',
            'VALUES' => $arHlBlocksList,
            'REFRESH' => 'Y',
        ],
        'HL_BLOCK_FIELDS_DATE' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHARSHAKOV_HL_BLOCK_DATE'),
            'TYPE' => 'LIST',
            'VALUES' => $arHlBlocksFields,
            'REFRESH' => 'N',
        ],
        'HL_BLOCK_FIELDS_NAME' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHARSHAKOV_HL_BLOCK_NAME'),
            'TYPE' => 'LIST',
            'VALUES' => $arHlBlocksFields,
            'REFRESH' => 'N',
        ],
        'HL_BLOCK_FIELDS_DESC' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHARSHAKOV_HL_BLOCK_DESC'),
            'TYPE' => 'LIST',
            'VALUES' => $arHlBlocksFields,
            'REFRESH' => 'N',
        ],
        'HL_BLOCK_FIELDS_LINK' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHARSHAKOV_HL_BLOCK_LINK'),
            'TYPE' => 'LIST',
            'VALUES' => $arHlBlocksFields,
            'REFRESH' => 'N',
        ],
        'HL_BLOCK_FIELDS_PICTURE' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SHARSHAKOV_HL_BLOCK_PICTURE'),
            'TYPE' => 'LIST',
            'VALUES' => $arHlBlocksFields,
            'REFRESH' => 'N',
        ],

        'CACHE_TIME' => [
            'DEFAULT' => '3600'
        ],
    ],
];
