<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">

<head>
  <meta charset="UTF-8">
  <title>Invite User</title>
</head>

<body>
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="background-color: #f2f2f2;">
        <table width="600" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" style="background-color: #000; padding: 40px 0 30px 0;">
              <img src="your-logo-here.png" alt="Your Company Logo" width="300" height="100" style="display: block;">
            </td>
          </tr>
          <tr>
            <td align="center" style="background-color: #ffffff; padding: 40px 30px 40px 30px;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                    <b>{{$data['greetings']}}</b>
                  </td>
                </tr>
                <tr>
                  <td
                    style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                    {{$data['line']}}</br>
                    {{$data['content']}}
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="260" valign="top">
                          <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                              <td
                                style="background-color: #ee543f; color: #ffffff; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; padding: 12px 10px 12px 10px;">
                               Login Id
                              </td>
                              <td
                                style="background-color: #ffffff; color: #153643; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; padding: 12px 10px 12px 10px;">
                                {{ $data['login_id'] }}
                              </td>
                            </tr>
                            <tr>
                              <td
                                style="background-color: #ee543f; color: #ffffff; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; padding: 12px 10px 12px 10px;">
                               Password
                              </td>
                              <td
                                style="background-color: #ffffff; color: #153643; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; padding: 12px 10px 12px 10px;">
                                {{ $data['password'] }}
                              </td>
                            </tr>
                            <tr>
                              <td
                                style="background-color: #ee543f; color: #ffffff; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; padding: 12px 10px 12px 10px;">
                               Login Url
                              </td>
                              <td
                                style="background-color: #ffffff; color: #153643; font-family: Arial, sans-serif; font-size: 14px; font-weight: bold; text-align: center; padding: 12px 10px 12px 10px;">
                                {{ $data['login_link'] }}
                              </td>
                            </tr>
                          </table>
                        </td>
                        <td style="font-size: 0; line-height: 0;" width="20">
                          &nbsp;
                        </td>
                        <td width="260" valign="top">
                          <table width="100%" cellpadding="0" cellspacing="0">
                            <tr></tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
