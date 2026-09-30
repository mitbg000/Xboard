<div style="background-color:#f3f4f6; padding: 40px 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">
        <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 600px;">
          <!-- Header -->
          <tr>
            <td style="padding: 50px 40px; text-align: center; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
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
                <div style="background-color: #fef3c7; width: 64px; height: 64px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                  </svg>
                </div>
                <h2 style="margin: 0; font-size: 24px; color: #111827; font-weight: 700;">{{ __('Expiration Reminder') }}</h2>
              </div>
              
              <div style="background-color: #fffbeb; border: 1px solid #fcd34d; border-radius: 12px; padding: 24px; color: #92400e; font-size: 16px; line-height: 1.6; text-align: center;">
                <p style="margin-top: 0;">{{ __('Your service will expire within 24 hours. Please renew to avoid interruption.') }}</p>
                <p style="margin-bottom: 0;">{{ __('If you have already renewed, please ignore this email.') }}</p>
              </div>

              <div style="margin-top: 30px; background-color: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 20px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="padding-bottom: 12px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 14px;">{{ __('Plan Name') }}</td>
                    <td style="padding-bottom: 12px; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{$plan_name}}</td>
                  </tr>
                  <tr>
                    <td style="padding: 12px 0; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 14px;">{{ __('Expiration Date') }}</td>
                    <td style="padding: 12px 0; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{$expired_at}}</td>
                  </tr>
                  <tr>
                    <td style="padding-top: 12px; color: #6b7280; font-size: 14px;">{{ __('Traffic Usage') }}</td>
                    <td style="padding-top: 12px; color: #111827; font-size: 14px; font-weight: 600; text-align: right;">{{$used_traffic}} / {{$total_traffic}}</td>
                  </tr>
                </table>
              </div>
              
              <div style="text-align: center; margin-top: 20px;">
                <p style="margin: 0; font-size: 15px; color: #4b5563; font-weight: 500;">{{ __('Thank you for choosing our service.') }}</p>
              </div>

              <div style="border-top: 1px solid #f3f4f6; margin-top: 40px; padding-top: 20px; text-align: center;">
                <a href="{{$url}}" style="display: inline-block; padding: 12px 24px; background-color: #f59e0b; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.2);">{{ __('Back to Homepage') }}</a>
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
