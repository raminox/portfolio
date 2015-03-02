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
        case 'file':
            return "<input type='file' class='form-control' id='$id' name='$id'>";
            break;

        case 'submit':
            return "<input type='$type' class='btn btn-default' name='$id' value='$value'>";
            break;

        default:
            return "# Input type not supported ";
            break;
    }
}

function selectInput($id, $options = [])
{
    $selectInput = "<select name='$id' id='$id' class='form-control' >";

    foreach ($options as $option_id => $value) {
        $selected = '';
        if (isset($_POST[$id]) && $option_id == $_POST[$id]) {
            $selected = 'selected="selected"';
        }
        $selectInput .= "<option value='$option_id' $selected>$value</option>";
    }

    $selectInput .= "</select>";

    return $selectInput;
}
