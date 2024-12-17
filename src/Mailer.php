<?php
class Mailer {
    private $to;
    private $subject;
    private $message;
    private $headers;

    // Constructor to initialize the mail details
    public function __construct($to, $subject, $message, $headers = '') {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    // Set email recipient
    public function setRecipient($to) {
        $this->to = $to;
    }

    // Set email subject
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    // Set email message body
    public function setMessage($message) {
        $this->message = $message;
    }

    // Set custom headers (optional)
    public function setHeaders($headers) {
        $this->headers = $headers;
    }

    // Send the email
    public function send():bool {
        // Default headers if none are provided
        if (empty($this->headers)) {
            $this->headers = "MIME-Version: 1.0" . "\r\n" .
                             "Content-Type: text/html; charset=UTF-8" . "\r\n" .
                             "From: no-reply@yourdomain.com" . "\r\n" .
                             "Reply-To: no-reply@yourdomain.com" . "\r\n";
        }

        // Use PHP's mail() function to send the email
        return mail($this->to, $this->subject, $this->message, $this->headers);
    }
}
