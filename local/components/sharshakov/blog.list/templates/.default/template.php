<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
?>

<div class="sidebar-box">
    <h3 class="heading">Categories</h3>
    <ul class="categories">
    <? foreach ($arResult as $item):?>
        <li><a href="<?=$item['SECTION_PAGE_URL']?>"><?=$item['NAME']?> <span>(<?=$item['ELEMENT_CNT']?>)</span></a></li>
        <? endforeach;?>
    </ul>
</div>
