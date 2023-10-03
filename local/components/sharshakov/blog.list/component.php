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

$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
$arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'SECTION_PAGE_URL');
$rsSect = CIBlockSection::GetList(
    array("SORT" => "ASC"),
    $arFilter,
    true,
    $arSelect
);
$arResult = [];
while ($arSect = $rsSect->GetNext()) {
    $arResult[] = $arSect;
}
$this->IncludeComponentTemplate();

?>
