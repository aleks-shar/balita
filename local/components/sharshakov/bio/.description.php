<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    "NAME" => Loc::getMessage("SHARSHAKOV_BIO_COMPONENT_NAME"),
    "DESCRIPTION" => Loc::getMessage("SHARSHAKOV_BIO__COMPONENT_DESCR"),
    "ICON" => "/images/feedback.gif",
    "PATH" => [
        "ID" => "SHARSHAKOV",
    ],
];
