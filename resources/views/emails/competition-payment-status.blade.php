<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $stageLabel }} Payment {{ $isVerified ? 'Verified' : 'Rejected' }} - Inception 2026</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #FBB137 0%, #B22A2A 50%, #4683B5 100%);
            padding: 32px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }
        .content {
            padding: 30px;
        }
        .badge {
            text-align: center;
            color: white;
            border-radius: 10px;
            padding: 16px;
            font-size: 20px;
            font-weight: 800;
            margin: 20px 0;
            background: {{ $isVerified ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #b91c1c 100%)' }};
        }
        .info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
        }
        .label {
            font-weight: 700;
            color: #374151;
        }
        .wa-box {
            margin-top: 24px;
            padding: 20px;
            border-radius: 10px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
        }
        .wa-link {
            display: inline-block;
            background: #25D366;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            margin-top: 10px;
        }
        .dummy-note {
            margin-top: 12px;
            padding: 10px;
            border-radius: 8px;
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fdba74;
            font-size: 12px;
        }
        .reason-box {
            margin-top: 16px;
            padding: 12px;
            border-radius: 8px;
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>INCEPTION 2026</h1>
            <p>{{ $stageLabel }} Payment Status Update</p>
        </div>

        <div class="content">
            <p>Hello {{ $leaderName }},</p>

            <div class="badge">
                {{ $stageLabel }} Payment {{ $isVerified ? 'VERIFIED' : 'REJECTED' }}
            </div>

            <div class="info">
                <div class="info-row"><span class="label">Team:</span> {{ $teamName }}</div>
                <div class="info-row"><span class="label">University:</span> {{ $university }}</div>
                <div class="info-row"><span class="label">Category:</span> {{ $categoryName }}</div>
                <div class="info-row"><span class="label">Stage:</span> {{ $stageLabel }}</div>
            </div>

            @if($isVerified)
                <p>Your {{ strtolower($stageLabel) }} payment has been verified successfully.</p>

                @if($groupLink)
                    <div class="wa-box">
                        <strong>WhatsApp Group Link</strong>
                        <br>
                        <a href="{{ $groupLink }}" target="_blank" class="wa-link">Join WhatsApp Group</a>

                        @if($isDummyLink)
                            <div class="dummy-note">
                                DUMMY LINK MARKER: This link still uses placeholder value (<strong>CHANGE_ME</strong>) and needs to be replaced by committee.
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <p>Your {{ strtolower($stageLabel) }} payment has been rejected. Please review the reason below and re-upload your payment proof.</p>

                @if($rejectionReason)
                    <div class="reason-box">
                        <strong>Rejection Reason:</strong><br>
                        {{ $rejectionReason }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</body>
</html>