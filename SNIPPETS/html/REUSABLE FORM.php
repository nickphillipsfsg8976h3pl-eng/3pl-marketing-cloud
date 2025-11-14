<!--
============================================
============== REUSABLE FORM ===============
============================================
-->



<script runat="server" executioncontexttype="Post">
  /**
   * BACKEND-SSJS
   * 
   * @description: This code will run on the backend when the form is submitted
   */
  Platform.Load("core", "1");
  try {
    Write('...Processing');
  } catch (error) {
    Write("Error: " + error.message);
  }

  //do not render the below on post requests
  if (false)
</script>


<script runat="server" executioncontexttype="Get">
  /**
   * FRONTEND-SSJS
   * 
   * @description: This code will run on the frontend when the form is displayed
   */
  Platform.Load("core", "1");
  try {



    /*******************************
    ----------- SECURITY -----------
    ********************************/

    // Platform.Response.SetResponseHeader("X-Frame-Options","Deny");
    // Platform.Response.SetResponseHeader("Content-Security-Policy","default-src 'self'");
    Platform.Response.SetResponseHeader("Strict-Transport-Security", "max-age=200");
    Platform.Response.SetResponseHeader("X-XSS-Protection", "1; mode=block");
    Platform.Response.SetResponseHeader("X-Content-Type-Options", "nosniff");
    Platform.Response.SetResponseHeader("Referrer-Policy", "strict-origin-when-cross-origin");


    /*******************************
    -- GENERAL REQUEST PARAMETER ---

    @description:  This section is used to capture all query parameters and make them avaiable to ampscript.

    @example: https://www.3plearning.com?cid=029184790897a249&rid=83&pid=mathletics

    ********************************/


    Variable.SetValue('debug', Request.GetQueryStringParameter("debug"))

    Variable.SetValue('cid', Request.GetQueryStringParameter("cid"))
    Variable.SetValue('rid', Request.GetQueryStringParameter("rid"))

    Variable.SetValue('utm_source', Request.GetQueryStringParameter("utm_source"))
    Variable.SetValue('utm_medium', Request.GetQueryStringParameter("utm_medium"))
    Variable.SetValue('utm_campaign', Request.GetQueryStringParameter("utm_campaign"))
    Variable.SetValue('utm_content', Request.GetQueryStringParameter("utm_content"))
    Variable.SetValue('utm_term', Request.GetQueryStringParameter("utm_term"))


    /*******************************
    ----- CHOOSE A FIELDS -----
    
    @description:  This section will choose all the fields to display based on "form" and/or "fields query parameters.
    You can use "form" or "fields" query parameters seperately or together. Create more templates below for common
    configurations as needed. Ie. Top-of-funnel, Bottom of funnel, Product-based etc.

    @example: https://3plearning.com?form=master
    @example: https://3plearning.com?form=master&fields=PRODUCT_INTEREST,FIRST_NAME
    @example: https://3plearning.com?fields=PRODUCT_INTEREST,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,CAPTCHA,TERMS_AND_CONDITIONS,SUBMIT_BUTTTON

    ********************************/

    // PRECONFIGURED FORMS TO REUSE
    var TEMPLATES = {

      //?form=master
      ALL_FIELDS: [
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
      ]

    }

    // SET COMPONENTS TO RENDER
    var RENDER_COMPONENTS = [];

    // ADD TEMPLATE INPUTS TO RENDER COMPONENTS
    var _form = Request.GetQueryStringParameter("form")
    _form = _form && _form.toLowerCase();
    if (_form) {
      var _templateComponents = TEMPLATES[_form];
      RENDER_COMPONENTS.concat(_templateComponents);
    } //if

    // ADD INDIVIDUAL INPTUS TO RENDER COMPONENTS
    var _fields = Request.GetQueryStringParameter("fields")
    _fields = _fields && _fields.toUpperCase().split(',');
    if (_fields) {
      for (var i = 0; i < _fields.length; i++) {
        var _fieldComponent = _fields[i]
        RENDER_COMPONENTS.push(_fieldComponent);
      }
    }

    // PASS RENDER COMPONENTS TO AMPSCRIPT
    Variable.SetValue('RENDER_COMPONENTS', RENDER_COMPONENTS);

  } catch (error) {
    Write("Error: " + error.message);
  }

  //render the below form on get requests
  if (true)
