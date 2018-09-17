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
                    return $id ;
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

?>