<script runat="server">
    Platform.Load("core", "1");
    /**
     * 
     * ==========================================================================================================
     * ========================================= REUSABLE FORM PIPELINE =========================================
     * ==========================================================================================================
     * 
     * 
     * @author: Nick Phillips
     * @version: 1.0.0
     * 
     * 
     * 
     * 
     * CHANGE LOG
     * -------------------------------------------
     *
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * DATA EXTENSION COLUMNS CURRENTLY IN USE
     * -------------------------------------------
     * 
     * submission_id
     * submission_name
     * submission_email
     * submission_url
     * submission_data
     * submission_date
     * 
     * queue_record_id
     * queue_upsert_method
     * queue_error_message
     * queue_completed_date
     * 
     *
     * 
     * 
     * SUBMITTED FORM FIELDS CURRENTLY IN USE
     * --------------------------------------------
     * 
     * debug
     * 
     * cid
     * rid
     * eid
     * sid
     * fid
     *
     * inputs
     * template
     * request_url
     *
     * utm_source
     * utm_medium
     * utm_campaign
     * utm_content
     * utm_term
     * gclid
     * gtm_referrer
     *
     * product_interest
     * user_interest
     * first_name
     * last_name
     * email_address
     * phone_number
     * grade_level
     * job_title
     * country_code
     * state_code
     * postcode_zipcode
     * school_name
     * no_of_licences
     * terms_and_conditions
     * subscriber_opt_in
     * 
     * 
     * 
     * 
     */
</script>


