<script runat="server">
    Platform.Load("core", "1");
</script>


<!--


TODO:



Automatic redirect when a person enters “Parent” or “student” into
the Job Title form field, to the appropriate B2C landing page
- What is the landing page based or region or query param
- Is there a better way to do this
        - "Are you a parent/student? Click here" link
        - optional popup?

add a loading indicator on submit

follow up on  missing EMEA mapping for job title -> job functions mappings

look into gclid, fbclid mscclid functionality and pass valus through perhaps

finish processing script porting from automation into here with ssjs

implement full wsproxy/wrapped ampscript salesforce sync section

run everything through cl-ai to simplify, fix errors, seek advice, etc

test. test, test ===> batte-test for all variatioons and 150 form planned rollout!!!!

confirm a solid list of finalized form fields (and there overrides) with teams

confirm all form fields are mapped to the correct field in salesforce

overidde all displayed inputs and update here and pipeline

-->



<script runat="server">
    if (Request.Method() != "GET") return;
    try {

        var documentation = ''.concat(
            '<div style="padding: 15px; font-weight:bold">',
            '//========================================================================================================== <br>',
            '// REUSABLE FORM TEMPLATE <br>',
            '// <br>',
            '// @Template Author: Nick Phillips <br>',
            '// @Template Version: 1.0.0 <br>',
            '// <br>',
            '// CHANGE LOG <br>',
            '// ------------------------------------------- <br>',
            '// <br>',
            '// Version: 1.0.0... ',
            '// Date: ... ',
            '// Change: ... <br>',
            '// Version: ?.?.?... ',
            '// Date: ... ',
            '// Change: ... <br>',
            '// <br>',
            '// ========================================================================================================== <br>',
            '<br>',
            '<br>',
            'FORM DETAILS <br>',
            '------------------------------------------- <br>',
            '<br>',
            'Region: <br>',
            'Campaign(s): <br>',
            'Form Created By: <br>',
            'Form Created Date: <br>',
            '<br>',
            '<br>',
            '<span style="color:green; font-size:20px">Congratulations, Your form is working!</span><br>',
            'Please configure all the required query parameters below to hide this documentaiton<br>',
            '<br>',
            '<br>',
            'QUERY PARAMETERS <br>',
            '------------------------------------------- <br>',
            '<br>',
            '@parameter: (optional) debug - Used to output debug information when testing the form <br>',
            '<br>',
            '@parameter: (required) template - the name of an array of preconfigured form inputs to display OR...<br>',
            '@parameter: (required) inputs - a comma-deliminated string of single form inputs to display <br>',
            '<br>',
            '@parameter: (optional) apac_cid - Used on GLOBAL forms to choose the campaign id when the lead submits from an APAC based country  <br>',
            '@parameter: (optional) amer_cid - Used on GLOBAL forms to choose the campaign id when the lead submits from an AMER based country <br>',
            '@parameter: (optional) emea_cid - Used on GLOBAL forms to choose the campaign id when the lead submits from an EMEA based country   <br>',
            '<br>',
            '@parameter: (optional) cid - the default salesforce campaign id regardless of country or region. <br>',
            '@parameter: (optional) rid - the redirect id used to retrieve a url from a DE and redirect the user after form submission <br>',
            '<br>',
            '@parameter: (optional) utm_source - marketing trackers retrieved from a browser cookie <br>',
            '@parameter: (optional) utm_medium - marketing trackers retrieved from a browser cookie <br>',
            '@parameter: (optional) utm_campaign - marketing trackers retrieved from a browser cookie <br>',
            '@parameter: (optional) utm_content - marketing trackers retrieved from a browser cookie <br>',
            '@parameter: (optional) utm_term - marketing trackers retrieved from a browser cookie <br>',
            '<br>',
            '@parameter: (optional) gclid - (google click ID) marketing trackers retrieved from a browser cookie <br>',
            '<br>',
            '<br>',
            'EXAMPLE URLS <br>',
            '------------------------------------------- <br>',
            '<br>',
            '@example: Test <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?template=test <br>',
            '<br>',
            '@example: Test Columns <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?template=test_columns <br>',
            '<br>',
            '@example: Test States <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?template=test_states <br>',
            '<br>',
            '@example: Basic Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,SCHOOL_NAME,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: TOF Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,JOB_TITLE_PER_COUNTRY_CODE,SCHOOL_NAME,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: BOF Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,JOB_TITLE_PER_COUNTRY_CODE,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,POSTCODE_ZIPCODE,SCHOOL_NAME,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: Quote Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=PRODUCT_INTEREST,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,POSTCODE_ZIPCODE,SCHOOL_NAME,PHONE_NUMBER,JOB_TITLE_PER_COUNTRY_CODE,GRADE_LEVEL,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: US Form Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=PRODUCT_INTEREST,ENQUIRY_TYPE,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,POSTCODE_ZIPCODE,SCHOOL_NAME,PHONE_NUMBER,JOB_TITLE_PER_COUNTRY_CODE,GRADE_LEVEL,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: Trial Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE_PER_COUNTRY_CODE,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,POSTCODE_ZIPCODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: Info Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE_PER_COUNTRY_CODE,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,POSTCODE_ZIPCODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '@example: Demo Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE_PER_COUNTRY_CODE,COUNTRY_CODE,STATE_CODE_PER_COUNTRY_CODE,POSTCODE_ZIPCODE,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON_3PL <br>',
            '<br>',
            '<br> ',
            '</div>'
        );


        /*******************************
        ----------- SECURITY -----------
        ********************************/


        // Prevents the page from being iframed into another site.
        // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
        // Platform.Response.SetResponseHeader("X-Frame-Options","Deny");

        // Prevents loading of malicious content.
        // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy
        // Platform.Response.SetResponseHeader("Content-Security-Policy","default-src 'self'");

        // Prevents man-in-the-middle attacks by ensuring traffic is HTTPS.
        // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security
        Platform.Response.SetResponseHeader("Strict-Transport-Security", "max-age=200");

        // Prevents MIME sniffing attacks.
        // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options
        Platform.Response.SetResponseHeader("X-Content-Type-Options", "nosniff");

        // Prevents cross-site scripting attacks.
        // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection
        Platform.Response.SetResponseHeader("X-XSS-Protection", "1; mode=block");

        // Prevents referrer leakage.
        // See https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy
        Platform.Response.SetResponseHeader("Referrer-Policy", "strict-origin-when-cross-origin");


        /*******************************
        ------- QUERY PARAMETERS -------
        ********************************/


        var config = {};


        //retrieve data
        config.debug = Request.GetQueryStringParameter("debug");

        config.apac_cid = Request.GetQueryStringParameter("apac_cid");
        config.amer_cid = Request.GetQueryStringParameter("amer_cid");
        config.emea_cid = Request.GetQueryStringParameter("emea_cid");
        config.cid = Request.GetQueryStringParameter("cid");

        config.rid = Request.GetQueryStringParameter("rid");

        config.template = Request.GetQueryStringParameter("template");
        config.inputs = Request.GetQueryStringParameter("inputs");

        config.text_heading_content = Request.GetQueryStringParameter("text_heading_content");
        config.text_paragraph_content = Request.GetQueryStringParameter("text_paragraph_content");

        config.utm_source = Request.GetQueryStringParameter("utm_source");
        config.utm_medium = Request.GetQueryStringParameter("utm_medium");
        config.utm_campaign = Request.GetQueryStringParameter("utm_campaign");
        config.utm_content = Request.GetQueryStringParameter("utm_content");
        config.utm_term = Request.GetQueryStringParameter("utm_term");

        config.gclid = Request.GetQueryStringParameter("gclid");
        config.fbclid = Request.GetQueryStringParameter("fbclid");
        config.msclkid = Request.GetQueryStringParameter("msclkid");

        config.override_country_code = Request.GetQueryStringParameter("override_country_code");
        config.override_product_interest = Request.GetQueryStringParameter("override_product_interest");
        config.override_marketing_interest = Request.GetQueryStringParameter("override_marketing_interest");
        config.override_enquiry_type = Request.GetQueryStringParameter("override_enquiry_type");
        config.override_lead_status = Request.GetQueryStringParameter("override_lead_status");
        config.override_job_title = Request.GetQueryStringParameter("override_job_title");


        /*******************************
         ------ ADDITIONAL VALUES ------
        ********************************/


        //request url
        config.request_url = Request.URL();


        /*************************
        -------- TEMPLATES -------
        **************************/


        config.TEMPLATES = {


            //?template=test_full
            test: [
                "PRODUCT_INTEREST",
                "MARKETING_INTEREST",
                "ENQUIRY_TYPE",
                "FIRST_NAME",
                "LAST_NAME",
                "EMAIL_ADDRESS",
                "PHONE_NUMBER",
                "GRADE_LEVEL",
                "SUBJECT",
                "COUNTRY_CODE",
                "STATE_CODE_PER_COUNTRY_CODE",
                "POSTCODE_ZIPCODE",
                "SCHOOL_NAME",
                "JOB_TITLE_PER_COUNTRY_CODE",
                "NO_OF_LICENCES",
                "TERMS_AND_CONDITIONS",
                "SUBSCRIBER_OPT_IN",
                "SUBMIT_BUTTON_3PL"
            ],


            //?template=test_full_half
            test_half: [
                "PRODUCT_INTEREST_HALF",
                "MARKETING_INTEREST_HALF",
                "ENQUIRY_TYPE_HALF",
                "FIRST_NAME_HALF",
                "LAST_NAME_HALF",
                "EMAIL_ADDRESS_HALF",
                "PHONE_NUMBER_HALF",
                "GRADE_LEVEL_HALF",
                "SUBJECT_HALF",
                "COUNTRY_CODE_HALF",
                "STATE_CODE_PER_COUNTRY_CODE_HALF",
                "POSTCODE_ZIPCODE_HALF",
                "SCHOOL_NAME_HALF",
                "JOB_TITLE_PER_COUNTRY_CODE_HALF",
                "NO_OF_LICENCES_HALF",
                "PUSH_HALF",
                "TERMS_AND_CONDITIONS_HALF",
                "SUBSCRIBER_OPT_IN_HALF",
                "SUBMIT_BUTTON_3PL"
            ],

            //?template=test_inputs
            test_inputs: [

            ],

            //?template=test_selects
            test_selects: [

            ],

            //?template=test_selects
            test_multi_selects: [

            ],

            //?template=test_checkboxes
            test_checkboxes: [
                "TERMS_AND_CONDITIONS",
                "TERMS_AND_CONDITIONS_HALF",
                "SUBSCRIBER_OPT_IN",
                "SUBSCRIBER_OPT_IN_HALF"
            ],

            //?template=test_countries
            test_countries: [
                "COUNTRY_CODE",
                "COUNTRY_CODE_HALF",
                "COUNTRY_CODE_APAC",
                "COUNTRY_CODE_APAC_HALF",
                "COUNTRY_CODE_AMER",
                "COUNTRY_CODE_AMER_HALF",
                "COUNTRY_CODE_EMEA",
                "COUNTRY_CODE_EMEA_HALF",
            ],

            //?template=test_states
            test_states: [
                "COUNTRY_CODE",
                "COUNTRY_CODE_HALF",
                "STATE_CODE_PER_COUNTRY_CODE",
                "STATE_CODE_PER_COUNTRY_CODE_HALF",
                "STATE_CODE_AU",
                "STATE_CODE_AU_HALF",
                "STATE_CODE_NZ",
                "STATE_CODE_NZ_HALF",
                "STATE_CODE_US",
                "STATE_CODE_US_HALF",
                "STATE_CODE_CA",
                "STATE_CODE_CA_HALF",
                "STATE_CODE_ZA",
                "STATE_CODE_ZA_HALF"
            ],

            //?template=job_titles
            test_job_titles: [
                "COUNTRY_CODE",
                "COUNTRY_CODE_HALF",
                "JOB_TITLE_PER_COUNTRY_CODE",
                "JOB_TITLE_PER_COUNTRY_CODE_HALF",
                "JOB_TITLE_APAC",
                "JOB_TITLE_APAC_HALF",
                "JOB_TITLE_AMER",
                "JOB_TITLE_AMER_HALF",
                "JOB_TITLE_EMEA",
                "JOB_TITLE_EMEA_HALF",
            ],

            //?template=test_all
            test_all: [
                "PRODUCT_INTEREST",
                "PRODUCT_INTEREST_HALF",
                "MARKETING_INTEREST",
                "MARKETING_INTEREST_HALF",
                "ENQUIRY_TYPE",
                "ENQUIRY_TYPE_HALF",
                "FIRST_NAME",
                "FIRST_NAME_HALF",
                "LAST_NAME",
                "LAST_NAME_HALF",
                "EMAIL_ADDRESS",
                "EMAIL_ADDRESS_HALF",
                "PHONE_NUMBER",
                "PHONE_NUMBER_HALF",
                "GRADE_LEVEL",
                "GRADE_LEVEL_HALF",
                "SUBJECT",
                "SUBJECT_HALF",
                "JOB_TITLE_PER_COUNTRY_CODE",
                "JOB_TITLE_PER_COUNTRY_CODE_HALF",
                "COUNTRY_CODE",
                "COUNTRY_CODE_HALF",
                "STATE_CODE_PER_COUNTRY_CODE",
                "STATE_CODE_PER_COUNTRY_CODE_HALF",
                "POSTCODE_ZIPCODE",
                "POSTCODE_ZIPCODE_HALF",
                "SCHOOL_NAME",
                "SCHOOL_NAME_HALF",
                "NO_OF_LICENCES",
                "NO_OF_LICENCES_HALF",
                "TERMS_AND_CONDITIONS",
                "TERMS_AND_CONDITIONS_HALF",
                "SUBSCRIBER_OPT_IN",
                "SUBSCRIBER_OPT_IN_HALF",
                "SUBMIT_BUTTON_3PL",
            ]

        } //config.TEMPLATES


        /**************************************
        ----- CHOOSE COMPONENTS TO RENDER -----
        ***************************************/


        // CONSTANTS
        config.FORM_COMPONENT_LIST = [];


        // ADD ALL TEMPLATE COMPONENTS
        if (config.template) {
            var templateComponentList = config.TEMPLATES[config.template.toLowerCase()];
            config.FORM_COMPONENT_LIST = config.FORM_COMPONENT_LIST.concat(templateComponentList);
        } //if


        // ADD SINGLE INPUT COMPONENTS
        if (config.inputs) {
            var singleInputList = config.inputs.toUpperCase().split(',');
            for (var i = 0; i < singleInputList.length; i++) {
                var singleInput = singleInputList[i];
                config.FORM_COMPONENT_LIST.push(singleInput);
            } //for
        } //if


        // PASS CONFIGURATION TO AMPSCRIPT
        for (var key in config) {
            if (config.hasOwnProperty(key)) {
                Variable.SetValue(key, config[key]);
            }
        }


        // RENDER FORM
        if (config.FORM_COMPONENT_LIST.length > 0) {
            Variable.SetValue("RENDER_HTML", true);
        }


        /*******************************
        ------------ INFO -------------
        ********************************/

        //show config documentation when required query parameters are missing
        if (
            !config.template &&
            !config.inputs
        ) {
            Write(documentation);
        }

        //show  debug info when debug is true
        if (debug) {
            Write('<div style="padding:15px">[DEBUG MODE] <br><br> Current Cofiguration: <br><br>' + Stringify(config) + '</div>');
        }

        /*******************************
         ------------ ERROR -------------
         ********************************/


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }
</script>



