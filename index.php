<?php
include 'phpqrcode/qrlib.php';
include 'Variable.php';
date_default_timezone_set('Asia/Tehran');
error_reporting(0);
#-----------------------------#
#-----------------------------#
#-----------------------------#
#-----------------------------#
///QR code
$randomString = bin2hex(random_bytes(10));
$folderPath = 'qrcodes/';
$filename = $folderPath .$randomString. '.png';
#-----------------------------##-----------------------------#
define('API_KEY', $token);
#-----------------------------#
$namahdod="100 گیگ تک کاربره";
$addnamahdod="افزودن " . $namahdod;
$singel="30 گیگ تک کاربره";
$addsingel="افزودن ".$singel;
$test="اکانت تست";
$addtest="افزودن ".$test;
#-----------------------------#
$update = json_decode(file_get_contents("php://input"));
if(isset($update->message)){
    $from_id    = $update->message->from->id;
    $usernameid=$update->message->from->username;
    $chat_id    = $update->message->chat->id;
    $tc         = $update->message->chat->type;
    $text       = $update->message->text;
    $first_name = $update->message->from->first_name;
    $message_id = $update->message->message_id;
}elseif(isset($update->callback_query)){
    $chat_id    = $update->callback_query->message->chat->id;
    $data       = $update->callback_query->data;
    $query_id   = $update->callback_query->id;
    $message_id = $update->callback_query->message->message_id;
    $in_text    = $update->callback_query->message->text;
    $from_id    = $update->callback_query->from->id;
}
#-----------------------------#
$weltxt="سلام .$first_name. 
برای خرید اول از گزینه وضعیت سرویس ها از موجودی و قیمت سرویس ها اطلاع پیدا کن 
بعد از قسمت افزایش موجودی ، موجودی خودت رو تکمیل کن 
در آخر از قسمت خرید فیلتر شکن کانفیگ مورد نظر خودت رو دریافت کن " ;
#-----------------------------#
//SQL SETUP
$servername = "localhost";
$username= "lachlach_morteza";
$password= "Armin2afm*";
$dbname= "lachlach_bot";
$conn= new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn,'set names "utf8"');
#-----------------------------#
#-----------------------------#
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}
#-----------------------------#
if(!is_dir("data")){
    mkdir("data");
}
if(!is_dir("data/user")){
    mkdir("data/user");
}
if(!is_dir("data/code")){
    mkdir("data/code");
}
if(!is_dir("data/vpn")){
    mkdir("data/vpn");
}
if(!is_dir("data/vpn/v2ray")){
    mkdir("data/vpn/v2ray");
}
if(!is_dir("data/vpn/ex")){
    mkdir("data/vpn/ex");
}
if(!is_dir("data/user/$from_id")){
    mkdir("data/user/$from_id");
}
if(!is_dir("data/user/$from_id/vpn")){
    mkdir("data/user/$from_id/vpn");
}
if(!is_dir("data/user/$from_id/vpn/v2ray")){
    mkdir("data/user/$from_id/vpn/v2ray");
}
if(!is_dir("data/user/$from_id/vpn/ex")){
    mkdir("data/user/$from_id/vpn/ex");
}
if(!file_exists("data/user/$from_id/coin.txt")){
    file_put_contents("data/user/$from_id/coin.txt", "10000");
}
if(!file_exists("data/user/$from_id/test.txt")){
    file_put_contents("data/user/$from_id/test.txt", "none");
}
if(!file_exists("data/helpcont")){
    file_put_contents("data/helpcont", "😑متن راهنما تنظیم نشده است !");
}
if(!file_exists("data/ex")){
    file_put_contents("data/ex", "0");
}
if(!file_exists("data/v2ray")){
    file_put_contents("data/v2ray", "0");
}
if(!file_exists("data/osm")){
    file_put_contents("data/osm", "خاموش");
}
if(!file_exists("data/channel")){
    file_put_contents("data/channel", "none");
}
#-----------------------------#
$delkha = file_get_contents("data/user/$from_id/delkha.txt") ;
#-----------------------------#
#-----------------------------#یث
$step = file_get_contents ("data/user/$from_id/step.txt");
$coin = file_get_contents ("data/user/$from_id/coin.txt");
$helpcont = file_get_contents ("data/helpcont");
$cart = file_get_contents ("data/cart");
$o = "🔘 بازگشت";
$oo = "🔘 برگشت";
$channel = file_get_contents ("data/channel");
$truechannel = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel&user_id=".$from_id));
$tch = $truechannel->result->status;
$pooyaosm = file_get_contents ("data/osm");
#-----------------------------#
$ex = file_get_contents ("data/ex");
$v2ray = file_get_contents ("data/v2ray");
#-----------------------------#

