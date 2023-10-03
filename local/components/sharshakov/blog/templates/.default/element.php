<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

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
    'sharshakov:blog.element',
    '',
    [
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'USE_CODE_INSTEAD_ID' => $arParams['USE_CODE_INSTEAD_ID'],
        'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
        'ELEMENT_ID' => $arResult['VARIABLES']['ELEMENT_ID'],
        'ELEMENT_CODE' => $arResult['VARIABLES']['ELEMENT_CODE'],
        'SET_PAGE_TITLE' => $arParams['ELEMENT_SET_PAGE_TITLE'],
        'SET_BROWSER_TITLE' => $arParams['ELEMENT_SET_BROWSER_TITLE'],
        'SET_META_KEYWORDS' => $arParams['ELEMENT_SET_META_KEYWORDS'],
        'SET_META_DESCRIPTION' => $arParams['ELEMENT_SET_META_DESCRIPTION'],
        'SECTION_URL' => $arResult['SECTION_URL'],
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        'MESSAGE_404' => $arParams['MESSAGE_404'],
        'SET_STATUS_404' => 'Y', //$arParams['SET_STATUS_404'],
        'SHOW_404' => 'Y',//$arParams['SHOW_404'],
        'FILE_404' => $arParams['FILE_404'],
    ],
    $component
);
?>
