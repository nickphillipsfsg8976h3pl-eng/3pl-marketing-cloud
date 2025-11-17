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


<script runat="server" section="helpers">
    /************************* 
    --------- HELPERS --------
    **************************/

    function logError(section, error) {
        Write("\nERROR in " + section + ": " + Stringify(error.message) + "\n");
    }
</script>


<script runat="server">
    /************************* 
    ------- GET QUEUED ------
    **************************/


    var QUEUED = [];
    try {

        //get unprocessed records orderd by first-in
        QUEUED = Platform.Function.LookupOrderedRows('REUSABLE_FORM_QUEUE', 0, 'submission_date ASC', 'queue_completed_date', null);

        //exit early if none
        if (!QUEUED) return;


    } catch (error) {
        logError('GET QUEUED', error);
    }
</script>


<script runat="server">
    /************************* 
    ------- PARSE JSON -------
    **************************/


    try {

        //loop
        for (var i = 0; i < QUEUED.length; i++) {

            QUEUED[i].record = Platform.Function.ParseJSON(QUEUED[0].submission_data);

        } //for


    } catch (error) {
        logError('PARSE JSON', error);
    }
</script>


<script runat="server">
    /**************************************
    --------- VALIDATE SUBMISSION ---------
    ***************************************/


    try {


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //INVALID_EMAIL_FORMAT
            if (
                QUEUED[i].record.email_address &&
                !Platform.Function.isEmailAddress(record.email_address)
            ) {
                QUEUED[i].queue_error_message = 'INVALID_EMAIL_FORMAT: email_address is missing or not valid';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //STUDENT_JOB_TITLE
            if (
                QUEUED[i].record.job_title &&
                QUEUED[i].record.job_title.toLowerCase().indexOf('student') !== -1
            ) {
                QUEUED[i].queue_error_message = 'STUDENT_JOB_TITLE: job_title contains the word "student"';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //PARENT_JOB_TITLE
            if (
                QUEUED[i].record.job_title &&
                QUEUED[i].record.job_title.toLowerCase().indexOf('parent') !== -1
            ) {
                QUEUED[i].queue_error_message = 'PARENT_JOB_TITLE: job_title contains the word "parent"';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //STUDENT_EMAIL_DOMAIN
            if (
                QUEUED[i].record.email_address &&
                QUEUED[i].record.email_address.toLowerCase().indexOf('student') !== -1
            ) {
                QUEUED[i].queue_error_message = 'STUDENT_EMAIL_DOMAIN: email_address contains the word "student"';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //BLOCKED_EMAIL_ADDRESS
            if (
                QUEUED[i].record.email_address &&
                Platform.Function.Lookup('BLOCKED_EMAIL_REFERENCE', 'Name', 'EmailAddress', QUEUED[i].record.email_address.toLowerCase())
            ) {
                QUEUED[i].queue_error_message = 'BLOCKED_EMAIL_ADDRESS: email_address is blacklisted';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //SANCTIONED_COUNTRY
            if (
                QUEUED[i].record.country_code &&
                Platform.Function.Lookup('COUNTRY_REFERENCE', 'IsSanctionedCountry', 'CountryCode', QUEUED[i].record.country_code.toLowerCase())
            ) {
                QUEUED[i].queue_error_message = 'SANCTIONED_COUNTRY: country is sanctioned, we are unable to provide services';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //RESTRICTED_COUNTRY
            if (
                QUEUED[i].record.country_code &&
                Platform.Function.Lookup('COUNTRY_REFERENCE', 'IsCountryRestricted', 'CountryCode', QUEUED[i].record.country_code.toLowerCase())
            ) {
                QUEUED[i].queue_error_message = 'RESTRICTED_COUNTRY: country is restricted, we are unable to provide services';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //PROFANITY_DETECTED
            if (
                (
                    QUEUED[i].record.first_name &&
                    Platform.Function.Lookup('PROFANITY_REFERENCE', 'Name', 'Name', QUEUED[i].record.first_name.toLowerCase())
                ) ||
                (
                    QUEUED[i].record.last_name &&
                    Platform.Function.Lookup('PROFANITY_REFERENCE', 'Name', 'Name', QUEUED[i].record.last_name.toLowerCase())
                )
            ) {
                QUEUED[i].queue_error_message = 'PROFANITY_DETECTED: swear words were equal to the first_name or last_name';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


        } //for(i)nextItemInQueue

    }
    catch (error) {
        logError('VALIDATE SUBMISSION', error);
    }
</script>


<script runat="server">
    /**************************************
    ------------ PROCESS DATA -------------
    ***************************************/


    try {


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //skip if already processed
            if (QUEUED[i].queue_completed_date) continue nextItemInQueue;


            // REGION, COUNTRY NAME
            if (
                QUEUED[i].record.country_code
            ) {
                var country = Platform.Function.LookupRows('COUNTRY_REFERENCE', ['CountryCode'], [QUEUED[i].record.country_code])[0];
                if (country) {
                    QUEUED[i].record.region = country.Region;
                    QUEUED[i].record.country_name = country.CountryName;
                }
            }


            // STATE NAME
            if (
                QUEUED[i].record.country_code &&
                QUEUED[i].record.state_code
            ) {
                var state = Platform.Function.LookupRows('STATE_REFERENCE', ['StateCode', 'CountryCode'], [QUEUED[i].record.country_code, QUEUED[i].record.state_code])[0];
                if (state) {
                    QUEUED[i].record.state_name = state.Name;
                }
            }


            // JOB FUNCTION
            if (
                QUEUED[i].record.job_title &&
                QUEUED[i].record.region
            ) {
                var job = Platform.Function.LookupRows('JOB_REFERENCE', ['JobTitle', 'Region'], [QUEUED[i].record.job_title, QUEUED[i].record.region])[0];
                if (job) {
                    QUEUED[i].record.job_function = job.JobFunction;
                }
            }


            // LEAD STATUS
            if (
                QUEUED[i].record.sid
            ) {
                var status = Platform.Function.LookupRows('STATUS_REFERENCE', ['Id'], [QUEUED[i].record.sid])[0];
                if (status) {
                    QUEUED[i].record.status = status.Name;
                }
            }


            // CAMPAIGN
            if (
                QUEUED[i].record.cid
            ) {
                var campaign = Platform.Function.LookupRows('ENT.Campaign_Salesforce', ['Id'], [QUEUED[i].record.cid])[0];
                if (campaign) {
                    QUEUED[i].record.campaign_name = campaign.Name;
                }
            }


            // CAMPAIGN RESOURCES
            //
            //  TODO - configure to pull from an object related to the campaign instead of having to maintain a reference DE
            //


            // ENQUIRY TYPE, DESCRIPTION, ENQUIRY SUMMARY
            if (
                QUEUED[i].record.eid &&
                QUEUED[i].record.campaign_name &&
                QUEUED[i].record.request_url
            ) {
                var enquiryType = Platform.Function.LookupRows('ENQUIRY_TYPE_REFERENCE', ['Id'], [QUEUED[i].record.eid])[0];
                if (enquiryType) {

                    var description;
                    description += Datetime.SystemDateToLocalString();
                    description += " | ";
                    description += "The customer has requested:  ";
                    description += enquiryType.Name.toUpperCase();
                    description += enquiryType.Name === 'Quote' && QUEUED[i].no_of_licences ? ' (for ' + QUEUED[i].no_of_licences + ' licences)' : '';
                    description += " | ";
                    description += 'Related to campaign -- ';
                    description += QUEUED[i].record.campaign_name;
                    description += " | ";
                    description += "Generated by Salesforce Marketing Cloud Page URL -- ";
                    description += QUEUED[i].record.request_url;

                    QUEUED[i].record.enquiry_type = enquiryType.Name;
                    QUEUED[i].record.description = description
                    QUEUED[i].record.enquiry_summary = description.substring(0, 255);
                }
            }


        } //for(i)nextItemInQueue


    }
    catch (error) {
        logError('PROCESS DATA', error);
    }
</script>


<script runat="server">
    /**************************************
    ----------- SALESFROCE SYNC -----------
    ***************************************/

    try {
        //create proxy
        var api = new Script.Util.WSProxy();


        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //reset
            var LEAD = {};
            var isLeadExists = false;


            //RETRIEVE EXISTING LEAD (VIA EMAIL)
            var result = api.retrieve("Lead", [
                "Id",
                "FirstName",
                "LastName",
                "Email",
                "Status"
            ], {
                Property: "Email",
                SimpleOperator: "equals",
                Value: QUEUED[i].record.email_address
            });


            if (result.Status == "OK" && result.Results.length) {
                isLeadAlreadyExist = true;
                LEAD.record = result.Results[0];
            }


            //UPDATE EXISTING LEAD
            if (isLeadExists && LEAD.record) {

                var leadUpdate = {
                    ID: LEAD.record.Id,
                    Status: "Qualified",
                    Rating: "Hot"
                };

                var result = api.updateItem("Lead", leadUpdate);

            }


            //CREATE NEW LEAD
            if (!isLeadExists) {

            }

            //UPSERT CAMPAIGN MEMBER


        } //for(i)nextItemInQueue


    } catch (error) {
        logError('SALESFORCE SYNC', error);
    }
</script>