<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Contact");
$APPLICATION->SetPageProperty("keywords", "Contact");
$APPLICATION->SetPageProperty("description", "Contact");
$APPLICATION->SetTitle("Contact");
?>
<?$APPLICATION->IncludeComponent(
	"sharshakov:main.feedback", 
	".default", 
	array(
		"EMAIL_TO" => "l-e-stat@yandex.ru",
		"EVENT_MESSAGE_ID" => array(
		),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "EMAIL",
			2 => "MESSAGE",
			3 => "PHONE",
		),
		"USE_CAPTCHA" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>