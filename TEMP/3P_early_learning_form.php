<!--
=========================================
----------- GLOBAL FORM HTML ------------
=========================================

NOTES:
- clean up
- refine job titles and coutries ampscript
- add bootstrap validation
- clean up 3p js
- add in request parameter logic (?type=BOF/TOF -> BOF=2346 etc.)
- discuss multiple select box alternatives (simple checkboxes, selectable icons, no multiple, multiple options instead of multiple select, other pre-mades, bootstrap standard)
- dicuss hidden parametres to pass through
- redirectTO form
- XSRF Token
- add custom validation (joi.js)
- remove custom hides, change to d-none's
-->



<script runat="server">
    Platform.Load("core", "1");




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
            "FIRST_NAME",
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
            "FIRST_NAME",
            "LAST_NAME",
            "EMAIL_ADDRESS",
            "JOB_TITLE",
            "SCHOOL_NAME",
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
            "FIRST_NAME",
            "LAST_NAME",
            "EMAIL_ADDRESS",
            "PHONE_NUMBER",
            "JOB_TITLE",
            "STATE_NAME",
            "SCHOOL_NAME",
            "RE_INTEREST",
            "NO_OF_LICENCES",
            "TERMS_AND_CONDITIONS",
            "SUBSCRIBER_OPT_IN",
            "SUBMIT_BUTTON"
        ],
        //?form=quote
        dist_form: [
            "FIRST_NAME",
            "LAST_NAME",
            "EMAIL_ADDRESS",
            "PHONE_NUMBER",
            "JOB_TITLE",
            "STATE_NAME",
            "SCHOOL_NAME",
            "RE_INTEREST",
            "NO_OF_LICENCES",
            "TERMS_AND_CONDITIONS",
            "SUBSCRIBER_OPT_IN",
            "SUBMIT_BUTTON"
        ],

        //?form=info
        info: [
            "FIRST_NAME",
            "LAST_NAME",
            "EMAIL_ADDRESS",
            "JOB_TITLE",
            "STATE_NAME",
            "SCHOOL_NAME",
            "RE_INTEREST",
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
            "POSTAL_CODE",
            "TERMS_AND_CONDITIONS",
            "SUBSCRIBER_OPT_IN",
            "SUBMIT_BUTTON"
        ],

        demo: [
            "FIRST_NAME",
            "LAST_NAME",
            "EMAIL_ADDRESS",
            "JOB_TITLE",
            "STATE_NAME",
            "NO_OF_LICENCES",
            "TERMS_AND_CONDITIONS",
            "SUBSCRIBER_OPT_IN",
            "SUBMIT_BUTTON"
        ]

    } //FORM_TEMPLATE



    /*******************************
    ----- CHOOSE FORM TEMPLATE -----
    ********************************/


    //?form=( master | tof | bof )...etc
    var _form = Request.GetQueryStringParameter("form")
    _form = _form && _form.toLowerCase();
    if (_form) {
        var formFields = FORM_TEMPLATES[_form]
        for (var i = 0; i < formFields.length; i++) {
            Variable.SetValue(formFields[i], "true");
        } //for
    } //if




    /************************************
    ----- &/OR CHOOSE SINGLE FIELDS -----
    *************************************/


    //?fields=etc,etc,etc
    var _fields = Request.GetQueryStringParameter("fields")
    _fields = _fields && _fields.toUpperCase().split(',');
    if (_fields) {
        for (var i = 0; i < _fields.length; i++) {
            var _fields_field = _fields[i]
            Variable.SetValue(_fields_field, "true")
        } //for
    } //if




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
    Variable.SetValue('gclid', Request.GetQueryStringParameter("gclid"))
    Variable.SetValue('fbclid', Request.GetQueryStringParameter("fbclid"))
    Variable.SetValue('msclkid', Request.GetQueryStringParameter("msclkid"))






    /*******************************
    ----------- SECURITY -----------
    ********************************/


    Platform.Response.SetResponseHeader("Strict-Transport-Security", "max-age=200");
    Platform.Response.SetResponseHeader("X-XSS-Protection", "1; mode=block");
    // Platform.Response.SetResponseHeader("X-Frame-Options","Deny");
    Platform.Response.SetResponseHeader("X-Content-Type-Options", "nosniff");
    Platform.Response.SetResponseHeader("Referrer-Policy", "strict-origin-when-cross-origin");
    //Platform.Response.SetResponseHeader("Content-Security-Policy","default-src 'self'");
