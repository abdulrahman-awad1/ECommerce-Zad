@php
    // 1. فحص النوع من الرابط (للتجربة)
    $forceDevice = request()->query('device'); 

    // 2. الفحص الطبيعي عبر الـ User Agent
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $isMobile = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent);
@endphp

@if($forceDevice == 'mobile' || ($isMobile && $forceDevice != 'desktop'))
    {{-- سيفتح هنا إذا كتبت في الرابط ?device=mobile أو إذا كنت تستخدم موبايل حقيقي --}}
    @include('layouts.mob') 
@else
    {{-- سيفتح هنا في الحالة الطبيعية للكمبيوتر --}}
    @include('layouts.desctop')
@endif