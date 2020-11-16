<?php

use Carbon\Carbon;

/* Time Difference */
function conversation_activity($dateTime){
    $createTime = Carbon::parse($dateTime); 
    $today = Carbon::now(env("APP_TIMEZONE"));
    $interval = $createTime->diff($today);

    switch($interval){
        case ($interval->format('%Y')>='1'):
            return $interval->format('before %Y years');
            break;
        case ($interval->format('%m')>='1'):
            return $interval->format('before %m months');
            break;
        case ($interval->format('%d')>='1'):
            return $interval->format('before %d days');
            break;
        case ($interval->format('%H')>='1'):
            return $interval->format('before %h hours');
            break;
        case ($interval->format('%i')>='1'):
            return $interval->format('before %i minutes');
            break;
        default:
            return 'now';
            break; 
    }
}

/* Relation duration */
function duration($started_at, $finished_at){
    $started_at = Carbon::parse($started_at); 
    $finished_at = Carbon::parse($finished_at);
    $interval = $started_at->diff($finished_at);

    return $interval->format('%d days');
}

function explodeUrl($url){
    $url = explode('/', $url);

    if(empty($url[4]))
        return;
    else
        return $url[4];
}

function has_new_message($id)
{
    
}