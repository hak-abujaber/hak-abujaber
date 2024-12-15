<?php
$API_KEY = "6307477846:AAFrvUgN03A6wWJxDA4JKRecWc3QRy6dYLU";
define('API_KEY', $API_KEY);
$admin = 5413882281; // ايديك
define("IDBot", explode(":", $API_KEY)[0]);

function bot($method, $datas = []) {
$url = "https://api.telegram.org/bot" . API_KEY . "/" . $method;
$options = [
'http' => [
 'method'=> 'POST',
 'content' => http_build_query($datas),
 'header'=> 'Content-Type: application/x-www-form-urlencoded\r\n',
],
];
$context= stream_context_create($options);
$res = file_get_contents($url, false, $context);

if ($res === FALSE) {
return json_encode(['error' => 'Request failed']);
} else {
return json_decode($res);
}
}

$update = json_decode(file_get_contents('php://input'));

if ($update->message) {
$message = $update->message;
$message_id = $update->message->message_id;
$username = $message->from->username;
$chat_id = $message->chat->id;
$title = $message->chat->title;
$text = $message->text;
$user = $message->from->username;
$name = $message->from->first_name;
$from_id = $message->from->id;
}

if ($update->callback_query) {
$data = $update->callback_query->data;
$chat_id = $update->callback_query->message->chat->id;
$title = $update->callback_query->message->chat->title;
$message_id = $update->callback_query->message->message_id;
$name = $update->callback_query->message->chat->first_name;
$user = $update->callback_query->message->chat->username;
$from_id = $update->callback_query->from->id;
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
if (!file_exists("status")) {
mkdir("status", 0777, true);
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
//دخول الاعضاء//
$mem = explode("\n",file_get_contents("mem.txt"));
$je = file_get_contents("mem.txt");
$count = explode("\n",$je);
$SAl = count($count) -1;
if($username != null){
$sf = "@$username";
}else
if($username == null){
$sf = "لا يوجد معرف";
}
if($message and !in_array($from_id,$mem)){
file_put_contents("mem.txt",$from_id . "\n" ,FILE_APPEND);
$SAl = $SAl + 1;
bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"
*٭ تم دخول شخص جديد الى البوت 👤*
 -----------------------
_• معلومات العضو الجديد 🆕_

• الاسم : [$name](tg://user?id=$from_id)
• المعرف : $sf
• الايدي : [$from_id](tg://user?id=$from_id)
 -----------------------
• عدد الاعضاء الكلي :* $SAl 📊*
",
'parse_mode'=>"Markdown",
]);
}

/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
$hhmidos_name = "hhmido.json";
if (!file_exists($hhmidos_name)) {
$hhmidos_sock = [
'a' => "❌"
];
file_put_contents($hhmidos_name, json_encode($hhmidos_sock));
} else {
$hhmidos_sock = json_decode(file_get_contents($hhmidos_name), true);
}

if ($text == "/start" && $chat_id == $admin) {
bot("sendMessage", [
'chat_id' => $admin,
'text' => "*اهلا بك في لوحه التواصل*",
"disable_web_page_preview" => true, 
'parse_mode' => "markdown",
'reply_markup' => json_encode([ 
 'inline_keyboard' => [
[['text' => "التواصل : " . $hhmidos_sock['a'], 'callback_data' => "ss_a"]],
 ]
])
]);
}

if ($data == "Home") {
bot("EditMessageText", [
'chat_id' => $chat_id,
'message_id' => $message_id,
'text' => "*اهلا بك في لوحه التواصل*",
"disable_web_page_preview" => true, 
'parse_mode' => "markdown",
'reply_markup' => json_encode([ 
 'inline_keyboard' => [
[['text' => "التواصل : " . $hhmidos_sock['a'], 'callback_data' => "ss_a"]],
 ]
])
]);
}

if ($update->callback_query) {
$data = $update->callback_query->data;

if ($data == "ss_a") {
$Y = $hhmidos_sock['a'];
$t = ($Y == "✅") ? "❌" : "✅";
$hhmidos_sock['a'] = $t;
file_put_contents($hhmidos_name, json_encode($hhmidos_sock));

if ($t == "❌") {
 bot("editMessageText", [
'chat_id' => $update->callback_query->message->chat->id,
'message_id' => $update->callback_query->message->message_id,
'text' => "* اهلا بك في لوحه التواصل *",
"disable_web_page_preview" => true, 
'parse_mode' => "markdown",
'reply_markup' => json_encode([ 
 'inline_keyboard' => [
 [['text' => "التواصل : " . $hhmidos_sock['a'], 'callback_data' => "ss_a"]],
 ]
])
 ]);
}

bot("editMessageText", [
 'chat_id' => $update->callback_query->message->chat->id,
 'message_id' => $update->callback_query->message->message_id,
 'text' => "* اهلا بك في لوحه التواصل *",
 "disable_web_page_preview" => true, 
 'parse_mode' => "markdown",
 'reply_markup' => json_encode([ 
'inline_keyboard' => [
 [['text' => "التواصل : " . $hhmidos_sock['a'], 'callback_data' => "ss_a"]],
]
 ])
]);
}
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
if ($text == "/start") {
bot("sendMessage", [
'chat_id' => $chat_id,
'text' => "*⌔︙ هلا بيك حبيبي* [$name](tg://user?id=$from_id)
*يمكنك من خلال هذا البوت أرسال رسالتك
بشكل مجهول أو الإفصاح عن هويتك ولا
يُمكن لمالك البوت بأي طريقة معرفة الشخص المجهول*",
'parse_mode' => "Markdown",
'disable_web_page_preview' => true,
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "مجهول : 🥸", 'callback_data' => "s1"], ['text' => "الإفصاح عن هويتي : 💨", 'callback_data' => "s2"]],
[['text' => "انا ولد : 👦", 'callback_data' => "s3"], ['text' => "انا بنت : 👩‍🦰", 'callback_data' => "s4"]],
[['text' => "احصائيات عامة : 📊", 'callback_data' => "stats"]],
[['text' => "المبرمج", 'url' => "https://t.me/W_S_S_E"]],
]
])
]);
}

