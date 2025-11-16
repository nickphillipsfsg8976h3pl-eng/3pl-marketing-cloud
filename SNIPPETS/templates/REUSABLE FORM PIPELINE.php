<script runat="server">
    Platform.Load("core", "1");
    try {

        //=====================================================================================================
        //========================================== PIPELINE =================================================
        //=====================================================================================================



        /************************* 
        --------- VALIDATE --------
        **************************/


        //profanity
        //valid email
        //known email
        //student/parents


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


        /************************* 
        ---------- UPSERT --------
        **************************/


        // Upsert Lead
        // Upsert Campaign Member



        /*******************************
        ------------ ERROR -------------
        ********************************/


    } catch (error) {
        Write("Error: " + Stringify(error.message));
    }
</script>