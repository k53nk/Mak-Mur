<?php
error_reporting(0);
echo "\n";
awal:

    echo "\n[!] \e[0;32mGojek\e[0m\n";
    nohpKamu:
    echo "[!] No Hp +62 : ";
    $phoneNumber = trim(fgets(STDIN));
    echo "[!] Pin 6 dgt : ";
    $pingojek = trim(fgets(STDIN));
    echo "++++++++++++++++++++"."\n";
    echo "\n";
    $nama = explode(" ", nama());
    $nama1 = $nama[0];
    $nama2 = $nama[1];
    $rand = acak();

    $headers = [
        "Host: api.gojekapi.com",
        "X-Updater: 1",
        "X-Appid: com.go-jek.ios",
        "X-Phonemodel: Apple, iPhone13,4",
        "X-Phonemake: Apple",
        "Gojek-Service-Area: 1",
        "X-Location-Accuracy: 5.0",
        "Gojek-Country-Code: ID",
        "X-User-Locale: en_ID",
        "X-Platform: iOS",
        "Accept-Language: en-ID",
        "Gojek-Timezone: Asia/Jakarta",
        "X-Deviceos: iOS, 15.2",
        "X-Appversion: 4.34.0",
        "Accept: */*",
        "Content-Type: application/json",
        "X-Pushtokentype: APN",
        "X-User-Type: customer",
        "Connection: close",
    ];

    $data =
        '{"email":"' .
        $nama1 .
        "" .
        $nama2 .
        "" .
        $rand .
        '@gmail.com","name":"' .
        $nama1 .
        " " .
        $nama2 .
        '","phone":"+62' .
        $phoneNumber .
        '","signed_up_country":"ID"}';
    $register = curl("https://api.gojekapi.com/v5/customers", $data, $headers);
    $message = get_between($register[1], '"message":"', '","');
    $otpToken = get_between($register[1], '","otp_token":"', '","');
    if ($message == "This number is already registered.") {
        echo "[!] +62$phoneNumber : Nomor ini sudah terdaftar\n";
        goto nohpKamu;
    } elseif (
        $message ==
        "Your account will be unavailable for 24 hours because you’ve tried to register too many times."
    ) {
        echo "[!] +62$phoneNumber : Akun Anda tidak akan tersedia selama 24 jam karena Anda sudah mencoba mendaftar terlalu sering.\n";
        goto nohpKamu;
    } elseif (
        strpos(
            $register[1],
            "Enter the code we sent via SMS to your registered phone number"
        )
    ) {
        echo "[!] +62$phoneNumber : Otp terkirim\n";
    } elseif (
        $message ==
        "Your account will be unavailable for 1 hours because you’ve tried to register too many times."
    ) {
        echo "[!] +62$phoneNumber : Akun Anda tidak akan tersedia selama 1 jam karena Anda sudah mencoba mendaftar terlalu sering.\n";
        goto nohpKamu;
    } else {
        print_r($register);
    }
    $headers = [
        "Host: api.gojekapi.com",
        "X-Updater: 1",
        "X-Appid: com.go-jek.ios",
        "X-Phonemodel: Apple, iPhone13,4",
        "User-Agent: Gojek/4.34.0 (com.go-jek.ios; build:22264304; iOS 15.2.0) NetworkSDK/1.1.0",
        "X-Phonemake: Apple",
        "Gojek-Service-Area: 1",
        "X-Location-Accuracy: 5.0",
        "Gojek-Country-Code: ID",
        "Content-Length: 158",
        "X-Deviceos: iOS, 15.2",
        "X-Platform: iOS",
        "Accept-Language: en-ID",
        "Gojek-Timezone: Asia/Jakarta",
        "X-User-Locale: en_ID",
        "X-M1: 14:1642520822,12:D93C8B6FDD4D9A875B16B2F60757646942FE806B,13:ndUY984hngYamXbnui30kNUYStgWmeAgoqtzLdmK1DrWtM2GVFm995tw0QqUkzrscYMjMZjdpYsxDvJ2rmdNZd2jce6EIVurHUDCSMDwgEHGjyB0NdxVOaOBxR4MvAGYNM+Pe2OERknc/Ipv+K8bsIMZEAii8GxfLUtGNz3jiVgcfJsPVedwbxa5NaZyUimohZcKCjjeUzSOoUZLCgQebJK6iShMwzO5LiLhNZmsMBu7PJ2Tu7iPw2khoDF52hSBrLhMGQNT3yq4LAXlCozgURTz5SXP2+X4CvOPedWYIq3amqs6z7hbQ54mQMPCjtfBewZVoDaZK/P+cpfhg/RaJQ==",
        "X-Appversion: 4.34.0",
        "Accept: */*",
        "Content-Type: application/json",
        "X-Pushtokentype: APN",
        "X-User-Type: customer",
    ];

    otpCode:
    echo "[!] Kode OTP : ";
    $otpCode = trim(fgets(STDIN));

    $data =
        '{"client_name":"gojek:consumer:app","client_secret":"pGwQ7oi8bKqqwvid09UrjqpkMEHklb","data":{"otp":"' .
        $otpCode .
        '","otp_token":"' .
        $otpToken .
        '"}}';
    $verifOtp = curl(
        "https://api.gojekapi.com/v5/customers/phone/verify",
        $data,
        $headers
    );
    $message = get_between($verifOtp[1], '"message":"', '","');
    $token = get_between($verifOtp[1], '"access_token":"', '","expires_in"');
    $refresh = get_between($verifOtp[1], '"refresh_token":"', '",');
    if (strpos($message, "Seems like this code isn’t valid.")) {
        echo "[!] Otp salah.\n";
        goto otpCode;
    } elseif ($token) {
        echo "[!] $phoneNumber : Pendaftaran berhasil\n";
    } else {
        echo "[!] $phoneNumber : Pendaftaran gagal\n";
        goto akhir;
    }

    $headers = [
        "Host: goid.gojekapi.com",
        "X-Updater: 1",
        "X-Appid: com.go-jek.ios",
        "X-Phonemodel: Apple, iPhone13,4",
        "User-Agent: Gojek/4.34.0 (com.go-jek.ios; build:22264304; iOS 15.2.0) Alamofire/4.34.0",
        "X-Phonemake: Apple",
        "X-Uniqueid: C9F44D4A-367C-4729-B8BC-D68DDDCD7952",
        "Gojek-Service-Area: 1",
        "X-Location-Accuracy: 5.0",
        "Gojek-Country-Code: ID",
        "X-User-Locale: en_ID",
        "X-Deviceos: iOS, 15.2",
        "Authorization: Bearer " . $token . "",
        "Accept-Language: en-ID",
        "X-Platform: iOS",
        "Gojek-Timezone: Asia/Jakarta",
        "X-Signature: 1001",
        "X-Appversion: 4.34.0",
        "Accept: */*",
        "Content-Type: application/json",
        "X-Pushtokentype: APN",
        "X-User-Type: customer",
    ];

    $data =
        '{"client_id":"gojek:consumer:app","client_secret":"pGwQ7oi8bKqqwvid09UrjqpkMEHklb","data":{"refresh_token":"' .
        $refresh .
        '"},"grant_type":"refresh_token"}';
    $getToken = curl("https://goid.gojekapi.com/goid/token", $data, $headers);
    $token = get_between($getToken[1], '"access_token":"', '",');
    $headers = [
        "Host: customer.gopayapi.com",
        "X-Updater: 1",
        "X-Appid: com.go-jek.ios",
        "X-Phonemodel: Apple, iPhone13,4",
        "User-Agent: Gojek/4.34.0 (com.go-jek.ios; build:22264304; iOS 15.2.0) NetworkSDK/1.1.0",
        "X-Phonemake: Apple",
        "Gojek-Service-Area: 1",
        "X-Location-Accuracy: 5.0",
        "Gojek-Country-Code: ID",
        "X-User-Locale: en_ID",
        "X-Deviceos: iOS, 15.2",
        "Authorization: Bearer " . $token . "",
        "Accept-Language: en-ID",
        "X-Platform: iOS",
        "Gojek-Timezone: Asia/Jakarta",
        "X-Appversion: 4.34.0",
        "Accept: */*",
        "Content-Type: application/json",
        "X-Pushtokentype: APN",
        "X-User-Type: customer",
        "Connection: close",
    ];

    $data = '{"pin":"'.$pingojek.'"}';
    $setPin = curl(
        "https://customer.gopayapi.com/v1/users/pin",
        $data,
        $headers
    );
    if (strpos($setPin[1], "Your OTP is required to continue.")) {
        echo "[!] OTP terkirim\n";
    } else {
        echo "[!] OTP gagal terkirim\n";
    }
    anjayKamu:
    echo "[!] Kode OTP : ";
    $otpCode = trim(fgets(STDIN));
    $headers = [
        "Host: customer.gopayapi.com",
        "X-Updater: 1",
        "X-Appid: com.go-jek.ios",
        "X-Phonemodel: Apple, iPhone13,4",
        "User-Agent: Gojek/4.34.0 (com.go-jek.ios; build:22264304; iOS 15.2.0) NetworkSDK/1.1.0",
        "X-Phonemake: Apple",
        "Gojek-Service-Area: 1",
        "X-Location-Accuracy: 5.0",
        "Gojek-Country-Code: ID",
        "X-User-Locale: en_ID",
        "X-Deviceos: iOS, 15.2",
        "OTP: " . $otpCode . "",
        "Authorization: Bearer " . $token . "",
        "Accept-Language: en-ID",
        "X-Platform: iOS",
        "Gojek-Timezone: Asia/Jakarta",
        "X-Appversion: 4.34.0",
        "Accept: */*",
        "Content-Type: application/json",
        "X-Pushtokentype: APN",
        "X-User-Type: customer",
        "Connection: close",
    ];

    $data = '{"pin":"'.$pingojek.'"}';
    $setPin2 = curl(
        "https://customer.gopayapi.com/v1/users/pin",
        $data,
        $headers
    );
    if (strpos($setPin2[1], "Wrong OTP code")) {
        echo "[!] Otp salah\n";
        goto anjayKamu;
    } else {
        echo "[!] $setPin2[1]\n";
    }
    akhir:
    echo "++++++++++++++++++++"."\n";
    echo "\n";
    goto awal;


