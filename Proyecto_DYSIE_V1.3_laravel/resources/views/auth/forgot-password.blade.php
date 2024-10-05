<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
        <button type="submit">Send Password Reset Link</button>
    </form>
</body>
</html>
            