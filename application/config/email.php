 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 $config['protocol'] = 'smtp';
 $config['smtp_host'] = 'ssl://smtpout.asia.secureserver.net';
 $config['smtp_port'] = '465';
 $config['smtp_user'] = 'donotreply@zakuna.co';
 $config['smtp_pass'] = 'zakuna88';
 /*
 $config['smtp_host'] = 'ssl://smtp.gmail.com';
 $config['smtp_port'] = '465';
 $config['smtp_user'] = 'epos.zakuna@gmail.com';
 $config['smtp_pass'] = '3p05@ZAKUNA';
 */
 //$config['smtp_host'] = 'localhost';
 //$config['smtp_port'] = '25';
 //$config['protocol'] = 'sendmail';
 //$config['mailpath'] = '/usr/sbin/sendmail'; 
 $config['mailtype'] = 'html'; 
 $config['charset'] = 'iso-8859-1';
 $config['wordwrap'] = TRUE; 
 $config['smtp_timeout']='10';
 $config['newline'] = "\r\n";
 $config['crlf'] = "\r\n";