$key2 = json_encode(['keyboard'=>[
    [['text'=>$namahdod],['text'=>$singel]],
    [['text'=>"$o"]],
],

    'resize_keyboard' =>true]);
$back = json_encode(['keyboard'=>[
    [['text'=>"$o"]],
],
    'resize_keyboard' =>true]);
$key3 = json_encode(['keyboard'=>[
    [['text'=>"➕ افزودن وی پی ان"],['text'=>"📊 وضعیت ربات"]],
    [['text'=>"🔑 خدمات ارسال"],['text'=>"❌ حذف کل اکانتها"]],
    [['text'=>"ℹ سایر خدمات"],['text'=>"💳 تنظیمات مالی"]],
    [['text'=>"⚙ تنظیمات مدیریتی"]],
],
    'resize_keyboard' =>true]);
$key4 = json_encode(['keyboard'=>[
    [['text'=>$addnamahdod],['text'=>$addsingel]
        ,['text'=>$addtest]],
    [['text'=>"$oo"]],
],
    'resize_keyboard' =>true]);
$bk = json_encode(['keyboard'=>[
    [['text'=>"$oo"]],
],
    'resize_keyboard' =>true]);
$key5 = json_encode(['keyboard'=>[
    [['text'=>"♧ تنظیم متن راهنمای اتصال"]],
    [['text'=>"🎺 تنظیمات کانال"],['text'=>"$oo"]],
],'resize_keyboard' =>true]);
$key6 = json_encode(['keyboard'=>[
    [['text'=>"📥 فوروارد همگانی"],['text'=>"📤 ارسال همگانی"]],
    [['text'=>"$oo"]],
],'resize_keyboard' =>true]);
$key7 = json_encode(['keyboard'=>[
    [['text'=>"💳ثبت شماره کارت"],['text'=>"💰 ثبت آدرس   TRX"],['text'=>"💰 تعیین قیمت"]],
    [['text'=>"➖ کاهش پول"],['text'=>"➕ افزایش پول"]],
    [['text'=>"$oo"]],
],'resize_keyboard' =>true]);
$key8 = json_encode(['keyboard'=>[
    [['text'=>"💵 پول همگانی"]],
    [['text'=>"🏵ساخت کد هدیه"]],
    [['text'=>"$oo"]],
],'resize_keyboard' =>true]);
#-----------------------------#
#-----------------------------#
#-----------------------------#
if ($pooyaosm == "روشن"){
    if($tch != 'member' && $tch != 'creator' && $tch != 'administrator' && $chat_id != $dev){
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "
▫️شما در کانال اسپانسر عضو نیستید ⚜️
◼️عضو شوید و سپس /start را بفرستید",
            'parse_mode' => "html",
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => "@$channel", 'url' => "https://telegram.me/$channel"]
                    ],

                ]
            ])
        ]);
        exit();
    }}
