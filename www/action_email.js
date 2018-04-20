var email_provider = {
 "gmail": {
   "baseurl": "https://mail.google.com/mail/u/0/?view=cm&fs=1&to=",
   "subject": "su"
 },
 "yahoo": {
    "baseurl":"http://compose.mail.yahoo.com/?to="
 },
 "laposte": {
   "baseurl":"https://webmail.laposte.net/mail?view=compose&to="
 },
 "thunderbird": {
    "baseurl":"mailto:"
 },
 "outlook": {
    "baseurl":"mailto:"
 },
 "logiciel de courriel": {
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
     o_providers.innerHTML+="<div class=\"provider\"><a onClick=\"Javascript:generateLink('"+key+"');\">"+key+"</a></div>";
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
   if (document.getElementById(context+"_contact"))
      chargerContacts();
}

function generateText() {
  var email_tpl = document.getElementById(context+"_content_email_template").value;
  var obj_email_txt = document.getElementById(context+"_content_email");
  var text_raw = email_tpl;

  if (document.getElementById(context+"_contact")) {
    var selected = document.getElementById(context+"_contact").value;
    var contact_name = actionemail_data[selected]["contact_name"];
    var text_raw = text_raw.replace("@NOMCONTACT@",contact_name);
  }

  var ton_nom = document.getElementById(context+"_nom").value;
  var text_raw = text_raw.replace("@TONNOM@", ton_nom);
  obj_email_txt.value = text_raw;
}

function generateLink(emailtype) {
  if (document.getElementById(context+"_contact")) {
    var selected = document.getElementById(context+"_contact").value;
  }
  else {
    selected=Object.keys(actionemail_data)[0];
  }
  var content_email = document.getElementById(context+"_content_email").value;

   console.log(content_email.value);

   var subject = encodeURIComponent(document.getElementById(context+"_subject").value);

   var baseurl=email_provider[emailtype]["baseurl"];
   var to = actionemail_data[selected]["email"];
   var body = encodeURIComponent(content_email);

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
