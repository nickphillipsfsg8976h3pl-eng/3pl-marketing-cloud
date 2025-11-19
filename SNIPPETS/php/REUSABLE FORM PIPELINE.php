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
     * queue_method
     * queue_record_id
     * queue_campaign_member_id
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
     * apac_cid
     * amer_cid
     * emea_cid
     * cid
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
    /************************** 
     --------- HELPERS ---------
     ***************************/
    var lib = {

        /**
         * LOG ERROR
         * 
         * Displays formatted error messages
         * 
         * @param - name of script section
         * @param - caught ssjs error object
         * @return void
         */
        log: function(section, error) {
            Write("\nERROR in " + section + ": " + Stringify(error.message) + "\n");
        },

        /**
         * UNIQUE VALUES IN DELIMITED STRING
         * 
         * Returns a delimiter-separated string with unique values 
         * mainly used to remove duplicates from UTM fields.
         * 
         * @param - delimiter-separated string
         * @param - delimiter used in string
         * @return - delimiter-separated string with unique values
         */
        uniqueValuesInDelimiteredString: function(string, delimiter) {
            if (!string || !delimiter) return '';
            var valueList = string.split(delimiter);
            var keySet = {};
            for (let i = 0; i < valueList.length; i++) {
                if (valueList[i]) {
                    var trimmedValue = valueList[i].replace(/^\s\s*/, '').replace(/\s\s*$/, '')
                    keySet[trimmedValue] = true;
                }
            }
            keyList = [];
            for (const key in keySet) {
                if (!Object.hasOwn(keySet, key)) continue;
                keyList.push(keySet[key]);
            }
            var result = keyList.join(delimiter);
            return result;
        }

    } //lib
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
        lib.log('GET QUEUED', error);
    }
</script>


<script runat="server">
    /************************* 
    ------- PARSE JSON -------
    **************************/
    try {


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //skip if already processed
            // if (QUEUED[i].queue_completed_date) continue nextItemInQueue;


            QUEUED[i].record = Platform.Function.ParseJSON(QUEUED[0].submission_data);


        } //for(i)nextItemInQueue


    }
    catch (error) {
        lib.log('PARSE JSON', error);
    }
</script>