function get(){
	return trim(fgets(STDIN));
}

function get_between($string, $start, $end) 
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

function get_between_array($string, $start, $end) {
        $aa = explode($start, $string);
        for ($i=0; $i < count($aa) ; $i++) { 
            $su = explode($end, $aa[$i]);
            $uu[] = $su[0];
        }
        unset($uu[0]);
        $uu = array_values($uu);
        return $uu;
}
function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}
function acak()
{
    $string .= rand(0, 10000);
    return $string;
}
function curl($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curltor($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_PROXY, "http://127.0.0.1:9150/");
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curlget($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curlgettor($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_PROXY, "http://127.0.0.1:9150/");
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curlPut($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array();
  foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curlPuttor($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	curl_setopt($ch, CURLOPT_PROXY, "http://127.0.0.1:9150/");
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array();
  foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}


class Colors {
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct() {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors() {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }
}

function multicurl($arrayreq){
	$mh = curl_multi_init();
    $curl_array = array();
	for($i=0;$i<count($arrayreq);$i++){
		$curl_array[$i] = curl_init();
		curl_setopt($curl_array[$i], CURLOPT_URL, $arrayreq[$i][0]);
		curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
		if($arrayreq[$i][1]!=null){
			curl_setopt($curl_array[$i], CURLOPT_POSTFIELDS, $arrayreq[$i][1]);
		}
		curl_setopt($curl_array[$i], CURLOPT_CUSTOMREQUEST, $arrayreq[$i][2]);
		if($arrayreq[$i][3]!=null){
			curl_setopt($curl_array[$i], CURLOPT_HTTPHEADER, $arrayreq[$i][3]);
		}
		
		curl_setopt($curl_array[$i], CURLOPT_HEADER, true);	
		curl_setopt($curl_array[$i], CURLOPT_HEADER, true);	
		curl_setopt($curl_array[$i], CURLOPT_ENCODING, 'gzip');
		curl_multi_add_handle($mh, $curl_array[$i]);
	}
	$running = NULL;
    do{
        curl_multi_exec($mh,$running);
    }
	while($running > 0);
	for($i=0;$i<count($arrayreq);$i++){
		$header_size = curl_getinfo($curl_array[$i], CURLINFO_HEADER_SIZE);
		$body []= substr(curl_multi_getcontent($curl_array[$i]),$header_size);
	}
	for($i=0;$i<count($arrayreq);$i++){
	 curl_multi_remove_handle($mh, $curl_array[$i]);
    }
	return $body;		
}
function request($url, $param, $headers=null, $request = 'POST',$cookie=null,$followlocation=0,$proxy=null,$port=null) {
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
		if($param!=null){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		}
		if($headers!=null){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}	
		if($port!=null){
			curl_setopt($ch, CURLOPT_PORT, $port);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		}
		elseif($port==null){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		if($cookie!=null){
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		}
		if($proxy!=null){
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		}
		if($followlocation==1){
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$execute = curl_exec($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($execute, 0, $header_size);
		$body = substr($execute, $header_size);
		curl_close($ch);
		return [$header,$body];
}