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

$this->setFrameMode(false);
?>
        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
        <div class="post-entry-horzontal">
            <a href="<?= $arItem['DETAIL_PAGE_URL']; ?>">
                <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url(<?= $arItem['PREVIEW_PICTURE']['SRC']; ?>"></div>
                <span class="text">
                      <div class="post-meta">
                        <span class="mr-2"><?=date("F j, Y", MakeTimeStamp($arItem['DATE_CREATE'])); ?></span>
                      </div>
                      <h2><?= $arItem['NAME']; ?></h2>
                    </span>
            </a>
        </div>
        <?php endforeach; ?>
<div class="pager">
            <?= $arResult['NAV_STRING']; ?>
</div>


