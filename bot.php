<?php
/*
@sizdahorgg
*/
#-----------------------------#
date_default_timezone_set('Asia/Tehran');
error_reporting(0);
#-----------------------------#
include ("settings/update.php");
include ("settings/config.php");
include ("jdf.php");
#-----------------------------#
if (!is_dir("data")){
mkdir ("data");
}
if (!is_dir("data/user")){
mkdir ("data/user");
}
if (!is_dir("data/chat")){
mkdir ("data/chat");
}
if (!is_dir("data/user/$from_id")){
mkdir ("data/user/$from_id");
}
if (!is_dir("data/user/$from_id/cp")){
mkdir ("data/user/$from_id/cp");
}
if(!file_exists("data/user/$from_id/coin.txt")){
file_put_contents ("data/user/$from_id/coin.txt","100");
}
if(!file_exists("data/user/$from_id/respans.txt")){
file_put_contents ("data/user/$from_id/respans.txt","0");
}
if(!file_exists("data/sta.txt")){
file_put_contents ("data/sta.txt","off");
}
#-----------------------------#
$dir_path = "data/user";
if (is_dir($dir_path)) {
  $files = glob($dir_path."/*");
  foreach ($files as $file) {
    if (is_file($file)) {
      unlink($file);
    }
  }}
#-----------------------------#
$a1 = "🎮 شروع بازی";
$a2 = "📂 پروفایل شما";
$a3 = "🛍️ افزایش سکه";
$a4 = "📞 ارسال تیکت";
$a5 = "🔎 راهنمای استفاده";
$a6 = "💸 انتقال سکه";
$a7 = "💬 گفتگو آنلاین";
#-----------------------------#
$o  = "بازگشت";
$oo = "برگشت";
$time = date('h:i:s');
$dateh   = jdate('Y/m/d');
$numbers = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
$date = date("y/m/d");
$sta = file_get_contents ("data/sta.txt");
#-----------------------------#
$key1 = json_encode(['keyboard'=>[
[['text'=>"$a1"]],
[['text'=>"$a2"],['text'=>"$a3"]],
[['text'=>"$a4"],['text'=>"$a5"]],
[['text'=>"$a6"],['text'=>"$a7"]],
],'resize_keyboard'=>true]);
$key2 = json_encode(['keyboard'=>[
[['text'=>"دارت 🎯"],['text'=>"تاس 🎲"]],
[['text'=>"فوتبال ⚽"],['text'=>"بسکتبال 🏀"]],
[['text'=>"$o"]],
],'resize_keyboard'=>true]);
$back = json_encode(['keyboard'=>[
[['text'=>"$o"]],
],'resize_keyboard'=>true]);    
$bk = json_encode(['keyboard'=>[
[['text'=>"$oo"]],
],'resize_keyboard'=>true]);    
#-----------------------------#
$channel1 = file_get_contents ("data/channel1.txt");
$channel2 = file_get_contents ("data/channel2.txt");
$truechannel = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel1&user_id=".$from_id));
$tch = $truechannel->result->status;
$truechannel1 = json_decode(file_get_contents("https://api.telegram.org/bot$token/getChatMember?chat_id=@$channel2&user_id=".$from_id));
$tch1 = $truechannel1->result->status;
$urlm = "https://api.telegram.org/bot$token/getMe";
$api_response = file_get_contents($urlm);
$response = json_decode($api_response, true);
$idbot = $response["result"]["username"];

