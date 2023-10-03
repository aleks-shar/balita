<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;

if (!Loader::includeModule('highloadblock'))
{
    return;
}

if (!empty($arParams['HL_BLOCK']))
{
    $hlbl = (int)$arParams['HL_BLOCK'];
    $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    if ($this->StartResultCache())
    {
        $rsData = $entity_data_class::getList([
            'order' => [
                'ID' => 'ASC'
            ],
            'cache' => [
                'ttl' => (int)$arParams['CACHE_TIME']
            ],
        ])->fetchAll();
        foreach ($rsData as $item) {
            if ($item[$arParams['HL_BLOCK_FIELDS_PICTURE']])
            {
                $item[$arParams['HL_BLOCK_FIELDS_PICTURE']] = CFile::GetFileArray(
                    $item[$arParams['HL_BLOCK_FIELDS_PICTURE']]
                );
            }
            $arr['DATE'] = $item[$arParams['HL_BLOCK_FIELDS_DATE']];
            $arr['NAME'] = $item[$arParams['HL_BLOCK_FIELDS_NAME']];
            $arr['DESC'] = $item[$arParams['HL_BLOCK_FIELDS_DESC']];
            $arr['LINK'] = $item[$arParams['HL_BLOCK_FIELDS_LINK']];
            $arr['PICTURE'] = $item[$arParams['HL_BLOCK_FIELDS_PICTURE']];
            $arResult[] = $arr;
        }
        $this->includeComponentTemplate();
    }
}
