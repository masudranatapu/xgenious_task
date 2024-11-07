Hi, {{ $user->name }},
Your forget password mail is here
<a href="{{ route('set.forget.Password', ['token' => $token]) }}">
    Set Your Password
</a>
