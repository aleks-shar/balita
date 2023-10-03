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

<?php if (!empty($arResult['ROOT_SECTIONS'])): ?>

        <?php foreach ($arResult['ROOT_SECTIONS'] as $arSection):?>
                <div class="post-entry-horzontal">
                    <a href="<?= $arSection['SECTION_PAGE_URL']; ?>">
                        <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url(<?=$arSection['PREVIEW_PICTURE']['SRC']; ?>"></div>
                        <span class="text">
                      <div class="post-meta">
                        <span class="mr-2"><?=date("F j, Y", MakeTimeStamp($arSection['DATE_CREATE'])); ?></span>
                      </div>
                      <h2><?= $arSection['NAME']; ?></h2>
                    </span>
                    </a>
                </div>

        <?php endforeach; ?>

<?php endif; ?>
