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


    var records = [];
    try {

        //lookup new records
        records = Platform.Function.LookupOrderedRows('REUSABLE_FORM_QUEUE', 0, 'submission_date ASC', 'queue_completed_date', null);

        //exit early
        if (!records) return;


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }


    /************************* 
    ------- PARSE JSON -------
    **************************/
    try {

        //loop
        for (var i = 0; i < records.length; i++) {

            records[i].data = Platform.Function.ParseJSON(records[0].submission_data);

        } //for


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }


    /************************* 
    --------- VALIDATE --------
    **************************/
    try {


        var BLOCKED_EMAIL_REFERENCE = Platform.Function.LookupRows('BLOCKED_EMAIL_REFERENCE', 'Active', true);
        var COUNTRY_REFERENCE = Platform.Function.LookupRows('COUNTRY_REFERENCE', 'Active', true);


        //loop
        for (var i = 0; i < records.length; i++) {


            //INVALID_EMAIL_FORMAT
            if (
                records[i].data.email_address &&
                !Platform.Function.isEmailAddress(records[i].data.email_address)
            ) {
                records[i].queue_error_message = 'INVALID_EMAIL_FORMAT: email_address is missing or not valid';
                records[i].queue_completed_date = Datetime.SystemDateToLocalString();
            }

            //STUDENT_JOB_TITLE
            if (
                records[i].data.job_title &&
                records[i].data.job_title.toLowerCase().indexOf('student') !== -1
            ) {
                records[i].queue_error_message = 'STUDENT_JOB_TITLE: job_title contains the word "student"';
                records[i].queue_completed_date = Datetime.SystemDateToLocalString();
            }

            //PARENT_JOB_TITLE
            if (
                records[i].data.job_title &&
                records[i].data.job_title.toLowerCase().indexOf('parent') !== -1
            ) {
                records[i].queue_error_message = 'PARENT_JOB_TITLE: job_title contains the word "parent"';
                records[i].queue_completed_date = Datetime.SystemDateToLocalString();
            }

            //STUDENT_EMAIL_DOMAIN
            if (
                records[i].data.email_address &&
                records[i].data.email_address.toLowerCase().indexOf('student') !== -1
            ) {
                records[i].queue_error_message = 'STUDENT_EMAIL_DOMAIN: email_address contains the word "student"';
                records[i].queue_completed_date = Datetime.SystemDateToLocalString();
            }

            //BLOCKED_EMAIL_ADDRESS
            if (records[i].email_address) {
                for (var j = 0; j < BLOCKED_EMAIL_REFERENCE.length; j++) {
                    if (
                        records[i].email_address.toLowerCase() === BLOCKED_EMAIL_REFERENCE[j].EmailAddress.toLowerCase()
                    ) {
                        records[i].queue_error_message = 'BLOCKED_EMAIL_ADDRESS: email_address is blacklisted';
                        records[i].queue_completed_date = Datetime.SystemDateToLocalString();
                    }
                } //for(j)
            }


            //SANCTIONED_COUNTRY
            if (records[i].country_code) {
                for (var j = 0; j < COUNTRY_REFERENCE.length; j++) {
                    if (
                        records[i].country_code.toLowerCase() === COUNTRY_REFERENCE[j].CountryCode.toLowerCase() &&
                        COUNTRY_REFERENCE[j].IsSanctionedCountry
                    ) {
                        records[i].queue_error_message = 'SANCTIONED_COUNTRY: country is sanctioned, we are unable to provide services"';
                        records[i].queue_completed_date = Datetime.SystemDateToLocalString();
                    }
                } //for(j)
            }

            //RESTRICTED_COUNTRY
            if (records[i].country_code) {
                for (var j = 0; j < COUNTRY_REFERENCE.length; j++) {
                    if (
                        records[i].country_code.toLowerCase() === COUNTRY_REFERENCE[j].CountryCode.toLowerCase() &&
                        COUNTRY_REFERENCE[j].IsCountryRestricted
                    ) {
                        records[i].queue_error_message = 'RESTRICTED_COUNTRY: country is restricted, we are unable to provide services"';
                        records[i].queue_completed_date = Datetime.SystemDateToLocalString();
                    }
                } //for(j)
            }


            //PROFANITY_CHECK







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