</script>


<!--
============================================
=================== HTML ===================
============================================
-->


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
    })(window, document, 'script', 'dataLayer', 'GTM-PZJLM4L3');
  </script>
  <!-- /Google Tag Manager -->


  <!-- Meta/SEO -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Form">
  <!-- Meta/SEO -->


  <!-- Title & Favicons -->
  <link rel="shortcut icon" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-16px.png" type="image/x-icon" />
  <link rel="apple-touch-icon-precomposed" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-57px.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-114px.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-72px.png">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-144.png">
  <!-- /Title & Favicones -->


  <!-- CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <!-- /CSS -->


  <!-- Styles -->
  <style>
    :root {
      font-size: 16px;
      font-family: Open sans, helvetica, arial, sans-serif;
      font-weight: 400;
      color: #545454;

      --submit_button__rest--backgroundColor: #CB378C;
      --submit_button__rest--color: whitesmoke;
      --submit_button__hover--backgroundColor: #d92f9c;
      --submit_button__hover--color: white;
      --checkbox__rest--backgroundColor: lightgrey;
      --checkbox__hover--backgroundColor: #1981c4;
      --checkbox__checked--backgroundColor: #308ECB;
      --valid_input--color: green;
      --invalid_input--color: red;
      --invalid_label--color: red;
    }

    .form-control {
      display: block;
      width: 100%;
      height: calc(1.5em + 0.75rem + 2px);
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #545454;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid #c4c4c4;
      border-radius: 0.375rem;
      transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .custom_submit_button {
      background-color: var(--submit_button__rest--backgroundColor);
      border-radius: 0.25rem;
      padding: 12px 32px;
      text-align: center;
      color: var(--submit_button__rest--color);
      font-weight: 700;
      font-size: 1.125rem;
      width: 100%;
      border: 0;
    }

    .custom_submit_button:hover {
      background-color: var(--submit_button__hover--backgroundColor);
      color: var(--submit_button__hover--color);
    }

    .custom_submit_button:focus {
      outline: 0;
      box-shadow: 0 0 0 0.2rem rgb(0 0 0 / 12%);
    }

    .custom-hide {
      display: none;
    }

    .custom-show {
      display: block;
    }

    @media screen and (min-width: 767px) {
      .custom_submit_button {
        width: auto;
        margin-left: auto;
        margin-right: auto;
      }
    }

    .custom-checkbox {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 16px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    .custom-checkbox input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }

    .checkmark {
      position: absolute;
      top: 5px;
      left: 0;
      height: 25px;
      width: 25px;
      background-color: var(--checkbox__rest--backgroundColor);
      border-radius: 5px;

    }

    .custom-checkbox:hover input~.checkmark {
      background-color: var(--checkbox__hover--backgroundColor);
    }

    .custom-checkbox input:checked~.checkmark {
      background-color: var(--checkbox__checked--backgroundColor);
    }

    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }

    .custom-checkbox input:checked~.checkmark:after {
      display: block;
    }

    .custom-checkbox .checkmark:after {
      left: 9px;
      top: 5px;
      width: 7px;
      height: 15px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }

    .custom-field-label {
      font-weight: bold;
    }

    .custom-field-terms {
      font-weight: lighter;
      color: #495057;
    }

    .custom-hide {
      display: none;
    }

    .custom-valid-input {
      border: 3px solid var(--valid_input--color) !important;
    }

    .custom-invalid-input {
      border: 3px solid var(--invalid_input--color) !important;
    }

    .custom-invalid-label {
      color: var(--invalid_label--color) !important;
    }
  </style>
  <!-- /Styles -->


</head>


<!--
============================================
=================== BODY ===================
============================================
-->


