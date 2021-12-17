<?php
$question = $_POST['question'];
$array2 = file_get_contents('./people.json');
$array3 = json_decode($array2, true);

$fp = @fopen("messages.txt", 'r');

function func($arr,$que,$en)
{
    $x=hexdec(sha1($que . $en));
    $x = $x / 10**35;
    return ($arr[($x) % sizeof($arr)]);
}
if($fp)
{
    $array= explode("\n", fread($fp, filesize("messages.txt")));
}
//var_dump($array);


if (empty($_POST['person'])) {
    $en_name = array_rand($array3);
    $fa_name = $array3[$en_name];
} 

else {
    $en_name = $_POST['person'];
    $fa_name = $array3[$en_name];
}

if (empty($question)) {
    $msg = 'سوال خود را بپرس!';
}

elseif ((str_starts_with($question, "آیا") and (str_ends_with($question, "?") or str_ends_with($question, "؟")))) {
    $msg = func($array,$question,$en_name);
} 

else {
    $msg = 'سوال درستی پرسیده نشده';
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span
            id="label"
            style="display: <?php echo empty($question) ? 'none' : 'inline' ?>;"
        >پرسش:</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                foreach($array3 as $english => $persian){
                    if($english==$en_name){
                        echo "<option value= $english selected> $persian </option>";
                    }
                    else{
                        echo "<option value= $english> $persian </option>";
                    }
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>