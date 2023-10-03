<div class="col-md-12 col-lg-4 sidebar">
    <div class="sidebar-box search-form-wrap">
        <form action="#" class="search-form">
            <div class="form-group">
                <span class="icon fa fa-search"></span>
                <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
            </div>
        </form>
    </div>
    <?$APPLICATION->IncludeComponent(
	"sharshakov:bio", 
	".default", 
	array(
		"BUTTON_LINK" => "https://ya.ru",
		"BUTTON_TEXT" => "Read my bio",
		"COMPOSITE_FRAME_MODE" => "Y",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FACEBOOK" => "https://ya.ru",
		"FILE" => "/upload/medialibrary/368/bh6ikcjafif6il2vt96agugmzvts6noo.jpg",
		"HEADER" => "Meagan Smith",
		"INSTAGREMM" => "https://ya.ru",
		"TEXT" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem facilis sunt repellendus excepturi beatae porro debitis voluptate nulla quo veniam fuga sit molestias minus.",
		"TWITTER" => "https://ya.ru",
		"YOUTUBE" => "https://google.com",
		"COMPONENT_TEMPLATE" => ".default",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000"
	),
	false
);?>


    <?$APPLICATION->IncludeComponent(
	"sharshakov:blog.list", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "products",
		"IBLOCK_ID" => "2",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>

