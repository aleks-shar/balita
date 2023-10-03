<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

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

if (!isset($arParams['CACHE_TIME'])) {
    $arParams['CACHE_TIME'] = 3600;
}
$arParams['IBLOCK_TYPE'] = trim($arParams['IBLOCK_TYPE']);
$arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
$notFound = false;
if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
    $arParams['ELEMENT_CODE'] = empty($arParams['ELEMENT_CODE']) ? '' : trim($arParams['ELEMENT_CODE']);
    if (empty($arParams['ELEMENT_CODE'])) {
        $notFound = true;
    }
} else {
    $arParams['ELEMENT_ID'] = empty($arParams['ELEMENT_ID']) ? 0 : intval($arParams['ELEMENT_ID']);
    if (empty($arParams['ELEMENT_ID'])) {
        $notFound = true;
    }
}
if ($notFound) {
    \Bitrix\Iblock\Component\Tools::process404(
        trim($arParams['MESSAGE_404']) ?: 'Элемент инфоблока не найден',
        true,
        $arParams['SET_STATUS_404'] === 'Y',
        $arParams['SHOW_404'] === 'Y',
        $arParams['FILE_404']
    );
    return;
}

$arParams['SECTION_URL'] = trim($arParams['SECTION_URL']);
$arParams['ELEMENT_URL'] = trim($arParams['ELEMENT_URL']);

if ($this->StartResultCache(false, ($arParams['CACHE_GROUPS'] === 'N' ? false : $USER->GetGroups()))) {

    if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
        $ELEMENT_ID = CIBlockFindTools::GetElementID(
            0,
            $arParams['ELEMENT_CODE'],
            false,
            false,
            [
                'IBLOCK_ACTIVE' => 'Y',
                'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                'ACTIVE' => 'Y',
                'ACTIVE_DATE' => 'Y',
                'SECTION_GLOBAL_ACTIVE' => 'Y',
                'CHECK_PERMISSIONS' => 'Y',
            ]
        );
    } else {
        $ELEMENT_ID = $arParams['ELEMENT_ID'];
    }

    if ($ELEMENT_ID) {
        $arSelect = [
            'ID',
            'CODE',
            'IBLOCK_ID',
            'IBLOCK_SECTION_ID',
            'IBLOCK_SECTION',
            'SECTION_PAGE_URL',
            'NAME',
            'DATE_CREATE',
            'DETAIL_PICTURE',
            'DETAIL_TEXT',
            'DETAIL_PAGE_URL',
        ];

        $arFilter = [
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            'IBLOCK_ACTIVE' => 'Y',
            'ID' => $ELEMENT_ID,
            'ACTIVE' => 'Y',
            'ACTIVE_DATE' => 'Y',
            'SECTION_GLOBAL_ACTIVE' => 'Y',
            'CHECK_PERMISSIONS' => 'Y',
        ];
        if ($arParams['SECTION_ID']) {
            $arFilter['SECTION_ID'] = $arParams['SECTION_ID'];
        } elseif ($arParams['SECTION_CODE']) {
            $arFilter['SECTION_CODE'] = $arParams['SECTION_CODE'];
        }

        $rsElement = CIBlockElement::GetList(
            [],
            $arFilter,
            false,
            false,
            $arSelect
        );

        $rsElement->SetUrlTemplates($arParams['ELEMENT_URL'], $arParams['SECTION_URL']);

        if ($obElement = $rsElement->GetNextElement()) {

            $arResult = $obElement->GetFields();

            $arResult['PROPERTIES'] = $obElement->GetProperties();

            foreach ($arResult['PROPERTIES'] as $code => $data) {
                $arResult['DISPLAY_PROPERTIES'][$code] = CIBlockFormatProperties::GetDisplayValue($arResult, $data, '');
            }

            $groups = CIBlockElement::GetElementGroups($ELEMENT_ID, true, ["ID", "NAME", "SECTION_PAGE_URL"]);

            while ($group = $groups->GetNext()) {
                $arResult['GROUPS'] [] = $group;
            }

            $ipropValues = new \Bitrix\Iblock\InheritedProperty\ElementValues(
                $arResult['IBLOCK_ID'],
                $arResult['ID']
            );
            $arResult['IPROPERTY_VALUES'] = $ipropValues->getValues();

            if (isset($arResult['DETAIL_PICTURE'])) {
                $arResult['DETAIL_PICTURE'] =
                    (0 < $arResult['DETAIL_PICTURE'] ? CFile::GetFileArray($arResult['DETAIL_PICTURE']) : false);
                if ($arResult['DETAIL_PICTURE']) {
                    $arResult['DETAIL_PICTURE']['ALT'] =
                        $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'];
                    if ($arResult['DETAIL_PICTURE']['ALT'] == '') {
                        $arResult['DETAIL_PICTURE']['ALT'] = $arResult['NAME'];
                    }
                    $arResult['DETAIL_PICTURE']['TITLE'] =
                        $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'];
                    if ($arResult['DETAIL_PICTURE']['TITLE'] == '') {
                        $arResult['DETAIL_PICTURE']['TITLE'] = $arResult['NAME'];
                    }
                }
            }

            $arSectionFilter = [
                'IBLOCK_ID' => $arResult['IBLOCK_ID'],
                'ID' => $arResult['IBLOCK_SECTION_ID'],
                'ACTIVE' => 'Y',
            ];

            $rsSection = CIBlockSection::GetList([], $arSectionFilter);

            $rsSection->SetUrlTemplates('', $arParams['SECTION_URL']);

            if ($arResult['SECTION'] = $rsSection->GetNext()) {
                $arResult['SECTION']['PATH'] = [];
                if ($arParams['ADD_SECTIONS_CHAIN'] == 'Y') {
                    $rsPath = CIBlockSection::GetNavChain(
                        $arResult['SECTION']['IBLOCK_ID'],
                        $arResult['SECTION']['ID'],
                        [
                            'ID',
                            'NAME',
                            'SECTION_PAGE_URL'
                        ]
                    );
                    $rsPath->SetUrlTemplates('', $arParams['SECTION_URL']);
                    while ($arPath = $rsPath->GetNext()) {
                        $arResult['SECTION']['PATH'][] = $arPath;
                    }
                }
            }

        }

    }

    if (isset($arResult['ID'])) {
        $this->SetResultCacheKeys(
            [
                'ID',
                'SECTION_PAGE_URL',
                'NAME',
                'DATE_CREATE',
                'DETAIL_PICTURE',
                'DETAIL_TEXT',
                'DETAIL_PAGE_URL',

            ]
        );
        $this->IncludeComponentTemplate();
    } else {
        $this->AbortResultCache();
        \Bitrix\Iblock\Component\Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Элемент инфоблока не найден',
            true,
            $arParams['SET_STATUS_404'] === 'Y',
            $arParams['SHOW_404'] === 'Y',
            $arParams['FILE_404']
        );
    }

}

