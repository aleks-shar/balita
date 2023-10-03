<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
<section class="site-section pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?  foreach ($arResult as $arItem): ?>
                <div class="owl-carousel owl-theme home-slider">
                    <div>
                        <a href="/<?=$arItem['LINK']?>" class="a-block d-flex align-items-center height-lg" style="background-image: url('<?=$arItem['PICTURE']['SRC']?>'); ">
                            <div class="text half-to-full">
                                <div class="post-meta">
                                    <span class="category">Lifestyle</span>
                                    <span class="mr-2">
                                        <?=date("F j, Y", MakeTimeStamp($arItem['DATE'])); ?>
                                    </span>
                                    <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                                </div>
                                <h3><?=$arItem['NAME']?></h3>
                                <p><?=$arItem['DESC']?></p>
                            </div>
                        </a>
                    </div>
                    <? endforeach; ?>
            </div>
        </div>
    </div>
</section>