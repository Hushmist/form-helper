<?php



if (!function_exists('formMap')) {

    function formMap($has_map = false, $lat = null, $lng = null, $location_values = null, $has_location_col = false) // TODO l11n
    {
        $res = '';
        if($has_map) {

            $res .= "<div id='map' style='width: 100%; height: 20rem'></div>";
        }
        if($has_location_col) {
            $res .= "
                <div class='row'>
                    ". formInputLang(name: 'location', label: __('location'), is_required: 1, values: $location_values)."
                </div>
            ";
        }
        $res .= "
           <div class='row'>
                <div class='col-6'>
                ".
                formInput(name: 'lat', label: __('latitudes'), is_required: 1,value: $lat) .
                "
                </div>
                <div class='col-6'>
                ".
                formInput(name: 'lng', label: __('longitudes'), is_required: 1,value: $lng) .
                "
                </div>
           </div>
            ";
        return $res;
    }
}


if (!function_exists('formDropdownOptgroup')) {

    function formDropdownOptgroup($options_name, $name = '', $options = [], $label = '', $selected_id = null, $has_null = false, $id = null, $is_disabled = false, $is_required = false, $is_multiple = false, $is_hidden = false, $select_extra_class = null, $on_change = null) {
        $res = "<div class='form-group' ".($is_hidden ? ' hidden ' : '').">
          <label>$label</label>
          <select name='$name' class='form-control $select_extra_class' id='$id' style='width: 100%;' tabindex='-1' aria-hidden='true' ".($is_multiple ? ' multiple ' : '').($is_disabled ? ' disabled ' : '').($is_required ? ' required ' : '')." onChange='$on_change'>
           ";
        if($has_null) {
            $res .= "
                <option value>Не выбрано</option>
            ";
        }
        foreach ($options ?? [] as $option_group) {
            $res .= "<optgroup label='$option_group->title'>";
            foreach ($option_group->$options_name ?? [] as $option) {
                if(!isset($option['id'])) {
                    $value = $option;
                    $text = $option;
                } else {
                    $value = $option['id'];
                    $text = $option['name'] ?? $option['title'] ?? $option['body'];
                }
                $is_selected = $is_multiple
                    ? in_array($value, $selected_id ?? [])
                    : ($selected_id == $value);

                $res .= "
                <option ".($is_selected ? 'selected="selected"' : '') . " value='$value'>".__($text)."</option>
                ";
            }
            $res .= "</optgroup>";
        }
        $res .= "
          </select>
        </div>
    ";
        return $res;
    }
}

if (!function_exists('formInput')) {

    function formInput($name = '', $placeholder = '', $value = '', $label = '', $is_hidden = false, $id = null, $is_disabled = false, $is_required = false, $type = '', $step = 'any', $is_readonly = false, $div_class = null, $input_class = null, $input_id = null)
    {
        return "
            <div class='" . ($div_class ?? 'mb-2 col-lg-18') . ($is_required ? ' required ' : '') . " ' id='$id'>
                    <label>$label</label>
                    <input " . ($is_hidden ? 'hidden' : '') . ($is_disabled ? 'disabled' : '') . ($is_required ? 'required' : '') . ($is_readonly ? ' readonly ' : '') . " value='$value' type='$type' class='".($input_class ?? 'form-control')."' name='$name'  placeholder='$placeholder' step='$step' id='$input_id' aria-describedby='basic-addon1'>
            </div>
        ";
    }
}
if (!function_exists('formInputLang')) {

    function formInputLang($name = '', $values = '', $label = '', $is_hidden = false, $id = null, $is_disabled = false, $is_required = false, $type = '', $step = 'any', $is_readonly = false, $div_class = null)
    {
        return "
            <div class='" . ($div_class ?? 'mb-2 col-lg-18') . ($is_required ? ' required ' : '') . " ' id='$id'>
                <label>$label</label>
                <div class='row'>
                    <div class='col-4'><input " . ($is_hidden ? 'hidden' : '') . ($is_disabled ? 'disabled' : '') . ($is_required ? 'required' : '') . ($is_readonly ? ' readonly ' : '') . " value='".(empty($values[0]) ? "" : $values[0])."' type='$type' class='form-control' name='".(str_ends_with($name, ']') ? $name.'[name]' : $name )."'  placeholder='На русском' step='$step' aria-describedby='basic-addon1'></div>
                    <div class='col-4'><input " . ($is_hidden ? 'hidden' : '') . ($is_disabled ? 'disabled' : '') . ($is_required ? 'required' : '') . ($is_readonly ? ' readonly ' : '') . " value='".(empty($values[1]) ? "" : $values[1])."' type='$type' class='form-control' name='".(str_ends_with($name, ']') ? $name.'[name_kk]' : ($name . '_kk') )."'  placeholder='На казахском' step='$step' aria-describedby='basic-addon1'></div>
                    <div class='col-4'><input " . ($is_hidden ? 'hidden' : '') . ($is_disabled ? 'disabled' : '') . ($is_required ? 'required' : '') . ($is_readonly ? ' readonly ' : '') . " value='".(empty($values[2]) ? "" : $values[2])."' type='$type' class='form-control' name='".(str_ends_with($name, ']') ? $name.'[name_en]' : ($name . '_en') )."'  placeholder='На английском' step='$step' aria-describedby='basic-addon1'></div>
                </div>
            </div>
        ";
    }
}