%%[IF (@RENDER_HTML) THEN]%%



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


    <!-- No Script -->
    <noscript>
        <!-- Google Tag Manager  -->
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T97DM2H"
            height="0" width="0" style="display:none;visibility:hidden">
        </iframe>
    </noscript>


    <!-- Meta/SEO -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>


    <!-- Global Styles -->
    <style>
        :root {
            font-size: 16px;
        }

        /* mui input placeholder color */
        input::placeholder {
            color: rgb(0, 0, 0, 0.87) !important;
        }

        /* mui select options text color */
        ul.dropdown-content.select-dropdown li span {
            color: rgb(0, 0, 0, 0.87) !important;
        }

        /* mui center toast container */
        #toast-container {
            left: 50% !important;
            transform: translateX(-50%) !important;
            min-width: 0 !important;
        }

        [data-custom-message] {
            display: inline-block;
            font-size: 12px;
            color: #039be5
        }

        [data-custom-message].valid {
            color: #4CAF50 !important;
        }

        [data-custom-message].invalid {
            color: #f44336 !important;
        }
    </style>


</head>



<!-- =============================== BODY =========================== -->



<body>


    <!------------- FORM ----------------->


    <form
        novalidate
        method="POST">


        <!-- HIDDEN -->

        <div>

            <input type="hidden" name="_debug" value="%%=v(@debug)=%%">

            <input type="hidden" name="_apac_cid" value="%%=v(@apac_cid)=%%">
            <input type="hidden" name="_amer_cid" value="%%=v(@amer_cid)=%%">
            <input type="hidden" name="_emea_cid" value="%%=v(@emea_cid)=%%">
            <input type="hidden" name="_cid" value="%%=v(@cid)=%%">

            <input type="hidden" name="_rid" value="%%=v(@rid)=%%">

            <input type="hidden" name="_template" value="%%=v(@template)=%%">
            <input type="hidden" name="_inputs" value="%%=v(@inputs)=%%">

            <input type="hidden" name="_utm_source" value="%%=v(@utm_source)=%%">
            <input type="hidden" name="_utm_medium" value="%%=v(@utm_medium)=%%">
            <input type="hidden" name="_utm_campaign" value="%%=v(@utm_campaign)=%%">
            <input type="hidden" name="_utm_content" value="%%=v(@utm_content)=%%">
            <input type="hidden" name="_utm_term" value="%%=v(@utm_term)=%%">

            <input type="hidden" name="_gclid" value="%%=v(@gclid)=%%">
            <input type="hidden" name="_fbclid" value="%%=v(@fbclid)=%%">
            <input type="hidden" name="_msclkid" value="%%=v(@msclkid)=%%">

            <input type="hidden" name="_request_url" value="%%=v(@request_url)=%%">
            <input type="hidden" name="_location_href">
            <input type="hidden" name="_document_referrer">

            <input type="hidden" name="_override_country_code" value="%%=v(@override_country_code)=%%">
            <input type="hidden" name="_override_product_interest" value="%%=v(@override_product_interest)=%%">
            <input type="hidden" name="_override_marketing_interest" value="%%=v(@override_marketing_interest)=%%">
            <input type="hidden" name="_override_enquiry_type" value="%%=v(@override_enquiry_type)=%%">
            <input type="hidden" name="_override_lead_status" value="%%=v(@override_lead_status)=%%">
            <input type="hidden" name="_override_job_title" value="%%=v(@override_job_title)=%%">


            <!-- Assign client side location and referrer urls -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelector('input[name="_location_href"]').value = window.location.href;
                    document.querySelector('input[name="_document_referrer"]').value = document.referrer;
                })
            </script>

        </div>


        <!-- Wrapper -->
        <div class="container">
            <div class="row card-panel orange lighten-5">


                %%[
                /************************************
                START LOOPING OVER RENDER COMPONENTS
                *************************************/
                SET @LENGTH = ROWCOUNT(@FORM_COMPONENT_LIST)
                FOR @index = 1 TO @LENGTH DO
                SET @FORM_COMPONENT = ROW(@FORM_COMPONENT_LIST, @index)
                ]%%


                %%[IF (@FORM_COMPONENT == "PUSH") THEN]%%
                <!------------------ Push --------------------->
                <div class="col s12 hide-on-small-only" style="height: 115px;"></div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PUSH_HALF") THEN]%%
                <!------------------ Push ---------------------->
                <div class="col s12 m6 hide-on-small-only" style="height: 115px;"></div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SPACER") THEN]%%
                <!------------------ Push --------------------->
                <div class="col s12 hide-on-small-only" style="height: 20px;"></div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SPACER_HALF") THEN]%%
                <!------------------ Push ---------------------->
                <div class="col s12 m6 hide-on-small-only" style="height: 20px;"></div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "DIVIDER") THEN]%%
                <!----------------- Divider --------------------->
                <div class="divider"></div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TEXT_HEADING") THEN]%%
                <!----------------- Text Heading --------------------->
                <div class="col s12">
                    <h5>%%=v(@TEXT_HEADING_CONTENT)=%%</h5>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TEXT_HEADING_HALF") THEN]%%
                <!----------------- Text Heading --------------------->
                <div class="col s12 m6">
                    <h5>%%=v(@TEXT_HEADING_CONTENT)=%%</h5>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TEXT_PARAGRAPH") THEN]%%
                <!----------------- Text Paragraph --------------------->
                <div class="col s12">
                    <p>%%=v(@TEXT_PARAGRAPH_CONTENT)=%%</p>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == " TEXT_PARAGRAPH_HALF") THEN]%%
                <!----------------- Text Paragraph --------------------->
                <div class="col s12 m6">
                    <p>%%=v(@TEXT_PARAGRAPH_CONTENT)=%%</p>
                </div>
                %%[ENDIF]%%



                %%[IF (@FORM_COMPONENT == "PRODUCT_INTEREST") THEN]%%
                <!------------- Product Interest ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        class="card-panel teal lighten-2 white-text"
                        id="_product_interest"
                        name="_product_interest"
                        multiple
                        data-custom-field>

                        <option value="" disabled>Product Interest</option>

                        %%[

                        SET @productRecords = LookupOrderedRows("PRODUCT_REFERENCE", 0, "ProductName ASC", "Active", "True")
                        FOR @i = 1 TO RowCount(@productRecords) DO
                        SET @productName = field(row(@productRecords, @i),"ProductName")
                        SET @productValue = field(row(@productRecords, @i),"ProductValue")
                        OutputLine(Concat('<option value="', @productValue,'">',@productName,'</option>'))
                        NEXT @i
                        VAR @productRecords, @i, @productName, @productValue

                        ]%%

                    </select>
                    <label for="_product_interest">Product Interest</label>

                    <span
                        data-custom-message
                        data-error="please select a product"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PRODUCT_INTEREST_HALF") THEN]%%
                <!------------- Product Interest  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_product_interest"
                        name="_product_interest"
                        multiple
                        data-custom-field>

                        <option value="" disabled>Product Interest</option>

                        %%[

                        SET @productRecords = LookupOrderedRows("PRODUCT_REFERENCE", 0, "ProductName ASC", "Active", "True")
                        FOR @i = 1 TO RowCount(@productRecords) DO
                        SET @productName = field(row(@productRecords, @i),"ProductName")
                        SET @productValue = field(row(@productRecords, @i),"ProductValue")
                        OutputLine(Concat('<option value="', @productValue,'">',@productName,'</option>'))
                        NEXT @i
                        VAR @productRecords, @i, @productName, @productValue

                        ]%%

                    </select>
                    <label for="_product_interest">Product Interest</label>

                    <span
                        data-custom-message
                        data-error="please select a product"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "MARKETING_INTEREST") THEN]%%
                <!------------- Product Interest ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_marketing_interest"
                        name="_marketing_interest"
                        multiple
                        data-custom-field>

                        <option value="" disabled>Marketing Interest</option>

                        <option value="Product Information">None</option>
                        <option value="Product Information">Product Information</option>
                        <option value="Newsletter">Newsletter</option>
                        <option value="Promotions">Promotions</option>

                    </select>
                    <label for="_marketing_interest">Marketing Interest</label>

                    <span
                        data-custom-message
                        data-error="please select a marketing interest"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "MARKETING_INTEREST_HALF") THEN]%%
                <!------------- Product Interest ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_marketing_interest"
                        name="_marketing_interest"
                        multiple>

                        <option value="" disabled>Marketing Interest</option>

                        <option value="Product Information">Product Information</option>
                        <option value="Newsletter">Newsletter</option>
                        <option value="Promotions">Promotions</option>

                    </select>
                    <label for="_marketing_interest">Marketing Interest</label>

                    <span
                        data-custom-message
                        data-error="please select a marketing interest"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "ENQUIRY_TYPE") THEN]%%
                <!------------- User Interest ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_enquiry_type"
                        name="_enquiry_type"
                        data-custom-field>

                        <option value="" selected disabled>Enquiry Type</option>

                        <option value="Demo">Demonstration</option>
                        <option value="Quote">Quote</option>
                        <option value="Trial">Trial</option>
                        <option value="Information">Information</option>

                    </select>
                    <label for="_enquiry_type">Equiry Type</label>

                    <span
                        data-custom-message
                        data-error="please select a enquiry type"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "ENQUIRY_TYPE_HALF") THEN]%%
                <!------------- User Interest  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_enquiry_type"
                        name="_enquiry_type"
                        data-custom-field>

                        <option value="" selected disabled>Enquiry Type</option>

                        <option value="Demo">Demonstration</option>
                        <option value="Quote">Quote</option>
                        <option value="Trial">Trial</option>
                        <option value="Information">Information</option>

                    </select>
                    <label for="_enquiry_type">Equiry Type</label>

                    <span
                        data-custom-message
                        data-error="please select a enquiry type"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBJECT") THEN]%%
                <!------------- Subject ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_subject"
                        name="_subject"
                        multiple

                        data-custom-field>

                        <option value="" disabled>Subject</option>

                        <option value="literacy">Literacy</option>
                        <option value="mathematics">Mathematics</option>

                    </select>
                    <label for="_subject">Subject</label>

                    <span
                        data-custom-message
                        data-error="please select a subject"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBJECT_HALF") THEN]%%
                <!------------- Subject ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_subject"
                        name="_subject"
                        multiple
                        data-custom-field>

                        <option value="" disabled>Subject</option>

                        <option value="literacy">Literacy</option>
                        <option value="mathematics">Mathematics</option>

                    </select>
                    <label for="_subject">Subject</label>

                    <span
                        data-custom-message
                        data-error="please select a subject"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "FIRST_NAME") THEN]%%
                <!------------- First Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="text"
                        id="_first_name"
                        name="_first_name"
                        placeholder="First Name"
                        data-custom-field>
                    <label for="_first_name">First Name</label>

                    <span
                        data-custom-message
                        data-error="please enter your first name"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "FIRST_NAME_HALF") THEN]%%
                <!------------- First Name  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="text"
                        id="_first_name"
                        name="_first_name"
                        placeholder="First Name"
                        data-custom-field>
                    <label for="_first_name">First Name</label>

                    <span
                        data-custom-message
                        data-error="please enter your first name"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "LAST_NAME") THEN]%%
                <!------------- Last Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="text"
                        id="_last_name"
                        name="_last_name"
                        placeholder="Last Name"
                        data-custom-field>
                    <label for="_last_name">Last Name</label>

                    <span
                        data-custom-message
                        data-error="please enter your last name"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "LAST_NAME_HALF") THEN]%%
                <!------------- Last Name  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="text"
                        id="_last_name"
                        name="_last_name"
                        placeholder="Last Name"
                        data-custom-field>
                    <label for="_last_name">Last Name</label>

                    <span
                        data-custom-message
                        data-error="please enter your last name"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "EMAIL_ADDRESS") THEN]%%
                <!------------- Email Address----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="email"
                        id="_email_address"
                        name="_email_address"
                        placeholder="Email Address"
                        data-custom-field>
                    <label for="_email_address">Email Address</label>

                    <span
                        data-custom-message
                        data-error="please enter a valid email address"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "EMAIL_ADDRESS_HALF") THEN]%%
                <!------------- Email Address  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="email"
                        id="_email_address"
                        name="_email_address"
                        placeholder="Email Address"
                        data-custom-field>
                    <label for="_email_address">Email Address</label>

                    <span
                        data-custom-message
                        data-error="please enter a valid email address"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PHONE_NUMBER") THEN]%%
                <!------------- Phone Number ----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="text"
                        id="_phone_number"
                        name="_phone_number"
                        placeholder="Mobile / Work Phone"
                        data-custom-field>
                    <label for="_phone_number">Mobile / Work Phone</label>

                    <span
                        data-custom-message
                        data-error="please enter a valid phone number"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PHONE_NUMBER_HALF") THEN]%%
                <!------------- Phone Number  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="text"
                        id="_phone_number"
                        name="_phone_number"
                        placeholder="Mobile / Work Phone"
                        data-custom-field>
                    <label for="_phone_number">Mobile / Work Phone</label>

                    <span
                        data-custom-message
                        data-error="please enter a valid phone number"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "GRADE_LEVEL") THEN]%%
                <!------------- Grade Level ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_grade_level"
                        name="_grade_level"
                        data-custom-field>

                        <option value="" selected disabled>Grade Level</option>

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
                    <label for="_grade_level">Grade Level</label>

                    <span
                        data-custom-message
                        data-error="please select a grade level"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "GRADE_LEVEL_HALF") THEN]%%
                <!------------- Grade Level  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_grade_level"
                        name="_grade_level"
                        data-custom-field>

                        <option value="" selected disabled>Grade Level</option>

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
                    <label for="_grade_level">Grade Level</label>

                    <span
                        data-custom-message
                        data-error="please select a grade level"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE") THEN]%%
                <!------------- Country Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryMainRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "IsMainCountry ASC, CountryName ASC", "IsMainCountry", "True", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryMainRecords) DO
                        SET @countryName = field(row(@countryMainRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryMainRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryMainRecords, @i, @countryName, @countryCode

                        OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

                        SET @countryAllRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryAllRecords) DO
                        SET @countryName = field(row(@countryAllRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryAllRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryAllRecords, @i, @countryName, @countryCode

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_HALF") THEN]%%
                <!------------- Country Name ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryMainRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "IsMainCountry ASC, CountryName ASC", "IsMainCountry", "True", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryMainRecords) DO
                        SET @countryName = field(row(@countryMainRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryMainRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryMainRecords, @i, @countryName, @countryCode

                        OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

                        SET @countryAllRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryAllRecords) DO
                        SET @countryName = field(row(@countryAllRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryAllRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryAllRecords, @i, @countryName, @countryCode

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%



                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_APAC") THEN]%%
                <!------------- Country Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Region", "APAC", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryRecords) DO
                        SET @countryName = field(row(@countryRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryRecords, @i, @countryName, @countryCode

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_APAC_HALF") THEN]%%
                <!------------- Country Name  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Region", "APAC", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryRecords) DO
                        SET @countryName = field(row(@countryRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_AMER") THEN]%%
                <!------------- Country Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Region", "AMER", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryRecords) DO
                        SET @countryName = field(row(@countryRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryRecords, @i, @countryName, @countryCode

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_AMER_HALF") THEN]%%
                <!------------- Country Name  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Region", "AMER", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryRecords) DO
                        SET @countryName = field(row(@countryRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryRecords, @i, @countryName, @countryCode

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_EMEA") THEN]%%
                <!------------- Country Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Region", "EMEA", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryRecords) DO
                        SET @countryName = field(row(@countryRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_CODE_EMEA_HALF") THEN]%%
                <!------------- Country Name  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        data-custom-field>

                        <option value="" selected disabled>Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @countryRecords = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName ASC", "Region", "EMEA", "Active", "True")
                        FOR @i = 1 TO RowCount(@countryRecords) DO
                        SET @countryName = field(row(@countryRecords, @i),"CountryName")
                        SET @countryCode = field(row(@countryRecords, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @countryCode,'">',@countryName,'</option>'))
                        NEXT @i
                        VAR @countryRecords, @i, @countryName, @countryCode

                        ]%%

                    </select>
                    <label for="_country_code">Country</label>

                    <span
                        data-custom-message
                        data-error="please select a country"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_PER_COUNTRY_CODE") THEN]%%
                <!------------- State / Province Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State / Province</option>

                    </select>
                    <label for="_state_code">State / Province</label>

                    <span
                        data-custom-message
                        data-error="Please select a country first then select a state / province"
                        class="custom-validation-message">
                        Please select a country first then select a state / province.
                    </span>

                </div>


                <script runat="server">
                    /**
                     * GET ALL STATE RECORDS
                     *****************************/
                    var stateRecords = Platform.Function.LookupOrderedRows('STATE_REFERENCE', 0, 'StateName ASC', ['Active'], [true])
                    Write('<script>let stateRecords = ' + Stringify(stateRecords) + '</' + 'script>');
                </script>


                <!-- On Country Change -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        // get elements
                        const countryCodeSelectElement = document.getElementById('_country_code');
                        const stateCodeSelectElement = document.getElementById('_state_code');
                        const stateCodeCustomContainer = stateCodeSelectElement.closest('[data-custom-container]');

                        countryCodeSelectElement.addEventListener('change', (event) => {

                            // change options
                            const selectedCountryCode = event.target.value;

                            const stateRecordsFiltered = stateRecords.filter(i => i.CountryCode === selectedCountryCode);

                            // hide if no records
                            if (stateRecordsFiltered.length === 0) {
                                stateCodeCustomContainer.classList.add('hide');
                                return;
                            } else {
                                stateCodeCustomContainer.classList.remove('hide');
                            }

                            // populate options
                            const options = ['<option value="" selected disabled>State / Province</option>']
                                .concat(stateRecordsFiltered.map(i => `<option value="${i.StateCode}">${i.StateName}</option>`))
                                .join('');

                            stateCodeSelectElement.innerHTML = options;

                            // recreate instance
                            const stateCodeSelectInstance = M.FormSelect.getInstance(stateCodeSelectElement);
                            if (stateCodeSelectInstance) {
                                stateCodeSelectInstance.destroy();
                            }
                            M.FormSelect.init(stateCodeSelectElement);


                        });
                    });
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_PER_COUNTRY_CODE_HALF") THEN]%%
                <!------------- State / Province Name ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State / Province</option>

                    </select>
                    <label for="_state_code">State / Province</label>

                    <span
                        data-custom-message
                        data-error="Please select a country first then select a state / province"
                        class="custom-validation-message">
                        Please select a country first then select a state / province.
                    </span>

                </div>


                <script runat="server">
                    /**
                     * GET ALL STATE RECORDS
                     *****************************/
                    var stateRecords = Platform.Function.LookupOrderedRows('STATE_REFERENCE', 0, 'StateName ASC', ['Active'], [true])
                    Write('<script>let stateRecords = ' + Stringify(stateRecords) + '</' + 'script>');
                </script>


                <!-- On Country Change -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        // get elements
                        const countryCodeSelectElement = document.getElementById('_country_code');
                        const stateCodeSelectElement = document.getElementById('_state_code');
                        const stateCodeCustomContainer = stateCodeSelectElement.closest('[data-custom-container]');

                        countryCodeSelectElement.addEventListener('change', (event) => {

                            // change options
                            const selectedCountryCode = event.target.value;

                            const stateRecordsFiltered = stateRecords.filter(i => i.CountryCode === selectedCountryCode);

                            // hide if no records
                            if (stateRecordsFiltered.length === 0) {
                                stateCodeCustomContainer.classList.add('hide');
                                return;
                            } else {
                                stateCodeCustomContainer.classList.remove('hide');
                            }

                            // populate options
                            const options = ['<option value="" selected disabled>State / Province</option>']
                                .concat(stateRecordsFiltered.map(i => `<option value="${i.StateCode}">${i.StateName}</option>`))
                                .join('');

                            stateCodeSelectElement.innerHTML = options;

                            // recreate instance
                            const stateCodeSelectInstance = M.FormSelect.getInstance(stateCodeSelectElement);
                            if (stateCodeSelectInstance) {
                                stateCodeSelectInstance.destroy();
                            }
                            M.FormSelect.init(stateCodeSelectElement);


                        });
                    });
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_AU") THEN]%%
                <!------------- State / Province Name (AU) ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "AU", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_AU_HALF") THEN]%%
                <!------------- State / Province Name (AU)  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "AU", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_NZ") THEN]%%
                <!------------- State / Province Name (NZ) ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "NZ", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_NZ_HALF") THEN]%%
                <!------------- State / Province Name (NZ)  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "NZ", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_US") THEN]%%
                <!------------- State / Province Name (US) ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "US", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_US_HALF") THEN]%%
                <!------------- State / Province Name (US)  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "US", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_CA") THEN]%%
                <!------------- State / Province Name (CA) ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>Province</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "CA", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">Province</label>

                    <span
                        data-custom-message
                        data-error="please select a province"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_CA_HALF") THEN]%%
                <!------------- State / Province Name (CA)  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>Province</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "CA", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">Province</label>

                    <span
                        data-custom-message
                        data-error="please select a province"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_ZA") THEN]%%
                <!------------- State / Province Name (ZA) ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "ZA", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_CODE_ZA_HALF") THEN]%%
                <!------------- State / Province Name (ZA)  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        data-custom-field>

                        <option value="" selected disabled>State</option>

                        %%[

                        /******************************
                        POPULATE STATE/PROVINCE OPTIONS
                        *******************************/

                        SET @stateRecords = LookupOrderedRows("STATE_REFERENCE", 0,"StateName ASC", "CountryCode", "ZA", "Active", "True")
                        FOR @i = 1 TO RowCount(@stateRecords) DO
                        SET @stateName = Field(Row(@stateRecords, @i), "StateName")
                        SET @stateCode = Field(Row(@stateRecords, @i), "StateCode")
                        OutputLine(Concat('<option value="',@stateCode,'">',@stateName,'</option>'))
                        NEXT @i
                        VAR @stateRecords, @i, @stateName, @stateCode

                        ]%%

                    </select>
                    <label for="_state_code">State</label>

                    <span
                        data-custom-message
                        data-error="please select a state"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "POSTCODE_ZIPCODE") THEN]%%
                <!------------- Postcode / Zipcode ----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="text"
                        id="_postcode_zipcode"
                        name="_postcode_zipcode"
                        placeholder="Postcode / Zipcode"
                        data-custom-field>
                    <label for="_postcode_zipcode">Postcode / Zipcode</label>

                    <span
                        data-custom-message
                        data-error="please select a valid postcode / zipcode"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "POSTCODE_ZIPCODE_HALF") THEN]%%
                <!------------- Postcode / Zipcode  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="text"
                        id="_postcode_zipcode"
                        name="_postcode_zipcode"
                        placeholder="Postcode / Zipcode"
                        title="Postcode/Zipcode is 4 digits with no spaces"
                        data-custom-field>
                    <label for="_postcode_zipcode">Postcode / Zipcode</label>

                    <span
                        data-custom-message
                        data-error="please select a valid postcode / zipcode"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_PER_COUNTRY_CODE") THEN]%%
                <!------------- Job Title ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="Please select a country first then select a job title"
                        class="custom-validation-message">
                        Please select a country first then select a job title
                    </span>

                </div>


                <script runat="server">
                    /**
                     * GET ALL COUNTRY RECORDS
                     *****************************/
                    var countryRecords = Platform.Function.LookupOrderedRows('COUNTRY_REFERENCE', 0, 'CountryName ASC', 'Active', true)
                    Write('<script>let countryRecords = ' + Stringify(countryRecords) + '</' + 'script>');
                </script>


                <script runat="server">
                    /**
                     * GET ALL JOB TITLE RECORDS
                     *****************************/
                    var jobRecords = Platform.Function.LookupOrderedRows('JOB_REFERENCE', 0, 'JobTitle ASC', 'Active', true)
                    Write('<script>let jobRecords = ' + Stringify(jobRecords) + '</' + 'script>');
                </script>


                <!-- On Country Change -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        // get elements
                        const countryCodeSelectElement = document.getElementById('_country_code');
                        const jobTitleSelectElement = document.getElementById('_job_title');

                        countryCodeSelectElement.addEventListener('change', (event) => {

                            // change options
                            const selectedCountryCode = event.target.value;
                            const selectedRegion = countryRecords.find(i => i.CountryCode === selectedCountryCode)?.Region;

                            // Guard clause if region not found
                            if (!selectedRegion) return;

                            const jobRecordsFiltered = jobRecords.filter(i => i.Region === selectedRegion);

                            // Build options more efficiently
                            const options = ['<option value="" selected disabled>Job Title</option>']
                                .concat(jobRecordsFiltered.map(i => `<option value="${i.JobTitle}">${i.JobTitle}</option>`))
                                .join('');

                            jobTitleSelectElement.innerHTML = options;

                            // Recreate Materialize instance
                            const jobTitleSelectInstance = M.FormSelect.getInstance(jobTitleSelectElement);
                            if (jobTitleSelectInstance) {
                                jobTitleSelectInstance.destroy();
                            }
                            M.FormSelect.init(jobTitleSelectElement);

                        });
                    });
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_PER_COUNTRY_CODE_HALF") THEN]%%
                <!------------- Job Title ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="Please select a country first then select a job title"
                        class="custom-validation-message">
                        Please select a country first then select a job title
                    </span>

                </div>


                <script runat="server">
                    /**
                     * GET ALL COUNTRY RECORDS
                     *****************************/
                    var countryRecords = Platform.Function.LookupOrderedRows('COUNTRY_REFERENCE', 0, 'CountryName ASC', 'Active', true)
                    Write('<script>let countryRecords = ' + Stringify(countryRecords) + '</' + 'script>');
                </script>


                <script runat="server">
                    /**
                     * GET ALL JOB TITLE RECORDS
                     *****************************/
                    var jobRecords = Platform.Function.LookupOrderedRows('JOB_REFERENCE', 0, 'JobTitle ASC', 'Active', true)
                    Write('<script>let jobRecords = ' + Stringify(jobRecords) + '</' + 'script>');
                </script>


                <!-- On Country Change -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        // get elements
                        const countryCodeSelectElement = document.getElementById('_country_code');
                        const jobTitleSelectElement = document.getElementById('_job_title');

                        countryCodeSelectElement.addEventListener('change', (event) => {

                            // change options
                            const selectedCountryCode = event.target.value;
                            const selectedRegion = countryRecords.find(i => i.CountryCode === selectedCountryCode)?.Region;

                            // Guard clause if region not found
                            if (!selectedRegion) return;

                            const jobRecordsFiltered = jobRecords.filter(i => i.Region === selectedRegion);

                            // Build options more efficiently
                            const options = ['<option value="" selected disabled>Job Title</option>']
                                .concat(jobRecordsFiltered.map(i => `<option value="${i.JobTitle}">${i.JobTitle}</option>`))
                                .join('');

                            jobTitleSelectElement.innerHTML = options;

                            // Recreate Materialize instance
                            const jobTitleSelectInstance = M.FormSelect.getInstance(jobTitleSelectElement);
                            if (jobTitleSelectInstance) {
                                jobTitleSelectInstance.destroy();
                            }
                            M.FormSelect.init(jobTitleSelectElement);

                        });
                    });
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_APAC") THEN]%%
                <!------------- Job Title ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobRecords = LookupOrderedRows("JOB_REFERENCE", 0, "JobTitle ASC", "Region", "APAC", "Active", "True")
                        FOR @i = 1 TO RowCount(@jobRecords) DO
                        SET @jobTitle = Field(Row(@jobRecords, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i
                        VAR @jobRecords, @i, @jobTitle

                        ]%%

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="please select a job title"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_APAC_HALF") THEN]%%
                <!------------- Job Title  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>


                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobRecords = LookupOrderedRows("JOB_REFERENCE", 0, "JobTitle ASC", "Region", "APAC", "Active", "True")
                        FOR @i = 1 TO RowCount(@jobRecords) DO
                        SET @jobTitle = Field(Row(@jobRecords, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i
                        VAR @jobRecords, @i, @jobTitle

                        ]%%

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="please select a job title"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_AMER") THEN]%%
                <!------------- Job Title ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobRecords = LookupOrderedRows("JOB_REFERENCE", 0, "JobTitle ASC", "Region", "AMER", "Active", "True")
                        FOR @i = 1 TO RowCount(@jobRecords) DO
                        SET @jobTitle = Field(Row(@jobRecords, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i
                        VAR @jobRecords, @i, @jobTitle

                        ]%%

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="please select a job title"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_AMER_HALF") THEN]%%
                <!------------- Job Title  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobRecords = LookupOrderedRows("JOB_REFERENCE", 0, "JobTitle ASC", "Region", "AMER", "Active", "True")
                        FOR @i = 1 TO RowCount(@jobRecords) DO
                        SET @jobTitle = Field(Row(@jobRecords, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i
                        VAR @jobRecords, @i, @jobTitle

                        ]%%

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="please select a job title"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_EMEA") THEN]%%
                <!------------- Job Title ----------------->
                <div data-custom-container class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobRecords = LookupOrderedRows("JOB_REFERENCE", 0, "JobTitle ASC", "Region", "EMEA", "Active", "True")
                        FOR @i = 1 TO RowCount(@jobRecords) DO
                        SET @jobTitle = Field(Row(@jobRecords, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i
                        VAR @jobRecords, @i, @jobTitle

                        ]%%

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="please select a job title"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_EMEA_HALF") THEN]%%
                <!------------- Job Title  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        data-custom-field>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobRecords = LookupOrderedRows("JOB_REFERENCE", 0, "JobTitle ASC", "Region", "EMEA", "Active", "True")
                        FOR @i = 1 TO RowCount(@jobRecords) DO
                        SET @jobTitle = Field(Row(@jobRecords, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i
                        VAR @jobRecords, @i, @jobTitle

                        ]%%

                    </select>
                    <label for="_job_title">Job Title</label>

                    <span
                        data-custom-message
                        data-error="please select a job title"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SCHOOL_NAME") THEN]%%
                <!------------- School Name ----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="text"
                        id="_school_name"
                        name="_school_name"
                        placeholder="School or District Name"
                        data-custom-field>
                    <label for="_school_name">School or District Name</label>

                    <span
                        data-custom-message
                        data-error="please enter a school name"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SCHOOL_NAME_HALF") THEN]%%
                <!------------- School Name  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="text"
                        id="_school_name"
                        name="_school_name"
                        placeholder="School or District Name"
                        data-custom-field>
                    <label for="_school_name">School or District Name</label>

                    <span
                        data-custom-message
                        data-error="please enter a school name"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "NO_OF_LICENCES") THEN]%%
                <!------------- No. Of Licences  ----------------->
                <div data-custom-container class="input-field col s12">

                    <input
                        type="number"
                        id="_no_of_licences"
                        name="_no_of_licences"
                        placeholder="Number of Student Licences"
                        data-custom-field
                        min="20"
                        max="1000">
                    <label for="_no_of_licences">Number of Student Licenses</label>

                    <span
                        data-custom-message
                        data-error="please enter a number of licences"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "NO_OF_LICENCES_HALF") THEN]%%
                <!------------- No. Of Licences  ----------------->
                <div data-custom-container class="input-field col s12 m6">

                    <input
                        type="number"
                        id="_no_of_licences"
                        name="_no_of_licences"
                        placeholder="Number of Student Licences"
                        data-custom-field
                        min="20"
                        max="1000">
                    <label for="_no_of_licences">Number of Student Licenses</label>

                    <span
                        data-custom-message
                        data-error="please enter a number of licences"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TERMS_AND_CONDITIONS") THEN]%%
                <!------------- Terms & Conditions ----------------->
                <p data-custom-container class="col s12">
                    <label>
                        <input
                            type="checkbox"
                            id="_terms_and_conditions"
                            name="_terms_and_conditions"
                            checked
                            data-custom-field>
                        <span>
                            I understand and agree to the 3P Learning
                            <a tabindex="-1" target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms and Conditions</a>.
                        </span>
                    </label>

                    <span
                        data-custom-message
                        data-error="please agree to the terms and conditions"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </p>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TERMS_AND_CONDITIONS_HALF") THEN]%%
                <!------------- Terms & Conditions ----------------->
                <p data-custom-container class="col s12 m6">
                    <label>
                        <input
                            type="checkbox"
                            id="_terms_and_conditions"
                            name="_terms_and_conditions"
                            checked
                            data-custom-field>
                        <span>
                            I agree to the 3P Learning
                            <a tabindex="-1" target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms and Conditions</a>.
                        </span>
                    </label>

                    <span
                        data-custom-message
                        data-error="please agree to the terms and conditions"
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </p>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBSCRIBER_OPT_IN") THEN]%%
                <!------------- Subscriber Opt In ----------------->
                <p data-custom-container class="col s12">
                    <label>
                        <input
                            type="checkbox"
                            id="_subscriber_opt_in"
                            name="_subscriber_opt_in"
                            checked>
                        <span>
                            Sign up to receive monthly newsletters, educational content, resources, and occasional promotional material.
                        </span>
                    </label>

                    <span
                        data-custom-message
                        data-error=""
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </p>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBSCRIBER_OPT_IN_HALF") THEN]%%
                <!------------- Subscriber Opt In  ----------------->
                <p data-custom-container class="col s12 m6">
                    <label>
                        <input
                            type="checkbox"
                            id="_subscriber_opt_in"
                            name="_subscriber_opt_in"
                            checked>
                        <span>
                            Sign up to receive monthly newsletters, educational content, resources, and occasional promotional material.
                        </span>
                    </label>

                    <span
                        data-custom-message
                        data-error=""
                        class="custom-validation-message">
                        <!-- helper text -->
                    </span>

                </p>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBMIT_BUTTON_3PL") THEN]%%
                <!------------- Submit Button ----------------->
                <div data-custom-container class="col s12">

                    <button
                        class="custom_submit_button scale-transition scale-out"
                        type="submit"
                        id="_submit_button"
                        name="_submit_button">
                        Submit
                    </button>

                </div>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // grow animate submit button
                        const submitButton = document.getElementById("_submit_button");
                        submitButton.classList.remove("scale-out");
                        submitButton.classList.add("scale-in");
                    })
                </script>


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
                        border: none;
                        border-radius: 25px;
                        padding: 15px 50px;
                        text-align: center;
                        color: var(--submit_button__rest--color);
                        font-weight: 600;
                        font-size: 1rem;
                        width: 100%;
                        cursor: pointer;
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


    <!-- Materialize Autoinit All Components: https://materializecss.com/auto-init.html -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
    </script>


    <!-- Custom Form Validation (Shown only after first submit) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // set flags
            let isValidationEnabled = false;
            let isFormValidToSubmit = true;

            // get dom elements
            const form = document.querySelector('form');
            const fieldsToValidate = form.querySelectorAll('[data-custom-field]');

            // on form submit
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // enable validation
                isValidationEnabled = true;

                // reset flags
                isFormValidToSubmit = true;

                // validate all fields
                fieldsToValidate.forEach(field => {
                    handleFieldValidation(field);
                });

                // if form is valid
                if (isFormValidToSubmit) {

                    //show loader
                    const loader = document.createElement('div');
                    loader.classList.add('loader');

                    //submit form
                    form.submit();

                } else {
                    // notify of errors
                    M.toast({
                        html: 'Please fix errors before continuing',
                        classes: 'red'
                    });
                }

            });

            // on field change
            fieldsToValidate.forEach(field => {

                // on blur
                field.addEventListener('change', () => {
                    if (isValidationEnabled) {
                        handleFieldValidation(field);
                    }
                });

                // on input
                field.addEventListener('input', () => {
                    if (isValidationEnabled) {
                        handleFieldValidation(field);
                    }
                });
            });

            function handleFieldValidation(field) {

                // if single select field
                if (field.tagName === "SELECT" && !field.multiple) {
                    if (!field.value) {
                        isFormValidToSubmit = false;
                        const selectDropdown = field.parentElement.querySelector('.select-dropdown');
                        selectDropdown.classList.add('invalid');
                        selectDropdown.classList.remove('valid');
                        showValidationMessage(field, false);
                    } else {
                        const selectDropdown = field.parentElement.querySelector('.select-dropdown');
                        selectDropdown.classList.add('valid');
                        selectDropdown.classList.remove('invalid');
                        showValidationMessage(field, true);
                    }

                    // if a multiple select field
                } else if (field.tagName === "SELECT" && field.multiple) {
                    if (!field.value) {
                        isFormValidToSubmit = false;
                        const selectDropdown = field.parentElement.querySelector('.select-dropdown');
                        selectDropdown.classList.add('invalid');
                        selectDropdown.classList.remove('valid');
                        showValidationMessage(field, false);
                    } else {
                        const selectDropdown = field.parentElement.querySelector('.select-dropdown');
                        selectDropdown.classList.add('valid');
                        selectDropdown.classList.remove('invalid');
                        showValidationMessage(field, true);
                    }

                    // if an email input field
                } else if (field.tagName === "INPUT" && field.type === "email") {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!field.value || !emailRegex.test(field.value)) {
                        isFormValidToSubmit = false;
                        field.classList.add('invalid');
                        field.classList.remove('valid');
                        showValidationMessage(field, false);
                    } else {
                        field.classList.remove('invalid');
                        field.classList.add('valid');
                        showValidationMessage(field, true);
                    }

                    // if a number nput field
                } else if (field.tagName === "INPUT" && field.type === "number") {
                    if (!field.value) {
                        isFormValidToSubmit = false;
                        field.classList.add('invalid');
                        field.classList.remove('valid');
                        showValidationMessage(field, false);
                    } else {
                        field.classList.remove('invalid');
                        field.classList.add('valid');
                        showValidationMessage(field, true);
                    }

                    // if a text input field
                } else if (field.tagName === "INPUT" && field.type === "text") {
                    if (!field.value) {
                        isFormValidToSubmit = false;
                        field.classList.add('invalid');
                        field.classList.add('valid');
                        showValidationMessage(field, false);
                    } else {
                        field.classList.remove('invalid');
                        field.classList.add('valid');
                        showValidationMessage(field, true);
                    }

                    // if a checkbox input field
                } else if (field.tagName === "INPUT" && field.type === "checkbox") {
                    if (!field.checked) {
                        isFormValidToSubmit = false;
                        showValidationMessage(field, false);
                    } else {
                        showValidationMessage(field, true);
                    }
                }

            } //handleFieldValidation


            function showValidationMessage(field, isFieldValid) {
                const validationMessage = field.closest('[data-custom-container]').querySelector('[data-custom-message]');
                if (validationMessage) {
                    if (isFieldValid) {
                        validationMessage.classList.remove('invalid');
                        validationMessage.classList.add('valid');
                        validationMessage.innerHTML = validationMessage.dataset.success || '';
                    } else {
                        validationMessage.classList.add('invalid');
                        validationMessage.classList.remove('valid');
                        validationMessage.innerHTML = validationMessage.dataset.error || '';
                    }
                }


            }










        });
    </script>



