# Codeigniter + PHPMailer

How to integrate PHPMailer with Codeigniter 3

> This code was originally written by [Stack Overflow - stevebaros](https://stackoverflow.com/users/3820244/stevebaros)

## Versions

Application used for creating the system.

|               |Developer                      |Version        |
|---------------|-------------------------------|---------------|
|CodeIgniter    |`EllisLab`                     |`3.2.0`        |
|PhpMailer      |`PHPMailer`                    |`6.1.3`        |
|PHP            |`PHP`                          |`5.6`          |


# Steps
Steps:
1.	Download the latest PhpMailer File on this link https://github.com/PHPMailer/PHPMailer
2.	Extract the file and copy to application/third_party/ folder and make the folder name to “phpmailer”
3.	The next steps will be creating of php files..


## Create files and folders

 **application/libraries/Phpmailer_lib.php** 
 

       <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        
        class PHPMailer_Lib
        {
        	public function __construct(){
        	    log_message('Debug', 'PHPMailer class is loaded.');
        	}
        
        	public function load(){
        	    // Include PHPMailer library files
        	    require_once APPPATH.'third_party/phpmailer/src/Exception.php';
        	    require_once APPPATH.'third_party/phpmailer/src/PHPMailer.php';
        	    require_once APPPATH.'third_party/phpmailer/src/SMTP.php';
        
        	    $mail = new PHPMailer(true);
        	    return $mail;
        	}
        }

    
 **application/controller/Email.php** 

       <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
            
        class Email extends CI_Controller{
        
            function  __construct(){
                parent::__construct();
            }
        
            function send(){
                // Load PHPMailer library
                $this->load->library('phpmailer_lib');
        
                // PHPMailer object
                $mail = $this->phpmailer_lib->load();
        
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host     = 'smtp.example.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'user@example.com';
                $mail->Password = '********';
                $mail->SMTPSecure = 'ssl';
                $mail->Port     = 465;
        
                $mail->setFrom('info@example.com', 'CodexWorld');
                $mail->addReplyTo('info@example.com', 'CodexWorld');
        
                // Add a recipient
                $mail->addAddress('john.doe@gmail.com');
        
                // Add cc or bcc 
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
        
                // Email subject
                $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';
        
                // Set email format to HTML
                $mail->isHTML(true);
        
                // Email body content
                $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
                    <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
                $mail->Body = $mailContent;
        
                // Send email
                if(!$mail->send()){
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }else{
                    echo 'Message has been sent';
                }
            }
        
        }
### Note
Ports, Host and SMTPSecure might not work on the production and test server. Please refer on the table below.

|SMTP| Port # | Description |
|--|--| --|
| tls |587  | You can use it on Test and Live Server|
| ssl|465| You can use it on Test Server Only|
| -|993| This port is set as default. You can use it on Live Server Only|

> :) Thanks!