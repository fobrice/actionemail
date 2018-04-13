var db = {
"Colmar": {
  "email": "Gilbert.meyer@ville-colmar.fr,contact@colmar.fr",
  "maire": "Monsieur Meyer"
},
"Schaffhouse": {
  "email":"mairie.schaffhouse@payszorn.com",
  "maire": "Monsieur Krauth"
}
};

var email_provider = {
 "gmail": {
   "baseurl": "https://mail.google.com/mail/u/0/?view=cm&fs=1&to=",
   "subject": "su"
 },
 "laposte": {
   "baseurl":"https://webmail.laposte.net/mail?view=compose&to="
 },
 "yahoo": {
    "baseurl":"http://compose.mail.yahoo.com/?to="
 },
 "thunderbird": {
    "baseurl":"mailto:"
 }

};

var htmlDecode = function(input) {
   var e = document.createElement('div');
   e.innerHTML = input;
   console.log(e);
   return e.innerText;
}

function chargerProviders(){
  o_providers = document.getElementById(context+"_providers");
  var keys = Object.keys(email_provider);
  var size = keys.length;
  for (i=0; i < size; i++) {
     key=keys[i];
     o_providers.innerHTML+="<div><a onClick=\"Javascript:generateLink('"+key+"');\">"+key+"</a></div>";
  }
}

function chargerMairies() {
   o_mairies = document.getElementById(context+"_mairies");
  var keys = Object.keys(db);
  var size = keys.length;
   for (i=0; i < size; i++) {
      key = keys[i];
      var option = document.createElement("option");
      option.value = key;
      option.text = key;
      o_mairies.add(option);
   }
}

function init_action_email() {
   chargerProviders();
   chargerMairies();
}

function generateLink(emailtype) {
   var selected = document.getElementById(context+"_mairies").value;
   var nom_maire = db[selected]["maire"];
   var ton_nom = document.getElementById(context+"_nom").value;
   console.log("SELECTED="+selected);
   jQuery.get( "/?rest_route=/wp/v2/pages/"+email_text, function( data ) {

   var text_raw = htmlDecode(data.content.rendered).replace("@NOMMAIRE@",nom_maire).replace("@TONNOM@", ton_nom);
   var subject = encodeURIComponent(htmlDecode(data.title.rendered));

   var baseurl=email_provider[emailtype]["baseurl"];
   var to = db[selected]["email"];
   var body = encodeURIComponent(text_raw.replace(/<[^>]+>/g, ''));

   var args=["bcc="+bcc,"subject="+subject,"body="+body].join("&");
   if ( emailtype == "gmail" ) {
      args  = args.replace("&subject=","&su=");
   }

   if (baseurl == "mailto:") {
      var url=baseurl+to+"?"+args;
   }
   else {   
     var url=baseurl+to+"&"+args;
   }
   console.log(url);
   var email_win = window.open(url,'_blank');
   email_win.focus();
   });
}
