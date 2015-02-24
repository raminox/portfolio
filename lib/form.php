<?php

function input($id, $type = 'text', $value = null)
{

    switch ($type) {

        case 'text':
            $value = isset($_POST[$id]) ? $_POST[$id] : '';
            return "<input type='$type' class='form-control' id='$id' name='$id' value ='$value'>";
            break;

        case 'password':
            return "<input type='$type' class='form-control' id='$id' name='$id'>";
            break;

        case 'textarea':
            $value = isset($_POST[$id]) ? $_POST[$id] : '';
            return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
            break;

        case 'submit':
            return "<input type='$type' class='btn btn-default' name='$id' value='$value'>";
            break;

        default:
            return "# Input type not supported ";
            break;
    }
}
