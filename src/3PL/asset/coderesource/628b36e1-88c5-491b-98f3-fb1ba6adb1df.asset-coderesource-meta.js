

<script runat="server">
  Platform.Load("core","1");




  /************************* 
  --------- FORMS ----------
  **************************/


  var FORM_TEMPLATES = {

    //?form=master
    master: [
      "PRODUCT_INTEREST",
      "FIRST_NAME",
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "PHONE_NUMBER",
      "GRADE_LEVEL",
      "JOB_TITLE",
      "COUNTRY_NAME",
      "STATE_NAME",
      "POSTAL_CODE",
      "SCHOOL_NAME",
      "NO_OF_LICENCES",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ],

    //?form=basic
    required: [
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "SCHOOL_NAME",
      "COUNTRY_NAME",
      "STATE_NAME",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ],

    //?form=tof
    tof: [
    "PRODUCT_INTEREST",
      "FIRST_NAME",
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "JOB_TITLE",
      "COUNTRY_NAME",
      "STATE_NAME",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ],

    //?form=bof
    bof: [
      "FIRST_NAME",
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "PHONE_NUMBER",
      "JOB_TITLE",
      "COUNTRY_NAME",
      "STATE_NAME",
      "SCHOOL_NAME",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ],

    //?form=quote
    quote: [
      "PRODUCT_INTEREST",
      "FIRST_NAME",
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "COUNTRY_NAME",
      "STATE_NAME",
      "PHONE_NUMBER",
      "JOB_TITLE",
      "GRADE_LEVEL",
      "NO_OF_LICENCES",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ],

    //?form=trial
    trial: [
      "FIRST_NAME",
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "PHONE_NUMBER",
      "SCHOOL_NAME",
      "JOB_TITLE",
      "COUNTRY_NAME",
      "STATE_NAME",
      "POSTCODE",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ],
    
    demo: [
      "FIRST_NAME",
      "LAST_NAME",
      "EMAIL_ADDRESS",
      "PHONE_NUMBER",
      "SCHOOL_NAME",
      "JOB_TITLE",
      "COUNTRY_NAME",
      "STATE_NAME",
      "POSTCODE",
      "NO_OF_LICENCES",
      "TERMS_AND_CONDITIONS",
      "SUBSCRIBER_OPT_IN",
      "SUBMIT_BUTTON"
    ]
    
  }//FORM_TEMPLATE



  /*******************************
  ----- CHOOSE FORM TEMPLATE -----
  ********************************/


  //?form=( master | tof | bof )...etc
  var _form = Request.GetQueryStringParameter("form")
  _form = _form && _form.toLowerCase();
  if (_form) {
    var formFields = FORM_TEMPLATES[_form]
    for (var i=0; i<formFields.length; i++) {
      Variable.SetValue(formFields[i], "true");
    }//for
  }//if




  /************************************
  ----- &/OR CHOOSE SINGLE FIELDS -----
  *************************************/


  //?fields=etc,etc,etc
  var _fields = Request.GetQueryStringParameter("fields")
  _fields = _fields && _fields.toUpperCase().split(',');
  if (_fields) {
    for(var i=0; i<_fields.length; i++) {
      var _fields_field = _fields[i]
      Variable.SetValue(_fields_field, "true") 
    }//for    
  }//if




  /*******************************
  -- GENERAL REQUEST PARAMETER ---
  ********************************/


  Variable.SetValue('_Debug', Request.GetQueryStringParameter("debug")) 

  Variable.SetValue('_Campaign_Name', Request.GetQueryStringParameter("cid")) 
  Variable.SetValue('_Triggered_Send_Key', Request.GetQueryStringParameter("triggered_send_key")) 
  Variable.SetValue('_Redirect_To_Page', Request.GetQueryStringParameter("redirect_to_page")) 

  Variable.SetValue('_UTM_Source', Request.GetQueryStringParameter("utm_source")) 
  Variable.SetValue('_UTM_Medium', Request.GetQueryStringParameter("utm_medium")) 
  Variable.SetValue('_UTM_Campaign', Request.GetQueryStringParameter("utm_campaign")) 
  Variable.SetValue('_UTM_Content', Request.GetQueryStringParameter("utm_content")) 
  Variable.SetValue('_UTM_Term', Request.GetQueryStringParameter("utm_term")) 







  /*******************************
  ----------- SECURITY -----------
  ********************************/


  Platform.Response.SetResponseHeader("Strict-Transport-Security","max-age=200");
  Platform.Response.SetResponseHeader("X-XSS-Protection","1; mode=block");
  Platform.Response.SetResponseHeader("X-Frame-Options","Deny");
  Platform.Response.SetResponseHeader("X-Content-Type-Options","nosniff");
  Platform.Response.SetResponseHeader("Referrer-Policy","strict-origin-when-cross-origin");
  //Platform.Response.SetResponseHeader("Content-Security-Policy","default-src 'self'");


</script>
