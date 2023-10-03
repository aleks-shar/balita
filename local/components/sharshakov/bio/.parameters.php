<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = [
    "PARAMETERS" => [
        "FILE" => [
            "NAME" =>  Loc::getMessage("SHARSHAKOV_BIO_PARA_NAME"),
            "TYPE" => "FILE",
            "FD_EXT" => "png, gif, jpg, jpeg",
            "FD_UPLOAD" => true,
            "FD_USE_MEDIALIB" => true,
            "FD_MEDIALIB_TYPES" => ['image'],
            "DEFAULT" => "",
            "PARENT" => "BASE",
        ],
        "HEADER" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_HEADER"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("SHARSHAKOV_BIO_PARA_HEADER_DEFAULT"),
            "PARENT" => "BASE",
        ],
        "TEXT" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_TEXT"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("SHARSHAKOV_BIO_PARA_TEXT_DEFAULT"),
            "PARENT" => "BASE",
        ],
        "BUTTON_TEXT" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_BUTTON_TEXT"),
            "TYPE" => "STRING",
            "DEFAULT" => Loc::getMessage("SHARSHAKOV_BIO_PARA_TEXT_DEFAULT"),
            "PARENT" => "BASE",
        ],
        "BUTTON_LINK" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_BUTTON_LINK"),
            "TYPE" => "STRING",
            "DEFAULT" => null,
            "PARENT" => "BASE",
        ],
        "FACEBOOK" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_FACEBOOK"),
            "TYPE" => "STRING",
            "DEFAULT"  => null,
            "PARENT" => "BASE",
        ],
        "TWITTER" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_TWITTER"),
            "TYPE" => "STRING",
            "DEFAULT" => null,
            "PARENT" => "BASE",
        ],
        "INSTAGREMM" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_INSTAGRAMM"),
            "TYPE" => "STRING",
            "DEFAULT" => null,
            "PARENT" => "BASE",
        ],
        "YOUTUBE" => [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_YOUTUBE"),
            "TYPE" => "STRING",
            "DEFAULT" => null,
            "PARENT" => "BASE",
        ],
        "CACHE_TIME"  =>  [
            "NAME" => Loc::getMessage("SHARSHAKOV_BIO_PARA_CACHE_TIME"),
            "TYPE" => "STRING",
            "PARENT" => "CACHE_SETTINGS",
            "DEFAULT"=>36000
        ],

    ]
];
