<?php

if (!function_exists('LUM_GetEncodeId'))
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
if (!function_exists('LUM_GetDecodeId'))
{
    function LUM_GetDecodeId($id, $route = false)
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
if (!function_exists('LUM_Date_GtoJ'))
{
    function LUM_Date_GtoJ($GDate = null, $Format = "Y/m/d-H:i", $convert = true)
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

if (!function_exists('LUM_Date_JtoG'))
{
    function LUM_Date_JtoG($jDate, $delimiter = '/', $to_string = false, $with_time = false, $input_format = 'Y/m/d H:i:s')
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
if (!function_exists('LUM_BuildTree'))
{
    function LUM_BuildTree($flat_array, $pidKey, $parent = 0, $idKey = 'id', $children_key = 'children')
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

if (!function_exists('generate_permissions_layout'))
{
    function generate_permissions_layout($model,$current_level = 0, $maximum_depth = false, $is_first_level = true)
    {
        $items = $model::with('Children','childItems')->where('parent_id', $current_level)->get();
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
                $result_html .= '<div class="card-header"><div class="show_permission_checkbox '.LUM_Create_checkbox_Class($item,'show_div',false).'" data-status="0" id="show_div_'.$item->id.'" data-item_id="'.$item->id.'"><i class="far fa-circle '.LUM_Create_checkbox_Class($item,'font_check_i',false).'" id="font_check_'.$item->id.'"></i></div><div class="card-title">'.$item->title.'</div></div>';
                if (count($item->childItems) > 0)
                {
                    $result_html .= '<ul>' ;
                    foreach ($item->childItems as $childitem)
                    {
                        $result_html .= '<li  style="margin: 5px 10px 0px;float: right;cursor: pointer;"><div class="checkbox"><label><input class="'.LUM_Create_checkbox_Class($childitem,'pch').' checkbox" type="checkbox" value="" data-item_id="'.$childitem->id.'" onchange="change_checked(this)"><span>'.$childitem->display_name.'</span></label></div></li>' ;
                    }
                    $result_html .= '</ul>' ;
                }

                $result_html .= generate_permissions_layout($model, $item->id, $maximum_depth, false);
                $result_html .= '</li>';
            }
            else
            {
                if ($is_first_level)
                {
                    $result_html .= '<li class="nav-item card padding_10 margin_3" style="clear: both"><div class="card-header"><div class="show_permission_checkbox '.LUM_Create_checkbox_Class($item,'show_div',false).'" id="show_div_'.$item->id.'" data-status="0" data-item_id="'.$item->id.'"><i class="far fa-circle '.LUM_Create_checkbox_Class($item,'font_check_i',false).'" id="font_check_'.$item->id.'"></i></div><div class="card-title">'. $item->title .'</div></div>';
                    if (count($item->childItems) > 0)
                    {
                        $result_html .= '<ul>' ;
                        foreach ($item->childItems as $childitem)
                        {
                            $result_html .= '<li style="margin: 5px 10px 0px;float: right;cursor: pointer;"><div class="checkbox"><label><input class="'.LUM_Create_checkbox_Class($childitem,'pch').' checkbox" type="checkbox" value="" data-item_id="'.$childitem->id.'"  onchange="change_checked(this)"><span>'.$childitem->display_name.'</span></label></div></li>' ;
                        }
                        $result_html .= '</ul>' ;
                    }
                    $result_html .= '</li>';

                }
                else
                {
                    $result_html .= '<li class="card padding_10 margin_3"  style="clear: both"><div class="card-header"><div class="show_permission_checkbox '.LUM_Create_checkbox_Class($item,'show_div',false).'" id="show_div_'.$item->id.'" data-status="0" data-item_id="'.$item->id.'"><i class="far fa-circle '.LUM_Create_checkbox_Class($item,'font_check_i',false).'" id="font_check_'.$item->id.'"></i></div><div class="card-title">'. $item->title . '</div></div>';
                    if (count($item->childItems) > 0)
                    {
                        $result_html .= '<ul>' ;
                        foreach ($item->childItems as $childitem)
                        {
                            $result_html .= '<li style="margin: 5px 10px 0px;float: right;cursor: pointer;"><div class="checkbox"><label><input class="'.LUM_Create_checkbox_Class($childitem,'pch').' checkbox" type="checkbox" value="" data-item_id="'.$childitem->id.'" onchange="change_checked(this)"><span>'.$childitem->display_name.'</span></label></div></li>' ;
                        }
                        $result_html .= '</ul>' ;
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
if (!function_exists('LUM_AllParentsPermission'))
{
    function LUM_AllParentsPermission($item,$is_item=true)
    {
        if($is_item)
        {
            $item_id = $item->category_id ;
            $parrents[] =$item->category_id ;
        }
        else
        {
            $item_id = $item->parent_id ;
            if($item_id !=0)
            {
                $parrents[] =$item->parent_id ;
            }
            else
            {
                $parrents = [] ;
            }
        }
        if($item_id !=0)
        {
            while ($item_id != 0)
            {
                $pat =  ArtinCMS\LUM\Models\PermissionCategoryManagement::where('id',$item_id)->first();
                if($pat)
                {
                    if(isset($pat->parent_id))
                    {
                        $parrents[]=$pat->parent_id ;
                        $item_id = $pat->parent_id ;
                    }
                    else
                    {
                        $item_id = 0 ;
                    }

                }
                else
                {
                    $item_id = 0 ;
                }
            }
        }

        return $parrents ;
    }
}

if (!function_exists('LUM_Create_checkbox_Class'))
{
    function LUM_Create_checkbox_Class($item,$pre_class,$is_item=true)
    {
        $arra_ids = LUM_AllParentsPermission($item,$is_item);
        $res = '' ;
        foreach ($arra_ids as $id)
        {
            if ($id)
            {
                $res .=' '.$pre_class.'_'.$id ;
            }
        }
        return $res ;
    }
}
?>