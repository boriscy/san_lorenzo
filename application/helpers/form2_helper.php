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
    $config = array(
      'name' => $name,
      'value' => get_form_value($name, $values),
      'size' => '30'
    );
    $html.= form_input($config);
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
    $config = array(
      'name' => $name,
      'size' => '30'
    );
    $html.= form_password($config);
    $html.= form_error($name);
    $html.= '</div>';
    return $html;
  }
}

if(!function_exists('hidden')) 
{
  function hidden($name, $values = array()) {
    return form_hidden($name, get_form_value($name, $values));
  }
}


if(!function_exists('radio'))
{
  /**
   * Creates a radio button
   * @param string
   * @param string
   * @param string
   * @param array
   * @return string
   */
  function radio($name, $label, $value, $options) {
    $html = "<fieldset><legend>$label</legend>";
    $id = preg_replace('/\[/', '_', $name);
    $id = preg_replace('/]/', '', $id);
    if(trim($value) == '')
      $value = get_form_value($name);

    foreach($options as $k => $v) {
      $_id = $id . '_' . $k;
      $checked = $value == $k ? 'checked="true" ' : '';
      $html.= "<label><input type='radio' id='$_id' name='$name' value='$k' $checked />$v</label>";
    }
    $html.= form_error($name);
    $html.='</fieldset>';
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
    global $token;
    if(isset($options['delete'])) {
      $url.= '/' . $options['delete'];
      unset($options['delete']);
      $options['data-delete'] = 'true';
    }
    $html = '<a href="' . site_url($url) . '"';
    foreach($options as $k => $v) {
      $html.= ' '.$k.'="'.$v.'"';
    }
    $html.= '>' . $title . '</a>';
    return $html;
  }
}
