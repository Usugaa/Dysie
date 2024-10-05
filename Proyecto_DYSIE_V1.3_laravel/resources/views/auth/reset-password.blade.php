<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" name="email" value="{{ request()->email }}" placeholder="Email" required>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
        <input type="password" name="password" placeholder="New Password" required>
        @error('password')
            <span>{{ $message }}</span>
        @enderror
        <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
