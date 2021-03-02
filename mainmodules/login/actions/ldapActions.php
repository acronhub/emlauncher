<?php
require_once __DIR__.'/actions.php';
require_once APP_ROOT.'/model/UserPass.php';

class ldapActions extends loginActions
{
	public function executeLdap()
	{
		$username = mfwRequest::param('username');
		$password = mfwRequest::param('password');
		$ldap_host = $this->config['ldap_host'];
		$ldap_port = $this->config['ldap_port'];
		$ldap_dc   = $this->config['ldap_dc'];
		$ldap_ou   = $this->config['ldap_ou'];
		$ldap_cn   = $this->config['ldap_atr'] . '=' . $username;

		$email_domain = $this->config['ldap_email_domain'];

		$ldap_conn = ldap_connect($ldap_host); 
		ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

		if ($ldap_conn) {
			$ldap_bind  = ldap_bind($ldap_conn, $ldap_cn . "," . $ldap_ou . "," . $ldap_dc, $password);
			if ($ldap_bind) {
				// SUCCESS
		  } else {
				return $this->buildErrorPage('invalid username or password');
			}
			ldap_close($ldap_conn);
		} else {
			return $this->buildErrorPage('connect error');
		}
		User::login($username . $email_domain);
		return $this->redirectUrlBeforeLogin();
	}
}