<h2>New Vehicle Inquiry</h2>

<p><strong>Vehicle:</strong> {{ $inquiry->vehicle->full_title }}</p>
<p><strong>Price:</strong> {{ $inquiry->vehicle->formatted_price }}</p>

<hr>

<p><strong>From:</strong> {{ $inquiry->name }}</p>
<p><strong>Email:</strong> {{ $inquiry->email }}</p>
<p><strong>Phone:</strong> {{ $inquiry->phone ?? 'Not provided' }}</p>

<h3>Message:</h3>
<p>{{ $inquiry->message }}</p>

<hr>
<small>Received at {{ $inquiry->created_at->format('M d, Y h:i A') }}</small>
