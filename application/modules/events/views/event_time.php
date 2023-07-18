<?php
$d = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
$d->setTimeZone(new DateTimeZone("UTC"));

$today = date("Y-m-d");
$tomorrow = date('Y-m-d', strtotime($today . ' + 1 days'));

if ($model_info->start_date == $model_info->end_date) {
    if ($model_info->start_date === $today) {
        echo lang("today");
    } else if ($model_info->start_date === $tomorrow) {
        echo lang("tomorrow");
    } else {
        $day_name = ucfirst(strtolower(date("l", strtotime($model_info->start_date)))); 
        $month_name = ucfirst(strtolower(date("F", strtotime($model_info->start_date)))); 
        echo $day_name . ", " . $month_name . " " . date("d", strtotime($model_info->start_date));
    }

    if ($model_info->start_time) {
        $target_start = new DateTime($model_info->start_date . " " . $model_info->start_time);
        $target_end = new DateTime($model_info->end_date . " " . $model_info->end_time);
        echo ", " . $target_start->format("g:i a");
        echo " – " . $target_end->format("g:i a");
    }
} else {

    $day_name = ucfirst(strtolower(date("l", strtotime($model_info->start_date)))); 
    $month_name = ucfirst(strtolower(date("F", strtotime($model_info->start_date)))); 
    echo $day_name . ", " . $month_name . " " . date("d", strtotime($model_info->start_date));

    if ($model_info->start_time) {
        $target_start = new DateTime($model_info->start_date . " " . $model_info->start_time);
        echo ", " . $target_start->format("g:i a");
    }

    $end_day_name = ucfirst(strtolower(date("l", strtotime($model_info->end_date)))); 
    $end_month_name = ucfirst(strtolower(date("F", strtotime($model_info->end_date)))); //get month name from language
    echo " – " . $end_day_name . ", " . $end_month_name . " " . date("d", strtotime($model_info->end_date));

    if ($model_info->end_time) {
        $target_end = new DateTime($model_info->end_date . " " . $model_info->end_time);
        echo ", " . $target_end->format("g:i a");
    }
}
?>