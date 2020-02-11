<html>
<head></head>
<style>
    body{
        font-family: 'Roboto', 'sans-serif';
        font-size: 18px;
    }
    p {
        margin: 0 0 40px 0;
    }
    a{
        color: #4290df;
        margin-left: 10px;
    }
    a:hover{
        text-decoration: none;
    }
</style>
<body>
    <div style="margin: auto; padding-top: 50px; max-width: 50%; min-width: 450px;">
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <a href="{{ $resetLinkUrl }}">Reset Password</a>
        <p>If you did not request a password reset, no further action is required.</p>
    </div>
</body>
</html>