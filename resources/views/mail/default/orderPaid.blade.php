<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Successful</title>
  <!--[if mso]>
  <style type="text/css">
    table { border-collapse: collapse; }
    td { font-family: Arial, sans-serif; }
  </style>
  <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%;">
  <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f3f4f6;">
    <tr>
      <td align="center" style="padding: 24px 12px;">
        <!-- Main Container -->
        <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); max-width: 600px;">

          <!-- Header -->
          <tr>
            <td style="padding: 40px 24px; text-align: center; background-color: #059669;">
              <h1 style="margin: 0; font-size: 24px; color: #ffffff; font-weight: 700; letter-spacing: 1px;">
                {{$name}}
              </h1>
              <p style="margin: 8px 0 0; font-size: 14px; color: rgba(255, 255, 255, 0.9);">
                {{$description}}
              </p>
            </td>
          </tr>

          <!-- Content -->
          <tr>
            <td style="padding: 32px 24px;">
              <!-- Success Icon & Title -->
              <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" style="padding-bottom: 24px;">
                    <!-- Checkmark Icon (email-safe) -->
                    <table role="presentation" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" valign="middle" width="60" height="60" style="background-color: #d1fae5; border-radius: 50%; font-size: 28px; color: #059669; font-weight: bold;">
                          &#10003;
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td align="center">
                    <h2 style="margin: 0; font-size: 22px; color: #111827; font-weight: 700;">Payment Successful</h2>
                    <p style="margin: 8px 0 0; color: #6b7280; font-size: 14px;">Your order has been completed successfully.</p>
                  </td>
                </tr>
              </table>

              <!-- Order Details -->
              <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden;">
                <!-- Order Number -->
                <tr>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 13px; width: 40%;">Order Number</td>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 13px; font-weight: 600; text-align: right;">{{$order_no}}</td>
                </tr>
                <!-- Plan Name -->
                <tr>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 13px;">Plan Name</td>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 13px; font-weight: 600; text-align: right;">{{$plan_name}}</td>
                </tr>
                <!-- Total Amount -->
                <tr>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 13px;">Total Amount</td>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 13px; font-weight: 600; text-align: right;">{{$price}}</td>
                </tr>
                <!-- Expiration Date -->
                <tr>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #6b7280; font-size: 13px;">Expiration Date</td>
                  <td style="padding: 12px 16px; border-bottom: 1px solid #f3f4f6; color: #111827; font-size: 13px; font-weight: 600; text-align: right;">{{$expired_at}}</td>
                </tr>
                <!-- Traffic Usage -->
                <tr>
                  <td style="padding: 12px 16px; color: #6b7280; font-size: 13px;">Traffic Usage</td>
                  <td style="padding: 12px 16px; color: #111827; font-size: 13px; font-weight: 600; text-align: right;">{{$used_traffic}} / {{$total_traffic}}</td>
                </tr>
              </table>

              <!-- Thank You -->
              <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 20px;">
                <tr>
                  <td align="center">
                    <p style="margin: 0; font-size: 14px; color: #4b5563; font-weight: 500;">Thank you for choosing our service.</p>
                  </td>
                </tr>
              </table>

              <!-- View Order Button -->
              <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 28px; border-top: 1px solid #f3f4f6; padding-top: 20px;">
                <tr>
                  <td align="center" style="padding-top: 20px;">
                    <table role="presentation" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center" style="background-color: #10b981; border-radius: 8px;">
                          <a href="{{$url}}/#/order" target="_blank" style="display: inline-block; padding: 12px 28px; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 14px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">View Order</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color: #f9fafb; padding: 20px 24px; text-align: center; border-top: 1px solid #e5e7eb;">
              <p style="margin: 0 0 8px; font-size: 12px; color: #6b7280; line-height: 1.5;">{{$intro}}</p>
              <p style="margin: 0; font-size: 12px; color: #9ca3af;">&copy; {{ date('Y') }} {{$name}}. All rights reserved.</p>
              <p style="margin: 4px 0 0; font-size: 11px; color: #d1d5db;">This is an automated message, please do not reply.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
