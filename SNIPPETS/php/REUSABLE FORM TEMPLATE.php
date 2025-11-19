<script runat="server">
    Platform.Load("core", "1");

    var documentation = ''.concat(
        '<div style="padding: 15px; font-weight:bold">',
        '<br>',
        '//========================================================================================================== <br>',
        '// REUSABLE FORM TEMPLATE <br>',
        '// ========================================================================================================== <br>',
        '<br>',
        '<br>',
        '<span style="color:green;">Congratulations! Your form is working.</span><br>',
        'Please configure all the required query parameters below to hide this documentaiton<br>',
        '<br>',
        '<br>',
        '@Template Author: Nick Phillips <br>',
        '@Template Version: 1.0.0 <br>',
        '<br>',
        '<br>',
        'CHANGE LOG <br>',
        '------------------------------------------- <br>',
        '<br>',
        'Region: <br>',
        'Campaign(s): <br>',
        'Form Created By: <br>',
        'Form Created Date: <br>',
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
        '@parameter: (optional) cid - the default salesforce campaign id regardless of country or region. <br>',
        '@parameter: (optional) rid - the redirect id used to retrieve a url from a DE and redirect the user after form submission <br>',
        '@parameter: (optional) eid - enquiry id -  (tof, bof, quote, info). Links to enquiry type picklist in Salesforce <br>',
        '@parameter: (optional) sid - lead status id - [UQ, MP, SP, MQL, SAL, SQL] <br>',
        '@parameter: (optional) fid - form Id - a random bunch of characters that makes the url unique in comparison to other configurations<br>',
        '<br>',
        '@parameter: (optional) apac_cid - Used on GLOBAL forms to choose the campaign id when the lead submits from an APAC based country  <br>',
        '@parameter: (optional) amer_cid - Used on GLOBAL forms to choose the campaign id when the lead submits from an AMER based country <br>',
        '@parameter: (optional) emea_cid - Used on GLOBAL forms to choose the campaign id when the lead submits from an EMEA based country   <br>',
        '<br>',
        '@parameter: (optional) utm_source - marketing trackers retrieved from a browser cookie <br>',
        '@parameter: (optional) utm_medium - marketing trackers retrieved from a browser cookie <br>',
        '@parameter: (optional) utm_campaign - marketing trackers retrieved from a browser cookie <br>',
        '@parameter: (optional) utm_content - marketing trackers retrieved from a browser cookie <br>',
        '@parameter: (optional) utm_term - marketing trackers retrieved from a browser cookie <br>',
        '<br>',
        '@parameter: (optional) gclid - (google click ID) marketing trackers retrieved from a browser cookie <br>',
        '@parameter: (optional) gtm_referrer - marketing trackers retrieved from a browser cookie <br>',
        '<br>',
        '<br>',
        'EXAMPLE URLS <br>',
        '------------------------------------------- <br>',
        '<br>',
        '@example: Test <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?template=test <br>',
        '<br>',
        '@example: Test Columns <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?template=test_columns <br>',
        '<br>',
        '@example: Test States <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?template=test_states <br>',
        '<br>',
        '@example: Basic Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,SCHOOL_NAME,COUNTRY_NAME,STATE_PROVINCE_NAME,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: TOF Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,JOB_TITLE,SCHOOL_NAME,COUNTRY_NAME,STATE_PROVINCE_NAME,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: BOF Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,JOB_TITLE,COUNTRY_NAME,STATE_PROVINCE_NAME,POSTCODE_ZIPCODE,SCHOOL_NAME,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: Quote Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=PRODUCT_INTEREST,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,COUNTRY_NAME,STATE_PROVINCE_NAME,POSTCODE_ZIPCODE,SCHOOL_NAME,PHONE_NUMBER,JOB_TITLE,GRADE_LEVEL,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: US Form Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=PRODUCT_INTEREST,USER_INTEREST,FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,COUNTRY_NAME,STATE_PROVINCE_NAME,POSTCODE_ZIPCODE,SCHOOL_NAME,PHONE_NUMBER,JOB_TITLE,GRADE_LEVEL,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: Trial Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE,COUNTRY_NAME,STATE_PROVINCE_NAME,POSTCODE_ZIPCODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: Info Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE,COUNTRY_NAME,STATE_PROVINCE_NAME,POSTCODE_ZIPCODE,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '@example: Demo Template <br>',
        'https://webform.my.3plearning.com/REUSABLE_FORM?inputs=FIRST_NAME,LAST_NAME,EMAIL_ADDRESS,PHONE_NUMBER,SCHOOL_NAME,JOB_TITLE,COUNTRY_NAME,STATE_PROVINCE_NAME,POSTCODE_ZIPCODE,NO_OF_LICENCES,TERMS_AND_CONDITIONS,SUBSCRIBER_OPT_IN,SUBMIT_BUTTON <br>',
        '<br>',
        '<br> ',
        '</div>'
    );
