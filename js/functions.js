function isValidEmailAddress(email) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(email);
}
function isURL(string) {
	var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
	if (res == null){
		return false;
	}else{
		return true;
	}
}
function isDate(string){
	var bol = true;
	if(new Date(string) == "Invalid Date"){
		bol = false;
	}
	return bol;
}
function encrypt( $key, $plaintext, $meta = '' ) {
	// Generate valid key
	$key = hash_pbkdf2( 'sha256', $key, '', 10000, 0, true );
	// Serialize metadata
	$meta = serialize($meta);
	// Derive two subkeys from the original key
	$mac_key = hash_hmac( 'sha256', 'mac', $key, true );
	$enc_key = hash_hmac( 'sha256', 'enc', $key, true );
	$enc_key = substr( $enc_key, 0, 32 );
	// Derive a "synthetic IV" from the nonce, plaintext and metadata
	$temp = $nonce = ( 16 > 0 ? mcrypt_create_iv( 16 ) : "" );
	$temp .= hash_hmac( 'sha256', $plaintext, $mac_key, true );
	$temp .= hash_hmac( 'sha256', $meta, $mac_key, true );
	$mac = hash_hmac( 'sha256', $temp, $mac_key, true );
	$siv = substr( $mac, 0, 16 );
	// Encrypt the message
	$enc = mcrypt_encrypt( 'rijndael-128', $enc_key, $plaintext, 'ctr', $siv );
	return base64_encode( $siv . $nonce . $enc );
}