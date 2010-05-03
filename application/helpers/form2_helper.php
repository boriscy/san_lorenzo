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
      if(is_array($name)) {
        $opts = $name;
        $name = $opts['name'];
        $label = $opts['label'];
        $options = $opts['options'];
        foreach(array('value', 'hint') as $v) {
          if(isset($opts[$v]))
            ${$v} = $opts[$v];
        }
        $value = $opts['value'];
        $hint = $opts['hint'];
      }
      $html =  '<div class="input">';
      $html.= "<label>{$label}</label>";
      $config = array(
        'name' => $name,
        'value' => get_form_value($name, $values),
        'size' => '30'
      );
      $html.= form_input($config);
      $html.= form_error($name);
      if(isset($hint)) {
        $html.= "<quote>$hint</quote>";
      }

      $html.= '</div>';
      return $html;
  }
}


if(!function_exists('checkbox'))
{
  /**
   * Creates an input
   * @param string
   * @param string
   * @param array Used to repopulate the field in case of an edit
   */
  function checkbox($name, $label, $values=array() ) {

    $html =  '<div class="input"><input type="hidden" name="'.$name.'" value="0" />';
    $config = array(
      'name' => $name,
      'value' => '1',
      'checked' => get_form_value($name, $values),
      'size' => '30'
    );

    if(isset($config['value'])) {
      $value = true;
    }else{
      $value = false;
    }

    $html.= "<label>";
    $html.= form_checkbox($config, $value);
    $html.= "{$label}</label>";
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


if(!function_exists('select'))
{
  /**
   * Creates a radio button
   * @param string or array
   * @param string
   * @param string
   * @param array
   * @return string
   */
  function select($name, $label='', $value='', $options = array()) {
    if(is_array($name)) {
      $opts = $name;
      $name = $opts['name'];
      $options = $opts['options'];
      $label = $opts['label'];

      foreach(array('hint', 'required') as $v) {
        if(isset($opts[$v])) {
          ${$v} = $opts[$v];
          unset($opts['hint']);
        }
      }
    }

    $html = '<div class="input">';
    $html.= "<label>$label</label>";
    $html.= "<select name=\"$name\">";
    if(trim($value) == '')
      $value = get_form_value($name);

    $html.= '<option></option>';
    foreach($options as $k => $v) {
      $checked = $value == $k ? 'selected="true" ' : '';
      $html.= "<option value='$k' $checked />$v</option>";
    }
    $html.= '</select>';
    $html.= form_error($name);
    if(isset($hint))
      $html.= "<br /><quote>$hint</quote>";
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


if(!function_exists('activo')) 
{
  function activo($val) {
    if($val) {
      return "Sí";
    }else{
      return "No";
    }
  }
}

if(!function_exists('is_ajax'))
{
  function is_ajax()
  {
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return true;
    }else{
      return false;
    }
  }
}

function input2($params){
  $input = new Form2Helper();
  return $input->input($params);
}

function select2($params) {
  $select = new Form2Helper();
  return $select->select($params);
}
/**
 * Creates all necessary form helpers in a simple way
 */
class Form2Helper
{
  public $wrapper, $control;
  private $obligatory;
  public $afterControl = array(); // Parameters that are set after the control
  public $listOptions = array(); // The list of options for select or radio controls

  public function __construct() {
    $this->wrapper = '<div class="input">${cont}</div>';
  }

  /**
   * Wraps the content
   */
  public function wrapper($cont) {
    return str_replace('${cont}', $cont, $this->wrapper);
  }


  /**
   * Set parameters
   */
  private function setParameters($params) {
    $html = array();
//    print_r($params);
    foreach($this->obligatory as $k) {
      if(!isset($params[$k]) ) {
        die("You must set the obligatory param '$v'");
      }
      array_push($html, "$k='{$params[$k]}'");
      unset($params[$k]);
    }

    if(isset($params['hint'])) {
      $this->afterControl['hint'] = $params['hint'];
      unset($params['hint']);
    }

    if(isset($params['required'])) {
      $this->afterControl['required'] = $params['required'];
      unset($params['required']);
    }

    if(isset($params['options'])) {
      $this->listOptions = $params['options'];
      unset($params['options']);
    }

    foreach($params as $k => $v) {
      array_push($html, "$k='{$v}'");
    }

    return join($html, ' ');
  }

  /**
   * Create an input text
   */
  public function input($params) {
    $this->obligatory = array('name');
    $html = '<input type="text"' . $this->setParameters($params) . ' />';
    $html.= $this->setAfterControl();

    return $this->wrapper($html);
  }

  /**
   * Select
   */
  public function select($params) {
    $this->obligatory = array('name');
    $html = '<select ' . $this->setParameters($params) . ' />';
    $value = '';
    if(isset($params['value'])) 
      $value = $params['value'];
    $html.= $this->options($params['options'], $value);
    $html.= '</select>';
    $html.= $this->setAfterControl();

    return $this->wrapper($html);
  }
  /**
   * Sets all content after control
   */
  private function setAfterControl() {
    $html = '';
    if(isset($this->afterControl['required']) )
      $html.= "<abbr title='requerido'>*</abbr>";
    if(isset($this->afterControl['hint']) )
      $html.= "<quote>{$this->afterControl['hint']}</quote>";

    return $html;
  }


  public function options($options, $value='') {
    $html = array('<option></option>');
    foreach($options as $k => $v) {
      if($k == $value) {
        array_push($html, "<option value='{$k}' selected='selected'>{$v}</option>");
      }else{
        array_push($html, "<option value='{$k}' >{$v}</option>");
      }
    }
    return join($html, ' ');
  }

}