</script>



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
        payload.eid = Request.GetFormField("_eid");
        payload.sid = Request.GetFormField("_sid");
        payload.fid = Request.GetFormField("_fid");

        payload.inputs = Request.GetFormField("_inputs");
        payload.template = Request.GetFormField("_template");
        payload.request_url = Request.GetFormField("_request_url");

        payload.utm_source = Request.GetFormField("_utm_source");
        payload.utm_medium = Request.GetFormField("_utm_medium");
        payload.utm_campaign = Request.GetFormField("_utm_campaign");
        payload.utm_content = Request.GetFormField("_utm_content");
        payload.utm_term = Request.GetFormField("_utm_term");
        payload.utm_term = Request.GetFormField("_gclid");
        payload.gtm_referrer = Request.GetFormField("_gtm_referrer");

        payload.product_interest = Request.GetFormField("_product_interest");
        payload.user_interest = Request.GetFormField("_user_interest");
        payload.first_name = Request.GetFormField("_first_name");
        payload.last_name = Request.GetFormField("_last_name");
        payload.email_address = Request.GetFormField("_email_address");
        payload.phone_number = Request.GetFormField("_phone_number");
        payload.grade_level = Request.GetFormField("_grade_level");
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
            "submission_id": Platform.Function.GUID(),
            "submission_name": payload.first_name + ' ' + payload.last_name,
            "submission_email": payload.email_address,
            "submission_url": payload.request_url,
            "submission_data": Stringify(payload),
            "submission_date": Datetime.SystemDateToLocalString()
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
            AUTOMATION_NAME: 'REUSABLE_PIPELINE_AUTOMATION',
            NUMBER_OF_REPEATS: 3,
            WAIT_MILLISECONDS: 5 * 60 * 1000 //5mins
        }
        proxy.triggerAutomationWait(config.AUTOMATION_NAME, config.NUMBER_OF_REPEATS, config.WAIT_MILLISECONDS)


        /************************* 
        -------- REDIRECT --------
        **************************/


        //navigate to redirect
        if (payload.rid) {
            paylaod.lookupRedirectData = Platform.Function.LookupRows('REDIRECT_REFERENCE', 'Id', payload.rid);
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



<script runat="server">
    if (Request.Method() != "GET") return;
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
        ------- QUERY PARAMETERS -------
        ********************************/


        //initiate
        var config = {};


        //retrieve data
        config.debug = Request.GetQueryStringParameter("debug");

        config.cid = Request.GetQueryStringParameter("cid");
        config.rid = Request.GetQueryStringParameter("rid");
        config.eid = Request.GetQueryStringParameter("eid");
        config.sid = Request.GetQueryStringParameter("sid");
        config.fid = Request.GetQueryStringParameter("fid");

        config.template = Request.GetQueryStringParameter("template");
        config.inputs = Request.GetQueryStringParameter("inputs");

        config.utm_source = Request.GetQueryStringParameter("utm_source");
        config.utm_medium = Request.GetQueryStringParameter("utm_medium");
        config.utm_campaign = Request.GetQueryStringParameter("utm_campaign");
        config.utm_content = Request.GetQueryStringParameter("utm_content");
        config.utm_term = Request.GetQueryStringParameter("utm_term");
        config.utm_term = Request.GetQueryStringParameter("gclid");
        config.gtm_referrer = Request.GetQueryStringParameter("gtm_referrer");


        /*******************************
         ------ ADDITIONAL VALUES ------
        ********************************/


        //request url
        config.request_url = Request.URL();


        /************************* 
        -------- TEMPLATES -------
        **************************/


        config.TEMPLATES = {

            //?template=test_overrides
            test_overrides: [
                "OVERRIDE_REGION_APAC",
                "OVERRIDE_REGION_AMER",
                "OVERRIDE_REGION_EMEA",
                "OVERRIDE_COUNTRY_CODE_AU",
                "OVERRIDE_COUNTRY_CODE_NZ",
                "OVERRIDE_COUNTRY_CODE_US",
                "OVERRIDE_COUNTRY_CODE_CA",
                "OVERRIDE_COUNTRY_CODE_UK",
                "OVERRIDE_COUNTRY_CODE_ZA"
            ],

            //?template=test_full
            test_full: [
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


            //?template=test_full_half
            test_full_half: [
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

            //?template=test_states
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

            //?template=test_all
            test_all: [
                "PRODUCT_INTEREST",
                "PRODUCT_INTEREST_HALF",
                "USER_INTEREST",
                "USER_INTEREST_HALF",
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
                "JOB_TITLE",
                "JOB_TITLE_HALF",
                "COUNTRY_NAME",
                "COUNTRY_NAME_HALF",
                "STATE_PROVINCE_NAME",
                "STATE_PROVINCE_NAME_HALF",
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
        config.COMPONENTS_TO_RENDER = [];


        // ADD ALL TEMPLATE COMPONENTS
        if (congig.template) {
            var templateComponentList = config.TEMPLATES[config.template.toLowerCase()];
            config.COMPONENTS_TO_RENDER = config.COMPONENTS_TO_RENDER.concat(templateComponentList);
        } //if


        // ADD SINGLE INPUT COMPONENTS
        if (config.inputs) {
            var singleInputList = config.inputs.toUpperCase().split(',');
            for (var i = 0; i < singleInputList.length; i++) {
                var singleInput = singleInputList[i];
                config.COMPONENTS_TO_RENDER.push(singleInput);
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


    <!-- Meta/SEO -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Form">


    <!-- Title & Favicons -->
    <title> 3P Learning </title>
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


    <!------------- FORM ----------------->


    <form
        class="needs-validation"
        novalidate
        method="POST">


        <!------------- HIDDEN (Static) ----------------->

        <div>

            <input type="hidden" name="_debug" value="%%=v(@debug)=%%">

            <input type="hidden" name="_triggered_send_key" value="%%=v(@triggered_send_key)=%%">

            <input type="hidden" name="_apac_cid" value="%%=v(@apac_cid)=%%">
            <input type="hidden" name="_amer_cid" value="%%=v(@amer_cid)=%%">
            <input type="hidden" name="_emea_cid" value="%%=v(@emea_cid)=%%">
            <input type="hidden" name="_cid" value="%%=v(@cid)=%%">
            <input type="hidden" name="_rid" value="%%=v(@rid)=%%">
            <input type="hidden" name="_eid" value="%%=v(@eid)=%%">
            <input type="hidden" name="_sid" value="%%=v(@sid)=%%">
            <input type="hidden" name="_fid" value="%%=v(@fid)=%%">

            <input type="hidden" name="_template" value="%%=v(@template)=%%">
            <input type="hidden" name="_components" value="%%=v(@inputs)=%%">
            <input type="hidden" name="_request_url" value="%%=v(@request_url)=%%">

            <input type="hidden" name="_utm_source" value="%%=v(@utm_source)=%%">
            <input type="hidden" name="_utm_medium" value="%%=v(@utm_medium)=%%">
            <input type="hidden" name="_utm_campaign" value="%%=v(@utm_campaign)=%%">
            <input type="hidden" name="_utm_content" value="%%=v(@utm_content)=%%">
            <input type="hidden" name="_utm_term" value="%%=v(@utm_term)=%%">
            <input type="hidden" name="_gclid" value="%%=v(@gclid)=%%">
            <input type="hidden" name="_gtm_referrer" value="%%=v(@gtm_referrer)=%%">


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
                        document.querySelector('input[name="_gtm_referrer"]').value = getCookie('__gtm_referrer');
                    }

                }); //DOMContentLoaded
            </script>

        </div>


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


                <!-- HIDDEN (Overrides) -->

                IIF(@COMPONENT == "OVERRIDE_REGION_APAC", OutputLine("<input type="hidden" name="override_region" value='APAC'>"),"")
                IIF(@COMPONENT == "OVERRIDE_REGION_AMER", OutputLine("<input type="hidden" name="override_region" value='AMER'>"),"")
                IIF(@COMPONENT == "OVERRIDE_REGION_EMEA", OutputLine("<input type="hidden" name="override_region" value='EMEA'>"),"")
                IIF(@COMPONENT == "OVERRIDE_COUNTRY_CODE_AU", OutputLine("<input type="hidden" name="override_country_code" value='AU'>"),"")
                IIF(@COMPONENT == "OVERRIDE_COUNTRY_CODE_NZ", OutputLine("<input type="hidden" name="override_country_code" value='NZ'>"),"")
                IIF(@COMPONENT == "OVERRIDE_COUNTRY_CODE_US", OutputLine("<input type="hidden" name="override_country_code" value='US'>"),"")
                IIF(@COMPONENT == "OVERRIDE_COUNTRY_CODE_CA", OutputLine("<input type="hidden" name="override_country_code" value='CA'>"),"")
                IIF(@COMPONENT == "OVERRIDE_COUNTRY_CODE_UK", OutputLine("<input type="hidden" name="override_country_code" value='UK'>"),"")
                IIF(@COMPONENT == "OVERRIDE_COUNTRY_CODE_ZA", OutputLine("<input type="hidden" name="override_country_code" value='ZA'>"),"")


                <!-- FIEDS -->


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
                            <!-- <option value="Brightpath Progress Writing">Brightpath Writing</option> -->

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


                %%[IF (@COMPONENT == "JOB_TITLE_APAC") THEN]%%
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

                            /* Populate Job Title Options
                            ********************************/

                            Set @Job_Titles = LookupRows("JOB_REFERENCE", "Region", "APAC", "Active", "1")
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


                %%[IF (@COMPONENT == "JOB_TITLE_APAC_HALF") THEN]%%
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
                            id="_country_code"
                            name="_country_code"
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
                            id="_country_code"
                            name="_country_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            const placeholderOption = document.createElement('option');
                            placeholderOption.value = '';
                            placeholderOption.disabled = true;
                            placeholderOption.selected = true;
                            placeholderOption.textContent = placeholderText;
                            stateProvinceSelect.appendChild(placeholderOption);

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


                %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_HALF") THEN]%%
                <!------------- State / Province Name HALF----------------->
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">

                        <select
                            class="form-control custom-reset-select-text"
                            id="_state_code"
                            name="_state_code"
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
                            const placeholderOption = document.createElement('option');
                            placeholderOption.value = '';
                            placeholderOption.disabled = true;
                            placeholderOption.selected = true;
                            placeholderOption.textContent = placeholderText;
                            stateProvinceSelect.appendChild(placeholderOption);

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


                %%[IF (@COMPONENT == "STATE_PROVINCE_NAME_US") THEN]%%
                <!------------- State / Province Name (US) ----------------->
                <div class="col-sm-12">
                    <div class="form-group">

                        <select
                            class="form-control custom-reset-select-text"
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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
                            id="_state_code"
                            name="_state_code"
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


    <!-- Validate Form Submission-->
    <script>
        // @url: https://getbootstrap.com/docs/4.1/components/forms/#validation
        // @url: https://developer.snapappointments.com/bootstrap-select/options/#events

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


</body>

</html>