<script runat="server">
    /**************************************
    --------- VALIDATE SUBMISSION ---------
    ***************************************/
    try {


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //skip if already processed
            // if (QUEUED[i].queue_completed_date) continue nextItemInQueue;


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
        lib.log('VALIDATE SUBMISSION', error);
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


            // COUNTRY CODE
            // @description: Country code is required for region, country_name & state_name assignments.
            // Its required in most forms but can be forced by the override_country_code hidden field.
            if (
                QUEUED[i].record.override_country_code
            ) {
                QUEUED[i].record.country_code = QUEUED[i].record.override_country_code;
            }


            // REGION
            // @description: APAC, AMER, or EMEA region selection is assign based on the country code 
            // if provided otherwise a value can be forced by the override_region hidden field.
            if (
                QUEUED[i].record.override_region ||
                QUEUED[i].record.country_code
            ) {
                QUEUED[i].record.region = QUEUED[i].record.override_region ?
                    QUEUED[i].record.override_region :
                    Platform.Function.LookupRows('COUNTRY_REFERENCE', ['CountryCode'], [QUEUED[i].record.country_code])[0].Region;
            }

            // COUNTRY NAME
            if (
                QUEUED[i].record.country_code
            ) {
                var country = Platform.Function.LookupRows('COUNTRY_REFERENCE', ['CountryCode'], [QUEUED[i].record.country_code])[0];
                if (country) {
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

            // TERRITORY
            if (
                QUEUED[i].record.region
            ) {
                var regionToTerritoryMapping = {
                    "EMEA": "EME",
                    "APAC": "APAC",
                    "AMER": "AMER",
                    "CANADA": "AMER"
                };
                QUEUED[i].record.territory = regionToTerritoryMapping[QUEUED[i].record.region];
            }

            // JOB FUNCTION
            // @description: matches external customer job titlea to internal job functions picklist values based on region
            // Job functions are mapped in lead conversion and therfore job functions fields exist on, lead, contact, 
            // and opportunity and opportunity-contact-role records. They cannot be changes in salesforce easily, so 
            // mapping should be kept simple, consistent accross form, and only vary by region. Missing mappings will 
            // default to "Other" and then the sales team will have to follow up to correct when speaking to the customer.
            var job;
            if (
                QUEUED[i].record.region &&
                QUEUED[i].record.job_title
            ) {
                job = Platform.Function.LookupRows('JOB_REFERENCE', ['Region', 'JobTitle'], [QUEUED[i].record.region, QUEUED[i].record.job_title])[0];
            }
            QUEUED[i].record.job_function = job && job.Function ?
                job.Function :
                "Other";



            // CAMPAIGN ID
            // @description: the campaign salesforce recordId is needed to assign leads to a campaign.
            // If the form is global the region specific campaign ids should be provided otherwise along
            // with a region, otherwise the default cid value will be used.
            if (
                QUEUED[i].record.apac_cid ||
                QUEUED[i].record.amer_cid ||
                QUEUED[i].record.emea_cid ||
                QUEUED[i].record.cid
            ) {
                var regionToCidMapping = {
                    "APAC": QUEUED[i].record.apac_cid,
                    "AMER": QUEUED[i].record.amer_cid,
                    "EMEA": QUEUED[i].record.emea_cid,
                    "DEFAULT": QUEUED[i].record.cid
                };
                QUEUED[i].record.campaign_id = QUEUED[i].record.region ?
                    regionToCidMapping[QUEUED[i].record.region] :
                    regionToCidMapping['DEFAULT'];
            }

            // CAMPAIGN NAME
            // @description: the campaign name is used in the description and enquiry summary
            if (
                QUEUED[i].record.campaign_id
            ) {
                var campaign = Platform.Function.LookupRows('ENT.Campaign_Salesforce', ['Id'], [QUEUED[i].record.cid])[0];
                if (campaign) {
                    QUEUED[i].record.campaign_name = campaign.Name;
                }
            }


            // CAMPAIGN RESOURCES
            // @description: configured to pull from a fields on the campaign record 
            // or a related object instead of having to maintain a reference DE
            //
            //
            //
            //
            ///////////////////////////////////////////////////////////////////////////////////////


            // STATUS
            // @description: lead status is assigned based on the sid query parameter. Most forms
            // can be left blank, except TOF type form which usually require a status of 
            // Marketing Prospect to be selected. 
            if (
                QUEUED[i].record.sid
            ) {
                var sidToStatusMapping = {
                    "UQ": "Unqualified",
                    "MP": "Marketing Prospect",
                    "SP": "Sales Prospect",
                    "MQL": "MQL",
                    "SAL": "SAL",
                    "SQL": "SQL"
                };
                QUEUED[i].record.status = sidToStatusMapping[QUEUED[i].record.sid] || 'MQL';
            }

            // ENQUIRY TYPE
            // @description: Enquiry type is used in the description, enquiry_summary fields
            // to determine select how the lead shoudld be described. Sales will use this to 
            // prioritize lead processing, and assign value.
            if (
                QUEUED[i].record.eid &&
                QUEUED[i].record.campaign_name &&
                QUEUED[i].record.request_url
            ) {
                var eidToEnquiryTypeMapping = {
                    "quote": "Quote",
                    "trial": "Trial",
                    "demo": "Demo",
                    "Info": "Information",
                };
                QUEUED[i].record.enquiry_type = sidToStatusMapping[QUEUED[i].record.eid];
            }

            //DESCRIPTION, ENQUIRY SUMMARY
            // @description: dynamically generated based on enquiry_type, campagin_name, and the request_url
            // This helps Sales people quickly filter leads or categorizing them during follow up.
            if (
                QUEUED[i].record.enquiry_type
            ) {

                var description;
                description += Datetime.SystemDateToLocalString();
                description += " | ";
                description += QUEUED[i].record.enquiry_type.toLowerCase() === 'information' ?
                    'the customer has requested ' :
                    'The customer has requested a ';
                description += QUEUED[i].record.enquiry_type.toUpperCase() + " ";
                description += QUEUED[i].record.enquiry_type.toLowerCase() === 'quote' && QUEUED[i].no_of_licences ?
                    'for ' + QUEUED[i].no_of_licences + ' licence(s)' :
                    '';
                description += " | ";
                description += 'Related to campaign -- ';
                description += QUEUED[i].record.campaign_name ? QUEUED[i].record.campaign_name : 'Not Specified';
                description += " | ";
                description += "Generated by Salesforce Marketing Cloud Page URL -- ";
                description += QUEUED[i].record.request_url ? QUEUED[i].record.request_url : 'Not Specified';

                QUEUED[i].record.description = description
                QUEUED[i].record.enquiry_summary = description.substring(0, 255);
            }

            // UTM_PARAMETERS
            // @description: Utm parameters are marketing tracking query parameters used
            // to elucidate the pathways travelled through digital content and track 
            // marketing content attribution and campaign effectiveness.
            // 
            //The parameters are:
            // utm_source: identifies the source of the traffic (e.g., google, newsletter, social_media)
            // utm_medium: specifies the medium of the traffic (e.g., email, cpc, banner)
            // utm_campaign: identifies the specific campaign name (e.g., summer_sale, black_friday)
            // utm_term: used for paid search keywords
            // utm_content: differentiates similar content or links within the same ad or campaign
            if (
                QUEUED[i].record.utm_source &&
                QUEUED[i].record.utm_medium &&
                QUEUED[i].record.utm_campaign &&
                QUEUED[i].record.utm_content &&
                QUEUED[i].record.utm_term
            ) {
                QUEUED[i].record.utm_source = lib.uniqueValuesInDelimiteredString(QUEUED[i].record.utm_source);
                QUEUED[i].record.utm_medium = lib.uniqueValuesInDelimiteredString(QUEUED[i].record.utm_medium);
                QUEUED[i].record.utm_campaign = lib.uniqueValuesInDelimiteredString(QUEUED[i].record.utm_campaign);
                QUEUED[i].record.utm_content = lib.uniqueValuesInDelimiteredString(QUEUED[i].record.utm_content);
                QUEUED[i].record.utm_term = lib.uniqueValuesInDelimiteredString(QUEUED[i].record.utm_term);
            }


        } //for(i)nextItemInQueue


    }
    catch (error) {
        lib.log('PROCESS DATA', error);
    }
</script>


<script runat="server">
    /**************************************
    ----------- SYNC SALESFROCE -----------
    ***************************************/
    try {


        //create proxy
        var api = new Script.Util.WSProxy();


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //skip if already processed
            if (QUEUED[i].queue_completed_date) continue nextItemInQueue;


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


            //CHECK RESULTS
            if (result.Status == "OK" && result.Results.length) {
                isLeadExists = true;
                LEAD.record = result.Results[0];
            }


            //UPDATE EXISTING LEAD
            if (isLeadExists) {

                var leadUpdate = {
                    ID: LEAD.record.Id,
                    Status: "Qualified",
                    Rating: "Hot"
                };

                var result = api.updateItem("Lead", leadUpdate);

                if (result.Status == "OK") {
                    QUEUED[i].queue_method = 'UPDATE'
                    QUEUED[i].queue_record_id = result.Results[0].Object.ID;
                }

            }


            //CREATE NEW LEAD
            if (!isLeadExists) {
                var lead = {
                    FirstName: "John",
                    LastName: "Doe",
                    Email: "john@example.com",
                    Company: "Acme Corp",
                    Status: "Open"
                };

                var result = api.createItem("Lead", lead);

                if (result.Status == "OK") {
                    QUEUED[i].queue_method = 'CREATE'
                    QUEUED[i].queue_record_id = result.Results[0].Object.ID;
                }
            }

            //UPSERT CAMPAIGN MEMBER
            if (
                QUEUED[i].record.campaign_id &&
                LEAD.record.id
            ) {
                var campaignMember = {
                    CampaignId: QUEUED[i].record.campaign_id,
                    LeadId: LEAD.record.id,
                    Status: "Sent"
                };

                var options = {
                    SaveOptions: [{
                        PropertyName: "*",
                        SaveAction: "UpdateAdd" // upsert
                    }]
                };

                var result = api.updateItem("CampaignMember", campaignMember, options);

                if (result.Status == "OK") {
                    QUEUED[i].queue_campaign_member_id = result.Results[0].Object.ID;
                }
            }


        } //for(i)nextItemInQueue


    } catch (error) {
        lib.log('SYNC SALESFORCE', error);
    }
</script>


<script runat="server">
    /**************************************
    ------------ UPDATE QUEUED ------------
    ***************************************/
    try {


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {

            //UPDATE QUEUED
            Platform.Function.UpdateData(
                "REUSABLE_FORM_QUEUE",
                ["submission_id", "submission_date"], [QUEUED[i].submission_id, QUEUED[i].submission_date], //composite key
                [
                    "queue_method",
                    "queue_record_id",
                    "queue_campaign_member_id",
                    "queue_error_message",
                    "queue_completed_date"

                ],
                [
                    QUEUED[i].queue_method,
                    QUEUED[i].queue_record_id,
                    QUEUED[i].queue_campaign_member_id,
                    QUEUED[i].queue_error_message,
                    QUEUED[i].queue_completed_date
                ]
            );


        } //for(i)nextItemInQueue
    }
    catch (error) {
        lib.log('SALESFORCE SYNC', error);
    }
</script>