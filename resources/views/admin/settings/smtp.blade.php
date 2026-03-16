@extends('admin.layouts.app')

@section('page-title', 'SMTP Settings')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-envelope-gear me-2"></i>Email Configuration
                </h5>
                <p class="text-muted mb-4">
                    Configure your outgoing SMTP server for sending emails and set a separate notification email to receive customer inquiries.
                </p>

                <form action="{{ route('admin.settings.smtp.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h6 class="fw-bold mb-3 text-white"><i class="bi bi-send me-2"></i>Outgoing SMTP (Sending Emails)</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="mail_mailer" class="form-label fw-semibold">Mail Driver</label>
                            <select class="form-select @error('mail_mailer') is-invalid @enderror" id="mail_mailer" name="mail_mailer">
                                <option value="smtp" {{ ($settings['mail_mailer'] ?? '') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="sendmail" {{ ($settings['mail_mailer'] ?? '') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                <option value="mailgun" {{ ($settings['mail_mailer'] ?? '') === 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                <option value="ses" {{ ($settings['mail_mailer'] ?? '') === 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                <option value="postmark" {{ ($settings['mail_mailer'] ?? '') === 'postmark' ? 'selected' : '' }}>Postmark</option>
                            </select>
                            @error('mail_mailer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mail_encryption" class="form-label fw-semibold">Encryption</label>
                            <select class="form-select @error('mail_encryption') is-invalid @enderror" id="mail_encryption" name="mail_encryption">
                                <option value="tls" {{ ($settings['mail_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="null" {{ ($settings['mail_encryption'] ?? '') === 'null' ? 'selected' : '' }}>None</option>
                            </select>
                            @error('mail_encryption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-8">
                            <label for="mail_host" class="form-label fw-semibold">SMTP Host <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mail_host') is-invalid @enderror"
                                   id="mail_host" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" required
                                   placeholder="smtp.gmail.com">
                            @error('mail_host')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="mail_port" class="form-label fw-semibold">Port <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('mail_port') is-invalid @enderror"
                                   id="mail_port" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" required
                                   placeholder="587">
                            @error('mail_port')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mail_username" class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control @error('mail_username') is-invalid @enderror"
                                   id="mail_username" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}"
                                   placeholder="your-email@gmail.com">
                            @error('mail_username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mail_password" class="form-label fw-semibold">Password / App Password</label>
                            <input type="password" class="form-control @error('mail_password') is-invalid @enderror"
                                   id="mail_password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}"
                                   placeholder="••••••••••••">
                            <small class="text-muted">For Gmail, use an App Password instead of your account password</small>
                            @error('mail_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-6">
                            <label for="mail_from_address" class="form-label fw-semibold">From Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('mail_from_address') is-invalid @enderror"
                                   id="mail_from_address" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" required
                                   placeholder="noreply@lakeautosales.com">
                            <small class="text-muted">Email address that appears as the sender</small>
                            @error('mail_from_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="mail_from_name" class="form-label fw-semibold">From Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mail_from_name') is-invalid @enderror"
                                   id="mail_from_name" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'Lake Auto Sales & Services' }}" required
                                   placeholder="Lake Auto Sales & Services">
                            @error('mail_from_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-12">
                            <label for="notification_email" class="form-label fw-semibold">
                                <i class="bi bi-inbox me-1"></i>Notification Email (Receive Inquiries) <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('notification_email') is-invalid @enderror"
                                   id="notification_email" name="notification_email" value="{{ $settings['notification_email'] ?? '' }}" required
                                   placeholder="inquiries@yourdomain.com">
                            <small class="text-muted">All customer inquiries will be sent to this email address. This can be different from your SMTP account.</small>
                            @error('notification_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <hr>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-check-lg me-1"></i> Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-send me-2"></i>Test Email
                </h5>
                <p class="text-muted mb-4">Send a test email to verify your SMTP configuration.</p>

                <form action="{{ route('admin.settings.smtp.test') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="test_email" class="form-label fw-semibold">Send Test Email To</label>
                        <input type="email" class="form-control @error('test_email') is-invalid @enderror"
                               id="test_email" name="test_email" value="{{ old('test_email') }}" required
                               placeholder="your-email@example.com">
                        @error('test_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-outline-primary rounded-pill w-100">
                        <i class="bi bi-envelope me-1"></i> Send Test Email
                    </button>
                </form>
            </div>

            <div class="form-card mt-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle me-2"></i>Gmail Setup
                </h6>
                <ol class="text-muted small mb-0" style="padding-left: 1rem;">
                    <li class="mb-2">Enable 2-Step Verification in your Google Account</li>
                    <li class="mb-2">Go to Google Account → Security → App passwords</li>
                    <li class="mb-2">Generate a new app password for "Mail"</li>
                    <li class="mb-2">Use that 16-character password above</li>
                    <li>Host: smtp.gmail.com, Port: 587, Encryption: TLS</li>
                </ol>
            </div>
        </div>
    </div>
@endsection