#-----------------------------#
if( $text == "/start" || $text == $o){
    $sql = "SELECT chatid FROM shekanbot WHERE chatid = $from_id";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> $weltxt,
            'reply_markup'=>$key1,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
    if($result->num_rows==0){
        sendmessage($dev,"یک نفر وارد ربات شد نام کاربری :".$usernameid." اسمش :".$first_name);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> $weltxt,
            'reply_markup'=>$key1,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        $sql10 ="INSERT INTO shekanbot (chatid,username,entrydate)VALUES('$from_id','$usernameid','$now')";
        $result1=$conn->query($sql10);
        file_put_contents ("data/user/$from_id/step.txt","none");
        // file_put_contents ("data/user/$from_id/test.txt","none");
    }
    $conn->close();

}
#-----------------------------#
if($text == "🔮 خرید فیلترشکن"){
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "
✅ لطفا سرویس مورد نظرتون رو انتخاب کنید :

💳 $singel : $v2ray
💳 $namahdod : $ex
",
        'reply_markup'=>$key2,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if ($text == "دریافت اکانت تست") {
#--------------------#
//    $sql1="SELECT status FROM bot WHERE chatid='$chat_id'";
//    $nsend=$conn->query($sql1);
//    $filds=$nsend->fetch_assoc();
//    $status=$filds['status'];
//    if($status=="0"){
//        $sql2 = "SELECT contest FROM bottest WHERE id";
//        $nsend2 = $conn->query($sql2);
//        if ( $nsend2->num_rows > 0) {
//            $filds2 = $nsend2->fetch_assoc();
//            $contest = $filds2['contest'];
//            $rep = json_decode(file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&text=".urlencode("`{$contest}`")."&parse_mode=Markdown"));
//            $sql3 = "DELETE FROM bottest ORDER BY id LIMIT 1";
//            $del = $conn->query($sql3);
//            $sql4 = "UPDATE bot SET status = '1' WHERE chatid = '$chat_id'";
//            $update1 = $conn->query($sql4);
//
//        } else {
//            $rep = json_decode(file_get_contents("https://api.telegram.org/bot".$token."/SendMessage?chat_id=".$chat_id."&text=رکورد مورد نظر یافت نشد."));
//        }
//
//    }
//    else{
//        $rep = json_decode(file_get_contents("https://api.telegram.org/bot".$token."/SendMessage?chat_id=".$chat_id."&text=شما قبلا اکانت تست خود را دیافت کرده اید"));
//    $conn->close();
#--------------------#
    $amounttest=file_get_contents("data/user/$from_id/test.txt");
    if($amounttest=="none") {
        $scan = scandir("data/vpn/test");
        $tex = count($scan) - 2;
        if ($tex < 1) {
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "متاسفانه تعداد اکانت های این سرویس به اتمام رسیده است . لطفا بعدا مراجعه کنید .",
                'reply_markup' => $key1,
                'parse_mode' => "Markdown",
                'reply_to_message_id' => $message_id,
            ]);
            sendmessage($dev," یارواکانت تست تموم کردی");
            exit();
        }
        else {
            sendmessage($dev,"یک اکانت تست گرفت".$chat_id);
            bot('sendmessage', [
                'chat_id' => $chat_id,
                'text' => "لطفا کمی صبر کنید ربات درحال ساخت فیلتر شکن شما می باشد ...",
                'parse_mode' => "Markdown",
                'reply_to_message_id' => $message_id,
            ]);
            sleep('3');
            $scan = scandir("data/vpn/test");
            $random = $scan[rand(2, count($scan) - 1)];
            $a = file_get_contents("data/vpn/test/$random");

            $text121 = $a;
            $folderPath = 'qrcodes/';
            $filename = $folderPath . $chat_id . '.png';
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            QRcode::png($text121, $filename);

            $photo1 = curl_file_create($filename, 'image/png');
            bot('sendphoto', [
                $text122 = "
    کانفیگ شما: ⬇️ (برای کپی کد لطفاً کد را لمس کنید)

⚙️ `$a`

📅 تاریخ خرید: $now
حجم : 300 مگ
⏳ اگر مایل به تمدید اکانت خود هستید، لطفاً دو روز قبل از اتمام تاریخ انقضا با ادمین در تماس باشید.

🙏 با تشکر، ادمین

",
                'chat_id' => $chat_id,
                'photo' => $photo1,
                'caption' => $text122,
                'reply_markup' => $key1,
                'parse_mode' => "Markdown",
                'reply_to_message_id' => $message_id,
            ]);
            unlink ("data/vpn/test/$random");
            file_put_contents ("data/user/$from_id/test.txt","1");
        }

    }
    elseif ($amounttest ="1"){
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "شما قبلا اکانت تست دریافت کرده اید",
            'reply_markup' => $key1,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        exit();
    }
}
#-----------------------------#
if($text == "⚜ خرید سرویس ها"){
    $scan = scandir ("data/vpn/v2ray");
    $tv2ray = count ($scan) - 2;
    if($tv2ray>0) {
        $tv2rayok = "✅ خرید";
    }else{
        $tv2rayok="⛔";
    }
    $scan1 = scandir ("data/vpn/ex");
    $tex = count ($scan1) - 2;
    if($tex>0) {
        $texok = "✅ خرید ";
    }else{
        $texok="⛔";
    }
    $scan2 = scandir ("data/vpn/test");
    $ttest = count ($scan2) - 2;
    $ttest = count ($scan1) - 2;
    if($ttest>0) {
        $ttestok = "✅";
    }else{
        $ttestok="⛔";
    }
    $keyom = json_encode(['inline_keyboard' => [
        [['text' =>" وضعیت سرویس های موجود",'callback_data'=>"a"],['text'=>"قیمت",'callback_data'=>"a"],['text' =>"نام سرویس",'callback_data'=>"a"]],
        [['text' =>"$texok",'callback_data'=>"buyex"],['text'=>"$ex",'callback_data'=>"a"],['text' =>$namahdod,'callback_data'=>"a"]],
        [['text' =>"$tv2rayok",'callback_data'=>"buyv2ray"],['text'=>"$v2ray",'callback_data'=>"a"],['text' =>$singel,'callback_data'=>"a"]],
        [['text' =>"$ttestok",'callback_data'=>"a"],['text'=>"رایگان",'callback_data'=>"a"],['text' =>$test,'callback_data'=>"a"]],

    ]]);
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "🎴 وضعیت سرویس های وی پی ان و همچنین قیمت های آنها به شرح ذیل می باشد :",
        'reply_markup'=>$keyom,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#

if ($data == 'buyex') {
    $payurlfull = $baseURL.'pay/request.php?chatid='.$chat_id."&amount=".$ex;
    $keybuy = json_encode(['inline_keyboard' => [
        [['text' => 'پرداخت', 'url' => $payurlfull]]
    ]]);
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "مبلغ پرداخت شما برای اکانت $namahdod به مبلغ $ex می باشد
        $payurlfull",
        'reply_markup' => $keybuy,
        'parse_mode' => "Markdown"
    ]);
}elseif($data=='buyv2ray'){
    $payurlfull = $baseURL.'pay/request.php?chatid='.$chat_id."&amount=".$v2ray;
    $keybuy = json_encode(['inline_keyboard' => [
        [['text' => 'پرداخت', 'url' => $payurlfull]]
    ]]);
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "مبلغ پرداخت شما برای اکانت $singel به مبلغ $v2ray می باشد
        $payurlfull",
        'reply_markup' => $keybuy,
        'parse_mode' => "Markdown"
    ]);
}
#-----------------------------#

