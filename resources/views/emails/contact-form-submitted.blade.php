<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] ?? '—' }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Preferred Contact Method:</strong> {{ $data['preferred_contact_method'] }}</p>
<p><strong>Preferred Time:</strong> {{ $data['preferred_time'] ?? '—' }}</p>

<p><strong>Comments:</strong></p>
<p>{{ nl2br(e($data['comments'])) }}</p>
