<?php

function input($id)
{
	$value = isset($id) ? $id : '';
	return "<input type='text' class='form-control' id='$id' name='$id' value ='$value'>"
}