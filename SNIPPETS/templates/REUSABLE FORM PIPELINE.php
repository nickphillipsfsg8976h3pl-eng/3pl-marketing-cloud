<script runat="server">
    Platform.Load("core", "1");
    /**
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


<script runat="server" language="Javascript">
    try {

        /************************* 
        ------- PARSE DATA -------
        **************************/


        //parse json data


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }
</script>


<script runat="server" language="Javascript">
    try {

        /************************* 
        --------- VALIDATE --------
        **************************/


        //profanity
        //valid email
        //known email
        //student/parents


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }
</script>


<script runat="server" language="Javascript">
    try {


        /************************* 
        --------- PROCESS --------
        **************************/


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


<script runat="server" language="AMPscript">
    /************************* 
    ---------- UPSERT --------
    **************************/


    // Upsert Lead
    // Upsert Campaign Member
</script>