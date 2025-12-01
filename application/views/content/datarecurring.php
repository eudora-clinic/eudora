<?php
$token = $this->session->userdata('token');

echo $token;
if ($token) {
	list($header, $payload, $signature) = explode('.', $token);
	$payload = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

	if (isset($payload['exp'])) {
		$exp = $payload['exp'];
		if ($exp < time()) {
			echo "Token expired at " . date('Y-m-d H:i:s', $exp);
		} else {
			echo "Token valid until " . date('Y-m-d H:i:s', $exp);
		}
	} else {
		echo "Token tidak punya exp.";
	}
}else{
	echo "Tidak ada token.";
}



?>