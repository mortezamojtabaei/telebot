<?php
include '../Variable.php';
//$token ='6037599729:AAFPxPQe-q7KuQtcI9JCOSC2EEKjSbYme14';
if(isset($_GET['chatid'])){
 $chatid = $_GET['chatid'];
 $amount=$_GET['amount'];
 //$rep=json_decode(file_get_contents("https://api.telegram.org/bot".$token."/SendMessage?chat_id=".$chatid."&text=".urlencode($chatid)));
//database
//data base
//$servername = "localhost";
//$username= "lachlach_morteza";
//$password= "Armin2afm*";
//$dbname= "lachlach_bot";
//$conn= new mysqli($servername, $username, $password, $dbname);
//mysqli_query($conn,'set names "utf8"');
//$amount=intval($amount);
    $data = [
    "merchant_id" => "test",
    "amount" => $amount, //// rial
    "invoice_id" => "PF-123456",
    "description" => "Invoice Description",
    "name" => $chatid,
    "mobile" => "09120001234",
    "email" => "info@example.com",
    "callback_url" => $baseURL."pay/verify.php?chatid=".$chatid
];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://api.novinopay.com/payment/ipg/v2/request");
curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type" => "application/json"]);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
curl_setopt($curl, CURLOPT_TIMEOUT, 50);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_exec = curl_exec($curl);
curl_close($curl);

$result = json_decode($curl_exec);

if (isset($result->status) && $result->status == 100) {
    ///save $result->data->authority in db
    ///save $result->data->trans_id in db
    $authority=$result->data->authority;
    $data2= array(
        'chatid'=>$chatid,
        'amount'=>$amount,
        'authority'=>$authority
    );
    if(!is_dir("../data/user/$chatid")){
        mkdir("../data/user/$chatid");
    }
    $jsonData = json_encode($data2);
    $file = "../data/user/$chatid/data.json";
    file_put_contents($file, $jsonData);
//    $sql="UPDATE shekanbot SET Authority='$authority' where chatid='$chatid'";
//    $sql2="UPDATE shekanbot SET amount='$amount' where chatid='$chatid'";
//    $result12=$conn->query($sql);
//    $result13=$conn->query($sql2);
    header("Location: {$result->data->payment_url}");
} else {
    echo isset($result->status) ? "Error Code: {$result->status} | {$result->message}" : "Error Connecting to novinopay.com";
}
}
?>