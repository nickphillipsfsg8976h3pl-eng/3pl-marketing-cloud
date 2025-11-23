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
     * override_lead_status
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
     * 
     * gclid
     * gtm_referrer
     * 
     * override_country_code
     * override_product_interest
     * override_marketing_interest
     * override_equiry_type
     * override_lead_status
     *
     * product_interest
     * market_interest
     * enquiry_type
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
    var helper = {

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
         * @param {string} string - delimiter-separated string
         * @param {string} delimiter - delimiter used in string (default: '|')
         * @return {string} - delimiter-separated string with unique values
         */
        getUniqueFromDelimitedString: function(string, delimiter) {
            if (!string) return '';
            delimiter = delimiter || '|';

            var valueList = string.split(delimiter);
            var uniqueValues = [];
            var seen = {};

            for (var i = 0; i < valueList.length; i++) {
                var trimmedValue = valueList[i].trim();
                if (trimmedValue && !seen[trimmedValue]) {
                    seen[trimmedValue] = true;
                    uniqueValues.push(trimmedValue);
                }
            }

            return uniqueValues.join(delimiter);
        }

    } //helper
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
        helper.log('GET QUEUED', error);
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


            QUEUED[i].payload = Platform.Function.ParseJSON(QUEUED[0].submission_data);


        } //for(i)nextItemInQueue


    }
    catch (error) {
        helper.log('PARSE JSON', error);
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


            //TEST_RECORD_DETECTED
            if (
                QUEUED[i].payload.first_name ||
                QUEUED[i].payload.last_name
            ) {
                QUEUED[i].queue_error_message += '- WARNING - TEST_RECORD_DETECTED: setting IsTest checkbox to true as first_name, last_name or email_address contained "test". Records will not be Sync\'d to Marketing Cloud';
                QUEUED[i].payload.is_test = true;
                // QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                // continue nextItemInQueue;
            }


            //PERSONAL_EMAIL_DOMAIN
            if (
                QUEUED[i].payload.email_address &&
                Platform.Function.Lookup('EMAIL_DOMAIN_REFERENCE', 'Name', ['Name', 'Type', 'Active'], [Platform.Function.RegexMatch(QUEUED[i].payload.email_address, /@(.*)$/)[1].toLowerCase(), 'personal', true])
            ) {
                QUEUED[i].queue_error_message += '- WARNING - PERSONAL_EMAIL_DOMAIN: setting HasPersonalEmail checkbox to true due to recognised personal email domain. Records will not be Sync\'d to Marketing Cloud';
                QUEUED[i].payload.has_personal_email = true;
                // QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                // continue nextItemInQueue;
            }


            //INVALID_EMAIL_FORMAT
            if (
                QUEUED[i].payload.email_address &&
                !Platform.Function.isEmailAddress(QUEUED[i].payload.email_address)
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - INVALID_EMAIL_FORMAT: email_address is missing or not valid';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //STUDENT_JOB_TITLE
            if (
                QUEUED[i].payload.job_title &&
                QUEUED[i].payload.job_title.toLowerCase().indexOf('student') !== -1
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - STUDENT_JOB_TITLE: job_title contains the word "student"';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //PARENT_JOB_TITLE
            if (
                QUEUED[i].payload.job_title &&
                QUEUED[i].payload.job_title.toLowerCase().indexOf('parent') !== -1
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - PARENT_JOB_TITLE: job_title contains the word "parent"';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //STUDENT_EMAIL_DOMAIN
            if (
                QUEUED[i].payload.email_address &&
                QUEUED[i].payload.email_address.toLowerCase().indexOf('student') !== -1
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED -STUDENT_EMAIL_DOMAIN: email_address contains the word "student"';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //KNOWN_EMAIL_ADDRESS
            if (
                QUEUED[i].payload.email_address &&
                Platform.Function.Lookup('KNOWN_EMAIL_REFERENCE', 'Name', 'EmailAddress', QUEUED[i].payload.email_address.toLowerCase())
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - KNOWN_EMAIL_ADDRESS: email address is blacklisted';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //SANCTIONED_COUNTRY
            if (
                QUEUED[i].payload.country_code &&
                Platform.Function.Lookup('COUNTRY_REFERENCE', 'IsSanctionedCountry', 'CountryCode', QUEUED[i].payload.country_code.toLowerCase())
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - SANCTIONED_COUNTRY: country is sanctioned, we are unable to provide services';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //RESTRICTED_COUNTRY
            if (
                QUEUED[i].payload.country_code &&
                Platform.Function.Lookup('COUNTRY_REFERENCE', 'IsCountryRestricted', 'CountryCode', QUEUED[i].payload.country_code.toLowerCase())
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - RESTRICTED_COUNTRY: country is restricted, we are unable to provide services';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


            //PROFANITY_DETECTED
            if (
                (
                    QUEUED[i].payload.first_name &&
                    Platform.Function.Lookup('PROFANITY_REFERENCE', 'Name', 'Name', QUEUED[i].payload.first_name.toLowerCase())
                ) ||
                (
                    QUEUED[i].payload.last_name &&
                    Platform.Function.Lookup('PROFANITY_REFERENCE', 'Name', 'Name', QUEUED[i].payload.last_name.toLowerCase())
                )
            ) {
                QUEUED[i].queue_error_message += '- BLOCKED - PROFANITY_DETECTED: first_name or last_name contains a swear words';
                QUEUED[i].queue_completed_date = Datetime.SystemDateToLocalString();
                continue nextItemInQueue;
            }


        } //for(i)nextItemInQueue

    }
    catch (error) {
        helper.log('VALIDATE SUBMISSION', error);
    }
</script>


<script runat="server">
    /**************************************
    ---------- PROCESS & MAP DATA ---------
    ***************************************/


    try {


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //skip if already processed
            if (QUEUED[i].queue_completed_date) continue nextItemInQueue;


            //OVERRIDES
            QUEUED[i].payload.country_code = QUEUED[i].payload.override_country_code || QUEUED[i].payload.country_code;
            QUEUED[i].payload.product_interest = QUEUED[i].payload.override_product_interest || QUEUED[i].payload.product_interest;
            QUEUED[i].payload.marketing_interest = QUEUED[i].payload.override_marketing_interest || QUEUED[i].payload.marketing_interest;
            QUEUED[i].payload.enquiry_type = QUEUED[i].payload.override_enquiry_type || QUEUED[i].payload.enquiry_type;
            QUEUED[i].payload.lead_status = QUEUED[i].payload.override_lead_status || QUEUED[i].payload.lead_status;


            // COUNTRY NAME, REGION
            if (
                QUEUED[i].payload.country_code
            ) {
                var country = Platform.Function.LookupRows('COUNTRY_REFERENCE', ['CountryCode'], [QUEUED[i].payload.country_code])[0];
                if (country) {
                    QUEUED[i].payload.country_name = country.CountryName;
                    QUEUED[i].payload.region = country.Region;
                }
            }


            // STATE NAME
            if (
                QUEUED[i].payload.country_code &&
                QUEUED[i].payload.state_code
            ) {
                var state = Platform.Function.LookupRows('STATE_REFERENCE', ['StateCode', 'CountryCode'], [QUEUED[i].payload.country_code, QUEUED[i].payload.state_code])[0];
                if (state) {
                    QUEUED[i].payload.state_name = state.Name;
                }
            }


            // TERRITORY
            if (
                QUEUED[i].payload.region
            ) {
                var regionToTerritoryMapping = {
                    "EMEA": "EME",
                    "APAC": "APAC",
                    "AMER": "AMER",
                    "CANADA": "AMER"
                };
                QUEUED[i].payload.territory = regionToTerritoryMapping[QUEUED[i].payload.region];
            }


            // JOB FUNCTION
            // @description: matches external customer job titlea to internal job functions picklist values based on region
            // Job functions are mapped in lead conversion and therfore job functions fields exist on, lead, contact, 
            // and opportunity and opportunity-contact-role records. They cannot be changes in salesforce easily, so 
            // mapping should be kept simple, consistent accross form, and only vary by region. Missing mappings will 
            // default to "Other" and then the sales team will have to follow up to correct when speaking to the customer.
            var job;
            if (
                QUEUED[i].payload.region &&
                QUEUED[i].payload.job_title
            ) {
                job = Platform.Function.LookupRows('JOB_REFERENCE', ['Region', 'JobTitle'], [QUEUED[i].payload.region, QUEUED[i].payload.job_title])[0];
            }
            QUEUED[i].payload.job_function = job && job.Function ?
                job.Function :
                "Other";


            // CAMPAIGN ID
            // @description: the campaign salesforce recordId is needed to assign leads to a campaign.
            // If the form is global the region specific campaign ids should be provided otherwise along
            // with a region, otherwise the default cid value will be used.
            if (
                QUEUED[i].payload.apac_cid ||
                QUEUED[i].payload.amer_cid ||
                QUEUED[i].payload.emea_cid
            ) {
                var regiontoCampaignIdMapping = {
                    "APAC": QUEUED[i].payload.apac_cid,
                    "AMER": QUEUED[i].payload.amer_cid,
                    "EMEA": QUEUED[i].payload.emea_cid,
                };
                QUEUED[i].payload.campaign_id = regiontoCampaignIdMapping[QUEUED[i].payload.region];

            } else {
                QUEUED[i].payload.campaign_id = QUEUED[i].payload.cid;
            }


            // CAMPAIGN NAME, //CAMPAIGN SUMMARY
            // @description: the campaign name is used in the description and enquiry summary
            if (
                QUEUED[i].payload.campaign_id
            ) {
                var campaign = Platform.Function.LookupRows('ENT.Campaign_Salesforce', ['Id'], [QUEUED[i].payload.campaign_id])[0];
                if (campaign) {
                    QUEUED[i].payload.campaign_name = campaign.Name;
                    // QUEUED[i].payload.campaign_summary = campaign.Summary;
                }
            }


            // CAMPAIGN RESOURCES
            // @description: change this to pull from a field on the campaign record 
            // or a related object instead if necessary rathen than having to maintain 
            // a mapping in another data extension
            //
            //
            //
            ///////////////////////////////////////////////////////////////////////////////////////


            // LEAD STATUS
            // @description: lead status is assigned based on the override_lead_status query parameter. As a general
            // rule of thumb, forms related to tof,sign-ups, conferences minor engagenment will be 
            // a Marketing Prospect and forms related to quotes, demo, callback etc will become MQL.  
            if (
                QUEUED[i].payload.override_lead_status
            ) {
                var LEAD_STATUS_MAPPING = {
                    "UQ": "Unqualified",
                    "MP": "Marketing Prospect",
                    "SP": "Sales Prospect",
                    "MQL": "MQL", //Marketing Qualified Lead
                    "SAL": "SAL", //Sales Accepted Lead
                    "SQL": "SQL" //Sales Qualified Lead
                };
                QUEUED[i].payload.status = LEAD_STATUS_MAPPING[QUEUED[i].payload.override_lead_status];
            } else {
                QUEUED[i].payload.status = 'MQL';
            }


            // ENQUIRY TYPE
            // @description: Enquiry type is used in the description, enquiry_summary fields
            // to determine select how the lead shoudld be described. Sales will use this to 
            // prioritize lead processing, and assign value.
            if (
                QUEUED[i].payload.override_enquiry_type
            ) {
                QUEUED[i].payload.enquiry_type = QUEUED[i].payload.override_enquiry_type
            }


            //DESCRIPTION, ENQUIRY SUMMARY
            // @description: dynamically generated based on enquiry_type, campagin_name, and the request_url
            // This helps Sales people quickly filter leads or categorizing them during follow up.
            if (
                QUEUED[i].payload.enquiry_type ||
                QUEUED[i].payload.override_enquiry_type ||
                QUEUED[i].payload.campaign_name ||
                QUEUED[i].payload.request_url ||
                QUEUED[i].payload.no_of_licences
            ) {
                //dynamically format description
                var description;
                description += Datetime.SystemDateToLocalString();
                // description += QUEUED[i].payload.campaign_summary && ' | ' + QUEUED[i].payload.campaign_summary;
                description += QUEUED[i].payload.override_enquiry_type || QUEUED[i].payload.enquiry_type && ' | The lead enquired about -- ' + QUEUED[i].payload.override_enquiry_type || QUEUED[i].payload.enquiry_type;
                description += QUEUED[i].payload.no_of_licences > 0 && ' | Number of licences -- ' + QUEUED[i].payload.no_of_licences;
                description += QUEUED[i].payload.campaign_name && ' | Related to campaign -- ' + QUEUED[i].payload.campaign_name;
                description += QUEUED[i].payload.request_url && ' | Generated by form -- ' + QUEUED[i].payload.request_url;

                QUEUED[i].payload.description = description
                QUEUED[i].payload.enquiry_summary = description.substring(0, 255);
            }


            // UTM_PARAMETERS
            // @description: Utm parameters are marketing tracking query parameters used
            // to elucidate the pathways travelled through digital content and track 
            // marketing content attribution and campaign effectiveness.
            if (
                QUEUED[i].payload.utm_source ||
                QUEUED[i].payload.utm_medium ||
                QUEUED[i].payload.utm_campaign ||
                QUEUED[i].payload.utm_content ||
                QUEUED[i].payload.utm_term
            ) {
                QUEUED[i].payload.utm_source = helper.getUniqueFromDelimitedString(QUEUED[i].payload.utm_source, ',');
                QUEUED[i].payload.utm_medium = helper.getUniqueFromDelimitedString(QUEUED[i].payload.utm_medium, ',');
                QUEUED[i].payload.utm_campaign = helper.getUniqueFromDelimitedString(QUEUED[i].payload.utm_campaign, ',');
                QUEUED[i].payload.utm_content = helper.getUniqueFromDelimitedString(QUEUED[i].payload.utm_content, ',');
                QUEUED[i].payload.utm_term = helper.getUniqueFromDelimitedString(QUEUED[i].payload.utm_term, ',');
            }


            //SUBJECT
            if (
                QUEUED[i].payload.subject
            ) {
                //replace commas with semicolons
                QUEUED[i].payload.subject = QUEUED[i].payload.subject.replace(/,/g, ';').concat(';');
            }


            //PRODUCT INTEREST
            if (
                QUEUED[i].payload.product_interest ||
                QUEUED[i].payload.override_product_interest
            ) {
                //replace commas with semicolons
                QUEUED[i].payload.product_interest = QUEUED[i].payload.override_product_interest ?
                    QUEUED[i].payload.override_product_interest.replace(/,/g, ';').concat(';') :
                    QUEUED[i].payload.product_interest.replace(/,/g, ';').concat(';');
            }


            //MARKETING INTEREST
            if (
                QUEUED[i].payload.marketing_interest ||
                QUEUED[i].payload.override_marketing_interest
            ) {
                //replace commas with semicolons
                QUEUED[i].payload.marketing_interest = QUEUED[i].payload.override_marketing_interest ?
                    QUEUED[i].payload.override_marketing_interest.replace(/,/g, ';').concat(';') :
                    QUEUED[i].payload.marketing_interest.replace(/,/g, ';').concat(';');
            }


            //LEAD SOURCE
            QUEUED[i].payload.lead_source = 'Marketing Cloud (Form Submission Pipeline)';



        } //for(i)nextItemInQueue


    }
    catch (error) {
        helper.log('PROCESS & MAP DATA', error);
    }
</script>


<script runat="server">
    /**************************************
    ---------- SYNC TO SALESFROCE ---------
    ***************************************/
    try {

        //get ssjs libraries
        Platform.Function.ContentBlockByKey("ssjs-library-amp")


        //create proxy
        var api = new Script.Util.WSProxy();


        //loop
        nextItemInQueue: for (var i = 0; i < QUEUED.length; i++) {


            //skip if already processed
            if (QUEUED[i].queue_completed_date) continue nextItemInQueue;


            //reset
            var LEAD = {};
            var METHOD; //CREATE OR UPDATE


            //GET EXISTING LEAD
            var LEAD = retrieveSingleSaleforceObject(
                "Lead",
                [
                    "Id",
                    "Email",
                    "Status"
                ],
                ["Email", '=', QUEUED[i].payload.email_address],
            );


            //SYNC LEAD TO SALESFORCE
            if (
                LEAD &&
                LEAD.status != 'Converted'
            ) {
                //UPDATE LEAD
                UpdateSingleSaleforceObject(
                    "Lead",
                    LEAD.Id, {
                        Status: "Qualified",
                        Rating: "Hot"
                    }
                );
            } else {
                //CREATE LEAD
                CreateSaleforceObject(
                    "Lead",
                    [
                        FirstName,
                        LastName,
                        Email,
                        Phone,
                        Grade_Level__c,
                        Title,
                        Country,
                        PostalCode,
                        Company,
                        No_of_licences__c,
                        UTM_Source__c,
                        UTM_Medium__c,
                        UTM_Campaign__c,
                        UTM_Content__c,
                        UTM_Term__c,
                        GCLID__c,
                        FBCLID__c,
                        MSCLKID__c,
                        Marketing_Interest__c,
                        LeadSource,
                        Status,
                        Existing_Customer__c,
                        Job_Function__c,
                        Description,
                        Enquiry_Summary__c,
                        Enquiry_Type__c,
                        State,
                        State__c,
                        Subject__c,
                        Campaign_Name__c,
                        Campaign_Code__c,
                        Product_Interest__c,
                        Marketing_Product_Interest__c,
                        Territory__c,
                        Invalid_Lead__c
                    ], [
                        QUEUED[i].payload.first_name,
                        QUEUED[i].payload.last_name,
                        QUEUED[i].payload.email_address,
                        QUEUED[i].payload.phone_number,
                        QUEUED[i].payload.grade_level,
                        QUEUED[i].payload.job_title,
                        QUEUED[i].payload.country,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                        QUEUED[i].payload.___________,
                    ]
                );
            }


            //UPSERT CAMPAIGN MEMBER
            if (
                QUEUED[i].payload.campaign_id &&
                LEAD.record.id
            ) {
                var campaignMember = {
                    CampaignId: QUEUED[i].payload.campaign_id,
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
                    QUEUED[i].queue_campaign_member_id = result.[0].Object.ID;
                }
            }


        } //for(i)nextItemInQueue


    } catch (error) {
        helper.log('SYNC TO SALESFORCE', error);
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
        helper.log('SALESFORCE SYNC', error);
    }
</script>