</script>


<!-- =============================== HTML =============================== -->
%%[

SET @Redirect = RequestParameter('rid')
SET @pid = ProperCase(RequestParameter('pid'))
SET @Product = LowerCase(RequestParameter('pid'))
set @fields = queryparameter('fields')
set @form = queryparameter('form')
]%%

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
    <!-- End Google Tag Manager -->

    <!-- Meta/SEO -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form">



    <!-- Title & Favicons -->
    <title> 3PLearning | Early Learning Canada form </title>
    <link rel="shortcut icon" href="https://image.mc1.3plearning.com/lib/fe95137375660d7974/m/1/Mathletics-Favicon-16px.png" type="image/x-icon" />
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
        /* font & colors
 ******************/
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

        /*
 custom submit button
 *********************/
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

        @media screen and (min-width: 767px) {
            .custom_submit_button {
                width: auto;
                margin-left: auto;
                margin-right: auto;
                /* float: right; */
            }
        }

        /*
 custom check boxes
 *******************/
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

        /* Fields
 ****************/
        .custom-field-label {
            font-weight: bold;
        }

        .custom-field-terms {
            font-weight: lighter;
            color: #495057;
        }

        /* Utility
 ****************/
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




</head>




<!-- =============================== BODY =========================== -->

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZJLM4L3"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <form id="3p_Early_Learning_Form"
        action="https://web.my.3plearning.com/3P_early_learning_processing"
        method="POST"
        target="_parent"
        onsubmit="return checkForm(this);">






        <!------------- Hidden ----------------->

        <input type="hidden" name="debug" value="%%=v(@_Debug)=%%">

        <input type="hidden" name="campaign-name" value="%%=v(@_Campaign_Name)=%%">
        <input type="hidden" name="triggered-send-key" value="%%=v(@_Triggered_Send_Key)=%%">
        <input type="hidden" id="pid" name="pid" value="%%=v(@Product)=%%">
        <input type="hidden" id="eid" name="eid" value="%%=v(@enquiry)=%%">
        <input type="hidden" id="rid" name="rid" value="%%=v(@Redirect)=%%">
        <input type="hidden" name="redirect-to-page" value="%%=v(@_Redirect_To_Page)=%%">
        <input type="hidden" id="form" name="form" value="%%=v(@form)=%%">
        <input type="hidden" id="utm-source" name="utm-source" value="%%=v(@_UTM_Source)=%%">
        <input type="hidden" id="utm-medium" name="utm-medium" value="%%=v(@_UTM_Medium)=%%">
        <input type="hidden" id="utm-campaign" name="utm-campaign" value="%%=v(@_UTM_Campaign)=%%">
        <input type="hidden" id="utm-content" name="utm-content" value="%%=v(@_UTM_Content)=%%">
        <input type="hidden" id="utm-term" name="utm-term" value="%%=v(@_UTM_Term)=%%">
        <input type="hidden" id="countrycode" name="countrycode" value="%%=v(@Country_Code)=%%">
        <input type="hidden" id="gclid" name="gclid" value="%%=v(@gclid)=%%">
        <input type="hidden" id="fbclid" name="fbclid" value="%%=v(@fbclid)=%%">
        <input type="hidden" id="msclkid" name="msclkid" value="%%=v(@msclkid)=%%">
        <input type="hidden" id="referrer" name="referrer" value="">









        <!-- Wrapper -->
        <div class=" container my-5">
            <div class="row">
                <div class="col">




                    %%[
                    if indexOf(@product, "mathletics") > 0 then
                    set @mathletics = 1
                    endif
                    if indexOf(@product, "mathseeds") > 0 then
                    set @mathseeds = 1
                    endif
                    if indexOf(@product, "readingeggs") > 0 then
                    set @readingeggs = 1
                    endif
                    ]%%




                    <!------------- Product Interest ----------------->

                    %%[If @PRODUCT_INTEREST Then]%%
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="product_interest_select" class="custom-field-label">
                                    PRODUCT INTERESTS
                                </label>
                                <select class="form-control selectpicker show-tick"
                                    id="product_interest_select"
                                    name="product-interest"
                                    multiple
                                    title="Select Your Product Interests"
                                    data-selected-text-format="values"
                                    data-actions-box="true"
                                    required
                                    style="color:#495057c7; font-weight: 400;">

                                    <option value="mathletics" %%=IIF(not empty(@mathletics), "Selected" , "" )=%%>Mathletics</option>
                                    <option value="mathseeds" %%=IIF(not empty(@mathseeds), "Selected" , "" )=%%>Mathseeds</option>
                                    <option value="readingeggs" %%=IIF(not empty(@readingeggs), "Selected" , "" )=%%>Reading Eggs</option>

                                </select>
                                <div id="product_interest_invalid" class="custom-invalid-label custom-hide text-right">Select a product interest</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%

                    <!------------- Grade Level ----------------->

                    %%[If @RE_INTEREST Then]%%
                    <div class="row">
                        <div class="col">
                            <div class="form-group" style="margin-bottom: 30px;">

                                <select class="form-control"
                                    id="re_interest_select"
                                    name="re_interest"
                                    required
                                    autofocus
                                    style="color:#495057c7; font-weight: 400;">
                                    <option disabled selected hidden>What are you interested in?</option>
                                    <option value="quote_mr">Request a quote for Mathseeds and Reading Eggs</option>
                                    <option value="demo_mr">Request a demo for Mathseeds and Reading Eggs</option>
                                    <option value="quote_m">Request a quote for Mathseeds</option>
                                    <option value="demo_m">Request a demo for Mathseeds</option>
                                    <option value="quote_r">Request a quote for Reading Eggs</option>
                                    <option value="demo_r">Request a demo for Reading Eggs</option>

                                </select>
                                <div id="re_interest_invalid" class="custom-invalid-label custom-hide text-right">Your Interest in ReadingEggs is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%


                    <!------------- First Name ----------------->

                    %%[If @FIRST_NAME Then]%%
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">

                                <input type="text"
                                    class="form-control"
                                    id="first_name_input"
                                    name="first-name"
                                    placeholder="First Name"

                                    required>
                                <div id="first_name_invalid" class="custom-invalid-label custom-hide text-right">First name is required</div>


                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <input type="text"
                                    class="form-control"
                                    id="last_name_input"
                                    name="last-name"
                                    placeholder="Last Name"
                                    required>
                                <div id="last_name_invalid" class="custom-invalid-label custom-hide text-right">Last name is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%








                    <!------------- Email Addres----------------->

                    %%[If @EMAIL_ADDRESS Then]%%
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">

                                <input type="email"
                                    class="form-control"
                                    id="email_address_input"
                                    name="email-address"
                                    placeholder="School or District Email Address"
                                    required>
                                <div id="email_address_invalid" class="custom-invalid-label custom-hide text-right">Please provide a valid school or district email address.</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <input type="text"
                                    class="form-control"
                                    id="phone_number_input"
                                    name="phone-number"
                                    placeholder="Mobile / Work Phone"
                                    required>
                                <div id="phone_number_invalid" class="custom-invalid-label custom-hide text-right">Phone number is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%





                    <!------------- Grade Level ----------------->

                    %%[If @GRADE_LEVEL Then]%%
                    <div class="row">
                        <div class="col">
                            <div class="form-group">

                                <select class="form-control"
                                    id="grade_level_select"
                                    name="grade-level"
                                    required
                                    style="color:#495057c7; font-weight: 400;">
                                    <option disabled selected>Select Grade Level</option>
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
                                <div id="grade_level_invalid" class="custom-invalid-label custom-hide text-right">Grade level is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%



                    <!------------- Job Title ----------------->
                    %%[If @JOB_TITLE Then]%%
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <select class="form-control"
                                    id="job_title_select"
                                    name="job_title_select"
                                    required
                                    onchange="showOtherTitleInput(this.value);" <!-- Added onchange event handler -->
                                    style="color:#495057c7; font-weight: 400;" >
                                    <option value="" selected disabled>Title</option>

                                    %%[
                                    /* Populate Job Title Options and Redirect
                                    ********************************/

                                    Set @Job_Titles = LookupRows("jobTitle_USA_District_Forms", "Active", "1")
                                    For @i = 1 TO RowCount(@Job_Titles) DO
                                    Set @Job_Title = Field(Row(@Job_Titles, @i), "Job Title")
                                    OutputLine(Concat('<option value="',@Job_Title,'">',@Job_Title,'</option>'))
                                    Next @i

                                    /* Add an option for 'Other' */
                                    OutputLine('<option value="Other">Other</option>')
                                    ]%%
                                </select>
                                <div id="job_title_invalid" class="custom-invalid-label custom-hide text-right">Role is required</div>

                                <!-- Additional input for 'Other' job title, initially hidden -->
                                <div class="row" id="other_job_title_div" style="display:none; margin-top: 10px;">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" id="other_job_title" name="other_job_title" class="form-control" placeholder="Please specify your role">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" id="state_name_form_group">

                                <select class="form-control"
                                    id="state_name_select"
                                    name="state-name"
                                    onchange=jobTitleChanged()
                                    required
                                    style="color:#495057c7; font-weight: 400;">
                                    <option disabled selected>State</option>

                                    %%[

                                    /* Populate Job Title Options and Redirect
                                    ********************************/

                                    Set @ca_states = LookupOrderedRows("state",0,"State Name ASC", "Country Code", "US")
                                    For @i = 1 TO RowCount(@ca_states) DO
                                    Set @CA_state = Field(Row(@ca_states, @i), "State Name")
                                    OutputLine(Concat('<option value="',@CA_state,'">',@CA_state,'</option>'))
                                    Next @i

                                    ]%%
                                </select>
                                <div id="state_invalid" class="custom-invalid-label custom-hide text-right">Province is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%




                    <!------------- Country ----------------->

                    %%[If @COUNTRY_NAME Then]%%
                    <div class="row">
                        <div class="col">
                            <div class="form-group">

                                <select class="form-control"
                                    id="country_name_select"
                                    name="country-name"
                                    required
                                    style="color:#495057c7; font-weight: 400;">
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
                                <div id="country_invalid" class="custom-invalid-label custom-hide text-right">Country is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%







                    <!------------- Postal Code ----------------->

                    %%[If @POSTAL_CODE Then]%%
                    <div class="row">
                        <div class="col">
                            <div class="form-group">

                                <input class="form-control"
                                    type="text"
                                    id="postal_code_input"
                                    name="postal-code"
                                    placeholder="Postcode / Zipcode"
                                    title="Postcode/Zipcode is 4 digits with no spaces"
                                    required>
                                <div id="postcode_invalid" class="custom-invalid-label custom-hide text-right">Postcode is required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%




                    <!------------- School Name ----------------->

                    %%[If @SCHOOL_NAME Then]%%
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">

                                <input type="text"
                                    class="form-control"
                                    id="school_name_input"
                                    name="school-name"
                                    placeholder="District or School Name"
                                    required>
                                <div id="school_name_invalid" class="custom-invalid-label custom-hide text-right">District or School name is required</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">

                                <input type="number"
                                    class="form-control"
                                    id="no_of_licences_input"
                                    name="no-of-licences"
                                    placeholder="How many students are you looking to support?"
                                    required
                                    min="20">
                                <div id="no_of_licences_invalid" class="custom-invalid-label custom-hide text-right">Number of student licences required</div>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%





                    <!------------- Terms & Conditions ----------------->

                    %%[If @TERMS_AND_CONDITIONS Then]%%
                    <div class="row mt-0">
                        <div class="col">
                            <div class="form-group">

                                <input
                                    type="checkbox"
                                    id="terms_and_conditions_input"
                                    name="terms-and-conditions"
                                    value="true"
                                    required
                                    tabindex="-1" />
                                <label for="terms_and_conditions_input" class="custom-field-terms form-check-label">
                                    I agree to the 3P Learning <a target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">terms and
                                        conditions</a>.</label>

                                <div id="terms_and_conditions_invalid" class="custom-invalid-label custom-hide text-right">Please agree to the <a target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">terms and
                                        conditions</a>.</div>

                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%



                    <!------------- Subscriber Opt In ----------------->

                    %%[If @SUBSCRIBER_OPT_IN Then]%%
                    <div class="row mt-0">
                        <div class="col">
                            <div class="form-group">
                                <input type="checkbox"
                                    id="subscriber_opt_in_input"
                                    name="subscriber-opt-in"
                                    value="true"
                                    tabindex="-1" />
                                <label for="subscriber_opt_in_input" class="custom-field-terms form-check-label" style="display: inline;">
                                    YES! Sign me up for monthly newsletters, educational content, resources and occasional promotional material.
                                </label>
                                <!-- <div id="subscriber_opt_in_invalid" class="custom-invalid-label custom-hide text-right">...</div> -->
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%



                    <!------------- Submit Button ----------------->

                    %%[If @SUBMIT_BUTTON Then]%%
                    <div class="row mt-4">
                        <div class="col text-center">
                            <div class="form-group">
                                <button class="custom_submit_button"
                                    type="submit"
                                    name="myButton"
                                    id="submit_button"
                                    value="Submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                    %%[EndIf]%%



                </div>
            </div>
        </div>
        <!-- //wrapper -->
    </form>



    <!-- ===========================  JAVASCRIPT  =========================== -->


    %%=Concat('<','script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js ">
        </script>')=%%
        %%=Concat('<','script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js">
            </script>')=%%
            %%=Concat('<','script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js ">
                </script>')=%%
                %%=Concat('<','script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js">
                    </script>')=%%
                    %%=Concat('<','script src="https://my.mathletics.com/MXformFieldFunctions">
                        </script>')=%%




                        <!-- Custom Javascript -->

                        %%=Concat('<','script>')=%%

                            /**************************************************
                            ----- Parse Cookie Data to hidden form fields -----
                            ***************************************************/

                            // Parse the Cookie
                            var cname = "setURLParamsCookie"
                            function getCookie(cname) {
                            var name = cname + "=";
                            var decodedCookie = decodeURIComponent(document.cookie);
                            var ca = decodedCookie.split(';');
                            for(var i = 0; i <ca.length; i++) {
                                var c=ca[i];
                                while (c.charAt(0)==' ' ) {
                                c=c.substring(1);
                                }
                                if (c.indexOf(name)==0) {
                                return c.substring(name.length, c.length);
                                }
                                }
                                return "" ;
                                }
                                var referrer=getCookie("__gtm_referrer");
                                // Parse the URL inside Cookie
                                function getParameterByName(name) {
                                name=name.replace(/[\[]/, "\\[" ).replace(/[\]]/, "\\]" );
                                var regex=new RegExp("[\\?&]" + name + "=([^&#]*)" );

                                results=regex.exec(getCookie("setURLParamsCookie"));
                                return results===null ? "" : decodeURIComponent(results[1].replace(/\+/g, " " ));
                                }
                                // Pass the values to hidden field
                                var cookieCheck=document.cookie.indexOf('setURLParamsCookie')
                                if (cookieCheck> 0) {
                                document.querySelector("#utm-source").value = getParameterByName('utm_source');
                                document.querySelector("#utm-medium").value = getParameterByName('utm_medium');
                                document.querySelector("#utm-campaign").value = getParameterByName('utm_campaign');
                                document.querySelector("#utm-content").value = getParameterByName('utm_content');
                                document.querySelector("#utm-term").value = getParameterByName('utm_term');
                                document.querySelector("#gclid").value = getParameterByName('gclid');
                                document.querySelector("#fbclid").value = getParameterByName('fbclid');
                                document.querySelector("#msclkid").value = getParameterByName('msclkid');
                                document.querySelector("#referrer").value = referrer;
                                };

                                %%=Concat('<',' /script>')=%%

                                    %%=Concat('<','script>')=%%

                                        /****************************
                                        ----- On Submit -----
                                        *****************************/

                                        function checkForm(form) // Submit button clicked
                                        {
                                        //
                                        // check form input values
                                        //
                                        let x = document.getElementById("submit_button");
                                        setTimeout(function(){ x.innerHTML="Processing..." }, 2000);
                                        form.myButton.innerHTML = "Please wait...";
                                        form.myButton.disabled = true;
                                        form.myButton.value = "Please wait...";
                                        return true;
                                        }


                                        /****************************
                                        ----- On Country Change -----
                                        *****************************/


                                        //CONSTANTS
                                        let allStateNameData;

                                        //DOM ELEMENTS
                                        const thisDocument = $(document);
                                        const countryNameSelect = $('#country_name_select');
                                        const stateNameFormGroup = $('#state_name_form_group');
                                        const stateNameSelect = $('#state_name_select');


                                        //EVENTS
                                        thisDocument.on('ready', getStateNameData)
                                        countryNameSelect.on('change', handleChangeCountryName);


                                        //HANDLERS

                                        function getStateNameData() {
                                        let allStatesURLPath = "/mx_states"
                                        axios.get(allStatesURLPath)
                                        .then(response => {
                                        allStateNameData = response.data
                                        }).catch(console.error)
                                        }//

                                        function handleChangeCountryName(e) {
                                        //choose states
                                        let countryCode = e.target[e.target.selectedIndex].dataset.countrycode
                                        let countryStateData = allStateNameData.filter((option) => option["Country Code"] == countryCode)

                                        //reset options
                                        stateNameSelect.val('')
                                        stateNameSelect.find("option").remove();
                                        stateNameSelect.append(`<option disabled selected>Select ${countryCode==="CA"? 'Province': 'State'}</option>`)

                                        //populate options or hide select
                                        if (countryStateData.length > 0) {
                                        //states found
                                        stateNameFormGroup.show();
                                        stateNameSelect.attr("required", "true");
                                        countryStateData.forEach((state) => {
                                        stateNameSelect.append(`<option value="${state['State Code']}">${state['State Name']}</option>`)
                                        })//forEach
                                        } else {
                                        //no states found
                                        stateNameFormGroup.hide();
                                        stateNameSelect.removeAttr("required");
                                        }//if

                                        }//handleChange()



                                        %%=Concat('<',' /script>')=%%


                                            %%=Concat('<','script>')=%%

                                                document.addEventListener("DOMContentLoaded", function() {
                                                var emailInput = document.getElementById("email_address_input");
                                                var invalidEmailLabel = document.getElementById("email_address_invalid");

                                                // List of common email domains to invalidate
                                                var commonDomains = [
                                                "gmail.com", "yahoo.com", "hotmail.com", "aol.com", "outlook.com",
                                                "live.com", "msn.com", "icloud.com", "mail.com", "yahoo.co.uk"
                                                ];

                                                emailInput.addEventListener("input", function() {
                                                var emailValue = emailInput.value.toLowerCase();
                                                var domain = emailValue.split('@')[1]; // Extract the domain from the email

                                                if (commonDomains.includes(domain)) {
                                                // If the domain is in the list of common domains, show the error message
                                                invalidEmailLabel.classList.remove("custom-hide");
                                                emailInput.setCustomValidity("Please provide a valid school or district email address.");
                                                } else {
                                                // If the domain is not in the list, hide the error message
                                                invalidEmailLabel.classList.add("custom-hide");
                                                emailInput.setCustomValidity("");
                                                }
                                                });
                                                });



                                                %%=Concat('<',' /script>')=%%

                                                    %%=Concat('<',' /script>')=%%


                                                        %%=Concat('<','script>')=%%

                                                            function showOtherTitleInput(value) {
                                                            var otherInputDiv = document.getElementById("other_job_title_div");
                                                            if (value === "Other") {
                                                            otherInputDiv.style.display = "block"; // Show the 'Other' input
                                                            } else {
                                                            otherInputDiv.style.display = "none"; // Hide the 'Other' input
                                                            document.getElementById("other_job_title").value = ""; // Clear the value if 'Other' is not selected
                                                            }
                                                            }



                                                            %%=Concat('<',' /script>')=%%

</body>

</html>
