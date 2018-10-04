<?php

if (!function_exists('LUM_get_encode_id'))
{
    function LUM_GetEncodeId($id)
    {
        if ($id < 0)
        {
            return $id;
        }
        else
        {
            $hashids = new \Hashids\Hashids(md5('sadeghi'));

            return $hashids->encode($id);
        }
    }
}
if (!function_exists('LUM_get_decode_id'))
{
    function LUM_get_decode_id($id, $route = false)
    {
        $my_routes = [

        ];
        if ((int)$id < 0)
        {
            return (int)$id;
        }
        else
        {
            $hashids = new \Hashids\Hashids(md5('sadeghi'));
            if ($route)
            {
                if (in_array($route->getName(), $my_routes))
                {
                    if ($hashids->decode($id) != [])
                    {
                        return $hashids->decode($id)[0];
                    }
                    else
                    {
                        return $id;
                    }
                }
                else
                {
                    return $id;
                }
            }
            else
            {
                if (isset($hashids->decode($id)[0]))
                {
                    return $hashids->decode($id)[0];
                }
                else
                {
                    return $id;
                }
            }
        }

    }
}
if (!function_exists('LUM_date_g_to_j'))
{
    function LUM_date_g_to_j($GDate = null, $Format = "Y/m/d-H:i", $convert = true)
    {
        if ($GDate == '-0001-11-30 00:00:00' || $GDate == null)
        {
            return '--/--/----';
        }
        $date = new ArtinCMS\LUM\Helpers\Classes\jDateTime($convert, true, 'Asia/Tehran');
        $time = is_numeric($GDate) ? strtotime(date('Y-m-d H:i:s', $GDate)) : strtotime($GDate);

        return $date->date($Format, $time);

    }
}
if (!function_exists('LUM_date_j_to_g'))
{
    function LUM_date_j_to_g($jDate, $delimiter = '/', $to_string = false, $with_time = false, $input_format = 'Y/m/d H:i:s')
    {
        $jDate = ConvertNumbersFatoEn($jDate);
        $parseDateTime = ArtinCMS\LUM\Helpers\Classes\jDateTime::parseFromFormat($input_format, $jDate);
        $r = ArtinCMS\LUM\Helpers\Classes\jDateTime::toGregorian($parseDateTime['year'], $parseDateTime['month'], $parseDateTime['day']);
        if ($to_string)
        {
            if ($with_time)
            {
                $r = $r[0] . $delimiter . $r[1] . $delimiter . $r[2] . ' ' . $parseDateTime['hour'] . ':' . $parseDateTime['minute'] . ':' . $parseDateTime['second'];
            }
            else
            {
                $r = $r[0] . $delimiter . $r[1] . $delimiter . $r[2];
            }
        }

        return ($r);
    }
}
if (!function_exists('LUM_build_tree'))
{
    function LUM_build_tree($flat_array, $pidKey, $parent = 0, $idKey = 'id', $children_key = 'children')
    {
        if (empty($flat_array))
        {
            return [];
        }
        $grouped = [];
        foreach ($flat_array as $sub)
        {
            $grouped[ $sub[ $pidKey ] ][] = $sub;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped, $idKey, $children_key) {
            foreach ($siblings as $k => $sibling)
            {
                $id = $sibling[ $idKey ];
                if (isset($grouped[ $id ]))
                {
                    $sibling[ $children_key ] = $fnBuilder($grouped[ $id ]);
                }
                $siblings[ $k ] = $sibling;
            }

            return $siblings;
        };
        $tree = $fnBuilder($grouped[ $parent ]);

        return $tree;
    }
}
if (!function_exists('LUM_all_permission_children'))
{
    function LUM_all_permission_children($item_id)
    {
        $array_ids = [];
        $item = \ArtinCMS\LUM\Models\PermissionCategoryManagement::with('Children', 'childItems')->find($item_id);
        if (count($item->childItems) > 0)
        {
            foreach ($item->childItems as $child)
            {
                $array_ids [] = $child->id;
            }
        }
        while ($item_id != 0)
        {
            if (count($item->Children) > 0)
            {
                foreach ($item->children as $cat)
                {
                    $item_id = $cat->id;
                    $item = \ArtinCMS\LUM\Models\PermissionCategoryManagement::with('Children', 'childItems')->find($item_id);
                    if (count($item->childItems) > 0)
                    {
                        foreach ($item->childItems as $child)
                        {
                            $array_ids [] = $child->id;
                        }
                    }
                }
            }
            else
            {
                $item_id = 0 ;
            }
        }

        return $array_ids;
    }
}
if (!function_exists('LUM_generate_permissions_layout'))
{
    function generate_permissions_layout($model, $current_level = 0, $data = [], $maximum_depth = false, $is_first_level = true)
    {
        $items = $model::with('Children', 'childItems')->where('parent_id', $current_level)->get();
        if ($is_first_level)
        {
            $result_html = '';//'<ul class="navbar-nav">';
        }
        else
        {
            $result_html = '<ul>';
        }

        if ($maximum_depth)
        {
            --$maximum_depth;
        }
        foreach ($items as $item)
        {
            if ($item->Children->count() > 0 && ($maximum_depth === false || $maximum_depth > 0))
            {
                $result_html .= '<li class="nav-item card padding_10 margin_3" style="clear: both">';
                $result_html .= '<div class="card-header permission_header"><div class="show_permission_checkbox ' . LUM_create_checkbox_class($item, 'show_div', false) . '" data-status="0" id="show_div_' . $item->id . '" data-item_id="' . $item->id . '"><i class="far fa-circle ' . LUM_create_checkbox_class($item, 'font_check_i', false) . '" id="font_check_' . $item->id . '"></i></div><div class="card-title">' . $item->title . '</div></div>';
                if (count($item->childItems) > 0)
                {
                    $result_html .= '<ul>';
                    foreach ($item->childItems as $childitem)
                    {
                        if (in_array($childitem->id, $data))
                        {
                            $check = 'checked';
                            $selected = 'selected';
                        }
                        else
                        {
                            $check = '';
                            $selected = '';
                        }
                        $result_html .= '<li  style="margin: 5px 10px 0px;float: right;cursor: pointer;"><div class="checkbox"><label><input ' . $check . ' name="permission[]" class="' . LUM_create_checkbox_class($childitem, 'pch') . ' checkbox ' . $selected . '" type="checkbox" value="" data-item_id="' . $childitem->id . '" onchange="change_checked(this)"><span>' . $childitem->display_name . '</span></label></div></li>';
                    }
                    $result_html .= '</ul>';
                }

                $result_html .= generate_permissions_layout($model, $item->id, $data, $maximum_depth, false);
                $result_html .= '</li>';
            }
            else
            {
                if ($is_first_level)
                {
                    $result_html .= '<li class="nav-item card padding_10 margin_3" style="clear: both"><div class="card-header permission_header"><div class="show_permission_checkbox ' . LUM_create_checkbox_class($item, 'show_div', false) . '" id="show_div_' . $item->id . '" data-status="0" data-item_id="' . $item->id . '"><i class="far fa-circle ' . LUM_create_checkbox_class($item, 'font_check_i', false) . '" id="font_check_' . $item->id . '"></i></div><div class="card-title">' . $item->title . '</div></div>';
                    if (count($item->childItems) > 0)
                    {
                        $result_html .= '<ul>';
                        foreach ($item->childItems as $childitem)
                        {
                            if (in_array($childitem->id, $data))
                            {
                                $check = 'checked';
                                $selected = 'selected';
                            }
                            else
                            {
                                $check = '';
                                $selected = '';
                            }
                            $result_html .= '<li style="margin: 5px 10px 0px;float: right;cursor: pointer;"><div class="checkbox"><label><input ' . $check . '  name="permission[]" class="' . LUM_create_checkbox_class($childitem, 'pch') . ' checkbox ' . $selected . '" type="checkbox" value="" data-item_id="' . $childitem->id . '"  onchange="change_checked(this)"><span>' . $childitem->display_name . '</span></label></div></li>';
                        }
                        $result_html .= '</ul>';
                    }
                    $result_html .= '</li>';

                }
                else
                {
                    $result_html .= '<li class="card padding_10 margin_3"  style="clear: both"><div class="card-header permission_header"><div class="show_permission_checkbox ' . LUM_create_checkbox_class($item, 'show_div', false) . '" id="show_div_' . $item->id . '" data-status="0" data-item_id="' . $item->id . '"><i class="far fa-circle ' . LUM_create_checkbox_class($item, 'font_check_i', false) . '" id="font_check_' . $item->id . '"></i></div><div class="card-title">' . $item->title . '</div></div>';
                    if (count($item->childItems) > 0)
                    {
                        $result_html .= '<ul>';
                        foreach ($item->childItems as $childitem)
                        {
                            if (in_array($childitem->id, $data))
                            {
                                $check = 'checked';
                                $selected = 'selected';
                            }
                            else
                            {
                                $check = '';
                                $selected = '';
                            }
                            $result_html .= '<li style="margin: 5px 10px 0px;float: right;cursor: pointer;"><div class="checkbox"><label><input ' . $check . '  name="permission[]" class="' . LUM_create_checkbox_class($childitem, 'pch') . ' checkbox ' . $selected . '" type="checkbox" value="" data-item_id="' . $childitem->id . '" onchange="change_checked(this)"><span>' . $childitem->display_name . '</span></label></div></li>';
                        }
                        $result_html .= '</ul>';
                    }
                    $result_html .= '</li>';
                }

            }
        }
        if ($is_first_level)
        {
            $result_html .= '';
        }
        else
        {
            $result_html .= '</ul>';
        }

        return $result_html;
    }
}
if (!function_exists('LUM_all_parents_permission'))
{
    function LUM_all_parents_permission($item, $is_item = true)
    {
        if ($is_item)
        {
            $item_id = $item->category_id;
            $parrents[] = $item->category_id;
        }
        else
        {
            $item_id = $item->parent_id;
            if ($item_id != 0)
            {
                $parrents[] = $item->parent_id;
            }
            else
            {
                $parrents = [];
            }
        }
        if ($item_id != 0)
        {
            while ($item_id != 0)
            {
                $pat = ArtinCMS\LUM\Models\PermissionCategoryManagement::where('id', $item_id)->first();
                if ($pat)
                {
                    if (isset($pat->parent_id))
                    {
                        $parrents[] = $pat->parent_id;
                        $item_id = $pat->parent_id;
                    }
                    else
                    {
                        $item_id = 0;
                    }

                }
                else
                {
                    $item_id = 0;
                }
            }
        }

        return $parrents;
    }
}
if (!function_exists('LUM_create_checkbox_class'))
{
    function LUM_create_checkbox_class($item, $pre_class, $is_item = true)
    {
        $arra_ids = LUM_all_parents_permission($item, $is_item);
        $res = '';
        foreach ($arra_ids as $id)
        {
            if ($id)
            {
                $res .= ' ' . $pre_class . '_' . $id;
            }
        }

        return $res;
    }
}
if (!function_exists('LUM_create_log_login'))
{
    function LUM_create_log_login($request, $user_id)
    {
        if ($request && $user_id)
        {
            $user = \ArtinCMS\LUM\Models\UserManagement::find($user_id);
            $roles = $user->roles->toArray();
            $permissions = $user->permissions->toArray();
            $access = array_merge($roles, $permissions);
            $log = new \ArtinCMS\LUM\Models\LogManagement();
            $log->ip = $request->ip;
            $log->user_id = $user_id;
            $log->access_json = json_encode($access);
            $log->save();
        }
    }
}
if (!function_exists('LUM_generate_sms_random_key'))
{
    function LUM_generate_sms_random_key($digits)
    {
        $min = pow(10, $digits - 1);
        $max = pow(10, $digits) - 1;

        return mt_rand($min, $max);
    }
}
if (!function_exists('LUM_generate_email_random_key'))
{
    function LUM_generate_email_random_key()
    {
        $random_key = md5(rand(1000, 50000).date('Y-m-d H:i:s'));
        $find = config('laravel_user_management.user_model') ::where('email_confirmation_code',$random_key)->first();
        if($find)
        {
            LUM_generate_email_random_key() ;
        }
        else
        {
            return $random_key;
        }
        return $random_key;
    }
}
if (!function_exists('LUM_array_field_name'))
{
    function LUM_array_field_name($key)
    {
        $key_name_parts = explode('.', $key);
        $res = $key_name_parts[0];
        foreach ($key_name_parts as $k => $part)
        {
            if ($k > 0)
            {
                $res .= '[' . $part . ']';
            }
        }

        return $res;
    }
}
if (!function_exists('LUM_validation_error_to_api_json'))
{
    function LUM_validation_error_to_api_json($errors)
    {
        $api_errors = [];
        foreach ($errors->getMessages() as $key => $value)
        {
            $key = LUM_array_field_name($key);
            $api_errors[ $key ] = array_values($value);
        }

        return $api_errors;
    }
}
if (!function_exists('LUM_next_date'))
{
    function LUM_next_date($key)
    {
        $date = date('Y-m-d H:i:s');
        $currentDate = strtotime($date);
        $futureDate = $currentDate+($key);
        $formatDate = date("Y-m-d H:i:s", $futureDate);
        return $formatDate ;
    }
}
//LUM_activation_url return 3 url
//1    successed  --->when activation successed
//2    failed     --->when activation failed
//3    expired    --->when activation code expired
if (!function_exists('LUM_activation_url'))
{
    function LUM_activation_url()
    {
        $route['failed'] = route('LUM.Activation.failedActivation');
        $route['successed'] = route('LUM.Activation.successedActivation');
        $route['expired'] = route('LUM.Activation.expiredActivation');
        return $route ;
    }
}
