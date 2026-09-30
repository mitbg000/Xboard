<div style="background-color:#f3f4f6; padding: 40px 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
          <!-- Header -->
          <tr>
            <td style="padding: 50px 40px; text-align: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
              <h1 style="margin: 0; font-size: 28px; color: #ffffff; font-weight: 700; letter-spacing: 1px; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                {{$name}}
              </h1>
              <p style="margin: 10px 0 0; font-size: 16px; color: rgba(255, 255, 255, 0.9);">
                {{$description}}
              </p>
            </td>
          </tr>
          
          <!-- Content -->
          <tr>
            <td style="padding: 40px;">
              <div style="text-align: center; margin-bottom: 30px;">
                <div style="background-color: #e0e7ff; width: 64px; height: 64px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21.2 8.4c.5.38.8.97.8 1.6v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V10a2 2 0 0 1 .8-1.6l8-6a2 2 0 0 1 2.4 0l8 6Z"/>
                    <path d="m22 10-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 10"/>
                  </svg>
                </div>
                <h2 style="margin: 0; font-size: 24px; color: #111827; font-weight: 700;">{{ __('Email Verification') }}</h2>
                <p style="margin: 10px 0 0; color: #6b7280; font-size: 16px;">{{ __('Please use the code below to complete verification.') }}</p>
              </div>

              <!-- Code Box -->
              <div style="background-color: #f9fafb; border: 2px dashed #e5e7eb; border-radius: 12px; padding: 24px; text-align: center; margin: 30px 0;">
                <span style="font-family: monospace; font-size: 36px; font-weight: 700; color: #4f46e5; letter-spacing: 8px; display: block;">{{$code}}</span>
                <p style="margin: 10px 0 0; font-size: 13px; color: #9ca3af;">{{ __('Code valid for 5 minutes') }}</p>
              </div>
              
              <div style="color: #4b5563; font-size: 15px; line-height: 1.6; text-align: center;">
                <p style="margin: 0;">{{ __('If you did not request this code, please ignore this email.') }}</p>
                <p style="margin: 10px 0 0; font-weight: 500;">{{ __('Thank you for choosing our service.') }}</p>
              </div>

              <div style="border-top: 1px solid #f3f4f6; margin-top: 40px; padding-top: 20px; text-align: center;">
                <a href="{{$url}}" style="display: inline-block; padding: 12px 24px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">{{ __('Back to Homepage') }}</a>
              </div>
            </td>
          </tr>
          
          <!-- Footer -->
          <tr>
            <td style="background-color: #f9fafb; padding: 24px; text-align: center; border-top: 1px solid #e5e7eb;">
              <p style="margin: 0 0 10px; font-size: 13px; color: #6b7280; line-height: 1.5;">{{$intro}}</p>
              <p style="margin: 0; font-size: 13px; color: #9ca3af;">&copy; {{ date('Y') }} {{$name}}. All rights reserved.</p>
              <p style="margin: 5px 0 0; font-size: 12px; color: #d1d5db;">{{ __('This is an automated message, please do not reply.') }}</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