if (isset($arResult['ID'])) {

    CIBlockElement::CounterInc($arResult['ID']);

    if ($arParams['SET_PAGE_TITLE'] == 'Y') {
        if ($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] != '') {
            $APPLICATION->SetTitle($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']);
        } else {
            $APPLICATION->SetTitle($arResult['NAME']);
        }
    }
    if ($arParams['SET_BROWSER_TITLE'] == 'Y') {
        if ($arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE'] != '') {
            $APPLICATION->SetPageProperty('title', $arResult['IPROPERTY_VALUES']['ELEMENT_META_TITLE']);
        } else {
            $APPLICATION->SetPageProperty('title', $arResult['NAME']);
        }
    }

    if ($arParams['SET_META_KEYWORDS'] == 'Y' && $arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS'] != '') {
        $APPLICATION->SetPageProperty('keywords', $arResult['IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS']);
    }

    if ($arParams['SET_META_DESCRIPTION'] == 'Y' && $arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'] != '') {
        $APPLICATION->SetPageProperty('description', $arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION']);
    }

    if ($arParams['ADD_SECTIONS_CHAIN'] == 'Y' && !empty($arResult['SECTION']['PATH'])) {
        foreach ($arResult['SECTION']['PATH'] as $arPath) {
            $APPLICATION->AddChainItem($arPath['NAME'], $arPath['~SECTION_PAGE_URL']);
        }
    }

    return $arResult['ID'];
}