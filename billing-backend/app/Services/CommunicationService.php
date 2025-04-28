<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CommunicationService
{
    protected $sid;
    protected $token;
    protected $smsFrom;
    protected $whatsappFrom;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->smsFrom = config('services.twilio.sms_from');
        $this->whatsappFrom = config('services.twilio.whatsapp_from');
    }

    public function sendMessage(string $to, string $message, bool $isWhatsApp = false, string $mediaUrl = null): array
    {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json";
        $from = $isWhatsApp ? $this->whatsappFrom : $this->smsFrom;
        $toFormatted = $isWhatsApp ? "whatsapp:+91{$to}" : "+91{$to}";
    
        $formData = [
            'From' => $from,
            'To' => $toFormatted,
            'Body' => $message,
        ];
    
        if ($mediaUrl && $isWhatsApp) {
            $formData['MediaUrl'] = $mediaUrl;
        }
    
        $response = Http::withBasicAuth($this->sid, $this->token)
            ->asForm()
            ->post($url, $formData);
    
        $responseData = $response->json();
         dd($responseData);
        if (isset($responseData['sid'])) {
            $status = $this->checkMessageStatus($responseData['sid']);
            Log::info('Message Status:', $status);
        }
    
        return $responseData;
    }
    
    public function checkMessageStatus(string $sid)
    {
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages/{$sid}.json";
        $response = Http::withBasicAuth($this->sid, $this->token)->get($url);
        return $response->json();
    }

    public function sendBillingMessages(string $name, string $phoneNumber, string $email, string $pdfFileName)
    {
    $downloadLink = asset('storage/billing_pdfs/' . $pdfFileName);
    $name = $name;
    $email = $email;
    $number = $phoneNumber;
    $date = date('d-m-Y');

    $message = "Dear $name,

    We hope you're doing well. Your electricity bill has been generated on $date.

    📄 *Bill Details*:
    • Name: $name  
    • Email: $email  
    • Mobile: $number

    🔗 You can download your bill from the link below, or check WhatsApp for the attached PDF:  
    $downloadLink

    Thank you for choosing our service.

    Warm regards,  
    Electricity Board";

    $this->sendMessage($phoneNumber, $message . ' ' . $downloadLink, false);
    $this->sendMessage($phoneNumber, $message, true, $downloadLink);
}

}
