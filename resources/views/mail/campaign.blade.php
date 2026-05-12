@php
    $appName = $appName ?? config('app.name', 'Laravel');
    $appUrl = $appUrl ?? rtrim((string) config('app.url', ''), '/');
    $headerSubtitle = $headerSubtitle ?? '';
    $logoUrl = $logoUrl ?? null;
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ $appName }}</title>
    <style type="text/css">
        @media only screen and (max-width: 600px) {
            .inner-body { width: 100% !important; }
            .content-padding { padding: 24px !important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#edf2f7;-webkit-text-size-adjust:100%;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
    @if (! empty($preheader))
        <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;">{{ $preheader }}</div>
    @endif

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#edf2f7;">
        <tr>
            <td align="center" style="padding:40px 16px;">
                {{-- Laravel-style card: border, radius, shadow --}}
                <table role="presentation" class="inner-body" cellspacing="0" cellpadding="0" border="0" width="570" style="width:100%;max-width:570px;background-color:#ffffff;border-radius:4px;border:1px solid #e4e4e7;box-shadow:0 1px 3px 0 rgba(0,0,0,0.1),0 1px 2px -1px rgba(0,0,0,0.1);overflow:hidden;">

                    {{-- Royal blue header (like Laravel notifications) --}}
                    <tr>
                        <td style="background-color:#3869d1;padding:24px 32px;text-align:left;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
                                <tr>
                                    @if (! empty($logoUrl))
                                        <td style="vertical-align:middle;padding-right:14px;width:1%;">
                                            @if ($appUrl !== '')
                                                <a href="{{ $appUrl }}" style="text-decoration:none;border:0;">
                                                    <img src="{{ $logoUrl }}" alt="{{ $appName }}" width="120" style="max-height:48px;width:auto;height:auto;display:block;border:0;outline:none;">
                                                </a>
                                            @else
                                                <img src="{{ $logoUrl }}" alt="{{ $appName }}" width="120" style="max-height:48px;width:auto;height:auto;display:block;border:0;outline:none;">
                                            @endif
                                        </td>
                                    @endif
                                    <td style="vertical-align:middle;">
                                        @if ($appUrl !== '')
                                            <a href="{{ $appUrl }}" style="color:#ffffff;font-size:19px;font-weight:bold;text-decoration:none;display:inline-block;">
                                                {{ $appName }}
                                            </a>
                                        @else
                                            <span style="color:#ffffff;font-size:19px;font-weight:bold;text-decoration:none;">
                                                {{ $appName }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            @if ($headerSubtitle !== '')
                                <p style="margin:10px 0 0 0;padding:0;color:#e8f2ff;font-size:15px;font-weight:normal;line-height:1.45;">
                                    {{ $headerSubtitle }}
                                </p>
                            @endif
                        </td>
                    </tr>

                    {{-- White body: main heading + dynamic HTML --}}
                    <tr>
                        <td class="content-padding" style="padding:32px;">
                            <h1 style="margin:0 0 18px 0;padding:0;color:#3d4852;font-size:18px;font-weight:bold;text-align:left;line-height:1.35;">
                                {{ $subject }}
                            </h1>

                            <div style="color:#52525b;font-size:16px;line-height:1.5em;text-align:left;">
                                {!! $body !!}
                            </div>

                            @if (! empty($fallbackUrl))
                                <p style="margin:28px 0 0 0;padding:0;font-size:14px;line-height:1.55;color:#52525b;border-top:1px solid #e4e4e7;padding-top:22px;">
                                    If the button does not work, copy and paste this URL into your browser:
                                </p>
                                <p style="margin:10px 0 0 0;padding:0;font-size:14px;line-height:1.5;">
                                    <a href="{{ $fallbackUrl }}" style="color:#3869d1;word-break:break-all;">{{ $fallbackUrl }}</a>
                                </p>
                            @endif

                            <p style="margin:24px 0 0 0;padding:0;font-size:14px;line-height:1.55;color:#718096;">
                                If you did not expect this message, no further action is required.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer strip --}}
                    <tr>
                        <td style="padding:18px 32px;background-color:#fafafa;border-top:1px solid #e4e4e7;text-align:center;">
                            <p style="margin:0;color:#a1a1aa;font-size:12px;line-height:1.5;">
                                © {{ date('Y') }} {{ $appName }}. All rights reserved.
                            </p>
                            @if ($appUrl !== '')
                                <p style="margin:8px 0 0 0;">
                                    <a href="{{ $appUrl }}" style="color:#a1a1aa;font-size:12px;text-decoration:underline;">{{ $appUrl }}</a>
                                </p>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
