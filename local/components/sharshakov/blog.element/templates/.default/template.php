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
<div class="post-meta">
    <span class="category"><?= $arResult["SECTION"]["NAME"] ?></span>
    <span class="mr-2"><?= date("F j, Y", MakeTimeStamp($arResult['DATE_CREATE'])); ?></span>
</div>
<div class="post-content-body">
    <?php if (!empty($arResult['DETAIL_PICTURE'])): ?>
        <img src="<?= $arResult['DETAIL_PICTURE']['SRC']; ?>"
             alt="<?= $arResult['DETAIL_PICTURE']['ALT']; ?>"
             title="<?= $arResult['DETAIL_PICTURE']['TITLE']; ?>"/>
    <?php endif; ?>
    <?php if (!empty($arResult['DETAIL_TEXT'])): ?>

        <?= $arResult['DETAIL_TEXT']; ?>
    <?php endif; ?>
</div>

<div class="pt-5">
    <p>Categories:
        <? $countG = count($arResult['GROUPS']);
        $i = 0; ?>
        <? foreach ($arResult['GROUPS'] as $group): ?>
            <a href="<?= $group["SECTION_PAGE_URL"] ?>"><?= $group['NAME'] ?></a><? if ($i < $countG - 1) {
                echo ', ';
            }
            $i++; ?>
        <? endforeach; ?>
    </p>
</div>
