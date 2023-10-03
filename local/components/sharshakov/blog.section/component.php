<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!CModule::IncludeModule('iblock')) {
    ShowError('Модуль «Информационные блоки» не установлен');
    return;
}

CPageOption::SetOptionString('main', 'nav_page_in_session', 'N');

if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
}

$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);

$notFound = false;
if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
    $arParams['SECTION_CODE'] = empty($arParams['SECTION_CODE']) ? '' : trim($arParams['SECTION_CODE']);
    if (empty($arParams['SECTION_CODE'])) {
        $notFound = true;
    }
} else {
    $arParams['SECTION_ID'] = empty($arParams['SECTION_ID']) ? 0 : intval($arParams['SECTION_ID']);
    if (empty($arParams['SECTION_ID']))
    {
        $notFound = true;
    }
}

if ($notFound) {
    \Bitrix\Iblock\Component\Tools::process404(
        trim($arParams['MESSAGE_404']) ?: 'Раздел инфоблока не найден',
        true,
        $arParams['SET_STATUS_404'] === 'Y',
        $arParams['SHOW_404'] === 'Y',
        $arParams['FILE_404']
    );
    return;
}

$arParams['SECTION_URL'] = trim($arParams['SECTION_URL']);
$arParams['ELEMENT_URL'] = trim($arParams['ELEMENT_URL']);
$arParams['ELEMENT_COUNT'] = intval($arParams['ELEMENT_COUNT']);
if ($arParams['ELEMENT_COUNT'] <= 0) {
    $arParams['ELEMENT_COUNT'] = 3;
}

$arParams['CACHE_GROUPS'] = $arParams['CACHE_GROUPS']=='Y';

$arParams['DISPLAY_TOP_PAGER'] = $arParams['DISPLAY_TOP_PAGER']=='Y';
$arParams['DISPLAY_BOTTOM_PAGER'] = $arParams['DISPLAY_BOTTOM_PAGER']=='Y';
$arParams['PAGER_TITLE'] = trim($arParams['PAGER_TITLE']);
$arParams['PAGER_SHOW_ALWAYS'] = $arParams['PAGER_SHOW_ALWAYS']=='Y';
$arParams['PAGER_TEMPLATE'] = trim($arParams['PAGER_TEMPLATE']);
$arParams['PAGER_SHOW_ALL'] = $arParams['PAGER_SHOW_ALL']=='Y';

$arNavParams = null;
$arNavigation = false;
if ($arParams['DISPLAY_TOP_PAGER'] || $arParams['DISPLAY_BOTTOM_PAGER']) {
    $arNavParams = [
        'nPageSize' => $arParams['ELEMENT_COUNT'],
        'bShowAll' => $arParams['PAGER_SHOW_ALL'],
    ];
    $arNavigation = CDBResult::GetNavParams($arNavParams);
}

