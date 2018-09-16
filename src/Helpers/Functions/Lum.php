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
            'LFM.DownloadFile',
            'LFM.ShowCategories',
            'LFM.ShowCategories.Create',
            'LFM.ShowCategories.Edit',
            'LFM.EditFile',
            'LFM.FileUpload',
            'LFM.FileUploadForm',
            'LFM.EditPicture',
            'LFM.Breadcrumbs',
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

?>