elseif($text == $singel){
    $scan = scandir ("data/vpn/v2ray");
    $tv2ray = count ($scan) - 2;
    if($coin < $v2ray){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "❌ متأسفانه موجودی شما جهت خرید این سرویس کافی نیست .",
            'reply_markup'=>$back,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        exit();
    }
    if($tv2ray < 1){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "متاسفانه تعداد اکانت های این سرویس به اتمام رسیده است . لطفا بعدا مراجعه کنید .",
            'reply_markup'=>$key1,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        exit();
    }
    else{
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "لطفا کمی صبر کنید ربات درحال ساخت فیلتر شکن شما می باشد ...",
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        sleep ('3');
        $a = $coin - $v2ray;
        file_put_contents ("data/user/$from_id/coin.txt",$a);
        $scan = scandir("data/vpn/v2ray");
        $random = $scan[rand(2, count($scan) - 1)];
        $a = file_get_contents ("data/vpn/v2ray/$random");

        $text121 = $a;
        $folderPath = 'qrcodes/';
        $filename = $folderPath .$chat_id. '.png';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        QRcode::png($text121, $filename);

        $photo1 = curl_file_create($filename, 'image/png');
        bot('sendphoto',[
            $text122="
    کانفیگ شما: ⬇️ (برای کپی کد لطفاً کد را لمس کنید)

⚙️ `$a`

📅 تاریخ خرید: $now
📆 تاریخ انقضا: $current_jdate

⏳ اگر مایل به تمدید اکانت خود هستید، لطفاً دو روز قبل از اتمام تاریخ انقضا با ادمین در تماس باشید.

🙏 با تشکر، ادمین

",
            'chat_id'=> $chat_id,
            'photo'=> $photo1,
            'caption'=> $text122,
            'reply_markup'=>$key1,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        $folder=__DIR__."/data/user/$from_id/vpn/v2ray/";
        $scandir=scandir($folder);

        $filename2=$scandir[2];

        $current_number = intval(basename($filename2));

        $acc = file_get_contents ("data/user/$from_id/vpn/v2ray/$filename2");
        $acc1="`".$acc."`";
        $new_number = $current_number + 1;

        file_put_contents ("data/user/$from_id/vpn/v2ray/$new_number","$acc
`$a`
📅 تاریخ خرید: $now
📆 تاریخ انقضا: $current_jdate");
        unlink ("data/vpn/v2ray/$random");
        unlink("data/user/$from_id/vpn/v2ray/$filename2");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
}
#-----------------------------#
if($text == "🪫کد هدیه"){
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "👈 کد هدیه را وارد کنید :",
        'reply_markup'=>$back,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/step.txt","okpopoa");
}
elseif ($step == "okpopoa"and $text != $o){

    $a = file_exists("data/code/$text");
    if($text == $a){

        $aa = file_get_contents ("data/code/$text");
        $b = $coin + $aa;
        file_put_contents ("data/user/$from_id/coin.txt",$b);
        unlink ("data/code/$text");
        sendmessage ($chat_id , "کد هدیه با موفقیت وارد شد و مبلغ $aa به حساب شما افزوده شد." , $back);
        file_put_contents ("data/user/$from_id/step.txt","none");

    }else{
        sendmessage ($chat_id , "کد هدیه اشتباه یا استفاده شده است.");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }

}
#-----------------------------#
#-----------------------------#
if($text == $namahdod){
    $scan = scandir ("data/vpn/ex");
    $tex = count ($scan) - 2;
    if($coin < $ex){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "❌ متأسفانه موجودی شما جهت خرید این سرویس کافی نیست .",
            'reply_markup'=>$back,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        exit();
    }
    if($tex < 1){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "متاسفانه تعداد اکانت های این سرویس به اتمام رسیده است . لطفا بعدا مراجعه کنید .",
            'reply_markup'=>$key1,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        exit();
    }
    else{
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "لطفا کمی صبر کنید ربات درحال ساخت فیلتر شکن شما می باشد ...",
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        sleep ('3');
        $a = $coin - $ex;
        file_put_contents ("data/user/$from_id/coin.txt",$a);
        $scan = scandir("data/vpn/ex");
        $random = $scan[rand(2, count($scan) - 1)];
        $a = file_get_contents ("data/vpn/ex/$random");

        $text121 = $a;
        $folderPath = 'qrcodes/';
        $filename = $folderPath .$chat_id. '.png';
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        QRcode::png($text121, $filename);

        $photo1 = curl_file_create($filename, 'image/png');
        bot('sendphoto',[
            $text122="
    کانفیگ شما: ⬇️ (برای کپی کد لطفاً کد را لمس کنید)

⚙️ `$a`

📅 تاریخ خرید: $now
📆 تاریخ انقضا: $current_jdate

⏳ اگر مایل به تمدید اکانت خود هستید، لطفاً دو روز قبل از اتمام تاریخ انقضا با ادمین در تماس باشید.

🙏 با تشکر، ادمین

",
            'chat_id'=> $chat_id,
            'photo'=> $photo1,
            'caption'=> $text122,
            'reply_markup'=>$key1,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        $folder=__DIR__."/data/user/$from_id/vpn/ex/";
        $scandir=scandir($folder);

        $filename2=$scandir[2];

        $current_number = intval(basename($filename2));

        $acc = file_get_contents ("data/user/$from_id/vpn/ex/$filename2");
        $acc1="`".$acc."`";
        $new_number = $current_number + 1;

        file_put_contents ("data/user/$from_id/vpn/ex/$new_number","$acc
`$a`
📅 تاریخ خرید: $now
📆 تاریخ انقضا: $current_jdate");
        unlink ("data/vpn/ex/$random");
        unlink("data/user/$from_id/vpn/ex/$filename2");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
}
#-----------------------------#
if($text == "💡 آموزش اتصال"){
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "$helpcont",
        'reply_markup'=>$key1,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "💫 اطلاعات کاربری"){
    $scan = scandir ("data/user/$from_id/vpn/v2ray");
    $scan1 = scandir ("data/user/$from_id/vpn/ex");
    $v2raybuy = count ($scan) - 2;
    $exbuy = count ($scan1) - 2;
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "
📌 وضعیت کاربری شما در ربات ما :

🔢 شناسه عددی شما : `$chat_id`
💳 موجودی کل شما : *$coin ریال*
🔑 تعداد اکانت  $singel خریداری شده : *$v2raybuy*
🎴 تعداد اکانت های $namahdod خریداری شده : *$exbuy*
",
        'reply_markup'=>$key1,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "➕ افزایش موجودی"){
    $rand  = rand (1,9);
    $rand1 = rand (1,9);
    $a = $rand + $rand1;
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "
♻️ لطفا جهت احراز هویت حاصل جمع زیر را وارد کنید :
$rand + $rand1 = ?
",
        'reply_markup'=>$back,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/rand","$a");
    file_put_contents ("data/user/$from_id/step.txt","rand");
}
elseif($step == "rand" and $text != $o){
    $b = file_get_contents ("data/user/$from_id/rand");
    if($text != $b){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "❌ حاصل وارد شده اشتباه است . لطفا دوباره تلاش کنید و از اعداد انگلیسی استفاده کنید .",
            'reply_markup'=>$back,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","rand");
    }
    else{
        $keycart = json_encode(['inline_keyboard' => [
            [['text' =>"ارسال رسید",'callback_data'=>"sendres"]],
            [['text' =>"پرداخت از درگاه بانکی",'callback_data'=>"zarin"]],
        ]]);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
✅ احراز هویت با موفقیت انجام شد.

💳 برای شارژ حساب خود ابتدا از طریق گزینه *پرداخت از درگاه بانکی* مبلغ مورد نظر را انتخاب کنید تا به درگاه بانکی هدایت شوید ",
            'reply_markup'=>$keycart,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","card");
    }
}
#-----------------------------#
if($data == "sendres"){
    bot('sendmessage',[
        'chat_id'=> $chat_id,
        'text'=> "✅ لطفا عکس رسید را برای من ارسال کنید :",
        'reply_markup'=>$back,
        'parse_mode'=>"Markdown",
        'reply_to_message_id'=>$message_id,
    ]);
    file_put_contents ("data/user/$from_id/step.txt","zitactm");
}
elseif($step == "zitactm" and $text != $o){
    $photo = $update->message->photo;
    $file_id = $update->message->photo[count($update->message->photo) - 1]->file_id;
    bot ('sendphoto',[
        'chat_id'=>$dev,
        'photo'=>"$file_id",
        'caption'=>"
✅ فرستاده شده توسط کاربر `$chat_id`
",
        'parse_mode'=>"Markdown",

    ]);
    sendmessage ($chat_id,"رسید یا موفقیت ارسال شد ."  , $key1);
    file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#

#-----------------------------#
if ($data == "zarin") {
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "برای خرید اکانت $singel مبلغ 
		و برای خرید اکانت $namahdod مبلغ  را انتخاب کنید.",

        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'پرداخت مبلغ '.$ex .' تومان', 'url' => 'https://lachlach.top/bot/request.php?pay='.$chat_id."&amount=".$ex]
                ],
                [
                    ['text' => 'پرداخت مبلغ '.$v2ray .' تومان', 'url' => 'https://lachlach.top/bot/request.php?pay='.$chat_id."&amount=".$v2ray]
                ],
                [
                    ['text' => 'مبلغ دلخواه', 'callback_data' => 'delkha']
                ]
            ]
        ]),
        'parse_mode' => "Markdown",
        'reply_to_message_id' => $message_id,
    ]);
    file_put_contents("data/user/$from_id/step.txt", "none");
}

#-----------------------------#
if ($data=="delkha"){
    bot('sendmessage', [
        'chat_id' => $chat_id,
        'text'=>'مبلغ دلخواه را وارد کنید و بر روی پرداخت را بزنید' ,
        'parse_mode' => "HTML",
        'disable_web_page_preview' => true,
        // 'reply_markup' =>$key20
    ]);
    $delkha=file_put_contents ("data/user/$from_id/delkha.txt","delkha");
} elseif($delkha=="delkha" and is_numeric($text)) {
    if($text<150000){
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text'=> 'حداقل مبلغ 150000 ریال است '
        ]);
        $delkha=file_put_contents ("data/user/$from_id/delkha.txt","delkha");
        exit();

    }else{
        $pay="https://lachlach.top/bot/request.php?pay=";
        $pay1=$pay.$chat_id ."&amount=". $text ;
        bot('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=> " برای پرداخت روی لینک زیر کلیک کنید
        $pay1
        "
        ]);
    }
    $delkha=file_put_contents ("data/user/$from_id/delkha.txt","");

}
#-----------------------------#
#-----------------------------#
elseif($from_id == $dev){
    if($text == "/panel" || $text == $oo || $text == "پنل"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "👍 سلام ادمین عزیز خوش آمدی :",
            'reply_markup'=>$key3,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "➕ افزودن وی پی ان"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "✅ یکی از سرویس های موجود را انتخاب کنید :",
            'reply_markup'=>$key4,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if ($text == $addsingel) {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🔑 لطفا کد کانکشن کانفیگ v2ray را وارد کنید:",
            'reply_markup' => $bk,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "cratev2ray");
    }

    if ($step == "cratev2ray" && $text != $oo) {
        $rand = rand(1000, 100000);
        file_put_contents("data/vpn/v2ray/$rand", $text);
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅🔑 کانکشن v2ray با موفقیت ذخیره شد و برای فروش آماده شد.",
            'reply_markup' => $key3,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
    }

    elseif ($text ==$addnamahdod) {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🔑 لطفا کد کانکشن کانفیگ v2ray را وارد کنید:",
            'reply_markup' => $bk,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "cratev2ra");
    }

    if ($step == "cratev2ra" && $text != $oo) {
        $rand = rand(1000, 100000);
        file_put_contents("data/vpn/ex/$rand", $text);
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅🔑 کانکشن v2ray با موفقیت ذخیره شد و برای فروش آماده شد.",
            'reply_markup' => $key3,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
    }