<body>


  <form method="POST">


    <!------------- Hidden Inputs ----------------->


    <input type="hidden" name="_debug" value="%%=v(@debug)=%%">

    <input type="hidden" name="_cid" value="%%=v(@cid)=%%">
    <input type="hidden" name="_rid" value="%%=v(@rid)=%%">

    <input type="hidden" name="_utm_source" value="%%=v(@utm_source)=%%">
    <input type="hidden" name="_utm_medium" value="%%=v(@utm_medium)=%%">
    <input type="hidden" name="_utm_campaign" value="%%=v(@utm_campaign)=%%">
    <input type="hidden" name="_utm_content" value="%%=v(@utm_content)=%%">
    <input type="hidden" name="_utm_term" value="%%=v(@utm_term)=%%">

    <input type="hidden" name="_form">

    <script>
      // set the hidden form input to the current URL
      document.querySelector('input[name="_form"]').value = location.href;
    </script>


    <!------------- Exposed Inputs ----------------->


    <!-- Wrapper -->
    <div class=" container my-5">
      <div class="row">


        %%[
        /************************************
        LOOPING OVER RENDER_COMPONENTS
        *************************************/
        SET @LENGTH = RowCount(@RENDER_COMPONENTS)
        FOR @i = 1 TO @LENGTH DO
        SET @COMPONENT = Row(@RENDER_COMPONENTS, @i)
        ]%%


        <!------------- Product Interest ----------------->
        %%[IF (@COMPONENT == "PRODUCT_INTEREST") THEN]%%
        <div class="col">
          <div class="form-group">

            <select
              class="form-control selectpicker show-tick"
              id="_product_interest"
              name="_product_interest"
              multiple
              required>

              <option disabled selected>Product Interest</option>

              <option value="mathletics">Mathletics</option>
              <option value="mathseeds">Mathseeds</option>
              <option value="readingeggs">Reading Eggs</option>

            </select>
            <!-- <div class="custom-invalid-label custom-hide text-right">Select a product interest</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- First Name ----------------->
        %%[IF (@COMPONENT == "FIRST_NAME") THEN]%%
        <div class="col">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_first_name"
              name="_first_name"
              placeholder="First Name"
              required>
            <!-- <div class="custom-invalid-label custom-hide text-right">First name is required</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- Last Name ----------------->
        %%[IF (@COMPONENT == "LAST_NAME") THEN]%%
        <div class="col">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_last_name"
              name="_last_name"
              placeholder="Last Name"
              required>
            <!-- <div class="custom-invalid-label custom-hide text-right">Last name is required</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- Email Addres----------------->
        %%[IF (@COMPONENT == "EMAIL_ADDRESS") THEN]%%
        <div class="col">
          <div class="form-group">

            <input
              class="form-control"
              type="email"
              id="_email_address"
              name="_email_address"
              placeholder="Email Address"
              required>
            <!-- <div class="custom-invalid-label custom-hide text-right">Please provide a valid email address.</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- Phone Number ----------------->
        %%[IF (@COMPONENT == "PHONE_NUMBER") THEN]%%
        <div class="col">
          <div class="form-group">

            <input
              class="form-control"
              type="tel"
              id="_phone_number"
              name="_phone_number"
              placeholder="Phone Number"
              required>
            <!-- <div class="custom-invalid-label custom-hide text-right">Phone number is required</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- Grade Level ----------------->
        %%[IF (@COMPONENT == "GRADE_LEVEL") THEN]%%
        <div class="col">
          <div class="form-group">

            <select
              class="form-control"
              id="_grade_level"
              name="_grade_level"
              required>

              <option disabled selected>Grade Level</option>

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
            <!-- <div class="custom-invalid-label custom-hide text-right">Grade level is required</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- Job Title ----------------->
        %%[IF (@COMPONENT == "JOB_TITLE") THEN]%%
        <div class="col">
          <div class="form-group">

            <select
              class="form-control"
              id="_job_title"
              name="_job_title"
              required>

              <option disabled selected>Job Title</option>

              %%[

              /* Populate Job Title Options and Redirect
              *******************************************/

              Set @Job_Titles = LookupRows("jobTitle_ENG_B2S", "Active", "1")
              For @i = 1 TO RowCount(@Job_Titles) DO
              Set @Job_Title = Field(Row(@Job_Titles, @i), "Job Title")
              OutputLine(Concat('<option value="',@Job_Title,'">',@Job_Title,'</option>'))
              Next @i

              /* Add an option for 'Other' */
              OutputLine('<option value="Other">Other</option>')

              ]%%
            </select>
            <!-- <div class="custom-invalid-label custom-hide text-right">Role is required</div> -->

          </div>
        </div>

        <!------------- If "Other" Value Selected ----------------->
        <div class="col d-none" id="_other_job_title_wrapper">
          <div class="form-group">

            <input
              class="form-control"
              type="text"
              id="_other_job_title_role"
              name="_other_job_title_role"
              placeholder="Please specify your role">
          </div>
        </div>

        <script>
          const jobTitle = document.getElementById('_job_title');
          jobTitle.addEventListener('change', () => {
            jobTitle.value === 'Other' ?
              document.getElementById('_other_job_title_wrapper').classList.remove('d-none') :
              document.getElementById('_other_job_title_wrapper').classList.add('d-none');
          });
        </script>
        %%[ENDIF]%%


        <!------------- Country ----------------->
        %%[IF (@COMPONENT == "COUNTRY_NAME") THEN]%%
        <div class="col">
          <div class="form-group">

            <select
              class="form-control"
              id="country-name"
              name="country-name"
              required>

              <option selected disabled>Country</option>

              %%[

              /* Populate Country Options
              ******************************/

              Set @Countries_Main = LookupOrderedRows("Country_DE", 0, "IsMainCountry desc, CountryName asc", "Active", "True", "IsMainCountry", "True")
              For @i = 1 to RowCount(@Countries_Main) Do
              Set @Country_Name = field(row(@Countries_Main, @i),"CountryName")
              Set @Country_Code = field(row(@Countries_Main, @i),"CountryCode")
              OutputLine(Concat('<option value="', @Country_Name,'" data-country-code="',@Country_Code,'">',@Country_Name,'</option>'))
              Next @i

              OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

              Set @Countries_All = LookupOrderedRows("Country_DE", 0, "CountryName asc", "Active", "True")
              For @i = 1 to RowCount(@Countries_All) Do
              Set @Country_Name = field(row(@Countries_All, @i),"CountryName")
              Set @Country_Code = field(row(@Countries_All, @i),"CountryCode")
              OutputLine(Concat('<option value="', @Country_Name,'" data-country-code="',@Country_Code,'">',@Country_Name,'</option>'))
              NEXT @i
              ]%%

            </select>
            <!-- <div class="custom-invalid-label custom-hide text-right">Country is required</div> -->
          </div>
        </div>
        %%[ENDIF]%%


        <!------------- State/Province (ALL)----------------->
        %%[IF @COMPONENT == "STATE_NAME" THEN]%%
        <div class="col">
          <div class="form-group">

            <select class="form-control"
              id="state-name"
              name="state-name"
              disabled
              required>

              <option disabled selected>State/Province</option>

              %%[

              /* Populate States/Provinces Options
              **************************************/

              Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "AU")
              For @i = 1 TO RowCount(@state_data) DO
              Set @state_option = Field(Row(@state_data, @i), "State Name")
              OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
              Next @i

              ]%%
            </select>
            <!-- <div class="custom-invalid-label custom-hide text-right">Province is required</div> -->
          </div>
        </div>
      </div>


      <script>

      </script>
      %%[ENDIF]%%


      <!------------- State/Province (AU) ----------------->
      %%[IF @COMPONENT == "STATE_NAME_AU" THEN]%%
      <div class="col">
        <div class="form-group">

          <select class="form-control"
            id="state_name_select"
            name="state-name"
            required>

            <option disabled selected>State/Province</option>

            %%[

            /* Populate States/Provinces Options
            **************************************/

            Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "AU")
            For @i = 1 TO RowCount(@state_data) DO
            Set @state_option = Field(Row(@state_data, @i), "State Name")
            OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
            Next @i

            ]%%
          </select>
          <!-- <div class="custom-invalid-label custom-hide text-right">Province is required</div> -->
        </div>
      </div>
    </div>
    %%[ENDIF]%%


    <!------------- State/Province (NZ) ----------------->
    %%[IF @COMPONENT == "STATE_NAME_NZ" THEN]%%
    <div class="col">
      <div class="form-group">

        <select class="form-control"
          id="state_name_select"
          name="state-name"
          required>

          <option disabled selected>State/Province</option>

          %%[

          /* Populate States/Provinces Options
          **************************************/

          Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "NZ")
          For @i = 1 TO RowCount(@state_data) DO
          Set @state_option = Field(Row(@state_data, @i), "State Name")
          OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
          Next @i

          ]%%
        </select>
        <!-- <div class="custom-invalid-label custom-hide text-right">Province is required</div> -->
      </div>
    </div>
    </div>
    %%[ENDIF]%%


    <!------------- State/Province (US) ----------------->
    %%[IF @COMPONENT == "STATE_NAME_US" THEN]%%
    <div class="col">
      <div class="form-group">

        <select class="form-control"
          id="state_name_select"
          name="state-name"
          required>

          <option disabled selected>State/Province</option>

          %%[

          /* Populate States/Provinces Options
          **************************************/

          Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "US")
          For @i = 1 TO RowCount(@state_data) DO
          Set @state_option = Field(Row(@state_data, @i), "State Name")
          OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
          Next @i

          ]%%
        </select>
        <!-- <div class="custom-invalid-label custom-hide text-right">Province is required</div> -->
      </div>
    </div>
    </div>
    %%[ENDIF]%%


    <!------------- State/Province (CA) ----------------->
    %%[IF @COMPONENT == "STATE_NAME_CA" THEN]%%
    <div class="col">
      <div class="form-group">

        <select class="form-control"
          id="state_name_select"
          name="state-name"
          required>

          <option disabled selected>State/Province</option>

          %%[

          /* Populate States/Provinces Options
          **************************************/

          Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "CA")
          For @i = 1 TO RowCount(@state_data) DO
          Set @state_option = Field(Row(@state_data, @i), "State Name")
          OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
          Next @i

          ]%%
        </select>
        <!-- <div class="custom-invalid-label custom-hide text-right">Province is required</div> -->
      </div>
    </div>
    </div>
    %%[ENDIF]%%


    <!------------- State/Province (UK) ----------------->
    %%[IF @COMPONENT == "STATE_NAME_UK" THEN]%%
    <div class="col">
      <div class="form-group">

        <select class="form-control"
          id="state_name_select"
          name="state-name"
          required>

          <option disabled selected>State/Province</option>

          %%[

          /* Populate States/Provinces Options
          **************************************/

          Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "UK")
          For @i = 1 TO RowCount(@state_data) DO
          Set @state_option = Field(Row(@state_data, @i), "State Name")
          OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
          Next @i

          ]%%
        </select>
        <div id="state_invalid" class="custom-invalid-label custom-hide text-right">Province is required</div>
      </div>
    </div>
    </div>
    %%[ENDIF]%%


    <!------------- State/Province (ZA) ----------------->
    %%[IF @COMPONENT == "STATE_NAME_ZA" THEN]%%
    <div class="col">
      <div class="form-group">

        <select class="form-control"
          id="state_name_select"
          name="state-name"
          required>

          <option disabled selected>State/Province</option>

          %%[

          /* Populate States/Provinces Options
          **************************************/

          Set @state_data = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "ZA")
          For @i = 1 TO RowCount(@state_data) DO
          Set @state_option = Field(Row(@state_data, @i), "State Name")
          OutputLine(Concat('<option value="',@state_option,'">',@state_option,'</option>'))
          Next @i

          ]%%
        </select>
        <!-- <div class="custom-invalid-label custom-hide text-right">Province is required</div> -->
      </div>
    </div>
    </div>
    %%[ENDIF]%%


    <!------------- Postal Code ----------------->
    %%[IF (@COMPONENT == "POSTAL_CODE") THEN]%%
    <div class="col">
      <div class="form-group">

        <input class="form-control"
          type="text"
          id="postal_code_input"
          name="postal-code"
          placeholder="Postcode"
          title="Postcode is 4 digits with no spaces"
          required>
        <!-- <div class="custom-invalid-label custom-hide text-right">Postcode is required</div> -->
      </div>
    </div>
    %%[ENDIF]%%


    <!------------- Postal Code ----------------->
    %%[IF (@COMPONENT == "SCHOOL_NAME") THEN]%%
    <div class="col">
      <div class="form-group">

        <input type="text"
          class="form-control"
          id="school_name_input"
          name="school-name"
          placeholder="School Name"
          required>

        <!-- <div class="custom-invalid-label custom-hide text-right">School name is required</div> -->
      </div>
    </div>
    %%[ENDIF]%%


    <!------------- Terms & Conditions ----------------->
    %%[IF (@COMPONENT == "TERMS_AND_CONDITIONS") THEN]%%
    <div class="col">
      <div class="form-group">

        <input
          class="form-control"
          type="checkbox"
          id="terms_and_conditions_input"
          name="terms-and-conditions"
          value="true"
          required
          tabindex="-1" />

        <label for="terms_and_conditions_input" class="custom-field-terms form-check-label" style="display: inline;">
          I agree to the <a target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms of Use</a> and I have read and accept the <a target="_parent" href="https://www.3plearning.com/privacy" style="text-decoration: underline;">Privacy Policy*</a><br>
          Reading Eggs and 3P Learning may process your personal information for its legitimate business purposes, including to enable us to provide, personalise and enhance our services for the benefit of our customers. Please see our <a target="_parent" href="https://www.3plearning.com/privacy" style="text-decoration: underline;">Privacy Policy</a> and <a target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms</a> to learn more. *Mandatory field.
        </label>

        <!-- <div class="custom-invalid-label custom-hide text-right">Please agree to the <a target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">terms and conditions</a>.</div> -->
      </div>
    </div>
    %%[ENDIF]%%


    <!------------- Subscriber Opt In ----------------->
    %%[IF (@COMPONENT == "SUBSCRIBER_OPT_IN") THEN]%%
    <div class="col">
      <div class="form-group">

        <input
          class="form-control"
          type="checkbox"
          id="subscriber_opt_in_input"
          name="subscriber-opt-in"
          value="true"
          tabindex="-1" />

        <label for="subscriber_opt_in_input" class="custom-field-terms form-check-label" style="display: inline;">
          YES! Sign me up for educational content, resources and occasional promotional material.
        </label>

        <!-- <div id="subscriber_opt_in_invalid" class="custom-invalid-label custom-hide text-right">...</div> -->
      </div>
    </div>
    %%[ENDIF]%%


    <!------------- Submit Button ----------------->
    %%[IF (@COMPONENT == "SUBMIT_BUTTON") THEN]%%
    <div class="col text-center">
      <div class="form-group">

        <button class="custom_submit_button"
          type="submit"
          id="submit_button"
          name="myButton"
          value="submit">Get 12 eBooks free!
        </button>

      </div>
    </div>
    %%[ENDIF]%%


    %%[
    /***************************************
    CONTINUE LOOPING OVER RENDER_COMPONENTS
    ****************************************/
    NEXT @i
    ]%%


    </div>
    </div>
    <!-- //wrapper -->


  </form>


  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZJLM4L3" height="0" width="0" style="display:none;visibility:hidden">
    </iframe>
  </noscript>
  <!-- /Google Tag Manager (noscript) -->



  <!-- ===========================  CLENT-SIDE JAVASCRIPT  =========================== -->
  %%=Concat('<','script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js ">
    </script>')=%%
    %%=Concat('<','script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js">
      </script>')=%%
      %%=Concat('<','script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js ">
        </script>')=%%
        %%=Concat('<','script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js">
          </script>')=%%



</body>

</html>