$cacheDependence = [$arParams['CACHE_GROUPS'] ? $USER->GetGroups() : false, $arNavigation];
if ($this->StartResultCache(false, $cacheDependence)) {

    $arSelect = [
        'ID',
        'NAME',
        'DETAIL_PICTURE',
        'DATE_CREATE'
    ];

    $arFilter = [
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'IBLOCK_ACTIVE' => 'Y',
        'ACTIVE' => 'Y',
        'GLOBAL_ACTIVE' => 'Y',
    ];

    if (strlen($arParams['SECTION_CODE']) > 0) {
        $arFilter['=CODE'] = $arParams['SECTION_CODE'];
    } else {
        $arFilter['ID'] = $arParams['SECTION_ID'];
    }

    $rsSection = CIBlockSection::GetList([], $arFilter, false, $arSelect);
    $rsSection->SetUrlTemplates('', $arParams['SECTION_URL']);
    $arResult = $rsSection->GetNext();

    if ($arResult) {
        $arResult['PATH'] = [];
        if ($arParams['ADD_SECTIONS_CHAIN'] == 'Y') {
            $rsPath = CIBlockSection::GetNavChain($arResult['IBLOCK_ID'], $arResult['ID']);
            $rsPath->SetUrlTemplates('', $arParams['SECTION_URL']);
            while ($arPath = $rsPath->GetNext()) {
                $arResult['PATH'][] = $arPath;
            }
        }

        if ($arResult['DETAIL_PICTURE'] > 0) {
            $arResult['DETAIL_PICTURE'] = CFile::GetFileArray($arResult['DETAIL_PICTURE']);
        } else {
            $arResult['DETAIL_PICTURE'] = false;
        }

        $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
            $arParams['IBLOCK_ID'],
            $arResult['ID']
        );
        $arResult['IPROPERTY_VALUES'] = $ipropValues->getValues();
        if ($arResult['DETAIL_PICTURE']) {
            $arResult['DETAIL_PICTURE']['ALT'] =
                $arResult['IPROPERTY_VALUES']['SECTION_DETAIL_PICTURE_FILE_ALT'];
            if ($arResult['DETAIL_PICTURE']['ALT'] == '') {
                $arResult['DETAIL_PICTURE']['ALT'] = $arResult['NAME'];
            }
            $arResult['DETAIL_PICTURE']['TITLE'] =
                $arResult['IPROPERTY_VALUES']['[SECTION_DETAIL_PICTURE_FILE_TITLE'];
            if ($arResult['DETAIL_PICTURE']['TITLE'] == '') {
                $arResult['DETAIL_PICTURE']['TITLE'] = $arResult['NAME'];
            }
        }

        $arSelect = [
            'ID',
            'NAME',
            'PICTURE',
            'SECTION_PAGE_URL',
            'DATE_CREATE'
        ];

        $arFilter = [
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'IBLOCK_ACTIVE' => 'Y',
            'SECTION_ID' => $arResult['ID'],
            'ACTIVE' => 'Y',
            'CHECK_PERMISSIONS' => 'Y',
        ];

        $arSort = [
            'SORT' => 'ASC',
        ];

        $rsSections = CIBlockSection::GetList($arSort, $arFilter, false, $arSelect);
        $rsSections->SetUrlTemplates('', $arParams['SECTION_URL']);

        while ($arSection = $rsSections->GetNext()) {
            if (0 < $arSection['PICTURE']) {
                $arSection['PREVIEW_PICTURE'] = CFile::GetFileArray($arSection['PICTURE']);
            } else {
                $arSection['PREVIEW_PICTURE'] = false;
            }
            unset($arSection['PICTURE']);

            $ipropValues = new \Bitrix\Iblock\InheritedProperty\SectionValues(
                $arParams['IBLOCK_ID'],
                $arSection['ID']
            );
            $arSection['IPROPERTY_VALUES'] = $ipropValues->getValues();

            if ($arSection['PREVIEW_PICTURE']) {
                $arSection['PREVIEW_PICTURE']['ALT'] =
                    $arSection['IPROPERTY_VALUES']['SECTION_PICTURE_FILE_ALT'];
                if ($arSection['PREVIEW_PICTURE']['ALT'] == '') {
                    $arSection['PREVIEW_PICTURE']['ALT'] = $arSection['NAME'];
                }
                $arSection['PREVIEW_PICTURE']['TITLE'] =
                    $arSection['IPROPERTY_VALUES']['[SECTION_PICTURE_FILE_TITLE'];
                if ($arSection['PREVIEW_PICTURE']['TITLE'] == '') {
                    $arSection['PREVIEW_PICTURE']['TITLE'] = $arSection['NAME'];
                }
            }

            $arResult['CHILD_SECTIONS'][] = $arSection;
        }

        $arSelect = [
            'ID',
            'CODE',
            'IBLOCK_ID',
            'NAME',
            'DATE_CREATE',
            'PREVIEW_PICTURE',
            'DETAIL_PAGE_URL',
        ];

        $arFilter = [
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'IBLOCK_ACTIVE' => 'Y',
            'SECTION_ID' => $arResult['ID'],
            'INCLUDE_SUBSECTIONS' => 'Y',
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'CHECK_PERMISSIONS' => 'Y'
        ];

        $arSort = [
            'SORT' => 'ASC'
        ];

        $rsElements = CIBlockElement::GetList($arSort, $arFilter, false, $arNavParams, $arSelect);

        $rsElements->SetUrlTemplates($arParams['ELEMENT_URL'], $arParams['SECTION_URL']);

        $arResult['ITEMS'] = [];
        while ($arItem = $rsElements->GetNext()) {

            $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(
                $arItem['IBLOCK_ID'],
                $arItem['ID']
            );
            $arItem['IPROPERTY_VALUES'] = $ipropValues->getValues();

            $arItem['PREVIEW_PICTURE'] =
                (0 < $arItem['PREVIEW_PICTURE'] ? CFile::GetFileArray($arItem['PREVIEW_PICTURE']) : false);
            if ($arItem['PREVIEW_PICTURE']) {
                $arItem['PREVIEW_PICTURE']['ALT'] =
                    $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_ALT'];
                if ($arItem['PREVIEW_PICTURE']['ALT'] == '') {
                    $arItem['PREVIEW_PICTURE']['ALT'] = $arItem['NAME'];
                }
                $arItem['PREVIEW_PICTURE']['TITLE'] =
                    $arItem['IPROPERTY_VALUES']['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'];
                if ($arItem['PREVIEW_PICTURE']['TITLE'] == '') {
                    $arItem['PREVIEW_PICTURE']['TITLE'] = $arItem['NAME'];
                }
            }

            $arResult['ITEMS'][] = $arItem;
        }

        $arResult['NAV_STRING'] = $rsElements->GetPageNavString(
            $arParams['PAGER_TITLE'],
            $arParams['PAGER_TEMPLATE'],
            $arParams['PAGER_SHOW_ALWAYS'],
            $this
        );

        $this->SetResultCacheKeys(
            [
                'ID',
                'IBLOCK_ID',
                'ACTIVE_DATE',
                'NAME',
                'DATE_CREATE',
                'PREVIEW_PICTURE',
                'DETAIL_PAGE_URL',
            ]
        );
        $this->IncludeComponentTemplate();
    } else {
        $this->AbortResultCache();
        \Bitrix\Iblock\Component\Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Раздел инфоблока не найден',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );
    }
}

