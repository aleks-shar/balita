<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="sidebar-box">
    <div class="bio text-center">
        <?if (!empty($arResult["FILE"])):?>
        <img src="<?=$arResult["FILE"]?>" alt="Image Placeholder" class="img-fluid">
        <?endif;?>
        <div class="bio-body">
            <?if (!empty($arResult["HEADER"])):?>
            <h2><?=$arResult["HEADER"]?></h2>
            <?endif;?>
            <?if (!empty($arResult["TEXT"])):?>
            <p><?=$arResult["TEXT"]?></p>
            <?endif;?>
            <?if (!empty($arResult["BUTTON_LINK"]) && !empty($arResult["BUTTON_TEXT"])):?>
            <p><a href="<?=$arResult["BUTTON_LINK"]?>" class="btn btn-primary btn-sm"><?=$arResult["BUTTON_TEXT"]?></a></p>
            <?endif;?>
            <p class="social">
                <?if (!empty($arResult["FACEBOOK"])):?>
                <a href="<?=$arResult["FACEBOOK"]?>" class="p-2"><span class="fa fa-facebook"></span></a>
                <?endif;?>
                <?if (!empty($arResult["TWITTER"])):?>
                <a href="<?=$arResult["TWITTER"]?>" class="p-2"><span class="fa fa-twitter"></span></a>
                <?endif;?>
                <?if (!empty($arResult["INSTAGREMM"])):?>
                <a href="<?=$arResult["INSTAGREMM"]?>" class="p-2"><span class="fa fa-instagram"></span></a>
                <?endif;?>
                <?if (!empty($arResult["YOUTUBE"])):?>
                <a href="<?=$arResult["YOUTUBE"]?>" class="p-2"><span class="fa fa-youtube-play"></span></a>
                <?endif;?>
            </p>
        </div>
    </div>
</div>