if ($data == "back_to_main") {
bot("editMessageText", [
'chat_id' => $chat_id,
'message_id' => $update->callback_query->message->message_id,
'text' => "*⌔︙ هلا بيك حبيبي* [$name](tg://user?id=$from_id)
*يمكنك من خلال هذا البوت أرسال رسالتك
بشكل مجهول أو الإفصاح عن هويتك ولا
يُمكن لمالك البوت بأي طريقة معرفة الشخص المجهول*",
'parse_mode' => "Markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "مجهول : 🥸", 'callback_data' => "s1"], ['text' => "الإفصاح عن هويتي : 💨", 'callback_data' => "s2"]],
[['text' => "انا ولد : 👦", 'callback_data' => "s3"], ['text' => "انا بنت : 👩‍🦰", 'callback_data' => "s4"]],
[['text' => "احصائيات عامة : 📊", 'callback_data' => "stats"]],
[['text' => "المبرمج", 'url' => "https://t.me/W_S_S_E"]],
]
])
]);
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
if ($data == "stats") {
$global_stats_file = "status/global_stats.json";

if (!file_exists($global_stats_file)) {
file_put_contents($global_stats_file, json_encode(["total_messages" => 0]));
}

$global_stats = json_decode(file_get_contents($global_stats_file), true);
$total_messages = $global_stats["total_messages"];

bot("editMessageText", [
'chat_id' => $chat_id,
'message_id' => $update->callback_query->message->message_id,
'text' => " 
*⌔︙الإحصائيات العامة :*

- ✉️ *إجمالي الرسائل المرسلة :* $total_messages",
'parse_mode' => "Markdown",
'reply_markup' => json_encode([
'inline_keyboard' => [
[['text' => "رجوع", 'callback_data' => "back_to_main"]],
]
])
]);
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
if ($data == "s1") {
$settings = ["anonymous" => true];
file_put_contents("status/$from_id.json", json_encode($settings));
bot("answerCallbackQuery", [
'callback_query_id' => $update->callback_query->id,
'text' => "تم تعيين إعداداتك إلى مجهول ✅",
'show_alert' => true
]);
}
if ($data == "s2") {
$settings = ["anonymous" => false];
file_put_contents("status/$from_id.json", json_encode($settings));
bot("answerCallbackQuery", [
'callback_query_id' => $update->callback_query->id,
'text' => "تم تعيين إعداداتك إلى مكشوف ✅",
'show_alert' => true
]);
}

if ($data == "s3") {
$settings_file = "status/$from_id.json";
$settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : [];
$settings["gender"] = "male";
file_put_contents($settings_file, json_encode($settings));
bot("answerCallbackQuery", [
'callback_query_id' => $update->callback_query->id,
'text' => "تم تحديد صيغة ولد ✅",
'show_alert' => true
]);
}
if ($data == "s4") {
$settings_file = "status/$from_id.json";
$settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : [];
$settings["gender"] = "female";
file_put_contents($settings_file, json_encode($settings));
bot("answerCallbackQuery", [
'callback_query_id' => $update->callback_query->id,
'text' => "تم تحديد صيغة بنت ✅",
'show_alert' => true
]);
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
if ($text && $text != "/start") {
if ($hhmidos_sock['a'] == "❌") {
bot("sendMessage", [
'chat_id' => $chat_id,
'text' => "*⌔︙ البوت تحت الصيانة *",
'parse_mode' => "Markdown"
]);
return;
}

$status_file = "status/$from_id.json";
$global_stats_file = "status/global_stats.json";

if (!file_exists($global_stats_file)) {
file_put_contents($global_stats_file, json_encode(["total_messages" => 0]));
}

$global_stats = json_decode(file_get_contents($global_stats_file), true);
$global_stats["total_messages"]++;
file_put_contents($global_stats_file, json_encode($global_stats));

$anonymous = file_exists($status_file) ? json_decode(file_get_contents($status_file), true)["anonymous"] : false;
$gender = file_exists($status_file) ? json_decode(file_get_contents($status_file), true)["gender"] : "male";

$greeting = ($gender == "male") ? "حبيبي" : "حبيبتي";
$message_text = ($gender == "male") 
? "*⌔︙♥🧸 تم إرسال رسالتك مع الكشف عن هويتك $greeting*" 
: "*⌔︙♥🧸 تم إرسال رسالتج مع الكشف عن هويتج $greeting*";

if ($anonymous) {
$sender = ($gender == "male") ? "من ولد" : "من بنت";
bot("sendMessage", [
'chat_id' => $admin,
'text' => "💌 رسالة مجهولة : $sender

*$text*",
'parse_mode' => "Markdown"
]);

$anonymous_message = ($gender == "male") 
? "*⌔︙ ♥🧸 تم إرسال رسالتك بشكل مجهول*" 
: "*⌔︙ ♥🧸 تم إرسال رسالتج بشكل مجهول*";

bot("sendMessage", [
'chat_id' => $chat_id,
'text' => $anonymous_message,
'parse_mode' => "Markdown"
]);
} else {
bot("sendMessage", [
'chat_id' => $admin,
'text' => "تم إرسال رسالة إليك

-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-
[$name](tg://user?id=$from_id)
[$from_id](tg://user?id=$from_id)
-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-

$text",
'parse_mode' => "Markdown",
'disable_web_page_preview' => true
]);

bot("sendMessage", [
'chat_id' => $chat_id,
'text' => $message_text,
'parse_mode' => "Markdown"
]);
}
}
/*-—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—--—-—-—-—-—-—-—-—-—-—-—-—-—-—-—-*/
