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
<div class="row">
    <?php foreach ($arResult['POPULAR_SECTIONS'] as $arSection): ?>
        <?$secName = $arSection['NAME'];?>
            <?php foreach ($arSection['ITEMS'] as $arItem):?>
            <div class="col-md-6">
                <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>" class="blog-entry element-animate" data-animate-effect="fadeIn"> <img alt="Image placeholder" src="<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>">
                    <div class="blog-content-body">
                        <div class="post-meta">
                            <span class="category"><?= $secName?></span> <span class="mr-2"><?=date("F j, Y", MakeTimeStamp($arItem['DATE_CREATE'])); ?></span>
                        </div>
                        <h2><?= $arItem['NAME']; ?></h2>
                    </div>
                </a>


            </div>
            <?php endforeach; ?>
    <?php endforeach; ?>
</div>
