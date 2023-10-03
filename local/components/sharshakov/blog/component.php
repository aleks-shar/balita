<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

if (!CModule::IncludeModule('iblock')) {
    ShowError('Модуль «Информационные блоки» не установлен');
    return;
}


if ($arParams['SEF_MODE'] == 'Y') {
    $arVariables = [];
    $componentPage = CComponentEngine::ParseComponentPath(
        $arParams['SEF_FOLDER'],
        $arParams['SEF_URL_TEMPLATES'],
        $arVariables
    );

    if ($componentPage === false && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $arParams['SEF_FOLDER']) {
        $componentPage = 'popular';
    }

    if (empty($componentPage)) {
        \Bitrix\Iblock\Component\Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Элемент или раздел инфоблока не найден',
            true,
            true,
            true,
            ""
        );
        return;
    }

    $notFound = false;
    if ($componentPage == 'element') {
        if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
            if (!(isset($arVariables['ELEMENT_CODE']) && strlen($arVariables['ELEMENT_CODE']) > 0)) {
                $notFound = true;
            }
        } else {
            if (!(isset($arVariables['ELEMENT_ID']) && ctype_digit($arVariables['ELEMENT_ID']))) {
                $notFound = true;
            }
        }
    }

    if ($componentPage == 'section') {
        if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
            if (!(isset($arVariables['SECTION_CODE']) && strlen($arVariables['SECTION_CODE']) > 0)) {
                $notFound = true;
            }
        } else {
            if (!(isset($arVariables['SECTION_ID']) && ctype_digit($arVariables['SECTION_ID']))) {
                $notFound = true;
            }
        }
    }

    if ($notFound) {
        \Bitrix\Iblock\Component\Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Элемент или раздел инфоблока не найден',
            true,
            true,
            true,
            ""
        );
        return;
    }

    CComponentEngine::InitComponentVariables(
        $componentPage,
        null,
        [],
        $arVariables
    );

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = $arParams['SEF_FOLDER'];
    $arResult['SECTION_URL'] = $arParams['SEF_FOLDER'] . $arParams['SEF_URL_TEMPLATES']['section'];
    $arResult['ELEMENT_URL'] = $arParams['SEF_FOLDER'] . $arParams['SEF_URL_TEMPLATES']['element'];

} else {
    $arVariables = [];
    CComponentEngine::InitComponentVariables(
        false,
        null,
        $arParams['VARIABLE_ALIASES'],
        $arVariables
    );

    $componentPage = '';
    if (isset($arVariables['ELEMENT_ID']) && intval($arVariables['ELEMENT_ID']) > 0)
        $componentPage = 'element';
    elseif (isset($arVariables['ELEMENT_CODE']) && strlen($arVariables['ELEMENT_CODE']) > 0)
        $componentPage = 'element';
    elseif (isset($arVariables['SECTION_ID']) && intval($arVariables['SECTION_ID']) > 0)
        $componentPage = 'section';
    elseif (isset($arVariables['SECTION_CODE']) && strlen($arVariables['SECTION_CODE']) > 0)
        $componentPage = 'section';
    else
        $componentPage = 'popular';

    $notFound = false;
    if ($componentPage == 'element') {
        if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
            if (!(isset($arVariables['ELEMENT_CODE']) && strlen($arVariables['ELEMENT_CODE']) > 0)) {
                $notFound = true;
            }
        } else {
            if (!(isset($arVariables['ELEMENT_ID']) && ctype_digit($arVariables['ELEMENT_ID']))) {
                $notFound = true;
            }
        }
    }

    if ($componentPage == 'section') {
        if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {

            if (!(isset($arVariables['SECTION_CODE']) && strlen($arVariables['SECTION_CODE']) > 0)) {
                $notFound = true;
            }
        } else {
            if (!(isset($arVariables['SECTION_ID']) && ctype_digit($arVariables['SECTION_ID']))) {
                $notFound = true;
            }
        }
    }

    if ($notFound) {
        \Bitrix\Iblock\Component\Tools::process404(
            trim($arParams['MESSAGE_404']) ?: 'Элемент или раздел инфоблока не найден',
            true,
            true,
            true,
            ""
        );
        return;
    }

    $arResult['VARIABLES'] = $arVariables;
    $arResult['FOLDER'] = '';
    if ($arParams['USE_CODE_INSTEAD_ID'] == 'Y') {
        $arResult['SECTION_URL'] =
            $APPLICATION->GetCurPage() . '?' . $arParams['VARIABLE_ALIASES']['SECTION_CODE'] . '=#SECTION_CODE#';
        $arResult['ELEMENT_URL'] =
            $APPLICATION->GetCurPage() . '?' . $arParams['VARIABLE_ALIASES']['ELEMENT_CODE'] . '=#ELEMENT_CODE#';
    } else {
        $arResult['SECTION_URL'] =
            $APPLICATION->GetCurPage() . '?' . $arParams['VARIABLE_ALIASES']['SECTION_ID'] . '=#SECTION_ID#';
        $arResult['ELEMENT_URL'] =
            $APPLICATION->GetCurPage() . '?' . $arParams['VARIABLE_ALIASES']['ELEMENT_ID'] . '=#ELEMENT_ID#';
    }

}

$this->IncludeComponentTemplate($componentPage);