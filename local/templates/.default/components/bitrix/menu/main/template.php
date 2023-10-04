<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? if (!empty($arResult)): ?>
    <nav class="navbar navbar-expand-md  navbar-light bg-light">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav mx-auto">
                    <? $previousLevel = 0;
                    foreach ($arResult as $arItem): ?>
                    <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
                        <?= str_repeat("</div></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
                    <? endif ?>
                    <? if ($arItem["IS_PARENT"]): ?>
                    <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
                    <li class="nav-item dropdown<? if ($arItem["SELECTED"]): ?>active<? endif ?>"><a href="<?= $arItem["LINK"] ?>" class="nav-link dropdown-toggle" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $arItem["TEXT"] ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown05">
                    <? endif ?>
                    <? else: ?>
                    <? if ($arItem["DEPTH_LEVEL"] == 1): ?>
                    <li class="nav-item"><a class="nav-link <? if ($arItem["SELECTED"]): ?>active<? endif ?>"href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"]  ?> </a></li>
                    <? else: ?>
                    <a class="dropdown-item" href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"]  ?></a>
                    <? endif ?>
                    <? endif ?>
                    <? endforeach ?>    
                </ul>
            </div>
        </div
    </nav>
<? endif ?>

