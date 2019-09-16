
function getBaseURL(){
	return "http://localhost:81/portal1/";
	// return "https://www.abacare.com/hermes/";
	// return "http://dev.abacare.com/abvt/";
}

function getAPIURL(){
	return getBaseURL() + "api/";
}

function getAbbreviationAPIURL(){
	return getAPIURL() + "abbreviations.php";
}

function getabaPeopleAPIURL(){
	return getAPIURL() + "abapeople.php";
}
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
function getDayOfDate(string){
	var dt = new Date(string);
	return dt.getDay();
}

function UCFirst(string) 
{
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function otlk(){
	var appId = '1738770e-d06a-453f-815e-600335e51488';
  	var redirectUri = 'http://localhost:81/portal1/leadssync.php';
  	apparr = { "appid":appId, "redirecturi":redirectUri };

  	return apparr;
}
function addCommas(x) {
	if(x == "" || x == null){
		return x;
	}else{
	    var parts = x.toString().split(".");
	    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    return parts.join(".");
	}
}