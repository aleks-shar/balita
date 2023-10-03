<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Главная страница");
$APPLICATION->SetPageProperty("keywords", "main");
$APPLICATION->SetPageProperty("description", "main");
$APPLICATION->SetTitle("Lifestyle Category");
?>

<div class="row">
    <?$APPLICATION->IncludeComponent(
	"sharshakov:blog.section.main", 
	".default", 
	array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"ELEMENT_COUNT" => "6",
		"ELEMENT_URL" => "/categories/#SECTION_CODE#/#ELEMENT_CODE#",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "products",
		"SECTIONS" => "4",
		"SECTION_URL" => "/categories/#SECTION_CODE#/",
		"USE_CODE_INSTEAD_ID" => "Y",
		"COMPONENT_TEMPLATE" => ".default",
		"SECTION" => "4",
		"POPULAR_SECTIONS" => "3"
	),
	false
);?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