if (isset($arResult['ID'])) {
    if ($arParams['SET_PAGE_TITLE'] == 'Y')
    {
        if ($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE'] != '') {
            $APPLICATION->SetTitle($arResult['IPROPERTY_VALUES']['SECTION_PAGE_TITLE']);
        } else {
            $APPLICATION->SetTitle($arResult['NAME']);
        }
    }
    if ($arParams['SET_BROWSER_TITLE'] == 'Y') {
        if ($arResult['IPROPERTY_VALUES']['SECTION_META_TITLE'] != '') {
            $APPLICATION->SetPageProperty('title', $arResult['IPROPERTY_VALUES']['SECTION_META_TITLE']);
        } else {
            $APPLICATION->SetPageProperty('title', $arResult['NAME']);
        }
    }

    if ($arParams['SET_META_KEYWORDS'] == 'Y' && $arResult['IPROPERTY_VALUES']['SECTION_META_KEYWORDS'] != '') {
        $APPLICATION->SetPageProperty('keywords', $arResult['IPROPERTY_VALUES']['SECTION_META_KEYWORDS']);
    }

    if ($arParams['SET_META_DESCRIPTION'] == 'Y' && $arResult['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION'] != '') {
        $APPLICATION->SetPageProperty('description', $arResult['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION']);
    }

}