if (!function_exists('formFile')) {

    function formFile($name = '', $label = '', $image = null, $is_hidden = false, $video = null, $footer_label = '', $link = '', $is_required = false, $accept = null, $images_delete_route = null)
    {
        $hash = md5(uniqid(mt_rand(10000000, 100000000)));
        $is_multiple = str_ends_with($name, '[]');
        $res = "
            <label style='font-style: italic;padding: 0px 4px'>$label</label>
            <div class='input-group mb-3 " . ($is_required ? ' required ' : '') . "' " . ($is_hidden ? 'hidden' : '') . " >
                <input type='file' class='form-control' id='inputGroupFile$hash' name='$name' " . ($is_multiple ? ' multiple ' : '') . ($is_required ? ' required ' : '') . " accept='$accept'>
                <label style='font-style: italic;padding: 0px 4px' for='inputGroupFile$hash' class='input-group-text'>$label</label>
            </div>";
        if ($image) {
            if(in_array(gettype($image), ['array', 'object'])) {
                $res .= "
                    <!-- Carousel wrapper -->
                    <div
                        id='carouselMultiItemExample'
                        class='carousel slide carousel-dark text-center'
                        data-mdb-ride='carousel'
                    >
                        <!-- Inner -->
                        <div class='carousel-inner py-4'>

                            <!-- Single item -->
                            <div class='carousel-item active'>
                                <div class='container'>
                                    <div class='row'>";
                foreach ($image as $image_el) {
                    $res .= "
                        <div class='col-lg-3'>
                            <div class='card'>
                                <img
                                    src='".$image_el['path']."'
                                    class='card-img-top'
                                />";
                    if($images_delete_route) {
                        $res .= "
                            <div class='card-body'>
                                <button type='button' onclick=\"deleteEventImage(this, '".route($images_delete_route, $image_el['id'])."')\" class='btn btn-primary'>Удалить</button>
                            </div>
                        ";
                    }
                    $res .= "
                        </div>
                    </div>
                    <script>
                    function deleteEventImage(button, delete_url) {
                        $.post(delete_url, {
                            '_token': '" . csrf_token() . "',
                            '_method': 'DELETE'
                        }, function() {
                            $(button).parent().parent().parent().remove()
                        })
                    }
                    </script>
                    ";
                }

                $res .=            "</div>
                                </div>
                            </div>
                        </div>
                        <!-- Inner -->
                    </div>
                ";
            } else {
                $res .= "
                <div class='form-group border border-secondary'>
                    <div class='row'>
                        <div class='col-3'>
                            <div class='card-body'>
                                <img src='$image' width='50%'>
                            </div>
                            <div class='card-footer'>
                                $footer_label
                            </div>
                        </div>
                    </div>
                </div>
            ";
            }
        }
        if ($video) {
            $res .= "
                <div class='form-group'>
                    <video controls src='$video'></video>
                </div>
            ";
        }
        if ($link) {
            $res .= "
                <div class='form-group'>
                    <a href='$link'>$footer_label</a>
                </div>
            ";
        }

        return $res;
    }
}
if (!function_exists('formTextarea')) {

    function formTextarea($name = '', $placeholder = '', $value = '', $label = '', $is_readonly = false, $rows = 6, $id = null, $input_class = null)
    {
        return "
            <div class='form-group mb-3 '>
                <label>$label</label>
                <textarea name='$name' id='$id' class='". ($input_class ?? 'form-control') ." rows='$rows' placeholder='$placeholder' ". ($is_readonly ? ' readonly ' : '') . " >$value</textarea>
            </div>
        ";
    }
}
if (!function_exists('formTextareaLang')) {

    function formTextareaLang($name = '', $values = '', $label = '', $is_readonly = false, $rows = 6, $id = null, $input_class = null, $is_required = false)
    {
        return "
            <div class='form-group mb-3 " . ($is_required ? ' required ' : '') . "'>
                <label>$label</label>
                <div class='row'>
                    <div class='col-4'><textarea name='$name' id='$id' placeholder='На русском' class='". ($input_class ?? 'form-control') ."' rows='$rows' ". ($is_readonly ? ' readonly ' : '') . ($is_required ? ' required ' : '') . " >".(empty($values[0]) ? "" : $values[0])."</textarea></div>
                    <div class='col-4'><textarea name='".$name."_kk' id='$id' placeholder='На казахском' class='". ($input_class ?? 'form-control') ."' rows='$rows' ". ($is_readonly ? ' readonly ' : '') . " >".(empty($values[1]) ? "" : $values[1])."</textarea></div>
                    <div class='col-4'><textarea name='".$name."_en' id='$id' placeholder='На английском' class='". ($input_class ?? 'form-control') ."' rows='$rows' ". ($is_readonly ? ' readonly ' : '') . " >".(empty($values[2]) ? "" : $values[2])."</textarea></div>
                </div>
            </div>
        ";
    }
}
if (!function_exists('formSubmitButton')) {

    function formSubmitButton($placeholder = '', $button_class = null, $div_class = null, $is_disabled = false)
    {
        return "
            <div class=' " . ($div_class ?? 'mt-4') . " '>
              <button type='submit' class=' " . ($button_class ?? 'btn btn-primary') . " ' ". ($is_disabled ? ' disabled ' : '') ." >$placeholder</button>
            </div>
        ";
    }
}
if (!function_exists('formDropdown')) {

    function formDropdown($name = '', $options = [], $label = '', $selected_id = null, $has_null = false, $id = null, $is_disabled = false, $is_required = false, $is_multiple = false, $can_add_lang = false, $on_change = null, $select_class = null)
    {
        $res = "
        <div class='form-group" . ($is_required ? ' required ' : '') . "'>
          <label>".__($label)."</label>
          <div class='row'>

            <select name='$name'
                class='".($select_class ?? 'form-control') .($can_add_lang ? ' col-11 ' : ' col-12 ')."'
                id='$id'
                style='width: 100%;'
                data-select2-id='1'
                tabindex='-1'
                aria-hidden='true' "
                . ($is_multiple ? ' multiple ' : '')
                . ($is_disabled ? ' disabled ' : '')
                . ($is_required ? ' required ' : '')
                . "
                onchange='$on_change'
            >";
        if ($has_null) {
            $res .= "<option value>Не выбрано</option>";
        }
        foreach ($options as $option) {
            if (!isset($option['id'])) {
                $value = $option;
                $text = $option;
            } else {
                $value = $option['id'];
                $text = $option['name'] ?? $option['title'];
            }
            $is_selected = $is_multiple
                ? in_array($value, $selected_id ?? [])
                : ($selected_id == $value);

            $res .= "
                <option " . ($is_selected ? 'selected="selected"' : '') . " value='$value'>" . __($text) . "</option>
                ";
        }
        $res .= "</select>";
        $res .= $can_add_lang
            ?   "
                  <div class='col-1'>
                      <button class='btn btn-info add-lang-cols' type='button'><i class='nav-icon fas fa fa-plus'></i></button>
                  </div>

                </div> <!-- .row -->
                <div class='row' style='display: none;'>
                " . formInputLang(name: "new_$name", is_disabled: 1) ."
                </div>

            </div> <!-- .form-group -->"
            :
            " </div> <!-- .row -->
        </div> <!-- .form-group -->";
        return $res;
    }
}
if (!function_exists('formDropdownSelect2')) {

    function formDropdownSelect2($name = '', $options = [], $label = '', $selected_id = null, $has_null = false, $id = null, $is_disabled = false, $is_required = false)
    {
        $select2_id = rand(0, 999999999);
        $res = "
        <div class='form-group" . ($is_required ? ' required ' : '') . "'>
          <label>".__($label)."</label>
          <div class='row'>

            <select name='$name'
                class='form-control dropdown-multiple-select2'
                id='$id'
                style='width: 100%;'
                data-select2-id='$select2_id'
                tabindex='-1'
                multiple='multiple'
                aria-hidden='true' "
                . ($is_disabled ? ' disabled ' : '')
                . ($is_required ? ' required ' : '')
                . "
            >";
        if ($has_null) {
            $res .= "<option value>Не выбрано</option>";
        }
        foreach ($options as $option) {
            if (!isset($option['id'])) {
                $value = $option;
                $text = $option;
            } else {
                $value = $option['id'];
                $text = $option['name'] ?? $option['title'];
            }
            $is_selected = in_array($value, $selected_id ?? []);

            $res .= "
                <option " . ($is_selected ? 'selected="selected"' : '') . " value='$value'>" . __($text) . "</option>
                ";
        }
        $res .= "</select>
            </div> <!-- .row -->
            <script>
                $('.dropdown-multiple-select2').select2();
            </script>
        </div> <!-- .form-group -->";
        return $res;
    }
}

if (!function_exists('formCheckbox')) {
    function formCheckbox($name = '', $label = '', $is_checked = false)
    {
        return "

            <label class='toggle  my-3'>
              <input class='toggle-checkbox' name='$name' " . ($is_checked ? ' checked ' : '') . "  type='checkbox'>
              <div class='toggle-switch'></div>
              <span class='toggle-label'>$label</span>
            </label>
        ";
    }
}

if (!function_exists('formColorPicker')) {
    function formColorPicker($name = null, $label = null, $value = null): string {
        return "
            <div class='mb-2 col-lg-18 d-block'>
                <label>$label</label>
                <br>
                <input name='$name' value='$value' type='color' class='w-25' style='height: 2rem' rgba>
            </div>
        ";
    }
}