#-----------------------------#
    if ($text ==$addtest) {
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "🔑 لطفا کد کانکشن کانفیگ v2ray را وارد کنید:",
            'reply_markup' => $bk,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "cratev2r");
    }

    if ($step == "cratev2r" && $text != $oo) {
        $rand = rand(1000, 100000);
        file_put_contents("data/vpn/test/$rand", $text);
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "✅🔑 کانکشن v2ray با موفقیت ذخیره شد و برای فروش آماده شد.",
            'reply_markup' => $key3,
            'parse_mode' => "Markdown",
            'reply_to_message_id' => $message_id,
        ]);
        file_put_contents("data/user/$from_id/step.txt", "none");
    }
#-----------------------------#
    if($text == "ℹ سایر خدمات"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "🙂 لطفا یکی از دسته های موجود را انتخاب کنید :",
            'reply_markup'=>$key5,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "💳ثبت شماره کارت"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
✅ شماره کارت خود را با اعداد انگلیسی وارد کنید :


شماره کارت فعلی : $cart
",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","pooya");
    }
    if($step == "pooya" and $text != $oo){
        file_put_contents ("data/cart",$text);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "👍 شماره کارت با موفقیت ثبت شد .",
            'reply_markup'=>$key3,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "♧ تنظیم متن راهنمای اتصال"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
✅ متن راهنمای اتصال را وارد کنید : انگلیسی یا فارسی یا تلفیقی یا ... مشکلی ندارد .

متن فعلی : $helpcont
",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","helpo");
    }
    if($step == "helpo" and $text != $oo){
        file_put_contents ("data/helpcont",$text);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "✅ با موفقیت ثبت شد",
            'reply_markup'=>$key3,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#

#-----------------------------#
    if($text == "💰 تعیین قیمت"){
        $moni = json_encode(['inline_keyboard' => [
            [['text' =>$singel,'callback_data'=>"d1"]],
            [['text' =>$namahdod,'callback_data'=>"d2"]],
        ]]);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "🙂 قصد تغییر دادن قیمت کدام سرویس را دارید ؟",
            'reply_markup'=>$moni,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "📊 وضعیت ربات"){
        $scan = scandir ("data/user");
        $alluser = count ($scan) - 2;
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
• نوع ربات : اختصاصی 💳
• وضعیت ربات : روشن ✅
• تعداد کاربران : $alluser کاربر
",
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "➕ افزایش پول"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "💳 لطفا مبلغ مورد نظرتون رو با اعداد انگلیسی و به تومان وارد کنید :",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","plus");
    }
    if($step == "plus" and $text != $oo){
        file_put_contents ("data/plus",$text);
        sendmessage ($chat_id , "🔢 اکنون ایدی عددی کاربر مورد نظر را وارد کنید ." , $bk);
        file_put_contents ("data/user/$from_id/step.txt","plus1");
    }
    if($step == "plus1" and $text != $o){
        $coink = file_get_contents ("data/user/$text/coin.txt");
        $a = file_get_contents ("data/plus");
        $b = $coink + $a;
        sendmessage ($chat_id , "✅ با موفقیت انجام شد .");
        file_put_contents ("data/user/$text/coin.txt",$b);
        sendmessage ($text , "
💳 از طرف مدیریت مبلغ $a تومان برای ما فرستاده شد .
");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "➖ کاهش پول"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "💳 لطفا مبلغ مورد نظرتون رو با اعداد انگلیسی و به تومان وارد کنید :",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","pluss");
    }
    if($step == "pluss" and $text != $oo){
        file_put_contents ("data/plus",$text);
        sendmessage ($chat_id , "🔢 اکنون ایدی عددی کاربر مورد نظر را وارد کنید ." , $bk);
        file_put_contents ("data/user/$from_id/step.txt","pluss1");
    }
    if($step == "pluss1" and $text != $o){
        $coink = file_get_contents ("data/user/$text/coin.txt");
        $a = file_get_contents ("data/plus");
        $b = $coink - $a;
        sendmessage ($chat_id , "✅ با موفقیت انجام شد .");
        file_put_contents ("data/user/$text/coin.txt",$b);
        sendmessage ($text , "
💳 از طرف مدیریت مبلغ $a تومان از ما کم شد .
");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($data == "d1"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
💳 قیمت مد نظرتون رو برای این سرویس با یک عدد انگلیسی و به تومان وارد کنید .
مثال : 5000

قیمت فعلی این سرویس : $v2ray
",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","hala");
    }
    if($step == "hala" and $text != $oo){
        file_put_contents ("data/v2ray",$text);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "قیمت سرویس با موفقیت عوض شد .",
            'reply_markup'=>$key3,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($data == "d2"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
💳 قیمت مد نظرتون رو برای این سرویس با یک عدد انگلیسی و به تومان وارد کنید .
مثال : 5000

قیمت فعلی این سرویس : $ex
",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","halaa");
    }
    if($step == "halaa" and $text != $oo){
        file_put_contents ("data/ex",$text);
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "قیمت سرویس با موفقیت عوض شد .",
            'reply_markup'=>$key3,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "🔑 خدمات ارسال"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "
🛡 یکی از خدمات موجود را انتخاب کنید :
",
            'reply_markup'=>$key6,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "💳 تنظیمات مالی"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "🔑 یکی از خدمات موجود را انتخاب کنید :",
            'reply_markup'=>$key7,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "📤 ارسال همگانی"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "📣 متن مورد نظرتون رو برای من ارسال کنید :",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","senall");
    }
    elseif($step == "senall" and $text != $oo){
        if($text){
            $allmmber = scandir ("data/user");
            foreach ($allmmber as $sendall){
                sendmessage ($sendall , $text);
            }
            sendmessage ($chat_id , "✅ پیام شما با موفقیت ارسال شد ‌.");
            file_put_contents ("data/user/$from_id/step.txt","none");
        }else{
            sendmessage ($chat_id , "🖊 شما فقط میتوانید متن ارسال کنید .");
        }
    }
#-----------------------------#
    if($text == "📥 فوروارد همگانی"){
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "📣 رسانه مورد نظرتون رو برای من ارسال کنید :",
            'reply_markup'=>$bk,
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","senalll");
    }
    elseif($step == "senalll" and $text != $oo){
        $allmmber = scandir ("data/user");
        foreach ($allmmber as $sendall){
            bot('forwardMessage',[
                'from_chat_id'=> $from_id,
                'message_id'=> $message_id,
                'chat_id'=> $sendall,
            ]);
        }
        sendmessage ($chat_id , "✅ پیام شما با موفقیت ارسال شد ‌.");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#
    if($text == "🎺 تنظیمات کانال"){
        $keykhoda = json_encode(['keyboard'=>[
            [['text'=>"خاموش|روشن قفل"],['text'=>"ست کانال"]],
            [['text'=>"$oo"]],
        ],'resize_keyboard' =>true]);
        sendmessage ($chat_id , "⚙ یکی از وضعیت های موجود را انتخاب کنید :" , $keykhoda);
    }

    elseif($text == "خاموش|روشن قفل"){
        if ($pooyaosm == "خاموش"){
            file_put_contents ("data/osm","روشن");
            sendmessage ($chat_id , "🔑قفل جوین اجباری کانال فعال شد .");
            file_put_contents ("data/user/$from_id/step.txt","none");
        }else{
            file_put_contents ("data/osm","خاموش");
            sendmessage ($chat_id , "🔑قفل جوین اجباری کانال غیر فعال شد .");
            file_put_contents ("data/user/$from_id/step.txt","none");
        }
    }

#-----------------------------#
    if($text == "❌ حذف کل اکانتها"){
        DeleteDirectory ("data/vpn");
        bot('sendmessage',[
            'chat_id'=> $chat_id,
            'text'=> "✅ تمام اکانت های ثبت شده برای فروش از سرور ربات پاک شدند ‌.",
            'parse_mode'=>"Markdown",
            'reply_to_message_id'=>$message_id,
        ]);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#




#-----------------------------#

    if($text == "⚙ تنظیمات مدیریتی"){
        sendmessage ($chat_id , "👑 یکی از تنظیمات موجود را انتخاب کنید :" , $key8);
        file_put_contents ("data/user/$from_id/step.txt","none");
    }

    if($text == "💵 پول همگانی"){
        sendmessage ($chat_id , "🪙 لطفا مبلغ را به تومان و با اعداد انگلیسی وارد کنید :" , $bk);
        file_put_contents ("data/user/$from_id/step.txt","cow");
    }
    if($step == "cow" and $text != $oo){
        $allmmber = scandir ("data/user");
        foreach ($allmmber as $alluser){
            $a = file_get_contents ("data/user/$alluser/coin.txt");
            $b = $a + $text;
            file_put_contents ("data/user/$alluser/coin.txt",$b);
            sendmessage ($alluser , "💸 از طرف مدیریت مبلغ $text تومان به صورت #همگانی به ما تعلق گرفت .");
        }
        sendmessage ($chat_id , "📤 مبلغ $text تومان به همه ی کاربران ربات ارسال شد ." );
        file_put_contents ("data/user/$from_id/step.txt","none");
    }

#-----------------------------#
    if($text == "🏵ساخت کد هدیه"){
        sendmessage ($chat_id , "🫠مبلغ کد هدیه را وارد کنید .

عدد انگلیسی و به تومان
"  , $bk);
        file_put_contents ("data/user/$from_id/step.txt","okpooya");
    }
    if($step == "okpooya" and $text != $oo){
        $rand = rand (10000,100000);
        file_put_contents ("data/code/$rand",$text);
        sendmessage ($chat_id , "کد هدیه با موفقیت ساخته شد و به کانال مورد نظر ارسال گردید . /n کد هدیه : $rand");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }
#-----------------------------#

    if ($text == "ست کانال"){

        bot ('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"آیدی کانال خود را بدون @ ارسال کنید .",
            'reply_markup'=>$bk,
        ]);

        file_put_contents ("data/user/$from_id/step.txt","setidok");

    }

    if ($step == "setidok" and $text != $oo){
        bot ('sendmessage',[
            'chat_id'=>$chat_id,
            'text'=>"کانال @$text با موفقیت ذخیره شد",
            'reply_markup'=>$bk,
        ]);
        file_put_contents ("data/channel","$text");
        file_put_contents ("data/user/$from_id/step.txt","none");
    }

} //
#-----------------------------#
#-----------------------------#
#-----------------------------#
