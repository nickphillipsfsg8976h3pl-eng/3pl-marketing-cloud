<script runat="server">
    Platform.Load("core", "1");
</script>


<!-- 
 

TODO: 

Add active flag in search criteria for all lookups to they can be centrally managed

Automatic redirect when a person enters “Parent” or “student” into 
the Job Title form field, to the appropriate B2C landing page
- What is the landing page based or region or query param
- Is there a better way to do this 
        - "Are you a parent/student? Click here" link
        - optional popup?

implement job function region static and global dynamic values components

follow up on  missing EMEA mapping for job title -> job functions mappings

create job title hidden override inputs (look at mapping for common values - teacher etc)

look into gclid, fbclid mscclid functionality and pass valus through perhaps

finish processing script porting from automation into here with ssjs

implement full wsproxy/wrapped ampscript salesforce sync section

run everything through cl-ai to simplify, fix errors, seek advice, etc

test. test, test ===> batte-test for all variatioons and 150 form planned rollout!!!!

confirm a solid list of finalized form fields (and there overrides) with teams

confirm all form fields are mapped to the correct field in salesforce

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
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,SCHOOL_NAME,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: TOF Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,JOB_TITLE,SCHOOL_NAME,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: BOF Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,JOB_TITLE,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,POSTCODE_ZIPCODE,SCHOOL_NAME,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: Quote Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=PRODUCT_INTEREST,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,POSTCODE_ZIPCODE,SCHOOL_NAME,PHONE_NUMBER,JOB_TITLE,GRADE_LEVEL,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: US Form Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=PRODUCT_INTEREST,ENQUIRY_TYPE,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,POSTCODE_ZIPCODE,SCHOOL_NAME,PHONE_NUMBER,JOB_TITLE,GRADE_LEVEL,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: Trial Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,POSTCODE_ZIPCODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: Info Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,POSTCODE_ZIPCODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
            '<br>',
            '@example: Demo Template <br>',
            'https://webform.my.3plearning.com/REUSABLE_FORM_TEMPLATE?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE,COUNTRY_GLOBAL,STATE_PROVINCE_GLOBAL,POSTCODE_ZIPCODE,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
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
            test_full: [
                "PRODUCT_INTEREST",
                "MARKETING_INTEREST",
                "ENQUIRY_TYPE",
                "FIRST_NAME",
                "LAST_NAME",
                "EMAIL_ADDRESS",
                "PHONE_NUMBER",
                "GRADE_LEVEL",
                "SUBJECT",
                "JOB_TITLE",
                "COUNTRY_GLOBAL",
                "STATE_PROVINCE_GLOBAL",
                "POSTCODE_ZIPCODE",
                "SCHOOL_NAME",
                "NO_OF_LICENCES",
                "TERMS_AND_CONDITIONS",
                "SUBSCRIBER_OPT_IN",
                "SUBMIT_BUTTON"
            ],


            //?template=test_full_half
            test_full_half: [
                "PRODUCT_INTEREST_HALF",
                "MARKETING_INTEREST_HALF",
                "ENQUIRY_TYPE_HALF",
                "FIRST_NAME_HALF",
                "LAST_NAME_HALF",
                "EMAIL_ADDRESS_HALF",
                "PHONE_NUMBER_HALF",
                "GRADE_LEVEL_HALF",
                "SUBJECT_HALF",
                "JOB_TITLE_HALF",
                "COUNTRY_GLOBAL_HALF",
                "STATE_PROVINCE_GLOBAL_HALF",
                "POSTCODE_ZIPCODE_HALF",
                "SCHOOL_NAME_HALF",
                "NO_OF_LICENCES_HALF",
                "TERMS_AND_CONDITIONS_HALF",
                "SUBSCRIBER_OPT_IN_HALF",
                "SUBMIT_BUTTON"
            ],

            //?template=test_countries
            test_countries: [
                "COUNTRY_GLOBAL",
                "COUNTRY_GLOBAL_HALF",
                "COUNTRY_APAC",
                "COUNTRY_APAC_HALF",
                "COUNTRY_AMER",
                "COUNTRY_AMER_HALF",
                "COUNTRY_EMEA",
                "COUNTRY_EMEA_HALF",
            ],

            //?template=test_states
            test_states: [
                "COUNTRY_GLOBAL",
                "COUNTRY_GLOBAL_HALF",
                "STATE_PROVINCE_GLOBAL",
                "STATE_PROVINCE_GLOBAL_HALF",
                "STATE_PROVINCE_AU",
                "STATE_PROVINCE_AU_HALF",
                "STATE_PROVINCE_NZ",
                "STATE_PROVINCE_NZ_HALF",
                "STATE_PROVINCE_US",
                "STATE_PROVINCE_US_HALF",
                "STATE_PROVINCE_CA",
                "STATE_PROVINCE_CA_HALF",
                "STATE_PROVINCE_ZA",
                "STATE_PROVINCE_ZA_HALF"
            ],

            //?template=job_titles
            test_job_titles: [
                "COUNTRY_GLOBAL",
                "COUNTRY_GLOBAL_HALF",
                "JOB_TITLE_GLOBAL",
                "JOB_TITLE_GLOBAL_HALF",
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
                "JOB_TITLE",
                "JOB_TITLE_HALF",
                "COUNTRY_GLOBAL",
                "COUNTRY_GLOBAL_HALF",
                "STATE_PROVINCE_GLOBAL",
                "STATE_PROVINCE_GLOBAL_HALF",
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
                "SUBMIT_BUTTON",
                "SUBMIT_BUTTO_HALF"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        //initialze select inputs: https://materializecss.com/select.html
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            var options = {};
            var instances = M.FormSelect.init(elems, options);
        });
    </script>


    <!-- Global Styles -->
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


    <!------------- FORM ----------------->


    <form
        method="POST">


        <!------------- HIDDEN ----------------->

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


            <!-- Assign client side location and referrer urls -->
            <script>
                document.querySelector('input[name="_location_href"]').value = window.location.href;
                document.querySelector('input[name="_document_referrer"]').value = document.referrer;
            </script>


            <!-- Extract Marketing Tracking Parameters -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {

                    // Get cookie value
                    function getCookie(name) {
                        const value = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
                        return value ? decodeURIComponent(value.pop()) : '';
                    }

                    // Get parameter from cookie URL
                    function getParam(name) {
                        const cookie = getCookie('setURLParamsCookie');
                        const match = cookie.match(new RegExp('[?&]' + name + '=([^&#]*)'));
                        return match ? decodeURIComponent(match[1].replace(/\+/g, ' ')) : '';
                    }

                    // Fill form fields if cookie exists
                    if (document.cookie.includes('setURLParamsCookie')) {
                        document.querySelector('input[name="_utm_source"]').value = getParam('utm_source');
                        document.querySelector('input[name="_utm_medium"]').value = getParam('utm_medium');
                        document.querySelector('input[name="_utm_campaign"]').value = getParam('utm_campaign');
                        document.querySelector('input[name="_utm_content"]').value = getParam('utm_content');
                        document.querySelector('input[name="_utm_term"]').value = getParam('utm_term');
                        document.querySelector('input[name="_gclid"]').value = getParam('gclid');
                        document.querySelector('input[name="_fbclid"]').value = getParam('fbclid');
                        document.querySelector('input[name="_msclkid"]').value = getParam('msclkid');
                    }

                }); //DOMContentLoaded
            </script>

        </div>


        <!-- Wrapper -->
        <div class=" container my-5">
            <div class="row g-3">


                %%[
                /************************************
                START LOOPING OVER RENDER COMPONENTS
                *************************************/
                SET @LENGTH = ROWCOUNT(@FORM_COMPONENT_LIST)
                FOR @index = 1 TO @LENGTH DO
                SET @FORM_COMPONENT = ROW(@FORM_COMPONENT_LIST, @index)
                ]%%


                <!-- FILEDS -->


                %%[IF (@FORM_COMPONENT == "PRODUCT_INTEREST") THEN]%%
                <!------------- Product Interest ----------------->
                <div class="input-field col s12">

                    <select
                        id="_product_interest"
                        name="_product_interest"
                        multiple
                        required>

                        <option value="" disabled selected>Product Interest</option>

                        SET @productsList = LookupOrderedRows("PRODUCT_REFERENCE", 0, "Name desc", "Active", "True")
                        FOR @i = 1 TO RowCount(@productsList) DO
                        SET @productName = field(row(@productsList, @i),"Name")
                        SET @productValue = field(row(@productsList, @i),"Value")
                        OutputLine(Concat('<option value="', @productValue,'">',@productName,'</option>'))
                        NEXT @i

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PRODUCT_INTEREST_HALF") THEN]%%
                <!------------- Product Interest HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_product_interest"
                        name="_product_interest"
                        multiple
                        required>

                        <option value="" disabled selected>Product Interest</option>

                        SET @productsList = LookupOrderedRows("PRODUCT_REFERENCE", 0, "Name desc", "Active", "True")
                        FOR @i = 1 TO RowCount(@productsList) DO
                        SET @productName = field(row(@productsList, @i),"Name")
                        SET @productValue = field(row(@productsList, @i),"Value")
                        OutputLine(Concat('<option value="', @productValue,'">',@productName,'</option>'))
                        NEXT @i

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "MARKETING_INTEREST") THEN]%%
                <!------------- Product Interest ----------------->
                <div class="input-field col s12">

                    <select
                        id="_marketing_interest"
                        name="_marketing_interest"
                        multiple>

                        <option value="" disabled selected>Marketing Interest</option>

                        <option value="Product Information">Product Information</option>
                        <option value="Newsletter">Newsletter</option>
                        <option value="Promotions">Promotions</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "MARKETING_INTEREST_HALF") THEN]%%
                <!------------- Product Interest ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_marketing_interest"
                        name="_marketing_interest"
                        multiple>

                        <option value="" disabled selected>Marketing Interest</option>

                        <option value="Product Information">Product Information</option>
                        <option value="Newsletter">Newsletter</option>
                        <option value="Promotions">Promotions</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "ENQUIRY_TYPE") THEN]%%
                <!------------- User Interest ----------------->
                <div class="input-field col s12">

                    <select
                        id="_enquiry_type"
                        name="_enquiry_type"
                        required>

                        <option value="" disabled selected>What would you like to enquire about?</option>

                        <option value="Demo">Demonstration</option>
                        <option value="Quote">Quote</option>
                        <option value="Trial">Trial</option>
                        <option value="Information">Information</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "ENQUIRY_TYPE_HALF") THEN]%%
                <!------------- User Interest HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_enquiry_type"
                        name="_enquiry_type"
                        required>

                        <option value="" disabled selected>What would you like to enquire about?</option>

                        <option value="Demo">Demonstration</option>
                        <option value="Quote">Quote</option>
                        <option value="Trial">Trial</option>
                        <option value="Information">Information</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBJECT") THEN]%%
                <!------------- Subject ----------------->
                <div class="input-field col s12">

                    <select
                        id="_subject"
                        name="_subject"
                        multiple
                        required>

                        <option value="" disabled selected>Subject</option>

                        <option value="literacy">Literacy</option>
                        <option value="mathematics">Mathematics</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBJECT_HALF") THEN]%%
                <!------------- Subject ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_subject"
                        name="_subject"
                        multiple
                        required>

                        <option value="" disabled selected>Subject</option>

                        <option value="literacy">Literacy</option>
                        <option value="mathematics">Mathematics</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "FIRST_NAME") THEN]%%
                <!------------- First Name ----------------->
                <div class="input-field col s12">

                    <label for="_first_name">First Name</label>
                    <input
                        type="text"
                        id="_first_name"
                        name="_first_name"
                        placeholder="First Name"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "FIRST_NAME_HALF") THEN]%%
                <!------------- First Name HALF ----------------->
                <div class="input-field col s12 m6">

                    <label for="_first_name">First Name</label>
                    <input
                        type="text"
                        id="_first_name"
                        name="_first_name"
                        placeholder="First Name"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "LAST_NAME") THEN]%%
                <!------------- Last Name ----------------->
                <div class="input-field col s12">

                    <label for="_last_name">Last Name</label>
                    <input
                        type="text"
                        id="_last_name"
                        name="_last_name"
                        placeholder="Last Name"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "LAST_NAME_HALF") THEN]%%
                <!------------- Last Name HALF ----------------->
                <div class="input-field col s12 m6">

                    <label for="_last_name">Last Name</label>
                    <input
                        type="text"
                        id="_last_name"
                        name="_last_name"
                        placeholder="Last Name"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "EMAIL_ADDRESS") THEN]%%
                <!------------- Email Address----------------->
                <div class="input-field col s12">

                    <label for="_email_address">Email Address</label>
                    <input
                        type="email"
                        id="_email_address"
                        name="_email_address"
                        placeholder="Email Address"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "EMAIL_ADDRESS_HALF") THEN]%%
                <!------------- Email Address HALF ----------------->
                <div class="input-field col s12 m6">

                    <label for="_email_address">Email Address</label>
                    <input
                        type="email"
                        id="_email_address"
                        name="_email_address"
                        placeholder="Email Address"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PHONE_NUMBER") THEN]%%
                <!------------- Phone Number ----------------->
                <div class="input-field col s12">

                    <label for="_phone_number">Mobile / Work Phone</label>
                    <input
                        type="text"
                        id="_phone_number"
                        name="_phone_number"
                        placeholder="Mobile / Work Phone"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "PHONE_NUMBER_HALF") THEN]%%
                <!------------- Phone Number HALF ----------------->
                <div class="input-field col s12 m6">

                    <label for="_phone_number">Mobile / Work Phone</label>
                    <input
                        type="text"
                        id="_phone_number"
                        name="_phone_number"
                        placeholder="Mobile / Work Phone"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "GRADE_LEVEL") THEN]%%
                <!------------- Grade Level ----------------->
                <div class="input-field col s12">

                    <select
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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "GRADE_LEVEL_HALF") THEN]%%
                <!------------- Grade Level HALF----------------->
                <div class="input-field col s12 m6">

                    <select
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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_GLOBAL") THEN]%%
                <!------------- Country Name ----------------->
                <div class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_Main = LookupOrderedRows("COUNTRY_REFERENCE", 0, "IsMainCountry desc, CountryName asc", "Active", "True", "IsMainCountry", "True")
                        FOR @i = 1 to RowCount(@Countries_Main) Do
                        SET @Country_Name = field(row(@Countries_Main, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_Main, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_GLOBAL_HALF") THEN]%%
                <!------------- Country Name HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_Main = LookupOrderedRows("COUNTRY_REFERENCE", 0, "IsMainCountry desc, CountryName asc", "Active", "True", "IsMainCountry", "True")
                        FOR @i = 1 to RowCount(@Countries_Main) Do
                        SET @Country_Name = field(row(@Countries_Main, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_Main, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Name,'"',' data-countrycode="',@Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        OutputLine(Concat('<option disabled>------------------------------------------------------</option>'))

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Name,'"',' data-countrycode="',@Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_APAC") THEN]%%
                <!------------- Country Name ----------------->
                <div class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True", "Region", "APAC")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_APAC_HALF") THEN]%%
                <!------------- Country Name HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True", "Region", "APAC")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_AMER") THEN]%%
                <!------------- Country Name ----------------->
                <div class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True", "Region", "AMER")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_AMER_HALF") THEN]%%
                <!------------- Country Name HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True", "Region", "AMER")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_EMEA") THEN]%%
                <!------------- Country Name ----------------->
                <div class="input-field col s12">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True", "Region", "EMEA")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "COUNTRY_EMEA_HALF") THEN]%%
                <!------------- Country Name HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_country_code"
                        name="_country_code"
                        required>

                        <option value="" selected disabled>Select Country</option>

                        %%[

                        /* POPULATE COUNTRY OPTIONS
                        ******************************/

                        SET @Countries_All = LookupOrderedRows("COUNTRY_REFERENCE", 0, "CountryName asc", "Active", "True", "Region", "EMEA")
                        FOR @i = 1 to RowCount(@Countries_All) Do
                        SET @Country_Name = field(row(@Countries_All, @i),"CountryName")
                        SET @Country_Code = field(row(@Countries_All, @i),"CountryCode")
                        OutputLine(Concat('<option value="', @Country_Code,'">',@Country_Name,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_GLOBAL") THEN]%%
                <!------------- State / Province Name ----------------->
                <div class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State / Province <small>&nbsp;(Please select a country first.)</small></option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>


                <!-- On Country Change -->
                <script>
                    try {

                        // CONSTANTS
                        let statesData;

                        // DOM ELEMENTS
                        const countrySelect = document.getElementById('_country_code');
                        const stateProvinceSelect = document.getElementById('_state_code');

                        // EVENTS
                        document.addEventListener('DOMContentLoaded', getStatesData);
                        countrySelect.addEventListener('change', handleCountryChange);

                        // HANDLERS
                        function getStatesData() {
                            const getStatesApi = "/getStates";

                            fetch(getStatesApi)
                                .then(response => response.json())
                                .then(data => {
                                    statesData = data;
                                })
                                .catch(error => console.error(error));
                        }

                        function handleCountryChange(e) {
                            // Choose states
                            const selectedOption = e.target.options[e.target.selectedIndex];
                            const countryCode = selectedOption.dataset.countrycode;
                            const countryStateData = statesData.filter((option) => option["CountryCode"] === countryCode);

                            // Reset options
                            stateProvinceSelect.value = '';
                            stateProvinceSelect.innerHTML = '';

                            const placeholderText = countryCode === "CA" ? 'Province' : 'State';
                            const option = document.createElement('option');
                            option.value = '';
                            option.disabled = true;
                            option.selected = true;
                            option.textContent = placeholderText;
                            stateProvinceSelect.appendChild(option);

                            // Populate options
                            countryStateData.forEach((state) => {
                                const option = document.createElement('option');
                                option.value = state['StateCode'];
                                option.textContent = state['StateName'];
                                stateProvinceSelect.appendChild(option);
                            });
                        }

                    } catch (e) {
                        console.error(e.message);
                    }
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_GLOBAL_HALF") THEN]%%
                <!------------- State / Province Name HALF----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State / Province <small>&nbsp;(Please select a country first.)</small></option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>


                <!-- On Country Change -->
                <script>
                    try {

                        // CONSTANTS
                        let statesData;

                        // DOM ELEMENTS
                        const countrySelect = document.getElementById('_country_code');
                        const stateProvinceSelect = document.getElementById('_state_code');

                        // EVENTS
                        document.addEventListener('DOMContentLoaded', getStatesData);
                        countrySelect.addEventListener('change', handleCountryChange);

                        // HANDLERS
                        function getStatesData() {
                            const getStatesApi = "/getStates";

                            fetch(getStatesApi)
                                .then(response => response.json())
                                .then(data => {
                                    statesData = data;
                                })
                                .catch(error => console.error(error));
                        }

                        function handleCountryChange(e) {
                            // Choose states
                            const selectedOption = e.target.options[e.target.selectedIndex];
                            const countryCode = selectedOption.dataset.countrycode;
                            const countryStateData = statesData.filter((option) => option["CountryCode"] === countryCode);

                            // Reset options
                            stateProvinceSelect.value = '';
                            stateProvinceSelect.innerHTML = '';

                            const placeholderText = countryCode === "CA" ? 'Province' : 'State';
                            const option = document.createElement('option');
                            option.value = '';
                            option.disabled = true;
                            option.selected = true;
                            option.textContent = placeholderText;
                            stateProvinceSelect.appendChild(option);

                            // Populate options
                            countryStateData.forEach((state) => {
                                const option = document.createElement('option');
                                option.value = state['StateCode'];
                                option.textContent = state['StateName'];
                                stateProvinceSelect.appendChild(option);
                            });
                        }

                    } catch (e) {
                        console.error(e.message);
                    }
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_US") THEN]%%
                <!------------- State / Province Name (US) ----------------->
                <div class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_US_HALF") THEN]%%
                <!------------- State / Province Name (US) HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_CA") THEN]%%
                <!------------- State / Province Name (CA) ----------------->
                <div class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>Province</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_CA_HALF") THEN]%%
                <!------------- State / Province Name (CA) HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>Province</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_AU") THEN]%%
                <!------------- State / Province Name (AU) ----------------->
                <div class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_AU_HALF") THEN]%%
                <!------------- State / Province Name (AU) HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_NZ") THEN]%%
                <!------------- State / Province Name (NZ) ----------------->
                <div class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_NZ_HALF") THEN]%%
                <!------------- State / Province Name (NZ) HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_ZA") THEN]%%
                <!------------- State / Province Name (ZA) ----------------->
                <div class="input-field col s12">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "STATE_PROVINCE_ZA_HALF") THEN]%%
                <!------------- State / Province Name (ZA) HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_state_code"
                        name="_state_code"
                        required>

                        <option value="" disabled selected>State</option>

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

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "POSTCODE_ZIPCODE") THEN]%%
                <!------------- Postcode / Zipcode ----------------->
                <div class="input-field col s12">

                    <label for="_postcode_zipcode">Postcode / Zipcode</label>
                    <input
                        type="text"
                        id="_postcode_zipcode"
                        name="_postcode_zipcode"
                        placeholder="Postcode / Zipcode"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "POSTCODE_ZIPCODE_HALF") THEN]%%
                <!------------- Postcode / Zipcode HALF ----------------->
                <div class="input-field col s12 m6">

                    <label for="_postcode_zipcode">Postcode / Zipcode</label>
                    <input
                        type="text"
                        id="_postcode_zipcode"
                        name="_postcode_zipcode"
                        placeholder="Postcode / Zipcode"
                        title="Postcode/Zipcode is 4 digits with no spaces"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_GLOBAL") THEN]%%
                <!------------- Job Title ----------------->
                <div class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title (Please select a country)</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>


                <script runat="server">
                    /**
                     * GET ALL COUNTRY RECORDS
                     *****************************/
                    var countryRegionRecords = Platform.Function.LookupRows('COUNTRY_REFERENCE', 'Active', true)
                    Write('<script>let countryRegionRecords = ' + Stringify(countryRegionRecords) + '</' + 'script>');
                </script>


                <script runat="server">
                    /**
                     * GET ALL JOB TITLE RECORDS
                     *****************************/
                    var jobTitleRecords = Platform.Function.LookupRows('JOB_REFERENCE', 'Active', true)
                    Write('<script>let jobTitleRecords = ' + Stringify(jobTitleRecords) + '</' + 'script>');
                </script>


                <!-- On Country Change -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const countrySelect = document.getElementById('_country_code');
                        const jobTitleSelect = document.getElementById('_job_title');

                        countrySelect.addEventListener('change', (event) => {
                            //get selected country code
                            const selectedCountryCode = event.target.value;
                            //get region
                            const selectedRegion = countryRegionRecords.find(i => {
                                return i.CountryCode === selectedCountryCode
                            }).Region;
                            //filter
                            const jobTitlesFiltered = jobTitleRecords.filter(i => i.Region === selectedRegion);
                            //clear
                            jobTitleSelect.innerHTML = '';
                            //placeholder
                            jobTitleSelect.innerHTML = '<option value="" disabled selected>Job Title</option>'
                            //append
                            jobTitleSelect.innerHTML += jobTitlesFiltered.map(i => {
                                return `<option value="${i.JobTitle}">${i.JobTitle}</option>`
                            }).join('');
                        });
                    });
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_GLOBAL_HALF") THEN]%%
                <!------------- Job Title ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title (Please select a country)</option>

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>


                <script runat="server">
                    /**
                     * GET ALL COUNTRY RECORDS
                     *****************************/
                    var countryRegionRecords = Platform.Function.LookupRows('COUNTRY_REFERENCE', 'Active', true)
                    Write('<script>let countryRegionRecords = ' + Stringify(countryRegionRecords) + '</' + 'script>');
                </script>


                <script runat="server">
                    /**
                     * GET ALL JOB TITLE RECORDS
                     *****************************/
                    var jobTitleRecords = Platform.Function.LookupRows('JOB_REFERENCE', 'Active', true)
                    Write('<script>let jobTitleRecords = ' + Stringify(jobTitleRecords) + '</' + 'script>');
                </script>


                <!-- On Country Change -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const countrySelect = document.getElementById('_country_code');
                        const jobTitleSelect = document.getElementById('_job_title');

                        countrySelect.addEventListener('change', (event) => {
                            //get selected country code
                            const selectedCountryCode = event.target.value;
                            //get region
                            const selectedRegion = countryRegionRecords.find(i => {
                                return i.CountryCode === selectedCountryCode
                            }).Region;
                            //filter
                            const jobTitlesFiltered = jobTitleRecords.filter(i => i.Region === selectedRegion);
                            //clear
                            jobTitleSelect.innerHTML = '';
                            //placeholder
                            jobTitleSelect.innerHTML = '<option value="" disabled selected>Job Title</option>'
                            //append
                            jobTitleSelect.innerHTML += jobTitlesFiltered.map(i => {
                                return `<option value="${i.JobTitle}">${i.JobTitle}</option>`
                            }).join('');
                        });
                    });
                </script>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_APAC") THEN]%%
                <!------------- Job Title ----------------->
                <div class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobList = LookupRows("JOB_REFERENCE", "Region", "APAC", "Active", "1")
                        FOR @i = 1 TO RowCount(@jobList) DO
                        SET @jobTitle = Field(Row(@jobList, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_APAC_HALF") THEN]%%
                <!------------- Job Title HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>


                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobList = LookupRows("JOB_REFERENCE", "Region", "APAC", "Active", "1")
                        FOR @i = 1 TO RowCount(@jobList) DO
                        SET @jobTitle = Field(Row(@jobList, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_AMER") THEN]%%
                <!------------- Job Title ----------------->
                <div class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobList = LookupRows("JOB_REFERENCE", "Region", "AMER", "Active", "1")
                        FOR @i = 1 TO RowCount(@jobList) DO
                        SET @jobTitle = Field(Row(@jobList, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_AMER_HALF") THEN]%%
                <!------------- Job Title HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobList = LookupRows("JOB_REFERENCE", "Region", "AMER", "Active", "1")
                        FOR @i = 1 TO RowCount(@jobList) DO
                        SET @jobTitle = Field(Row(@jobList, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_EMEA") THEN]%%
                <!------------- Job Title ----------------->
                <div class="input-field col s12">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobList = LookupRows("JOB_REFERENCE", "Region", "EMEA", "Active", "1")
                        FOR @i = 1 TO RowCount(@jobList) DO
                        SET @jobTitle = Field(Row(@jobList, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "JOB_TITLE_EMEA_HALF") THEN]%%
                <!------------- Job Title HALF ----------------->
                <div class="input-field col s12 m6">

                    <select
                        id="_job_title"
                        name="_job_title"
                        required>

                        <option value="" selected disabled>Job Title</option>

                        %%[

                        /* Populate Job Title Options
                        ********************************/

                        SET @jobList = LookupRows("JOB_REFERENCE", "Region", "EMEA", "Active", "1")
                        FOR @i = 1 TO RowCount(@jobList) DO
                        SET @jobTitle = Field(Row(@jobList, @i), "JobTitle")
                        OutputLine(Concat('<option value="',@jobTitle,'">',@jobTitle,'</option>'))
                        NEXT @i

                        ]%%

                    </select>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SCHOOL_NAME") THEN]%%
                <!------------- School Name ----------------->
                <div class="input-field col s12">

                    <label for="_school_name">School or District Name</label>
                    <input
                        type="text"
                        id="_school_name"
                        name="_school_name"
                        placeholder="School or District Name"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SCHOOL_NAME_HALF") THEN]%%
                <!------------- School Name HALF----------------->
                <div class="input-field col s12 m6">

                    <label for="_school_name">School or District Name</label>
                    <input
                        type="text"
                        id="_school_name"
                        name="_school_name"
                        placeholder="School or District Name"
                        required>

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "NO_OF_LICENCES") THEN]%%
                <!------------- No. Of Licences  ----------------->
                <div class="input-field col s12">

                    <label for="_no_of_licences">Number of Student Licenses</label>
                    <input
                        type="number"
                        id="_no_of_licences"
                        name="_no_of_licences"
                        placeholder="Number of Student Licenses"
                        required
                        min="20"
                        max="1000">

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "NO_OF_LICENCES_HALF") THEN]%%
                <!------------- No. Of Licences HALF ----------------->
                <div class="input-field col s12 m6">

                    <label for="_no_of_licences">Number of Student Licenses</label>
                    <input
                        type="number"
                        id="_no_of_licences"
                        name="_no_of_licences"
                        placeholder="Number of Student Licenses"
                        required
                        min="20"
                        max="1000">

                    <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TERMS_AND_CONDITIONS") THEN]%%
                <!------------- Terms & Conditions ----------------->
                <div class="input-field col s12">
                    <div class="form-check">

                        <label>
                            <input
                                type="checkbox"
                                id="_terms_and_conditions"
                                name="_terms_and_conditions"
                                checked
                                required>
                            <span>
                                I agree to the 3P Learning
                                <a tabindex="-1" target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms and Conditions</a>.
                            </span>
                        </label>

                        <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                    </div>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "TERMS_AND_CONDITIONS_HALF") THEN]%%
                <!------------- Terms & Conditions HALF ----------------->
                <div class="input-field col s12 m6">
                    <div class="form-check">

                        <label>
                            <input
                                type="checkbox"
                                id="_terms_and_conditions"
                                name="_terms_and_conditions"
                                checked
                                required>
                            <span>
                                I agree to the 3P Learning
                                <a tabindex="-1" target="_parent" href="https://www.3plearning.com/terms/" style="text-decoration: underline;">Terms and Conditions</a>.
                            </span>
                        </label>

                        <span class="helper-text" data-error="wrong" data-success="right">Helper text</span>

                    </div>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBSCRIBER_OPT_IN") THEN]%%
                <!------------- Subscriber Opt In ----------------->
                <div class="input-field col s12">
                    <div class="form-check">

                        <label>
                            <input
                                type="checkbox"
                                id="_subscriber_opt_in"
                                name="_subscriber_opt_in"
                                checked>
                            <span>
                                YES! Sign me up to receive monthly newsletters, educational content, resources, and occasional promotional material.
                            </span>
                        </label>

                        <!-- <span class="helper-text" data-error="wrong" data-success="right">Helper text</span> -->

                    </div>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBSCRIBER_OPT_IN_HALF") THEN]%%
                <!------------- Subscriber Opt In HALF ----------------->
                <div class="input-field col s12 m6">
                    <div class="form-check">

                        <label>
                            <input
                                type="checkbox"
                                id="_subscriber_opt_in"
                                name="_subscriber_opt_in"
                                checked>
                            <span>
                                YES! Sign me up to receive monthly newsletters, educational content, resources, and occasional promotional material.
                            </span>
                        </label>

                        <!-- <span class="helper-text" data-error="wrong" data-success="right">Helper text</span> -->

                    </div>
                </div>
                %%[ENDIF]%%


                %%[IF (@FORM_COMPONENT == "SUBMIT_BUTTON") THEN]%%
                <!------------- Submit Button ----------------->
                <div class="input-field col s12">

                    <button
                        class="custom_submit_button"
                        type="submit"
                        id="_submit_button"
                        name="_submit_button">
                        Submit
                    </button>

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


</body>

</html>




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
            payload.lookupRedirectData = Platform.Function.LookupRows('REDIRECT_REFERENCE', 'Id', payload.rid);
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