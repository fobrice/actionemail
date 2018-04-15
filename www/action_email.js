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

function chargerContacts() {
   o_contact = document.getElementById(context+"_contact");
  var keys = Object.keys(actionemail_data);
  var size = keys.length;
   for (i=0; i < size; i++) {
      key = keys[i];
      var option = document.createElement("option");
      option.value = key;
      option.text = key;
      o_contact.add(option);
   }
}

function init_action_email() {
   chargerProviders();
   chargerContacts();
}

function generateLink(emailtype) {
   var selected = document.getElementById(context+"_contact").value;
   var contact_name = actionemail_data[selected]["contact_name"];
   var ton_nom = document.getElementById(context+"_nom").value;
   console.log("SELECTED="+selected);

   var content_email = document.getElementById(context+"_content_email").innerHTML;
   console.log(context+"_content_email");
   console.log(content_email.innerHTML);
   return 1;
   var text_raw = htmlDecode(content_email).replace("@NOMCONTACT@",contact_name).replace("@TONNOM@", ton_nom);
   var subject = encodeURIComponent(htmlDecode(content_email));

   var baseurl=email_provider[emailtype]["baseurl"];
   var to = actionemail_data[selected]["email"];
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

}
