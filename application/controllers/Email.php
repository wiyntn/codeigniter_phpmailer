<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('email_view');
	}

	public function update_settings()
	{
		$jsonString = json_encode($_POST);
		header('content-type: application/json');
		if(file_put_contents('./assets/json/email_setting.json', $jsonString)){
			echo '{"status":"success"}';
		}else{
			echo '{"status":"failed"}';
		}
	}

	public function get_settings()
	{
		$jsonFile = file_get_contents('./assets/json/email_setting.json');
		header('content-type: application/json');
		echo $jsonFile;
	}

	public function send(){
		// Load Library
		$this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // Email Settings
        $jsonString = file_get_contents('./assets/json/email_setting.json');
        $mail_config = json_decode($jsonString, true);
      

         // SMTP configuration
        $mail->isSMTP();
        $mail->Host 		= $mail_config['email_host'];
        $mail->SMTPAuth 	= true;
        $mail->Username 	= $mail_config['email_username'];
        $mail->Password 	= $mail_config['email_password'];
        $mail->SMTPSecure 	= $mail_config['email_smtp'];
        $mail->Port     	= $mail_config['email_port'];

        $mail->setFrom('no-reply@email.com', 'Test Name');
        $mail->addAddress($_POST["mail_address"]);

        // Add a recipient
        // $mail->addAddress('john.doe@gmail.com');

        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject 		= 'Send Email via SMTP using PHPMailer in CodeIgniter';

        // Set email format to HTML
        $mail->isHTML(true);
        // $mail->AddEmbeddedImage($_SERVER['DOCUMENT_ROOT'].'/aos/assets/img/login_logo.png', 'logo');
        $mail->Body = $_POST["mail_message"];

        // Send email
        header('content-type: application/json');
        if(!$mail->send()){
        	echo '{"status":"failed","message":"'.$mail->ErrorInfo.'"}';
        }else{
            echo '{"status":"success","message":"Message has been sent"}';
        }

	}

}

/* End of file Email.php */
/* Location: ./application/controllers/Email.php */