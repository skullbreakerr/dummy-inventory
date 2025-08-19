<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <table style="width: 100%; max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px; background-color: #ffffff; text-align: center;">
                <img width="300" height="300" src="{{ image('logos/mail_logo.png') }}" />
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; background-color: #ffffff; font-size: 16px; line-height: 1.6;">
                <p>Dear {{ $data['name'] }},</p>
                <p>We are pleased to provide you with your account credentials for access to our Vexma Cloud application. Please find your login details below:</p>
                <p>Your account credentials are:</p>
                <ul>
                    <li>Email: {{ $data['email'] }}</li>
                    @isset($data['password'])
                    <li>Password: {{ $data['password'] }}</li>
                    @endisset
                </ul>
                <p>Please use the provided credentials to log in to our Vexma Cloud application. If you have any questions or encounter any issues, please don't hesitate to contact our support team at support@vexmatech.com.</p>
                <p>Thank you for choosing Vexma Technologies for your application needs. We look forward to serving you and ensuring a seamless experience.</p>
                <p>Best regards, <br>Team Vexma</p>
            </td>
        </tr>
        <tr><td>
                                                    <table class="section_wrapper footer" data-id="footer" id="section-footer"
                                            border="0" width="100%" cellpadding="0" cellspacing="0"
                                            align="center" style="min-width: 100%;" role="presentation"
                                            bgcolor="#ffffff">
                                            <tbody>
                                                <tr>
                                                    <td class="section_wrapper_th"
                                                        style="mso-line-height-rule: exactly; padding: 0 52px;"
                                                        bgcolor="#ffffff">
                                                        <table border="0" width="100%" cellpadding="0"
                                                            cellspacing="0" align="center" style="min-width: 100%;"
                                                            role="presentation">
                                                            <!-- BEGIN : 2 COLUMNS : SOCIAL_BLOCK -->
                                                            <tbody>
                                                                <tr>
                                                                    <th style="mso-line-height-rule: exactly;"
                                                                        bgcolor="#ffffff">
                                                                        <table border="0" width="100%"
                                                                            cellpadding="0" cellspacing="0"
                                                                            align="center" style="min-width: 100%;"
                                                                            role="presentation">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <!-- BEGIN : Column 1 of 2 : SOCIAL_BLOCK -->
                                                                                    <th width="50%"
                                                                                        class="column_1_of_2 column_social_block "
                                                                                        style="mso-line-height-rule: exactly; padding-top: 26px; padding-bottom: 26px; border-top-width: 2px; border-top-color: #dadada; border-top-style: solid; border-bottom-width: 2px; border-bottom-color: #dadada; border-bottom-style: solid; border-right-width: 2px; border-right-color: #dadada; border-right-style: solid;"
                                                                                        align="center"
                                                                                        bgcolor="#ffffff"
                                                                                        valign="top">
                                                                                        <table align="center"
                                                                                            border="0"
                                                                                            width="100%"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            style="min-width: 100%; text-align: center;"
                                                                                            role="presentation">
                                                                                            <!-- Social heading : BEGIN -->
                                                                                            <tbody>
                                                                                                <tr style=""
                                                                                                    align="center">
                                                                                                    <th class="column_footer_title "
                                                                                                        width="100%"
                                                                                                        style="mso-line-height-rule: exactly; padding-right: 5%; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Arial,'Karla'; font-size: 14px; line-height: 24px; font-weight: 400; color: #a3a1a1; text-transform: none;"
                                                                                                        align="center"
                                                                                                        bgcolor="#ffffff"
                                                                                                        valign="top">
                                                                                                        <p data-key="section_footer_title"
                                                                                                            style="mso-line-height-rule: exactly; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Arial,'Karla'; font-size: 14px; line-height: 24px; font-weight: 400; color: #a3a1a1; text-transform: none; margin: 0 0 13px;"
                                                                                                            align="center">
                                                                                                            Follow US</p>
                                                                                                    </th>
                                                                                                </tr>
                                                                                                <!-- Social heading : END -->
                                                                                                <!-- Store Address : BEGIN -->
                                                                                                <tr style=""
                                                                                                    align="center">
                                                                                                    <th class="column_shop_social_icons "
                                                                                                        width="100%"
                                                                                                        style="mso-line-height-rule: exactly; padding-right: 5%;"
                                                                                                        align="center"
                                                                                                        bgcolor="#ffffff"
                                                                                                        valign="top">
                                                                                                        <a class="social-link"
                                                                                                            href="https://www.facebook.com/vexmatech"
                                                                                                            target="_blank"
                                                                                                            title="Facebook"
                                                                                                            style="color: #0a72eb; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                            <img 
                                                                                                                class="social-icons"
                                                                                                                alt="Facebook"
                                                                                                                src="{{ image('logos/mail_icon/facebook_icon.png') }}"
                                                                                                                style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                        </a>
                                                                                                        <a class="social-link"
                                                                                                            href="https://www.linkedin.com/company/vexma-technologies-private-limtied"
                                                                                                            target="_blank"
                                                                                                            title="linkedin"
                                                                                                            style="color: #ecba78; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                            <img 
                                                                                                                class="social-icons"
                                                                                                                alt="linkdin"
                                                                                                                src="{{ image('logos/mail_icon/linkedin_icon.png') }}"
                                                                                                                style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                            <a class="social-link"
                                                                                                            href="https://instagram.com/vexmatech"
                                                                                                            target="_blank"
                                                                                                            title="Instagram"
                                                                                                            style="color: #ecba78; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                            <img 
                                                                                                                class="social-icons"
                                                                                                                alt="instagram"
                                                                                                                src="{{ image('logos/mail_icon/instagram_icon.png') }}"
                                                                                                                style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                                <a class="social-link"
                                                                                                            href="https://www.youtube.com/@Vexmatech"
                                                                                                            target="_blank"
                                                                                                            title="YouTube"
                                                                                                            style="color: #ecba78; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                            <img 
                                                                                                                class="social-icons"
                                                                                                                alt="youtube"
                                                                                                                src="{{ image('logos/mail_icon/youtube_icon.png') }}"
                                                                                                                style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                        </a>
                                                                                                        <a class="social-link"
                                                                                                        href="https://in.pinterest.com/vexmatech/pins/"
                                                                                                        target="_blank"
                                                                                                        title="pintrest"
                                                                                                        style="color: #0a72eb; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                        <img 
                                                                                                            class="social-icons"
                                                                                                            alt="pintrest"
                                                                                                            src="{{ image('logos/mail_icon/pinterest_icon.png') }}"
                                                                                                            style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                    </a>
                                                                                                    <a class="social-link"
                                                                                                        href="https://www.threads.net/@vexmatech"
                                                                                                        target="_blank"
                                                                                                        title="threds"
                                                                                                        style="color: #ecba78; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                        <img 
                                                                                                        class="social-icons"
                                                                                                        alt="thread"
                                                                                                        src="{{ image('logos/mail_icon/threads_icon.png') }}"
                                                                                                        style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                    </a>
                                                                                                    <a class="social-link"
                                                                                                        href="https://www.tumblr.com/vexmatech"
                                                                                                        target="_blank"
                                                                                                        title="tumblr"
                                                                                                        style="color: #ecba78; text-decoration: none !important; text-underline: none; font-size: 14px; text-align: center;">
                                                                                                        <img 
                                                                                                            class="social-icons"
                                                                                                            alt="tumblr"
                                                                                                            src="{{ image('logos/mail_icon/tumblr_icon.png') }}"
                                                                                                            style="width: 16px; height: auto !important; vertical-align: middle; text-align: center; padding: 6px 6px 0 0px;">
                                                                                                    </a>
                                                                                                    </th>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </th>
                                                                                    <!-- END : Column 1 of 2 : SOCIAL_BLOCK -->
                                                                                    <!-- BEGIN : Column 2 of 2 : SHOP_BLOCK -->
                                                                                    <th width="50%"
                                                                                        class="column_2_of_2 column_shop_block "
                                                                                        style="mso-line-height-rule: exactly; padding-top: 26px; padding-bottom: 26px; border-top-width: 2px; border-top-color: #dadada; border-top-style: solid; border-bottom-width: 2px; border-bottom-color: #dadada; border-bottom-style: solid;"
                                                                                        align="center"
                                                                                        bgcolor="#ffffff"
                                                                                        valign="top">
                                                                                        <table align="center"
                                                                                            border="0"
                                                                                            width="100%"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            style="min-width: 100%; text-align: center;"
                                                                                            role="presentation">
                                                                                            <!-- Store Address : BEGIN -->
                                                                                            <tbody>
                                                                                                <tr style=""
                                                                                                    align="center">
                                                                                                    <th class="column_shop_block2 "
                                                                                                        data-key="section_shop_block2"
                                                                                                        width="100%"
                                                                                                        style="mso-line-height-rule: exactly; padding-left: 5%; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Arial,'Karla'; font-size: 14px; line-height: 24px; font-weight: 400; color: #a3a1a1; text-transform: none;"
                                                                                                        align="center"
                                                                                                        bgcolor="#ffffff"
                                                                                                        valign="top">
                                                                                                        Vexma Technologies,<br
                                                                                                            style="text-align: center;">
                                                                                                         Old Chhani Road,Vadodara,
                                                                                                        <br
                                                                                                            style="text-align: center;">
                                                                                                         Gujarat - 390002<br
                                                                                                            style="text-align: center;">
                                                                                                        <br
                                                                                                            style="text-align: center;">
                                                                                                        Copyright © 2023
                                                                                                    </th>
                                                                                                </tr>
                                                                                                <!-- Store Address : END -->
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </th>
                                                                                    <!-- END : Column 2 of 2 : SHOP_BLOCK -->
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </th>
                                                                    <!-- END : 2 COLUMNS : SHOP_BLOCK -->
                                                                </tr>
                                                                <tr>
                                                                    <th data-id="store-info"
                                                                        style="mso-line-height-rule: exactly;"
                                                                        bgcolor="#ffffff">
                                                                        <table border="0" width="100%"
                                                                            cellpadding="0" cellspacing="0"
                                                                            role="presentation">
                                                                            <!-- Store Website : BEGIN -->
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th class="column_shop_block1 "
                                                                                        width="100%"
                                                                                        style="mso-line-height-rule: exactly; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Arial,'Karla'; font-size: 14px; line-height: 24px; font-weight: 400; color: #a3a1a1; text-transform: none; padding-bottom: 13px; padding-top: 26px;"
                                                                                        align="center"
                                                                                        bgcolor="#ffffff">
                                                                                        <a href="https://vexmatech.com/"
                                                                                            target="_blank"
                                                                                            data-key="section_shop_block1"
                                                                                            style="color: #0a72eb; text-decoration: none !important; text-underline: none; font-size: 14px; font-weight: 400; text-transform: none;">www.vexmatech.com</a>
                                                                                    </th>
                                                                                </tr>
                                                                                <!-- Store Website : END -->
                                                                            </tbody>
                                                                        </table>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th height="1" border="0"
                                                                        style="height: 1px; line-height: 1px; font-size: 1px; mso-line-height-rule: exactly; padding: 0;"
                                                                        bgcolor="#ffffff">
                                                                        <img id="open-image"
                                                                            src="https://us.tens.co/tools/emails/open/order-confirmation/1"
                                                                            alt="" width="1"
                                                                            height="1" border="0">
                                                                    </th>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td></tr>
        <tr>
            <td style="padding: 20px; background-color: #f5f5f5;">
                <p style="font-size: 12px; color: #999; text-align: center;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
