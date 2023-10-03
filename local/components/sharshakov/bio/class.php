<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
class BioComponentClass extends CBitrixComponent
{

    public function showBio($ap)
    {
        $arResult["FILE"] = $ap["FILE"];
        $arResult["HEADER"] = $ap["HEADER"];
        $arResult["TEXT"] = $ap["TEXT"];
        $arResult["BUTTON_TEXT"] = $ap["BUTTON_TEXT"];
        $arResult["BUTTON_LINK"] = $ap["BUTTON_LINK"];
        $arResult["FACEBOOK"] = $ap["FACEBOOK"];
        $arResult["TWITTER"] = $ap["TWITTER"];
        $arResult["INSTAGREMM"] = $ap["INSTAGREMM"];
        $arResult["YOUTUBE"] = $ap["YOUTUBE"];
        return $arResult;
    }

    public function executeComponent()
    {
        if ($this->StartResultCache()) {
            $this->arResult = array_merge($this->arResult, $this->showBio($this->arParams));
            $this->IncludeComponentTemplate();
        }
    }
}
