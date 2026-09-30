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
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                  </svg>
                </div>
                <h2 style="margin: 0; font-size: 24px; color: #111827; font-weight: 700;">{{ __('Login to :name', ['name' => $name]) }}</h2>
                <p style="margin: 10px 0 0; color: #6b7280; font-size: 16px;">{{ __('You are logging into :name. Please click the button below to login within 5 minutes.', ['name' => $name]) }}</p>
              </div>
              
              <div style="text-align: center; margin: 30px 0;">
                <a href="{{$link}}" style="display: inline-block; padding: 16px 32px; background-color: #4f46e5; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 16px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);">{{ __('Login Now') }}</a>
              </div>
              
              <div style="background-color: #f9fafb; border-radius: 8px; padding: 15px; text-align: center; word-break: break-all; margin-top: 20px;">
                  <p style="margin: 0 0 5px 0; font-size: 12px; color: #9ca3af;">{{ __('Or copy this link to your browser:') }}</p>
                  <a href="{{$link}}" style="color: #6b7280; font-size: 12px; text-decoration: none;">{{$link}}</a>
              </div>

              <div style="color: #4b5563; font-size: 15px; line-height: 1.6; text-align: center; margin-top: 30px;">
                <p style="margin: 0;">{{ __('If you did not authorize this request, please ignore this email.') }}</p>
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
