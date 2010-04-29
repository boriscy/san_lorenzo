<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('input'))
{
  /**
   * Creates an input
   * @param string
   * @param string
   * @param array Used to repopulate the field in case of an edit
   */
  function input($name, $label, $values=array() ) {
    $html =  '<div class="input">';
    $html.= "<label>{$label}</label>";
    $html.= form_input($name, get_form_value($name, $values) );
    $html.= form_error($name);
    $html.= '</div>';
    return $html;
  }
}

if(!function_exists('password')) 
{
  function password($name, $label) {
    $html =  '<div class="input">';
    $html.= "<label>{$label}</label>";
    $html.= form_password($name);
    $html.= form_error($name);
    $html.= '</div>';
    return $html;
  }
}


if(!function_exists('get_form_value'))
{
  /**
   * returns the value for a form given a $_POST array or and array of values
   * @param string
   * @param array
   * @return mixed
   */
  function get_form_value($name, $arr = array()) {
    if(isset($_POST) && count($_POST)> 0 ) {
      return get_array_name_value($name, $_POST);
    }else{
      return get_array_name_value($name, $arr);
    }
  }
}

if(!function_exists('get_array_name_value'))
{
  /**
   * Returns the value form an array when passed with the form name 'user[name]'
   * @param string
   * @param array
   * return mixed
   */
  function get_array_name_value($name, $arr) {
    $names = clean_brackets( preg_split('/\[/', $name) );
    $val = $arr;

    foreach($names as $v) {
      if(isset($val[$v])) {
        $val = $val[$v];
      }else if(isset($arr[end($names)] ) ) {
        return end($arr[end($names)]);
      }else{
        return;
      }
    }
    
    return $val;
  }
}

if(!function_exists('clean_brackets')) 
{
  /**
   * Cleans all fields in an array name
   * @param array
   * @return array
   */
  function clean_brackets($arr) {
    foreach($arr as $k => $v) {
      $arr[$k] = preg_replace('/(\[|]])/', '', $v);
    }
    return $arr;
  }
}

if(!function_exists('link_to')) 
{
  /**
   * Function very similar to the Ruby on Rails link_to
   * @param string
   * @param string
   * @param array
   * @return string
   */
  function link_to($title, $url, $options=array()) {
    $html = '<a href="' . site_url($url) . '"';
    foreach($options as $k => $v) {
      $html.= ' '.$k.'="'.$v.'"';
    }
    $html.= '>' . $title . '</a>';
    return $html;
  }
}
