<h2>Hello {{ $name }},</h2>

<p>Your account has been created.</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>

<p>Please click the link below to activate your account:</p>
<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>Thanks,<br/>EcoMark Team</p>
