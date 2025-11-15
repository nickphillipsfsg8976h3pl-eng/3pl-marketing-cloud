<script>
  /**
   * =========== REUSABLE FORM =============
   * 
   * Query Parameters
   * -----------------
   *
   * @parameter: cid - the salesforce campaign id where the lead will be attached
   * @parameter: rid - the id of a redirect url located in marketing cloud
   * @parameter: pid - the 3P Learning product name (ie. mathletics, readingeggs etc)
   * @parameter: gclid - ???
   * 
   * @parameter: template - the name of a template used to display preconfigured form inputs
   * @parameter: inputs - a list of individual form inputs to display
   * 
   */
</script>

<script runat="server" executioncontexttype="Post">
  Platform.Load("core", "1");
  /**
   * POST-SSJS
   * @description: ssjs that runs when the form is submitted on the backend
   */

  try {

  } catch (error) {
    Write("Error: " + Stringify(error.message));
  }
</script>


<script runat="server" executioncontexttype="Get">
  Platform.Load("core", "1");
  /**
   * GET-SSJS
   * @description: ssjs that runs when the form is displayed on the frontend
   */

  try {

    /************************* 
    --------- TEMPLATES ------
    **************************/


    var TEMPLATES = {

      //?template=test
      test: [
        "PRODUCT_INTEREST",
        "USER_INTEREST",
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "PHONE_NUMBER",
        "GRADE_LEVEL",
        "JOB_TITLE",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "SCHOOL_NAME",
        "NO_OF_LICENCES",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=test_half
      test_half: [
        "PRODUCT_INTEREST_HALF",
        "USER_INTEREST_HALF",
        "FIRST_NAME_HALF",
        "LAST_NAME_HALF",
        "EMAIL_ADDRESS_HALF",
        "PHONE_NUMBER_HALF",
        "GRADE_LEVEL_HALF",
        "JOB_TITLE_HALF",
        "COUNTRY_NAME_HALF",
        "STATE_PROVINCE_NAME_HALF",
        "POSTCODE_ZIPCODE_HALF",
        "SCHOOL_NAME_HALF",
        "NO_OF_LICENCES_HALF",
        "TERMS_AND_CONDITIONS_HALF",
        "SUBSCRIBER_OPT_IN_HALF",
        "SUBMIT_BUTTON"
      ],

      test_states: [
        "COUNTRY_NAME",
        "COUNTRY_NAME_HALF",
        "STATE_PROVINCE_NAME",
        "STATE_PROVINCE_NAME_HALF",
        "STATE_PROVINCE_NAME_AU",
        "STATE_PROVINCE_NAME_AU_HALF",
        "STATE_PROVINCE_NAME_NZ",
        "STATE_PROVINCE_NAME_NZ_HALF",
        "STATE_PROVINCE_NAME_US",
        "STATE_PROVINCE_NAME_US_HALF",
        "STATE_PROVINCE_NAME_CA",
        "STATE_PROVINCE_NAME_CA_HALF",
        "STATE_PROVINCE_NAME_ZA",
        "STATE_PROVINCE_NAME_ZA_HALF"
      ],

      //?template=basic
      required: [
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "SCHOOL_NAME",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=tof
      tof: [
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "JOB_TITLE",
        "SCHOOL_NAME",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=bof
      bof: [
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "PHONE_NUMBER",
        "JOB_TITLE",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "SCHOOL_NAME",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=quote
      quote: [
        "PRODUCT_INTEREST",
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "SCHOOL_NAME",
        "PHONE_NUMBER",
        "JOB_TITLE",
        "GRADE_LEVEL",
        "NO_OF_LICENCES",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=us_form
      us_form: [
        "PRODUCT_INTEREST",
        "USER_INTEREST",
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "SCHOOL_NAME",
        "PHONE_NUMBER",
        "JOB_TITLE",
        "GRADE_LEVEL",
        "NO_OF_LICENCES",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=trial
      trial: [
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "PHONE_NUMBER",
        "SCHOOL_NAME",
        "JOB_TITLE",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=info
      info: [
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "PHONE_NUMBER",
        "SCHOOL_NAME",
        "JOB_TITLE",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ],

      //?template=demo
      demo: [
        "FIRST_NAME",
        "LAST_NAME",
        "EMAIL_ADDRESS",
        "PHONE_NUMBER",
        "SCHOOL_NAME",
        "JOB_TITLE",
        "COUNTRY_NAME",
        "STATE_PROVINCE_NAME",
        "POSTCODE_ZIPCODE",
        "NO_OF_LICENCES",
        "TERMS_AND_CONDITIONS",
        "SUBSCRIBER_OPT_IN",
        "SUBMIT_BUTTON"
      ]

    } //TEMPLATES



    /**************************************
    ----- CHOOSE COMPONENTS TO RENDER -----
    ***************************************/


    // CONSTANTS
    var COMPONENTS_TO_RENDER = [];


    // ADD ALL TEMPLATE COMPONENTS
    var templateQueryParameter = Request.GetQueryStringParameter("template")
    if (templateQueryParameter) {
      var templateComponentList = TEMPLATES[templateQueryParameter.toLowerCase()];
      COMPONENTS_TO_RENDER = COMPONENTS_TO_RENDER.concat(templateComponentList);
    } //if


    // ADD SINGLE INPUT COMPONENTS
    var inputs = Request.GetQueryStringParameter("inputs")
    if (inputs) {
      var singleInputList = inputs.toUpperCase().split(',');
      for (var i = 0; i < singleInputList.length; i++) {
        var singleInput = singleInputList[i];
        COMPONENTS_TO_RENDER.push(singleInput);
      } //for    
    } //if


    // PASS COMPONENTS TO AMPSCRIPT
    Variable.SetValue("COMPONENTS_TO_RENDER", COMPONENTS_TO_RENDER);


    /*******************************
    -- GENERAL REQUEST PARAMETER ---
    ********************************/


    Variable.SetValue('debug', Request.GetQueryStringParameter("debug"))

    Variable.SetValue('cid', Request.GetQueryStringParameter("cid"))
    Variable.SetValue('rid', Request.GetQueryStringParameter("rid"))
    Variable.SetValue('pid', Request.GetQueryStringParameter("pid"))
    Variable.SetValue('gclid', Request.GetQueryStringParameter("gclid"))

    Variable.SetValue('utm_source', Request.GetQueryStringParameter("utm_source"))
    Variable.SetValue('utm_medium', Request.GetQueryStringParameter("utm_medium"))
    Variable.SetValue('utm_campaign', Request.GetQueryStringParameter("utm_campaign"))
    Variable.SetValue('utm_content', Request.GetQueryStringParameter("utm_content"))
    Variable.SetValue('utm_term', Request.GetQueryStringParameter("utm_term"))

    Variable.SetValue('template', Request.GetQueryStringParameter("template"))
    Variable.SetValue('inputs', Request.GetQueryStringParameter("inputs"))


    /*******************************
    ----------- SECURITY -----------
    ********************************/


    // Platform.Response.SetResponseHeader("X-Frame-Options","Deny");
    // Platform.Response.SetResponseHeader("Content-Security-Policy","default-src 'self'");
    Platform.Response.SetResponseHeader("Strict-Transport-Security", "max-age=200");
    Platform.Response.SetResponseHeader("X-XSS-Protection", "1; mode=block");
    Platform.Response.SetResponseHeader("X-Content-Type-Options", "nosniff");
    Platform.Response.SetResponseHeader("Referrer-Policy", "strict-origin-when-cross-origin");


  } catch (error) {
    Write("Error: " + Stringify(error.message));
  }
</script>


<!-- =============================== HTML =============================== -->


<!doctype html>
<html lang="en">


<head>


  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-T97DM2H');
  </script>


  <!-- Meta/SEO -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Form">


  <!-- Title & Favicons -->
  <title> 3PLearning </title>
  <link rel="shortcut icon" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-16px.png" type="image/x-icon">
  <link rel="apple-touch-icon-precomposed" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-57px.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-114px.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-72px.png">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-144.png">


  <!-- CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


  <!-- Styles -->
  <style>
    :root {
      font-size: 16px;
    }

    .custom-reset-select-text {
      color: #495057c7;
      font-weight: 400;
    }
  </style>


</head>


<!-- =============================== BODY =========================== -->


<body>


  <form
    class="needs-validation"
    novalidate
    method="POST">


    <!------------- Hidden ----------------->


    <input type="hidden" name="_debug" value="%%=v(@debug)=%%">

    <input type="hidden" name="_triggered_send_key" value="%%=v(@triggered_send_key)=%%">

    <input type="hidden" name="_cid" value="%%=v(@cid)=%%">
    <input type="hidden" name="_pid" value="%%=v(@pid)=%%">
    <input type="hidden" name="_eid" value="%%=v(@eid)=%%">
    <input type="hidden" name="_rid" value="%%=v(@rid)=%%">
    <input type="hidden" name="_gclid" value="%%=v(@gclid)=%%">

    <input type="hidden" name="_utm_source" value="%%=v(@utm_source)=%%">
    <input type="hidden" name="_utm_medium" value="%%=v(@utm_medium)=%%">
    <input type="hidden" name="_utm_campaign" value="%%=v(@utm_campaign)=%%">
    <input type="hidden" name="_utm_content" value="%%=v(@utm_content)=%%">
    <input type="hidden" name="_utm_term" value="%%=v(@utm_term)=%%">

    <input type="hidden" name="_template" value="%%=v(@template)=%%">
    <input type="hidden" name="_components" value="%%=v(@inputs)=%%">

    <input type="hidden" name="_referrer">
    <input type="hidden" name="_url">

    <script>
      // assign the form or website url to the hidden _url input
      document.querySelector('input[name="_url"]').value = location.href;
    </script>


    <!------------- Form ----------------->


    <!-- Wrapper -->
    <div class=" container my-5">
      <div class="form-row">


        %%[
        /***********************************
        START LOOPING OVER RENDER COMPONENTS
        ************************************/
        SET @LENGTH = ROWCOUNT(@COMPONENTS_TO_RENDER)
        FOR @index = 1 TO @LENGTH DO
        SET @COMPONENT = ROW(@COMPONENTS_TO_RENDER, @index)
        ]%%



        %%[IF (@COMPONENT == "PRODUCT_INTEREST") THEN]%%
        <!------------- Product Interest ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control selectpicker show-tick custom-reset-select-text"
              id="_product_interest"
              name="_product_interest"
              multiple
              title="Product Interests"
              data-selected-text-format="values"
              data-actions-box="true"
              required>

              <option value="mathletics">Mathletics</option>
              <option value="mathseeds">Mathseeds</option>
              <option value="readingEggs">Reading Eggs</option>

            </select>

            <div id="product_interest_invalid_feedback" class="invalid-feedback">Please select the products you are interested in</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "PRODUCT_INTEREST_HALF") THEN]%%
        <!------------- Product Interest HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control selectpicker show-tick custom-reset-select-text"
              id="_product_interest"
              name="_product_interest"
              multiple
              title="Product Interest"
              data-selected-text-format="values"
              data-actions-box="true"
              required>

              <option value="mathletics">Mathletics</option>
              <option value="mathseeds">Mathseeds</option>
              <option value="readingEggs">Reading Eggs</option>

            </select>

            <div id="product_interest_invalid_feedback" class="invalid-feedback">Please select the products you are interested in</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "USER_INTEREST") THEN]%%
        <!------------- User Interest ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_user_interest"
              name="_user_interest"
              required>

              <option value="" disabled selected>What are you interested in?</option>
              <option value="demo">Complimentary Consultation</option>
              <option value="quote">Quote</option>

            </select>

            <div class="invalid-feedback">Please select what you are interested in</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "USER_INTEREST_HALF") THEN]%%
        <!------------- User Interest HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_user_interest"
              name="_user_interest"
              required>

              <option value="" disabled selected>What are you interested in?</option>
              <option value="demo">Complimentary Consultation</option>
              <option value="quote">Quote</option>

            </select>

            <div class="invalid-feedback">Please select what you are interested in</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "FIRST_NAME") THEN]%%
        <!------------- First Name ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_first_name"
              name="_first_name"
              placeholder="First Name"
              required>

            <div class="invalid-feedback">Please enter a first name</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "FIRST_NAME_HALF") THEN]%%
        <!------------- First Name HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_first_name"
              name="_first_name"
              placeholder="First Name"
              required>

            <div class="invalid-feedback">Please enter a first name</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "LAST_NAME") THEN]%%
        <!------------- Last Name ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_last_name"
              name="_last_name"
              placeholder="Last Name"
              required>

            <div class="invalid-feedback">Please enter a last name</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "LAST_NAME_HALF") THEN]%%
        <!------------- Last Name HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_last_name"
              name="_last_name"
              placeholder="Last Name"
              required>

            <div class="invalid-feedback">Please enter a last name</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "EMAIL_ADDRESS") THEN]%%
        <!------------- Email Address----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="email"
              id="_email_address"
              name="_email_address"
              placeholder="Email Address"
              required>

            <div class="invalid-feedback">Please enter a valid email address</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "EMAIL_ADDRESS_HALF") THEN]%%
        <!------------- Email Address HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="email"
              id="_email_address"
              name="_email_address"
              placeholder="Email Address"
              required>

            <div class="invalid-feedback">Please enter a valid email address</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "PHONE_NUMBER") THEN]%%
        <!------------- Phone Number ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_phone_number"
              name="_phone_number"
              placeholder="Mobile / Work Phone"
              required>

            <div class="invalid-feedback">Please enter a phone number</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "PHONE_NUMBER_HALF") THEN]%%
        <!------------- Phone Number HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_phone_number"
              name="_phone_number"
              placeholder="Mobile / Work Phone"
              required>

            <div class="invalid-feedback">Please enter a phone number</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "GRADE_LEVEL") THEN]%%
        <!------------- Grade Level ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_grade_level"
              name="_grade_level"
              required>

              <option value="" disabled selected>Grade Level</option>

              <option value="K/R">K/R</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="I do not teach specific grades">I do not teach specific grades</option>

            </select>

            <div class="invalid-feedback">Please select a grade level</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "GRADE_LEVEL_HALF") THEN]%%
        <!------------- Grade Level HALF----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_grade_level"
              name="_grade_level"
              required>

              <option value="" disabled selected>Grade Level</option>

              <option value="K/R">K/R</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="I do not teach specific grades">I do not teach specific grades</option>

            </select>

            <div class="invalid-feedback">Please select a grade level</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "JOB_TITLE") THEN]%%
        <!------------- Job Title ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_job_title"
              name="_job_title"
              required>

              <option value="" selected disabled>Select Job Title</option>

              %%[

              /* Populate Job Title Options and Redirect
              ********************************/
              IF (@_Campaign_Name == "701Mp00000NfPA9IAN" OR @_Campaign_Name == "701Mp00000Te4FYIAZ" OR
              @_Campaign_Name == "701Mp00000VCznXIAT" OR @_Campaign_Name == "701Mp00000VCz4MIAT" OR
              @_Campaign_Name == "701Mp00000VD5CyIAL" OR @_Campaign_Name == "701Mp00000VCvVWIA1" OR
              @_Campaign_Name == "701Mp00000W03N2IAJ") THEN
              Set @Job_Titles = LookupRows("jobTitle_USA_District_Forms", "Active", "1")
              For @i = 1 TO RowCount(@Job_Titles) DO
              Set @Job_Title = Field(Row(@Job_Titles, @i), "Job Title")
              OutputLine(Concat('<option value="',@Job_Title,'">',@Job_Title,'</option>'))
              Next @i

              ELSE
              Set @Job_Titles = LookupRows("jobTitle_ENG", "Active", "1")
              For @i = 1 TO RowCount(@Job_Titles) DO
              Set @Job_Title = Field(Row(@Job_Titles, @i), "Job Title")
              OutputLine(Concat('<option value="',@Job_Title,'">',@Job_Title,'</option>'))
              Next @i

              ENDIF

              ]%%

            </select>

            <div class="invalid-feedback">Please select a job title</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "JOB_TITLE_HALF") THEN]%%
        <!------------- Job Title HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_job_title"
              name="_job_title"
              required>

              <option value="" selected disabled>Select Job Title</option>

              %%[

              /* Populate Job Title Options and Redirect
              ********************************/
              IF (@_Campaign_Name == "701Mp00000NfPA9IAN" OR @_Campaign_Name == "701Mp00000Te4FYIAZ" OR
              @_Campaign_Name == "701Mp00000VCznXIAT" OR @_Campaign_Name == "701Mp00000VCz4MIAT" OR
              @_Campaign_Name == "701Mp00000VD5CyIAL" OR @_Campaign_Name == "701Mp00000VCvVWIA1" OR
              @_Campaign_Name == "701Mp00000W03N2IAJ") THEN
              Set @Job_Titles = LookupRows("jobTitle_USA_District_Forms", "Active", "1")
              For @i = 1 TO RowCount(@Job_Titles) DO
              Set @Job_Title = Field(Row(@Job_Titles, @i), "Job Title")
              OutputLine(Concat('<option value="',@Job_Title,'">',@Job_Title,'</option>'))
              Next @i

              ELSE
              Set @Job_Titles = LookupRows("jobTitle_ENG", "Active", "1")
              For @i = 1 TO RowCount(@Job_Titles) DO
              Set @Job_Title = Field(Row(@Job_Titles, @i), "Job Title")
              OutputLine(Concat('<option value="',@Job_Title,'">',@Job_Title,'</option>'))
              Next @i

              ENDIF

              ]%%

            </select>

            <div class="invalid-feedback">Please select a job title</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "COUNTRY_NAME") THEN]%%
        <!------------- Country Name ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_country_name"
              name="_country_name"
              required>

              <option value="" selected disabled>Select Country</option>

              %%[

              /* Populate Country Options
              ******************************/

              Set @Countries_Main = LookupOrderedRows("Country_DE", 0, "IsMainCountry desc, CountryName asc", "Active", "True", "IsMainCountry", "True")
              For @i = 1 to RowCount(@Countries_Main) Do
              Set @Country_Name = field(row(@Countries_Main, @i),"CountryName")
              Set @Country_Code = field(row(@Countries_Main, @i),"CountryCode")
              OutputLine(Concat('<option value="', @Country_Name,'"',' data-countrycode="',@Country_Code,'">',@Country_Name,'</option>'))
              Next @i

              OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

              Set @Countries_All = LookupOrderedRows("Country_DE", 0, "CountryName asc", "Active", "True")
              For @i = 1 to RowCount(@Countries_All) Do
              Set @Country_Name = field(row(@Countries_All, @i),"CountryName")
              Set @Country_Code = field(row(@Countries_All, @i),"CountryCode")
              OutputLine(Concat('<option value="', @Country_Name,'"',' data-countrycode="',@Country_Code,'">',@Country_Name,'</option>'))
              NEXT @i
              ]%%

            </select>

            <div class="invalid-feedback">Please select a country</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "COUNTRY_NAME_HALF") THEN]%%
        <!------------- Country Name HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_country_name"
              name="_country_name"
              required>

              <option value="" selected disabled>Select Country</option>

              %%[

              /* Populate Country Options
              ******************************/

              Set @Countries_Main = LookupOrderedRows("Country_DE", 0, "IsMainCountry desc, CountryName asc", "Active", "True", "IsMainCountry", "True")
              For @i = 1 to RowCount(@Countries_Main) Do
              Set @Country_Name = field(row(@Countries_Main, @i),"CountryName")
              Set @Country_Code = field(row(@Countries_Main, @i),"CountryCode")
              OutputLine(Concat('<option value="', @Country_Name,'"',' data-countrycode="',@Country_Code,'">',@Country_Name,'</option>'))
              Next @i

              OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

              Set @Countries_All = LookupOrderedRows("Country_DE", 0, "CountryName asc", "Active", "True")
              For @i = 1 to RowCount(@Countries_All) Do
              Set @Country_Name = field(row(@Countries_All, @i),"CountryName")
              Set @Country_Code = field(row(@Countries_All, @i),"CountryCode")
              OutputLine(Concat('<option value="', @Country_Name,'"',' data-countrycode="',@Country_Code,'">',@Country_Name,'</option>'))
              NEXT @i
              ]%%

            </select>

            <div class="invalid-feedback">Please select a country</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME") THEN]%%
        <!------------- State / Province Name ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State / Province <small>&nbsp;(Please select a country first.)</small></option>

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>


        <!-- On Country Change -->
        <script>
          try {

            // CONSTANTS
            let allStateNameData;

            // DOM ELEMENTS
            const countryNameSelect = document.getElementById('_country_name');
            const stateProvinceNameSelect = document.getElementById('_state_province_name');

            // EVENTS
            document.addEventListener('DOMContentLoaded', getStateNameData);
            countryNameSelect.addEventListener('change', handleChangeCountryName);

            // HANDLERS
            function getStateNameData() {
              const allStatesURLPath = "/gf_states";

              fetch(allStatesURLPath)
                .then(response => response.json())
                .then(data => {
                  allStateNameData = data;
                })
                .catch(error => console.error(error));
            }

            function handleChangeCountryName(e) {
              // Choose states
              const selectedOption = e.target.options[e.target.selectedIndex];
              const countryCode = selectedOption.dataset.countrycode;
              const countryStateData = allStateNameData.filter((option) => option["Country Code"] === countryCode);

              // Reset options
              stateProvinceNameSelect.value = '';
              stateProvinceNameSelect.innerHTML = '';

              const placeholderText = countryCode === "CA" ? 'Province' : 'State';
              const placeholderOption = document.createElement('option');
              placeholderOption.value = '';
              placeholderOption.disabled = true;
              placeholderOption.selected = true;
              placeholderOption.textContent = placeholderText;
              stateProvinceNameSelect.appendChild(placeholderOption);

              // Populate options
              countryStateData.forEach((state) => {
                const option = document.createElement('option');
                option.value = state['State Code'];
                option.textContent = state['State Name'];
                stateProvinceNameSelect.appendChild(option);
              });
            }

          } catch (e) {
            console.error(e.message);
          }
        </script>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_HALF") THEN]%%
        <!------------- State / Province Name HALF----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State / Province <small>&nbsp;(Please select a country first.)</small></option>

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>


        <!-- On Country Change -->
        <script>
          try {

            // CONSTANTS
            let allStateNameData;

            // DOM ELEMENTS
            const countryNameSelect = document.getElementById('_country_name');
            const stateProvinceNameSelect = document.getElementById('_state_province_name');

            // EVENTS
            document.addEventListener('DOMContentLoaded', getStateNameData);
            countryNameSelect.addEventListener('change', handleChangeCountryName);

            // HANDLERS
            function getStateNameData() {
              const allStatesURLPath = "/gf_states";

              fetch(allStatesURLPath)
                .then(response => response.json())
                .then(data => {
                  allStateNameData = data;
                })
                .catch(error => console.error(error));
            }

            function handleChangeCountryName(e) {
              // Choose states
              const selectedOption = e.target.options[e.target.selectedIndex];
              const countryCode = selectedOption.dataset.countrycode;
              const countryStateData = allStateNameData.filter((option) => option["Country Code"] === countryCode);

              // Reset options
              stateProvinceNameSelect.value = '';
              stateProvinceNameSelect.innerHTML = '';

              const placeholderText = countryCode === "CA" ? 'Province' : 'State';
              const placeholderOption = document.createElement('option');
              placeholderOption.value = '';
              placeholderOption.disabled = true;
              placeholderOption.selected = true;
              placeholderOption.textContent = placeholderText;
              stateProvinceNameSelect.appendChild(placeholderOption);

              // Populate options
              countryStateData.forEach((state) => {
                const option = document.createElement('option');
                option.value = state['State Code'];
                option.textContent = state['State Name'];
                stateProvinceNameSelect.appendChild(option);
              });
            }

          } catch (e) {
            console.error(e.message);
          }
        </script>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_US") THEN]%%
        <!------------- State / Province Name (US) ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (United States)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "US")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_US_HALF") THEN]%%
        <!------------- State / Province Name (US) HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (United States)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "US")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_CA") THEN]%%
        <!------------- State / Province Name (CA) ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>Province (Canada)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "CA")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_CA_HALF") THEN]%%
        <!------------- State / Province Name (CA) HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>Province (Canada)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "CA")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_AU") THEN]%%
        <!------------- State / Province Name (AU) ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (Australia)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "AU")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_AU_HALF") THEN]%%
        <!------------- State / Province Name (AU) HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (Australia)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "AU")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_NZ") THEN]%%
        <!------------- State / Province Name (NZ) ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (New Zealand)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "NZ")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_NZ_HALF") THEN]%%
        <!------------- State / Province Name (NZ) HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (New Zealand)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "NZ")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_ZA") THEN]%%
        <!------------- State / Province Name (ZA) ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (South Africa)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "ZA")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_ZA_HALF") THEN]%%
        <!------------- State / Province Name (ZA) HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <select
              class="form-control custom-reset-select-text"
              id="_state_province_name"
              name="_state_province_name"
              required>

              <option value="" disabled selected>State (South Africa)</option>

              %%[

              /******************************
              POPULATE STATE/PROVINCE OPTIONS
              *******************************/

              SET @data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "ZA")
              FOR @i = 1 TO RowCount(@data) DO
              SET @option = Field(Row(@data, @i), "State Name")
              OutputLine(Concat('<option value="',@option,'">',@option,'</option>'))
              NEXT @i
              VAR @data, @option

              ]%%

            </select>

            <div class="invalid-feedback">Please select a state or province</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "POSTCODE_ZIPCODE") THEN]%%
        <!------------- Postcode / Zipcode ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_postcode_zipcode"
              name="_postcode_zipcode"
              placeholder="Postcode / Zipcode"
              title="Postcode/Zipcode is 4 digits with no spaces"
              required>

            <div class="invalid-feedback">Please enter a postcode or zipcode</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "POSTCODE_ZIPCODE_HALF") THEN]%%
        <!------------- Postcode / Zipcode HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_postcode_zipcode"
              name="_postcode_zipcode"
              placeholder="Postcode / Zipcode"
              title="Postcode/Zipcode is 4 digits with no spaces"
              required>

            <div class="invalid-feedback">Please enter a postcode or zipcode</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "SCHOOL_NAME") THEN]%%
        <!------------- School Name ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_school_name"
              name="_school_name"
              placeholder="School or District Name"
              required>

            <div class="invalid-feedback">Please enter a school name</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "SCHOOL_NAME_HALF") THEN]%%
        <!------------- School Name HALF----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_school_name"
              name="_school_name"
              placeholder="School or District Name"
              required>

            <div class="invalid-feedback">Please enter a school name</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "NO_OF_LICENCES") THEN]%%
        <!------------- No. Of Licences  ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <input
              class="form-control"
              type="number"
              id="_no_of_licences"
              name="_no_of_licences"
              placeholder="Number of Student Licenses"
              required
              min="20"
              max="1000">

            <div class="invalid-feedback">Please enter how many licences are needed</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "NO_OF_LICENCES_HALF") THEN]%%
        <!------------- No. Of Licences HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">

            <input
              class="form-control"
              type="number"
              id="_no_of_licences"
              name="_no_of_licences"
              placeholder="Number of Student Licenses"
              required
              min="20"
              max="1000">

            <div class="invalid-feedback">Please enter how many licences are needed</div>

          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "TERMS_AND_CONDITIONS") THEN]%%
        <!------------- Terms & Conditions ----------------->
        <div class="col-sm-12">
          <div class="form-group">
            <div class="form-check">


              <input
                class="form-check-input"
                type="checkbox"
                id="_terms_and_conditions"
                name="_terms_and_conditions"
                checked
                required>

              <label
                class="form-check-label"
                for="_terms_and_conditions">
                I agree to the 3P Learning
                <a tabindex="-1" target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms and Conditions</a>.
              </label>

              <div class="invalid-feedback">Please agree.</div>

            </div>
          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "TERMS_AND_CONDITIONS_HALF") THEN]%%
        <!------------- Terms & Conditions HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <div class="form-check">


              <input
                class="form-check-input"
                type="checkbox"
                id="_terms_and_conditions"
                name="_terms_and_conditions"
                checked
                required>

              <label
                class="form-check-label"
                for="_terms_and_conditions">
                I agree to the 3P Learning
                <a tabindex="-1" target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms and Conditions</a>.
              </label>

              <div class="invalid-feedback">Please agree.</div>

            </div>
          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "SUBSCRIBER_OPT_IN") THEN]%%
        <!------------- Subscriber Opt In ----------------->
        <div class="col-sm-12">
          <div class="form-group">
            <div class="form-check">

              <input
                class="form-check-input"
                type="checkbox"
                id="_subscriber_opt_in"
                name="_subscriber_opt_in"
                checked>

              <label
                class="form-check-label"
                for="subscriber_opt_in_input">
                YES! Sign me up to receive monthly newsletters, educational content, resources, and occasional promotional material.
              </label>

              <!-- <div class="invalid-feedback">Please opt in.</div> -->

            </div>
          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "SUBSCRIBER_OPT_IN_HALF") THEN]%%
        <!------------- Subscriber Opt In HALF ----------------->
        <div class="col-sm-12 col-md-6">
          <div class="form-group">
            <div class="form-check">

              <input
                class="form-check-input"
                type="checkbox"
                id="_subscriber_opt_in"
                name="_subscriber_opt_in"
                checked>

              <label
                class="form-check-label"
                for="subscriber_opt_in_input">
                YES! Sign me up to receive monthly newsletters, educational content, resources, and occasional promotional material.
              </label>

              <!-- <div class="invalid-feedback">Please opt in.</div> -->

            </div>
          </div>
        </div>
        %%[ENDIF]%%


        %%[IF (@COMPONENT == "SUBMIT_BUTTON") THEN]%%
        <!------------- Submit Button ----------------->
        <div class="col-sm-12">
          <div class="form-group">

            <button
              class="custom_submit_button"
              type="submit"
              id="_submit_button"
              name="_submit_button">
              Submit
            </button>

          </div>
        </div>


        <!-- custom_submit_button css -->
        <style>
          :root {
            --submit_button__rest--backgroundColor: #015F4E;
            --submit_button__rest--color: whitesmoke;
            --submit_button__hover--backgroundColor: #00473b;
            --submit_button__hover--color: white;
          }

          .custom_submit_button {
            background-color: var(--submit_button__rest--backgroundColor);
            border-radius: 25px;
            padding: 15px 50px;
            text-align: center;
            color: var(--submit_button__rest--color);
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
          }

          .custom_submit_button:hover {
            background-color: var(--submit_button__hover--backgroundColor);
            color: var(--submit_button__hover--color);
          }

          .custom_submit_button:focus {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
          }

          @media screen and (min-width: 767px) {
            .custom_submit_button {
              width: auto;
              float: right;
            }
          }
        </style>
        %%[ENDIF]%%


        %%[
        /************************************
        FINISH LOOPING OVER RENDER COMPONENTS
        *************************************/
        NEXT @index
        ]%%


      </div>
    </div>
    <!-- //wrapper -->


  </form>



  <!-- ===========================  JAVASCRIPT  =========================== -->


  <noscript>

    <!-- Google Tag Manager (noscript) -->
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T97DM2H"
      height="0" width="0" style="display:none;visibility:hidden">
    </iframe>

  </noscript>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js "></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js "></script>
  <script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
  <script src="https://web.my.3plearning.com/formFieldFunctions"></script>


  <!-- Validate -->
  <script>
    //
    //
    /*******************
    Validation
    @url: https://getbootstrap.com/docs/4.1/components/forms/#validation
    @url: https://developer.snapappointments.com/bootstrap-select/options/#events
    ********************/

    document.addEventListener('DOMContentLoaded', () => {

      //CONSTANTS
      const form = document.forms[0];
      const productInterestSelect = $('#_product_interest');
      const productInterestFeedbackList = document.querySelectorAll('#product_interest_invalid_feedback');

      //EVENTS
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {

          event.preventDefault();
          event.stopPropagation();

          form.classList.add('was-validated');

          // manually configure custom validation fpr Bootstrap selectpicker library
          validateProductInterest();
          productInterestSelect.on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            validateProductInterest();
          });
        } //checkValidity

      }); //submit


      //HANDLERS
      function validateProductInterest() {
        if (!productInterestSelect.selectpicker('val')) {
          productInterestFeedbackList.forEach((validationMessage) => {
            validationMessage.classList.add('d-block');
          })
        } else {
          productInterestFeedbackList.forEach((validationMessage) => {
            validationMessage.classList.remove('d-block');
          })
        }
      }


    }); //DOMContentLoaded
  </script>


  <!-- Get Cookies -->
  <script>
    /**************************************************
    ----- Parse Cookie Data to hidden form fields -----
    ***************************************************/

    // Parse the Cookie
    var cname = "setURLParamsCookie"

    function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
    var referrer = getCookie("__gtm_referrer");

    // Parse the URL inside Cookie
    function getParameterByName(name) {
      name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
      var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");

      results = regex.exec(getCookie("setURLParamsCookie"));
      return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }

    // Pass the values to hidden field
    var cookieCheck = document.cookie.indexOf('setURLParamsCookie')
    if (cookieCheck > 0) {
      document.querySelector("#utm-source").value = getParameterByName('utm_source');
      document.querySelector("#utm-medium").value = getParameterByName('utm_medium');
      document.querySelector("#utm-campaign").value = getParameterByName('utm_campaign');
      document.querySelector("#utm-content").value = getParameterByName('utm_content');
      document.querySelector("#utm-term").value = getParameterByName('utm_term');
      document.querySelector("#gclid").value = getParameterByName('gclid');
      document.querySelector("#referrer").value = referrer;
    };
  </script>




</body>

</html>