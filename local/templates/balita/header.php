<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @global CMain $APPLICATION */

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$dir = $APPLICATION->GetCurDir();
?>

<!doctype html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?$APPLICATION->ShowTitle();?> | Colorlib Balita</title>

    <?$APPLICATION->ShowHead();?>

    <?php
        Asset::getInstance()->addString('<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700" rel="stylesheet">');

        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/animate.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/owl.carousel.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fonts/ionicons/css/ionicons.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fonts/fontawesome/css/font-awesome.min.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/fonts/flaticon/font/flaticon.css");
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/style.css");

        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery-3.2.1.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery-migrate-3.0.0.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/popper.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/bootstrap.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/owl.carousel.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.waypoints.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/jquery.stellar.min.js");
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");
    ?>

</head>
<body>
<?$APPLICATION->ShowPanel();?>
<header role="banner">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-9 social">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "A",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/social.php"
                        )
                    );?>
                </div>
                <div class="col-3 search-top">
                    <!-- <a href="#"><span class="fa fa-search"></span></a> -->
                    <form action="#" class="search-top-form">
                        <span class="icon fa fa-search"></span>
                        <input type="text" id="s" placeholder="Type keyword to search...">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container logo-wrap">
        <div class="row pt-5">
            <div class="col-12 text-center">
                <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button" aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
                <div class="site-logo"><a href="/">Balita</a></div>
            </div>
        </div>
    </div>
    <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"main", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "main",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
</header>
<!-- END header -->
<? if($dir=='/'): ?>
    <?$APPLICATION->IncludeComponent(
	"sharshakov:slider", 
	".default", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "Y",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"HL_BLOCK" => "2",
		"HL_BLOCK_FIELDS_LINK" => "UF_LINK",
		"HL_BLOCK_FIELDS_NAME" => "UF_NAME",
		"HL_BLOCK_FIELDS_PICTURE" => "UF_PICTURE",
		"SLIDER_EFFECT" => "fade",
		"COMPONENT_TEMPLATE" => ".default",
		"HL_BLOCK_FIELDS_DATE" => "UF_DATE",
		"HL_BLOCK_FIELDS_DESC" => "UF_DESC"
	),
	false
);?>
<!-- END section -->
<? endif; ?>
<section class="site-section <? if($dir=='/'): ?>py-sm<? endif; ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4"><?$APPLICATION->ShowTitle(false);?></h1>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
