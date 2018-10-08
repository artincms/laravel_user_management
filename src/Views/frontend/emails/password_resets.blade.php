<!doctype html>
<html>
<head>
</head>
<body style="font-family: Tahoma; direction: rtl;">
<div class="">
    <div style="width: 100%">
        <div style="padding: 20px"></div>
        <span>جهت بازیابی رمز عبور خود بر روی لینک زیر کلیک نمایید:</span>
        <div style="padding: 10px"></div>
        <div style="text-align: center;">
            <div style="text-align: center; background-color: #449D44; font-size: 18px; width: 200px;">
                <a class="btn btn-lg btn-success" href="{{route('LUM.Recovery.reset',['code' =>$info['confirmation_code']])}}" role="button">فعال‌سازی حساب کاربری</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>