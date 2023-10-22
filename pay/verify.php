<?php
include '../Variable.php';
include '../phpqrcode/qrlib.php';
if(isset($_GET['chatid'])) {
    $chatid = $_GET['chatid'];
//===================
    $file = "../data/user/$chatid/data.json";
    $jsonData = file_get_contents($file);
    $data = json_decode($jsonData, true);
    $amount=$data['amount'];
    $authority=$data['authority'];
//data base
//$servername = "localhost";
//$username= "lachlach_morteza";
//$password= "Armin2afm*";
//$dbname= "lachlach_bot";
//$conn= new mysqli($servername, $username, $password, $dbname);
//mysqli_query($conn,'set names "utf8"');

    if (isset($_REQUEST["PaymentStatus"]) && $_REQUEST["PaymentStatus"] == "OK") {

        $Authority = (isset($_REQUEST["Authority"]) && !empty($_REQUEST["Authority"])) ? $_REQUEST["Authority"] : "";
        $InvoiceID = (isset($_REQUEST["InvoiceID"]) && !empty($_REQUEST["InvoiceID"])) ? $_REQUEST["InvoiceID"] : "";
//        $sql1 = "SELECT amount FROM shekanbot WHERE Authority='$Authority'";
//        $nsend = $conn->query($sql1);
//        $filds = $nsend->fetch_assoc();
//        $amount = $filds['amount'];
//        $sql2 = "SELECT chatid  FROM shekanbot WHERE Authority='$Authority'";
//        $nsend1 = $conn->query($sql2);
//        $filds1 = $nsend1->fetch_assoc();
//        $chatid = $filds1['chatid'];
//        $sql3 = "UPDATE shekanbot SET wallet='$amount' where chatid='$chatid'";
//        $result2 = $conn->query($sql3);
        // $amount = 1000000; /// Get From DB

        $data = [

            "merchant_id" => "test",
            "amount" => $amount,
            "authority" => $Authority
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.novinopay.com/payment/ipg/v2/verification");
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type" => "application/json"]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_exec = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($curl_exec);

        if (isset($result->status) && $result->status == 100) {

            $rep = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/SendMessage?chat_id=" . $chatid . "&text=" . urlencode("پرداخت شما با موفقیت انجام شد")));
            $ex=file_get_contents('../data/ex');
            if($amount==$ex){
                $scan = scandir ("../data/vpn/ex");
                $tv2ray = count ($scan) - 2;
                if($tv2ray>0){
                    $random = $scan[rand(2, count($scan) - 1)];
                    $a = file_get_contents ("../data/vpn/ex/$random");
                    $filename="../data/user/$chatid/$authority.png";
                    $filename1=urlencode($filename);
                    QRcode::png($a, $filename);
                   // $rep = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/SendMessage?chat_id=" . $chatid . "&text=" .urlencode($a)));
                    $photo1 = curl_file_create($filename, 'image/png');
                    bot('sendphoto', [
                        $text122 = "
    کانفیگ شما: ⬇️ (برای کپی کد لطفاً کد را لمس کنید)

⚙️ `$a`

📅 تاریخ خرید: $now
📆 تاریخ انقضا: $current_jdate
⏳ اگر مایل به تمدید اکانت خود هستید، لطفاً دو روز قبل از اتمام تاریخ انقضا با ادمین در تماس باشید.

🙏 با تشکر، ادمین

",
                        'chat_id' => $chatid,
                        'photo' => $photo1,
                        'caption' => $text122,
                        'reply_markup' => $key1,
                        'parse_mode' => "Markdown",
             //           'reply_to_message_id' => $message_id,
                    ]);
                    unlink("../data/vpn/ex/$random");
                }else{
                    bot('sendmessage',[
                        'chat_id'=> $chatid,
                        'text'=> "👈کانفیگ مد نظر شما موجود نمی باشد ، صبور باشید و به پشتیبان پیام بدهید  ",
                    ]);
                    bot('sendmessage',[
                        'chat_id'=> $dev,
                        'text'=> "کانفیگ تمام کردی   ",
                    ]);
                }

            }else{
                $scan = scandir ("../data/vpn/v2ray");
                $tv2ray = count ($scan) - 2;
                if($tv2ray>0){
                    $random = $scan[rand(2, count($scan) - 1)];
                    $a = file_get_contents ("../data/vpn/v2ray/$random");
                    $filename="../data/user/$chatid/$authority.png";
                    $filename1=urlencode($filename);
                    QRcode::png($a, $filename);
                    // $rep = json_decode(file_get_contents("https://api.telegram.org/bot" . $token . "/SendMessage?chat_id=" . $chatid . "&text=" .urlencode($a)));
                    $photo1 = curl_file_create($filename, 'image/png');
                    bot('sendphoto', [
                        $text122 = "
    کانفیگ شما: ⬇️ (برای کپی کد لطفاً کد را لمس کنید)

⚙️ `$a`

📅 تاریخ خرید: $now
📆 تاریخ انقضا: $current_jdate
⏳ اگر مایل به تمدید اکانت خود هستید، لطفاً دو روز قبل از اتمام تاریخ انقضا با ادمین در تماس باشید.

🙏 با تشکر، ادمین

",
                        'chat_id' => $chatid,
                        'photo' => $photo1,
                        'caption' => $text122,
                        'reply_markup' => $key1,
                        'parse_mode' => "Markdown",
                        //           'reply_to_message_id' => $message_id,
                    ]);
                    unlink("../data/vpn/v2ray/$random");
                }else{

                    bot('sendmessage',[
                        'chat_id'=> $chatid,
                        'text'=> "👈کانفیگ مد نظر شما موجود نمی باشد ، صبور باشید و به پشتیبان پیام بدهید  ",
                    ]);
                    bot('sendmessage',[
                        'chat_id'=> $dev,
                        'text'=> "کانفیگ تمام کردی   ",
                    ]);
                }


            }
            echo '<style>
            @font-face {
            font-family: \'Vazir-Bold\';
            src: url(\'../fonts/Vazir-Bold.ttf\') format(\'truetype\');
}
            </style>';
            echo '<div style="text-align: center; font-family: \'Vazir-Bold\', sans-serif;" dir="rtl">';
            echo "Invoice Successfully Paid | Price: {$result->data->amount} Rial | RefID: {$result->data->ref_id}<br>";
            echo " فاکتور با موفقیت پرداخت شد | قیمت: {$result->data->amount} ریال | کد رهگیری: {$result->data->ref_id}<br>";

            echo '<p><strong><span    <p>در صورت داشتن هر گونه سوال و مشکل با تلگرام ما در ارتباط باشید @abi_asemoni</p>
            <p>❤️❤️به امید دنیای آزاد ❤️❤️</p>
            </div>';;

        } else {
            echo isset($result->status) ? "Error Code: {$result->status} | {$result->message}" : "Error Connecting to novinopay.com";
        }

    } else {
        echo 'Your Payment is failed';
    }
}