<script runat="server">
    // 
    // 
    /************************* 
    ------- GET DATA -------
    **************************/


    var queue = [];
    try {

        //lookup new queue entries
        queue = Platform.Function.LookupOrderedRows('REUSABLE_FORM_QUEUE', 0, 'submission_date ASC', 'queue_completed_date', null);

        //exit early if no records
        if (!queue) return;


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }


    /************************* 
    ------- PARSE JSON -------
    **************************/
    try {

        //loop
        for (var i = 0; i < queue.length; i++) {

            queue[i].record = Platform.Function.ParseJSON(queue[0].submission_data);

        } //for


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }


    /************************* 
    --------- VALIDATE --------
    **************************/
    try {


        // get reference tables
        var COUNTRY_REFERENCE = Platform.Function.LookupRows('COUNTRY_REFERENCE', 'Active', true);
        var PROFANITY_REFERENCE = Platform.Function.LookupRows('PROFANITY_REFERENCE', 'Active', true);
        var BLOCKED_EMAIL_REFERENCE = Platform.Function.LookupRows('BLOCKED_EMAIL_REFERENCE', 'Active', true);


        //loop
        outerLoop: for (var i = 0; i < queue.length; i++) {

            var queueable = queue[i];
            var submitted = queue[i].record;

            //INVALID_EMAIL_FORMAT
            if (
                submitted.email_address &&
                !Platform.Function.isEmailAddress(submitted.email_address)
            ) {
                queueable.queue_error_message = 'INVALID_EMAIL_FORMAT: email_address is missing or not valid';
                queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                continue outerLoop;
            }

            //STUDENT_JOB_TITLE
            if (
                submitted.job_title &&
                submitted.job_title.toLowerCase().indexOf('student') !== -1
            ) {
                queueable.queue_error_message = 'STUDENT_JOB_TITLE: job_title contains the word "student"';
                queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                continue outerLoop;
            }

            //PARENT_JOB_TITLE
            if (
                submitted.job_title &&
                submitted.job_title.toLowerCase().indexOf('parent') !== -1
            ) {
                queueable.queue_error_message = 'PARENT_JOB_TITLE: job_title contains the word "parent"';
                queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                continue outerLoop;
            }

            //STUDENT_EMAIL_DOMAIN
            if (
                submitted.email_address &&
                submitted.email_address.toLowerCase().indexOf('student') !== -1
            ) {
                queueable.queue_error_message = 'STUDENT_EMAIL_DOMAIN: email_address contains the word "student"';
                queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                continue outerLoop;
            }

            //BLOCKED_EMAIL_ADDRESS
            if (submitted.email_address) {
                innerLoop: for (var j = 0; j < BLOCKED_EMAIL_REFERENCE.length; j++) {
                    if (
                        submitted.email_address.toLowerCase() === BLOCKED_EMAIL_REFERENCE[j].EmailAddress.toLowerCase()
                    ) {
                        queueable.queue_error_message = 'BLOCKED_EMAIL_ADDRESS: email_address is blacklisted';
                        queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                        continue outerLoop;
                    }
                } //for(j)
            }

            //SANCTIONED_COUNTRY
            if (submitted.country_code) {
                innnerLoop: for (var j = 0; j < COUNTRY_REFERENCE.length; j++) {
                    if (
                        submitted.country_code.toLowerCase() === COUNTRY_REFERENCE[j].CountryCode.toLowerCase() &&
                        COUNTRY_REFERENCE[j].IsSanctionedCountry
                    ) {
                        queueable.queue_error_message = 'SANCTIONED_COUNTRY: country is sanctioned, we are unable to provide services';
                        queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                        continue outerLoop;
                    }
                } //for(j)
            }

            //RESTRICTED_COUNTRY
            if (submitted.country_code) {
                innerLoop: for (var j = 0; j < COUNTRY_REFERENCE.length; j++) {
                    if (
                        submitted.country_code.toLowerCase() === COUNTRY_REFERENCE[j].CountryCode.toLowerCase() &&
                        COUNTRY_REFERENCE[j].IsCountryRestricted
                    ) {
                        queueable.queue_error_message = 'RESTRICTED_COUNTRY: country is restricted, we are unable to provide services';
                        queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                        continue outerLoop;
                    }
                } //for(j)
            }

            //PROFANITY_DETECTED
            if (submitted.first_name || submitted.last_name) {
                for (var j = 0; j < PROFANITY_REFERENCE.length; j++) {
                    if (
                        submitted.first_name.toLowerCase() === PROFANITY_REFERENCE[j].Name.toLowerCase() ||
                        submitted.last_name.toLowerCase() === PROFANITY_REFERENCE[j].Name.toLowerCase()
                    ) {
                        queueable.queue_error_message = 'PROFANITY_DETECTED: swear words were equal to the first_name or last_name';
                        queueable.queue_completed_date = Datetime.SystemDateToLocalString();
                        continue outerLoop;
                    }
                } //for(j)
            }


        } //for(i)


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }




    /************************* 
    ------ PRE-PROCESS -------
    **************************/
    try {


        // Lookup Region, Country
        if (payload.country_code) {
            payload.lookupCountryData = Platform.Function.LookupRows('COUNTRY_REFERENCE', 'CountryCode', payload.country_code);
            payload.region = payload.lookupCountryData[0].Region;
            payload.country_name = payload.lookupCountryData[0].CountryName;
        }

        // Lookup State
        if (payload.state_code) {
            payload.lookupStateData = Platform.Function.LookupRows('STATE_REFERENCE', 'CountryCode', payload.country_code);
            payload.state_name = payload.lookupStateData[0].StateName;
        }

        // Lookup Job Function
        if (payload.job_title) {
            paylaod.lookupJobData = Platform.Function.LookupRows('JOB_FUNCTION_REFERENCE', ['JobTitle', 'Region'], [payload.job_title, payload.region]);
            payload.job_function = payload.lookupJobData[0].JobFunction;
        }

        // Lookup Enquiry Type
        if (payload.eid) {
            paylaod.lookupEnquiryData = Platform.Function.LookupRows('ENQUIRY_REFERENCE', ['Id'], [payload.eid]);
            payload.enquiry = payload.lookupEnquiryData[0].Enquiry;
            payload.description = payload.lookupEnquiryData[0].Description;
            payload.enquiry_summary = payload.lookupEnquiryData[0].Description;
        }

        // Lookup Lead Status
        if (payload.sid) {
            paylaod.lookupLeadStatusData = Platform.Function.LookupRows('LEAD_STATUS_REFERENCE', ['Id'], [payload.sid]);
            payload.status = payload.lookupLeadStatusData[0].Status;
        }

        // Lookup Campaign
        if (payload.cid) {
            paylaod.lookupCampaignData = Platform.Function.LookupRows('ENT.Campaign_Salesforce', 'Id', payload.cid);
            payload.campaign_name = payload.lookupCampaignData[0].Name;
        }

        // Lookup Campaign Resources
        //
        //  TODO - configure to pull from an object related to the campaign instead of having to maintain a reference DE
        //


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }
</script>




%%[

/*************************
---------- UPSERT --------
**************************/


// Upsert Lead
// Upsert Campaign Member


]%%