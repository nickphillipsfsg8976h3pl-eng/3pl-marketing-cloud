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

        //get unprocessed queue entries ordered by first in first out
        queue = Platform.Function.LookupOrderedRows('REUSABLE_FORM_QUEUE', 0, 'submission_date ASC', 'queue_completed_date', null);

        //exit early if none
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


        //loop
        nextItemInQueue: for (var i = 0; i < queue.length; i++) {


            //INVALID_EMAIL_FORMAT
            if (
                queue[i].record.email_address &&
                !Platform.Function.isEmailAddress(record.email_address)
            ) {
                queue[i].queue_error_message = 'INVALID_EMAIL_FORMAT: email_address is missing or not valid';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //STUDENT_JOB_TITLE
            if (
                queue[i].record.job_title &&
                queue[i].record.job_title.toLowerCase().indexOf('student') !== -1
            ) {
                queue[i].queue_error_message = 'STUDENT_JOB_TITLE: job_title contains the word "student"';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //PARENT_JOB_TITLE
            if (
                queue[i].record.job_title &&
                queue[i].record.job_title.toLowerCase().indexOf('parent') !== -1
            ) {
                queue[i].queue_error_message = 'PARENT_JOB_TITLE: job_title contains the word "parent"';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //STUDENT_EMAIL_DOMAIN
            if (
                queue[i].record.email_address &&
                queue[i].record.email_address.toLowerCase().indexOf('student') !== -1
            ) {
                queue[i].queue_error_message = 'STUDENT_EMAIL_DOMAIN: email_address contains the word "student"';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //BLOCKED_EMAIL_ADDRESS
            if (
                queue[i].record.email_address &&
                Platform.Function.Lookup('BLOCKED_EMAIL_REFERENCE', 'Name', 'EmailAddress', queue[i].record.email_address.toLowerCase())
            ) {
                queue[i].queue_error_message = 'BLOCKED_EMAIL_ADDRESS: email_address is blacklisted';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //SANCTIONED_COUNTRY
            if (
                queue[i].record.country_code &&
                Platform.Function.Lookup('COUNTRY_REFERENCE', 'IsSanctionedCountry', 'CountryCode', queue[i].record.country_code.toLowerCase())
            ) {
                queue[i].queue_error_message = 'SANCTIONED_COUNTRY: country is sanctioned, we are unable to provide services';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //RESTRICTED_COUNTRY
            if (
                queue[i].record.country_code &&
                Platform.Function.Lookup('COUNTRY_REFERENCE', 'IsCountryRestricted', 'CountryCode', queue[i].record.country_code.toLowerCase())
            ) {
                queue[i].queue_error_message = 'RESTRICTED_COUNTRY: country is restricted, we are unable to provide services';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //PROFANITY_DETECTED
            if (
                (
                    queue[i].record.first_name &&
                    Platform.Function.Lookup('PROFANITY_REFERENCE', 'Name', 'Name', queue[i].record.first_name.toLowerCase())
                ) ||
                (
                    queue[i].record.last_name &&
                    Platform.Function.Lookup('PROFANITY_REFERENCE', 'Name', 'Name', queue[i].record.last_name.toLowerCase())
                )
            ) {
                queue[i].queue_error_message = 'PROFANITY_DETECTED: swear words were equal to the first_name or last_name';
                queue[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


        } //for(i)nextItemInQueue


    }
    catch (error) {
        Write("Error: " + Stringify(error.message));
    }



    /************************* 
    -------- ENRICH ---------
    **************************/


    try {

        //loop
        nextItemInQueue: for (var i = 0; i < queue.length; i++) {


            //skip if already processed
            if (queue[i].queue_completed_date) continue nextItemInQueue;


            // Lookup Region, Country
            if (queue[i].record.country_code) {
                var country = Platform.Function.LookupRows('COUNTRY_REFERENCE', 'CountryCode', queue[i].record.country_code);
                queue[i].record.region = country[0].Region;
                queue[i].record.country_name = country.CountryName;
            }

            // Lookup State
            if (queue[i].record.state_code) {
                queue[i].record.lookupStateData = Platform.Function.LookupRows('STATE_REFERENCE', 'CountryCode', queue[i].record.country_code);
                queue[i].record.state_name = queue[i].record.lookupStateData[0].StateName;
            }

            // Lookup Job Function
            if (queue[i].record.job_title) {
                paylaod.lookupJobData = Platform.Function.LookupRows('JOB_FUNCTION_REFERENCE', ['JobTitle', 'Region'], [queue[i].record.job_title, queue[i].record.region]);
                queue[i].record.job_function = queue[i].record.lookupJobData[0].JobFunction;
            }

            // Lookup Enquiry Type
            if (queue[i].record.eid) {
                paylaod.lookupEnquiryData = Platform.Function.LookupRows('ENQUIRY_REFERENCE', ['Id'], [queue[i].record.eid]);
                queue[i].record.enquiry = queue[i].record.lookupEnquiryData[0].Enquiry;
                queue[i].record.description = queue[i].record.lookupEnquiryData[0].Description;
                queue[i].record.enquiry_summary = queue[i].record.lookupEnquiryData[0].Description;
            }

            // Lookup Lead Status
            if (queue[i].record.sid) {
                paylaod.lookupLeadStatusData = Platform.Function.LookupRows('LEAD_STATUS_REFERENCE', ['Id'], [queue[i].record.sid]);
                queue[i].record.status = queue[i].record.lookupLeadStatusData[0].Status;
            }

            // Lookup Campaign
            if (queue[i].record.cid) {
                paylaod.lookupCampaignData = Platform.Function.LookupRows('ENT.Campaign_Salesforce', 'Id', queue[i].record.cid);
                queue[i].record.campaign_name = queue[i].record.lookupCampaignData[0].Name;
            }

            // Lookup Campaign Resources
            //
            //  TODO - configure to pull from an object related to the campaign instead of having to maintain a reference DE
            //


            //return item to queue
            queue[i] = queue[i];


        } //for(i)nextItemInQueue


    }
    catch (error) {
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