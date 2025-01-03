<div>
    Thanks for purchasing {{ $course->title }}

    If this is your first purchase on {{ config('app.name') }}, then a new account was created for you, 
    and you need to reset your password.

    Have fun with the new course.

    <a target="_blank" href="{{route('login')}}">Login</a>

</div>
