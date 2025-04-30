<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Billing Summary</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="background-image: url('https://png.pngtree.com/background/20230303/original/pngtree-light-blue-abstract-background-vector-picture-image_2079640.jpg'); background-size: cover; padding: 60px 0;">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background: rgba(255,255,255,0.95); border-radius: 10px;">
            <tr>
                <td style="padding: 30px; text-align: center; font-family: Arial, sans-serif;">
                    <h1>Hello {{ $data['first_name'] }} {{ $data['last_name'] }}</h1>
                    <p>Your billing summary is attached as a PDF.</p>

                    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">Bungalow No</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['hno'] }} {{ $data['area'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">Total Units</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['total_units'] }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">Amount Payable</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">₹{{ number_format($data['grossTotal'], 2) }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">Payment Link</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $data['payment_link'] }}</td>
                        </tr>
                    </table>
                    <p style="margin-top: 30px;">If you have any questions regarding your bill, feel free to reach out.</p>
                    <p>Thanks,<br><strong>Billing Team</strong></p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