if ($sta == "on"){
if($tch != 'member' && $tch != 'creator' && $tch != 'administrator' && $from_id != $admin && $tch1 != 'member' && $tch1 != 'creator' && $tch1 != 'administrator' && $from_id != $admin ){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"✅ کانال اطلاع رسانی",'url'=>"https://t.me/$channel1"]],
[['text'=>"🔥 کانال انجام بازی ها",'url'=>"https://t.me/$channel2"]],
[['text'=>"☝️ من عضو هر دو کانال شدم",'url'=>"https://t.me/$idbot?start"]],
]]);
bot('sendmessage', [
'chat_id' => $chat_id,
'text' => "
🔥🔑 جهت استفاده از این ربات شما باید داخل کانال اطلاع رسانی و کانال ثبت بازی های ما عضو باشید لطفا ابتدا از طریق دکمه های موجود عضو شوید سپس روی دکمه من عضو شدم کلیک کنید !
",
'parse_mode' => "markdown",
'reply_markup' => $oks,
]);
exit();
}
}
#-----------------------------#
if($text == "/start" || $text == $o){
sendmessage ($chat_id , "
✅ سلام به ربات ما خوش آمدی :
" , $key1);
file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "$a1"){
sendmessage ($chat_id , "
😘 یکی از بازی های موجود را انتخاب کنید :
" , $key2);
file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "بسکتبال 🏀"){
$respans = file_get_contents ("data/user/$from_id/respans.txt");
if ($respans > 5){
sendmessage ($chat_id , "
شما فقط میتوانید روزی 5 بار شرطبندی انجام دهید
" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
sendmessage ($chat_id , "
لطفا تعداد سکه ای که میخواهید شرط ببندید وارد کنید :
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setbas");
}
}
if($step == "setbas" and $text!=$o and $text != "/start"){
if($text > $coin){
sendmessage ($chat_id , "
موجودی کافی نیست .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setbas");
exit();
}
if($text < 100){
sendmessage ($chat_id , "
تعداد سکه انتخابی باید بیش از ۱۰۰ تا باشد .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setbas");
exit();
}else{
file_put_contents ("data/user/$from_id/tmsizdah.txt",$text);
$keylp = json_encode(['keyboard'=>[
[['text'=>"وارد حلقه میشود"]],
[['text'=>"وارد حلقه نمیشود"]],
[['text'=>"$o"]],
],'resize_keyboard'=>true]);
sendmessage ($chat_id , "
روی کدام مورد شرط میبندی ؟
" , $keylp);
file_put_contents ("data/user/$from_id/step.txt","setbas1");
}
}
if($step == "setbas1" and $text!=$o and $text != "/start"){
if ($text == "وارد حلقه میشود"){
file_put_contents ("data/user/$from_id/tmsizdah.txt",$text);
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🏀',
'parse_mode' => "html"
 ]);
$ok   = $sizdahorgg->result->dice->value;
if ($ok != 4 && $ok != 5 && $ok != 6){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی وارد حلقه میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "❌ شما بازنده شدید !

🦦 $chanmm" , $back);
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zb;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی وارد حلقه میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "وارد حلقه نمیشود"){
file_put_contents ("data/user/$from_id/tmsizdah.txt",$text);
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🏀',
'parse_mode' => "html"
 ]);
$sizdahorgg1 = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🏀',
'parse_mode' => "html"
 ]);
$ok  = $sizdahorgg->result->dice->value;
$ok1 = $sizdahorgg1->result->dice->value;
if ($ok == 4 || $ok1 == 4 || $ok == 5 || $ok1 == 5){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی وارد حلقه نمیشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "❌ شما بازنده شدید !

🦦 $chanmm" , $back);
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zb;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی وارد حلقه نمیشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
}
#-----------------------------#
if($text == "دارت 🎯"){
$respans = file_get_contents ("data/user/$from_id/respans.txt");
if ($respans > 5){
sendmessage ($chat_id , "
شما فقط میتوانید روزی 5 بار شرطبندی انجام دهید
" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
sendmessage ($chat_id , "
لطفا تعداد سکه ای که میخواهید شرط ببندید وارد کنید :
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setdart");
}
}
if($step == "setdart" and $text!=$o and $text != "/start"){
if($text > $coin){
sendmessage ($chat_id , "
موجودی کافی نیست .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setdart");
exit();
}
if($text < 100){
sendmessage ($chat_id , "
تعداد سکه انتخابی باید بیش از ۱۰۰ تا باشد .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setdart");
exit();
}else{
file_put_contents ("data/user/$from_id/tmsizdah.txt",$text);
$keylp = json_encode(['keyboard'=>[
[['text'=>"به هدف اصابت نمیکند"]],
[['text'=>"خانه قرمز"],['text'=>"خانه سفید"]],
[['text'=>"$o"]],
],'resize_keyboard'=>true]);
sendmessage ($chat_id , "
روی کدام مورد شرط میبندی ؟
" , $keylp);
file_put_contents ("data/user/$from_id/step.txt","setdarte");
}
}
if($step == "setdarte" and $text!=$o and $text != "/start"){
if ($text == "خانه قرمز"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎯',
'parse_mode' => "html"
 ]);
$ok   = $sizdahorgg->result->dice->value;
if ($ok != 2 && $ok != 4 && $ok != 6) {
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی خانه قرمز
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "❌ شما بازنده شدید !

🦦 $chanmm" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zd;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی خانه قرمز
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "خانه سفید"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎯',
'parse_mode' => "html"
 ]);
$ok   = $sizdahorgg->result->dice->value;
if ($ok != 3 && $ok != 5 && $ok == 1) {
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی خانه سفید
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "❌ شما بازنده شدید !

🦦 $chanmm" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zd;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی خانه سفید
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "به هدف اصابت نمیکند"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎯',
'parse_mode' => "html"
 ]);
$ok   = $sizdahorgg->result->dice->value;
if ($ok != 1) {
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی به هدف اصابت نمیکند
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "❌ شما بازنده شدید !

🦦 $chanmm" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zd1;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی به هدف اصابت نمیکند
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
" , $back);
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
}
#-----------------------------#
if($text == "فوتبال ⚽"){
$respans = file_get_contents ("data/user/$from_id/respans.txt");
if ($respans > 5){
sendmessage ($chat_id , "
شما فقط میتوانید روزی 5 بار شرطبندی انجام دهید
" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
sendmessage ($chat_id , "
لطفا تعداد سکه ای که میخواهید شرط ببندید وارد کنید :
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setboling");
}
}
if($step == "setboling" and $text!=$o and $text != "/start"){
if($text > $coin){
sendmessage ($chat_id , "
موجودی کافی نیست .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setboling");
exit();
}
if($text < 100){
sendmessage ($chat_id , "
تعداد سکه انتخابی باید بیش از ۱۰۰ تا باشد .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","setboling");
exit();
}else{
file_put_contents ("data/user/$from_id/tmsizdah.txt",$text);
$keylp = json_encode(['keyboard'=>[
[['text'=>"گل نمیشود"],['text'=>"گل میشود"]],
[['text'=>"$o"]],
],'resize_keyboard'=>true]);
sendmessage ($chat_id , "
روی کدام مورد شرط میبندی ؟
" , $keylp);
file_put_contents ("data/user/$from_id/step.txt","setboling1");
}
}
if($step == "setboling1" && $text!=$o && $text != "/start"){
if($text == "گل میشود"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'⚽',
'parse_mode' => "html"
 ]);
 $sizdahorgg1 = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'⚽',
'parse_mode' => "html"
 ]);
$ok  = $sizdahorgg->result->dice->value;
$ok1 = $sizdahorgg1->result->dice->value;
if ($ok == 1 || $ok1 == 1 || $ok == 2 || $ok1 == 2){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت توپ گل میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zf;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت توپ گل میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if($text == "گل نمیشود"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'⚽',
'parse_mode' => "html"
 ]);
 $sizdahorgg1 = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'⚽',
'parse_mode' => "html"
 ]);
$ok  = $sizdahorgg->result->dice->value;
$ok1 = $sizdahorgg1->result->dice->value;
if ($ok == 3 || $ok1 == 3 || $ok == 4 || $ok1 == 4 || $ok == 5 || $ok1 == 5){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت توپ گل نمیشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zf;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت توپ گل نمیشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
}
#-----------------------------#
if($text == "تاس 🎲"){
$respans = file_get_contents ("data/user/$from_id/respans.txt");
if ($respans > 5){
sendmessage ($chat_id , "
شما فقط میتوانید روزی 5 بار شرطبندی انجام دهید
" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
sendmessage ($chat_id , "
لطفا تعداد سکه ای که میخواهید شرط ببندید وارد کنید :
" , $back);
file_put_contents ("data/user/$from_id/step.txt","settas");
}
}
if($step == "settas" and $text!=$o and $text != "/start"){
if($text > $coin){
sendmessage ($chat_id , "
موجودی کافی نیست .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","settas");
exit();
}
if($text < 100){
sendmessage ($chat_id , "
تعداد سکه انتخابی باید بیش از ۱۰۰ تا باشد .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","settas");
exit();
}else{
file_put_contents ("data/user/$from_id/tmsizdah.txt",$text);
$keylp = json_encode(['keyboard'=>[
[['text'=>"جفت زوج"],['text'=>"جفت فرد"]],
[['text'=>"1"],['text'=>"2"],['text'=>"3"],['text'=>"4"],['text'=>"5"],['text'=>"6"]],
[['text'=>"$o"]],
],'resize_keyboard'=>true]);
sendmessage ($chat_id , "
روی کدام مورد شرط میبندی ؟
" , $keylp);
file_put_contents ("data/user/$from_id/step.txt","settasy");
}
}
if($step == "settasy" and $text!=$o and $text != "/start"){
$value = $update->message->dice->value;
$tmsizdah = file_get_contents ("data/user/$from_id/tmsizdah.txt");
if($text == "جفت زوج"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $sizdahorgg1 = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
$ok   = $sizdahorgg->result->dice->value;
$ok1  = $sizdahorgg1->result->dice->value;
if($ok % 2 != 0 || $ok1 % 2 != 0){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت تاس زوج
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت تاس زوج
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}

if($text == "جفت فرد"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $sizdahorgg1 = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
$ok   = $sizdahorgg->result->dice->value;
$ok1  = $sizdahorgg1->result->dice->value;
if($ok % 2 == 0 || $ok1 % 2 == 0){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت تاس فرد
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی جفت تاس فرد
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "1"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $ok   = $sizdahorgg->result->dice->value;
if ($ok != 1){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۱ میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt1;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۱ میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "2"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $ok   = $sizdahorgg->result->dice->value;
if ($ok != 2){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۲ میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt2;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۲ میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "3"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $ok   = $sizdahorgg->result->dice->value;
if ($ok != 3){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۳ میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt3;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۳ میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "4"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $ok   = $sizdahorgg->result->dice->value;
if ($ok != 4){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۴ میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt4;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۱ میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "5"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $ok   = $sizdahorgg->result->dice->value;
if ($ok != 5){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۵ میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt5;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۵ میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
if ($text == "6"){
$sizdahorgg = bot ('SendDice', [
'chat_id' => $chanmm,
'emoji'=>'🎲',
'parse_mode' => "html"
 ]);
 $ok   = $sizdahorgg->result->dice->value;
if ($ok != 6){
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۶ میشود
❌ شرطبندی شما شکست خورد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : 0 سکه
");
sendmessage ($chat_id , "
❌ شما بازنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$a = $coin - $tmsizdah;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$c = $tmsizdah * $zt6;
$b = $coin + $c;
file_put_contents ("data/user/$from_id/coin.txt",$b);
sendmessage ($chanmm , "
👤 کاربر : $first_name - $chat_id

💵 شرط : بسته شده روی عدد تاس ۶ میشود
✅ شرطبندی با موفقیت درست انجام شد .
💰 سکه شرطبندی شده : $tmsizdah سکه
🎁 سکه برنده شده : $c سکه
");
sendmessage ($chat_id , "
✅ شما برنده شدید !

🦦 $chanmm
");
$respans = file_get_contents ("data/user/$from_id/respans.txt");
$resi = $respans + 1;
file_put_contents ("data/user/$from_id/respans.txt",$resi);
file_put_contents ("data/user/$from_id/step.txt","none");
}
}
}
#-----------------------------#
$upkey = json_encode(['inline_keyboard' => [
[['text'=>"آپدیت اطلاعات",'callback_data'=>"up"]],
]]);
if($text == "$a2"){
$respanss = $respans - 1;
sendmessage ($chat_id , "
اطلاعات کاربری شما :

 @sizdahorgg
نام شما : $first_name
شماره کاربری : $chat_id
تعداد سکه شما : $coin سکه
تاریخ عضویت : $dateozv نامعلوم
تعداد درخواست : $respanss از ۵
ساعت : $time
تاریخ : $date
" , $upkey);
file_put_contents ("data/user/$from_id/step.txt","none");
}
if($data == "up"){
bot ('editmessagetext',[
'chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"
اطلاعات کاربری شما :

 @sizdahorgg
نام شما : $first_name 
شماره کاربری : $chat_id
تعداد سکه شما : $coin سکه
تاریخ عضویت : $dateozv نامعلوم
ساعت : $time
تاریخ : $date
",
'reply_markup'=>$upkey,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "$a3"){
bot ('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"
✅ لطفا مبلغ مورد نظر خود را به ایدی کاربری :

`$admin`

واریز کنید سپس رسید دریافتی را برای من فوروارد کنید .

ایدی ربات برای انتقال سکه : @NitroFaBot
",
'reply_markup'=>$back,
'parse_mode'=>"Markdown",
]);
file_put_contents ("data/user/$from_id/step.txt","oksizdahorgg");
}
if($step == "oksizdahorgg" and $text != $o){
$forwarded_from= $update->message->forward_from->username;
if($forwarded_from != "NitroFaBot"){
sendmessage ($chat_id , "❌ این رسید از جانب ربات @NitroFaBot فوروارد نشده است !" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
//////////////////////////////////////////////////////////////////
preg_match("/تعداد\s+(\d+)\s+سکه/", $text, $matches1);
$pattern = "/(?<=تاریخ\s)(.*?)(?=\sساعت)/";
preg_match($pattern, $text, $matches);
$a11  = explode("ساعت", $text);
$a22  = explode("با", $a11[1]);
$start = strpos($text, "کاربر") + 6;
$end  = strpos($text, "انتقال") - $start - 1;
$a44 = substr($text, $start, $end);
//////////////////////////////////////////////////////////////////
$a1 = $matches1[1];
$a2 = $matches[0];
$a3 = trim($a22[0]);
$a4 = str_replace('بر', '', $a44);
//////////////////////////////////////////////////////////////////
if($a4 != $adminid){
sendmessage ($chat_id , "شما برای اکانت ما نیتروسین واریز نکردید !" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if (file_exists("data/user/$from_id/cp/c$a3")){
sendmessage ($chat_id , "🍌 بیا ! شما قبلا این رسید رو فرستادین " , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
//////////////////////////////////////////////////////////////////
$c = (string) $a2 . $a3;
$a = $coin + $a1 ;
file_put_contents ("data/user/$from_id/coin.txt",$a);
file_put_contents ("data/user/$from_id/cp/c$a3","$a2");
//////////////////////////////////////////////////////////////////
sendmessage ($chat_id , "
✅ رسید شما با موفقیت تایید شد .
💰 تعداد $a1 سکه برای شما واریز شد .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
}
#-----------------------------#
if($text == "$a6"){
sendmessage ($chat_id , "✅ لطفا ایدی عددی کاربر مورد نظر خود را وارد کنید :" , $back);
file_put_contents ("data/user/$from_id/step.txt","step1");
exit();
}
if($step == "step1" and $text != $o){
if (!is_dir("data/user/$text")){
sendmessage ($chat_id , "❌ این کاربر عضو ربات نمی باشد !" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if ($text == $from_id){
sendmessage ($chat_id , "😑 برای خودت نمیتونی سکه انتقال بدی مرتیکه میخاری ؟" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
sendmessage ($chat_id , "🖥️ لطفا تعداد سکه ای که قصد دارید انتقال دهید را با اعداد انگلیسی وارد کنید :" , $back);
file_put_contents ("data/user/$from_id/step2.txt",$text);
file_put_contents ("data/user/$from_id/step.txt","step2");
exit();
}
}
if($step == "step2" and $text != $o){
if ($coin < $text){
sendmessage ($chat_id , "🍌 تعداد سکه شما برای این انتقال کافی نیست ! موز بخور" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}else{
$moz = file_get_contents ("data/user/$from_id/step2.txt");
$a = $coin - $text ;
file_put_contents ("data/user/$from_id/coin.txt",$a);
$coink = file_get_contents ("data/user/$moz/coin.txt");
$b = $coink + $text ;
file_put_contents ("data/user/$moz/coin.txt",$b);
sendmessage ($moz , "
✅ در ساعت $time و در تاریخ $date مقدار $text سکه از کاربر با شناسه $from_id برای ما ارسال شد .
");
sendmessage ($chat_id , "
✅ در ساعت $time و در تاریخ $date مقدار $text سکه برای کاربر با شناسه $moz ارسال شد .
" , $back);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
}
#-----------------------------#
if($text == "📞 ارسال تیکت"){
sendmessage ($chat_id , "
📞 ایدی ادمین جهت دریافت پشتیبانی :
$useradmin
");
file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "🔎 راهنمای استفاده"){
sendmessage ($chat_id , "
$helptxt
");
file_put_contents ("data/user/$from_id/step.txt","none");
}
#-----------------------------#
if($text == "$a7"){
mkdir ("data/chat/$from_id");
$scan = scandir ("data/chat");
$online = count ($scan) - 2;
$oks = json_encode(['keyboard'=>[
[['text'=>"❌ خروج از چت"]],
],'resize_keyboard'=>true]);
sendmessage ($chat_id , "
😀 شما وارد بخش گفتگو انلاین شدید .
🔥 اکنون هر پیامی ارسال کنید تمام افراد انلاین در این قسمت پیام شما را مشاهده میکنند .
🏅 افراد انلاین : $online نفر
" , $oks);
file_put_contents ("data/user/$from_id/step.txt","send");
exit();
}
if($step == "send" and $text != "❌ خروج از چت"){
$oks = json_encode(['keyboard'=>[
[['text'=>"❌ خروج از چت"]],
],'resize_keyboard'=>true]);
$scan = scandir ("data/chat");
$online = count ($scan) - 2;
if ($online == 1){
bot ('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "
❌ متأسفانه فقط شما انلاین هستید .
",
'reply_markup'=> $oks,
'parse_mode'=> "Markdown",
]);
exit();
}else{
foreach ($scan as $allchat){
sendmessage ($allchat , "
$first_name : $text 
🗣️ : $online نفر
" , $oks);
}
file_put_contents ("data/user/$from_id/step.txt","send");
exit();
}
}
#-----------------------------#
if($text == "❌ خروج از چت"){
DeleteDirectory ("data/chat/$from_id");
sendmessage ($chat_id , "✅ با موفقیت از صفحه چت خارج شدیم ." , $key1);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
#-----------------------------#
if ($from_id == $admin){
$ky1 = json_encode(['keyboard'=>[
[['text'=>"📂 آمار ربات"]],
[['text'=>"💰 کاهش سکه"],['text'=>"💰 افزایش سکه"]],
[['text'=>"🔐 تنظیمات کانال"],['text'=>"🧨 تنظیم ضریب"]],
],'resize_keyboard'=>true]);
if($text == "/sizdahorgg" || $text == $oo){
sendmessage ($chat_id , "سلام ادمین عزیز خیلی خوش آمدی ✅" , $ky1);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($text == "📂 آمار ربات"){
$scan = scandir ("data/user");
$users = count ($scan) - 2;
$ok = json_encode(['inline_keyboard' => [
[['text'=>"$users کاربر",'callback_data'=>"A"],['text'=>"👥 تعداد کاربران :",'callback_data'=>"A"]],
[['text'=>"@sizdahorgg",'callback_data'=>"A"],['text'=>"🖥️ @sizdahorgg :",'callback_data'=>"A"]],
]]);
sendmessage ($chat_id , "
✅🔎 مشخصات ربات شما در یک نگاه کلی :
" , $ok);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($text == "💰 افزایش سکه"){
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "💳 لطفا تعداد مورد نظرتون رو با اعداد انگلیسی وارد کنید :",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",

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
💳 از طرف مدیریت تعداد $a سکه برای ما فرستاده شد .
");
file_put_contents ("data/user/$from_id/step.txt","none"); 
}
if($text == "💰 کاهش سکه"){
bot('sendmessage',[
'chat_id'=> $chat_id,
'text'=> "💳 لطفا تعداد سکه مورد نظرتون رو با اعداد انگلیسی وارد کنید :",
'reply_markup'=>$bk,
'parse_mode'=>"Markdown",

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
💳 از طرف مدیریت تعداد $a سکه از ما کم شد .
");
file_put_contents ("data/user/$from_id/step.txt","none"); 
}
if($text == "🧨 تنظیم ضریب"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"فوتبال",'callback_data'=>"fot"],['text'=>"بسکتبال",'callback_data'=>"bas"]],
[['text'=>"دارت",'callback_data'=>"dar"],['text'=>"تاس",'callback_data'=>"tas"]],
]]);
sendmessage ($chat_id , "💲 لطفا تنظیمات ضریب یکی از بازی های زیر را انتخاب کنید :" , $oks);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "tas"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"ضریب :",'callback_data'=>"A"],['text'=>"نوع :",'callback_data'=>"A"]],
[['text'=>"$zt1",'callback_data'=>"zt1"],['text'=>"حدس درست عدد",'callback_data'=>"A"]],
[['text'=>"$zt",'callback_data'=>"zt1"],['text'=>"حدس زوج یا فرد",'callback_data'=>"A"]],
[['text'=>"بازگشت",'callback_data'=>"bk"]],
]]);
bot ('editmessagetext',[
'message_id'=>$message_id,
'chat_id'=>$chat_id,
'text'=>"🔥😀 ضریب زیر مجموعه بازی انتخابی شما به شکل زیر است . جهت تغییر ضریب ها به فایل config.php مراجعه کنید .",
'reply_markup'=>$oks,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "dar"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"ضریب :",'callback_data'=>"A"],['text'=>"نوع :",'callback_data'=>"A"]],
[['text'=>"$zd",'callback_data'=>"zd"],['text'=>"حدس درست رنگ",'callback_data'=>"A"]],
[['text'=>"$zd1",'callback_data'=>"zd1"],['text'=>"حدس اصابت نکردن",'callback_data'=>"A"]],
[['text'=>"بازگشت",'callback_data'=>"bk"]],
]]);
bot ('editmessagetext',[
'message_id'=>$message_id,
'chat_id'=>$chat_id,
'text'=>"🔥😀 ضریب زیر مجموعه بازی انتخابی شما به شکل زیر است . جهت تغییر ضریب ها به فایل config.php مراجعه کنید .",
'reply_markup'=>$oks,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "fot"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"ضریب :",'callback_data'=>"A"],['text'=>"نوع :",'callback_data'=>"A"]],
[['text'=>"$zf",'callback_data'=>"zf"],['text'=>"حدس گل شدن یا نشدن",'callback_data'=>"A"]],
[['text'=>"بازگشت",'callback_data'=>"bk"]],
]]);
bot ('editmessagetext',[
'message_id'=>$message_id,
'chat_id'=>$chat_id,
'text'=>"🔥😀 ضریب زیر مجموعه بازی انتخابی شما به شکل زیر است . جهت تغییر ضریب ها به فایل config.php مراجعه کنید .",
'reply_markup'=>$oks,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "bas"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"ضریب :",'callback_data'=>"A"],['text'=>"نوع :",'callback_data'=>"A"]],
[['text'=>"$zb",'callback_data'=>"zb"],['text'=>"حدس وارد سبد شدن یا نشدن",'callback_data'=>"A"]],
[['text'=>"بازگشت",'callback_data'=>"bk"]],
]]);
bot ('editmessagetext',[
'message_id'=>$message_id,
'chat_id'=>$chat_id,
'text'=>"🔥😀 ضریب زیر مجموعه بازی انتخابی شما به شکل زیر است . جهت تغییر ضریب ها به فایل config.php مراجعه کنید .",
'reply_markup'=>$oks,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "bk"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"فوتبال",'callback_data'=>"fot"],['text'=>"بسکتبال",'callback_data'=>"bas"]],
[['text'=>"دارت",'callback_data'=>"dar"],['text'=>"تاس",'callback_data'=>"tas"]],
]]);
bot ('editmessagetext',[
'message_id'=>$message_id,
'chat_id'=>$chat_id,
'text'=>"💲 لطفا تنظیمات ضریب یکی از بازی های زیر را انتخاب کنید :",
'reply_markup'=>$oks,
]);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($text == "🔐 تنظیمات کانال"){
$oks = json_encode(['inline_keyboard' => [
[['text'=>"آیدی تنظیم شده :",'callback_data'=>"fot"],['text'=>"ردیف کانال :",'callback_data'=>"bas"]],
[['text'=>"@$channel1",'callback_data'=>"dar"],['text'=>"1",'callback_data'=>"r1"]],
[['text'=>"@$channel2",'callback_data'=>"dar"],['text'=>"2",'callback_data'=>"r2"]],
[['text'=>"🔑 خاموش | روشن کردن قفل کانال",'callback_data'=>"r3"]],
]]);
sendmessage ($chat_id , "
🔥 تنظیمات کلی کانال شما به شکل زیر است : 
جهت تعیین کردن ایدی کانال روی شماره ردیف کلیک کنید .
" , $oks);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "r1"){
sendmessage ($chat_id , "🔥 لطفا ایدی کانال خود را بدون @ ارسال کنید . \n مثال : tmsizdah" , $bk);
file_put_contents ("data/user/$from_id/step.txt","set1");
exit();
}
if($step == "set1" and $text != $oo){
file_put_contents ("data/channel1.txt",$text);
sendmessage ($chat_id , "ایدی کانال @$text ذخیره شد ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "r2"){
sendmessage ($chat_id , "🔥 لطفا ایدی کانال خود را بدون @ ارسال کنید . \n مثال : tmsizdah" , $bk);
file_put_contents ("data/user/$from_id/step.txt","set2");
exit();
}
if($step == "set2" and $text != $oo){
file_put_contents ("data/channel2.txt",$text);
sendmessage ($chat_id , "ایدی کانال @$text ذخیره شد ." , $bk);
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
if($data == "r3"){
if ($sta == "on"){
file_put_contents ("data/sta.txt","off");
bot('answerCallbackQuery',[
'callback_query_id' => $query_id,
'text' => "❌ قفل جوین اجباری غیر فعال شد .",
'show_alert' => true,
]);
}else{
file_put_contents ("data/sta.txt","on");
bot('answerCallbackQuery',[
'callback_query_id' => $query_id,
'text' => "✅ قفل جوین اجباری فعال شد",
'show_alert' => true,
]);
}
file_put_contents ("data/user/$from_id/step.txt","none");
exit();
}
}//
#-----------------------------#
?>