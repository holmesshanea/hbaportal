<p>Hi {{ $user->first_name ?? $user->name ?? 'there' }},</p>

<p>Your account has been successfully verified.</p>

<p>
    In order to RSVP to an Event or Retreat, you must
    <a href="{{ route('login') }}" style="color:#1d4ed8; text-decoration: underline;">
        log in
    </a>
    and complete your
    <a href="{{ route('profile.edit') }}" style="color:#1d4ed8; text-decoration: underline;">
        Profile
    </a>.
</p>

<p>Thank you!</p>

