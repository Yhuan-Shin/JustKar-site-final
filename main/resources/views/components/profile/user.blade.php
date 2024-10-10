<span class="d-none d-sm-inline text-dark mx-1"> 
    @if (Auth::guard('admin')->check())
    {{ Auth::guard('admin')->user()->username }}
@endif

</span>