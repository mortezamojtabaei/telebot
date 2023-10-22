<?php
include 'jdf.php';
$token = "6614517638:AAGa2SDN-fOY2Ck2pBh7LwehEYhfxIAJls8";
$dev = "324839776";
$payurl="../pay/";
$baseURL = 'https://github.com/mortezamojtabaei/telebot/';
define('API_KEY', $token);

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
#-----------------------------#
function sendmessage($chat_id,$text,$keyboard = null) {
    bot('sendMessage',[
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => "HTML",
        'disable_web_page_preview' => true,
        'reply_markup' => $keyboard
    ]);
}
#-----------------------------#
function sendPhoto($chat_id, $photo, $caption = null, $keyboard = null) {
    bot('sendPhoto', [
        'chat_id' => $chat_id,
        'photo' => $photo,
        'caption' => $caption,
        'reply_markup' => $keyboard
    ]);
}

#-----------------------------#
$now= jdate('Y/m/d', '', '', 'Asia/Tehran', 'en');
$currentDate = date('Y-m-d'); // تاریخ فعلی
$newDate = date('Y-m-d', strtotime($currentDate . ' +30 days')); // اضافه کردن 30 روز به تاریخ فعلی
$arr_parts = explode('-', $newDate);
$gYear  = $arr_parts[0];
$gMonth = $arr_parts[1];
$gDay   = $arr_parts[2];
$current_jdate = gregorian_to_jalali($gYear, $gMonth, $gDay, '/');
#-------------------------#
$key1 = json_encode(['keyboard'=>[
    [['text'=>"⚜ خرید سرویس ها"],['text'=>"دریافت اکانت تست"]],
    [['text'=>"💫 اطلاعات کاربری"],['text'=>"🪫کد هدیه"]],
    [['text'=>"💡 آموزش اتصال"],['text'=>"➕ افزایش موجودی"]],
],
    'resize_keyboard' =>true]);
