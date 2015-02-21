<?php

function flash($type = 'success', $message)
{
    return "<div class='alert alert-$type' role='alert'>$message</div>";
}
