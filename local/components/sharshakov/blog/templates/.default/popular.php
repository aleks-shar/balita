<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<?php
$APPLICATION->IncludeComponent(
    'sharshakov:blog.popular',
    '',
    [
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'USE_CODE_INSTEAD_ID' => $arParams['USE_CODE_INSTEAD_ID'],
        'ROOT_SECTIONS' => $arParams['POPULAR_ROOT_SECTIONS'],
        'POPULAR_SECTIONS' => $arParams['POPULAR_SECTIONS'],
        'ELEMENT_COUNT' => $arParams['POPULAR_ELEMENT_COUNT'],
        'SET_PAGE_TITLE' => $arParams['POPULAR_SET_PAGE_TITLE'],
        'SET_BROWSER_TITLE' => $arParams['POPULAR_SET_BROWSER_TITLE'],
        'SECTION_URL' => $arResult['SECTION_URL'],
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    ],
    $component
);
?>