</body>

</html>
%%[
/** RENDER_HTML */
ENDIF
]%%




<script runat="server">
    if (Request.Method() != "POST") return;
    try {


        /*******************************
        ----------- SECURITY -----------
        ********************************/


        // Platform.Response.SetResponseHeader("X-Frame-Options","Deny");
        // Platform.Response.SetResponseHeader("Content-Security-Policy","default-src 'self'");
        // Platform.Response.SetResponseHeader("Strict-Transport-Security", "max-age=200");
        // Platform.Response.SetResponseHeader("X-XSS-Protection", "1; mode=block");
        // Platform.Response.SetResponseHeader("X-Content-Type-Options", "nosniff");
        // Platform.Response.SetResponseHeader("Referrer-Policy", "strict-origin-when-cross-origin");


        /*************************
        --------- PAYLOAD --------
        **************************/


        //initiate
        var payload = {};

        //retrieve data
        payload.debug = Request.GetFormField("_debug");

        payload.apac_cid = Request.GetFormField("_apac_cid");
        payload.amer_cid = Request.GetFormField("_amer_cid");
        payload.emea_cid = Request.GetFormField("_emea_cid");

        payload.cid = Request.GetFormField("_cid");
        payload.rid = Request.GetFormField("_rid");

        payload.template = Request.GetFormField("_template");
        payload.inputs = Request.GetFormField("_inputs");

        payload.utm_source = Request.GetFormField("_utm_source");
        payload.utm_medium = Request.GetFormField("_utm_medium");
        payload.utm_campaign = Request.GetFormField("_utm_campaign");
        payload.utm_content = Request.GetFormField("_utm_content");
        payload.utm_term = Request.GetFormField("_utm_term");

        payload.gclid = Request.GetFormField("_gclid");
        payload.fbclid = Request.GetFormField("_fbclid");
        payload.msclkid = Request.GetFormField("_msclkid");

        payload.request_url = Request.GetFormField("_request_url");
        payload.location_href = Request.GetFormField("_location_href");
        payload.document_referrer = Request.GetFormField("_document_referrer");

        payload.override_country_code = Request.GetFormField("_override_country_code");
        payload.override_product_interest = Request.GetFormField("_override_product_interest");
        payload.override_marketing_interest = Request.GetFormField("_override_marketing_interest");
        payload.override_enquiry_type = Request.GetFormField("_override_enquiry_type");
        payload.override_lead_status = Request.GetFormField("_override_lead_status");
        payload.override_job_title = Request.GetFormField("_override_job_title");

        payload.product_interest = Request.GetFormField("_product_interest");
        payload._market_interest = Request.GetFormField("_market_interest");
        payload.user_interest = Request.GetFormField("_enquiry_type");
        payload.first_name = Request.GetFormField("_first_name");
        payload.last_name = Request.GetFormField("_last_name");
        payload.email_address = Request.GetFormField("_email_address");
        payload.phone_number = Request.GetFormField("_phone_number");
        payload.grade_level = Request.GetFormField("_grade_level");
        payload.subject = Request.GetFormField("_subject");
        payload.job_title = Request.GetFormField("_job_title");
        payload.country_code = Request.GetFormField("_country_code");
        payload.state_code = Request.GetFormField("_state_code");
        payload.postcode_zipcode = Request.GetFormField("_postcode_zipcode");
        payload.school_name = Request.GetFormField("_school_name");
        payload.no_of_licences = Request.GetFormField("_no_of_licences");
        payload.terms_and_conditions = Request.GetFormField("_terms_and_conditions");
        payload.subscriber_opt_in = Request.GetFormField("_subscriber_opt_in");


        /*************************
        ---------- DEBUG --------- 
        **************************/


        //show debug info when ?debug=true
        if (payload.debug) {
            Write('=== DEBUG MODE ===')
            Write('<br>')
            Write('Payload: ' + Stringify(payload));
            return;
        }


        /*************************
        --------- SUBMIT --------
        **************************/


        //push to queue
        var queue = DataExtension.Init("REUSABLE_FORM_QUEUE");
        queue.Rows.Add({
            "queue_submission_id": Platform.Function.GUID(),
            "queue_submission_name": payload.first_name + ' ' + payload.last_name,
            "queue_submission_email": payload.email_address,
            "queue_submission_url": payload.request_url,
            "queue_submission_data": Stringify(payload),
            "queue_submission_date": Datetime.SystemDateToLocalString()
            // "queue_method": //the method used to upsert the salesforce lead [CREATE/UPDATE]
            // "queue_record_id": //the saleforce recoordId of the lead (or contact) sync'd with salesforce
            // "queue_campaign_member_id": //the saleforce campaign member id after lead is upserted to campaign
            // "queue_error_message": //the error message set when record fails processing in pipeline
            // "queue_completed_date": //a datetime set when the pipeline has run and the record has been processed
        });



        /************************************
        --------- TRIGGER AUTOMATION --------
        *************************************/

        //triggers a script activity to run but waits and repeats if already running
        var content = Platform.Function.ContentBlockByKey('ssjs-lib-wsproxy');
        var proxy = new wsproxy();
        var config = {
            AUTOMATION_NAME: 'REUSABLE_FORM_PIPELINE',
            NUMBER_OF_REPEATS: 3,
            WAIT_MILLISECONDS: 5 * 60 * 1000 //5mins
        }
        proxy.triggerAutomationWait(config.AUTOMATION_NAME, config.NUMBER_OF_REPEATS, config.WAIT_MILLISECONDS)


        /*************************
        -------- REDIRECT --------
        **************************/


        //navigate to redirect
        if (payload.rid) {
            payload.lookupRedirectData = Platform.Function.LookupOrderedRows('REDIRECT_REFERENCE', 0, 'Id ASC', ['Id', 'Active'], [payload.rid, true]);
            payload.redirect_url = payload.lookupRedirectData[0].Url;
            Redirect(payload.redirect_url);
        }


        /*************************
        ------- ACKNOWLEDGE ------
        **************************/


        //otherwise, feedback
        Write("<br>");
        Write("<p>Thank you for submitting your information. We will be in contact with you shortly</p>");
        Write("<br>");


        /*******************************
        ------------ ERROR -------------
        ********************************/


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }
</script>