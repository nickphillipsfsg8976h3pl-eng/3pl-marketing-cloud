## 6FD8BAD8-1D38-4D2D-9B9B-69EFC2CCE15C

**Name** (not equal to External Key)**:** New Journey - 5 October 2023 at 1033 am - 2023-10-05T104433284

**Description:** n/a

**Folder:** Data Extensions/

**Fields in table:** 44

**Sendable:** Yes (`CampaignMember:Common:Id` to `Subscriber Key`)

**Testable:** No

**Retention Policy:** none

| Name | FieldType | MaxLength | IsPrimaryKey | IsNullable | DefaultValue |
| --- | --- | --- | --- | --- | --- |
| CampaignMember:Id | Text | 18 | - | - |  |
| CampaignMember:UTM_Term__c | Text | 255 | - | + |  |
| CampaignMember:UTM_Source__c | Text | 255 | - | + |  |
| CampaignMember:UTM_Medium__c | Text | 255 | - | + |  |
| CampaignMember:UTM_Content__c | Text | 255 | - | + |  |
| CampaignMember:UTM_Campaign__c | Text | 255 | - | + |  |
| CampaignMember:City | Text | 40 | - | + |  |
| CampaignMember:Country | Text | 80 | - | + |  |
| CampaignMember:HasOptedOutOfEmail | Boolean |  | - | + | False |
| CampaignMember:LastName | Text | 80 | - | + |  |
| CampaignMember:Name | Text | 255 | - | + |  |
| CampaignMember:State | Text | 80 | - | + |  |
| CampaignMember:FirstName | Text | 40 | - | + |  |
| CampaignMember:PostalCode | Text | 20 | - | + |  |
| CampaignMember:Common:Id | Text | 18 | - | - |  |
| CampaignMember:Common:Email | EmailAddress | 80 | - | + |  |
| CampaignMember:Common:HasOptedOutOfEmail | Boolean |  | - | + | False |
| CampaignMember:Common:FirstName | Text | 40 | - | + |  |
| CampaignMember:Common:LastName | Text | 80 | - | + |  |
| CampaignMember:Common:Sync_to_Marketing_Cloud__c | Boolean |  | - | + | False |
| CampaignMember:Common:Marketing_Product_Interest__c | Text | 4000 | - | + |  |
| CampaignMember:Common:Marketing_Interest__c | Text | 4000 | - | + |  |
| CampaignMember:Lead:Campaign_Code__c | Text | 100 | - | + |  |
| CampaignMember:Lead:Campaign_Name__c | Text | 150 | - | + |  |
| CampaignMember:Lead:Country | Text | 80 | - | + |  |
| CampaignMember:Lead:Country__c | Text | 255 | - | + |  |
| CampaignMember:Lead:Created_Date_Time__c | Date |  | - | + |  |
| CampaignMember:Lead:Has_Opted_Out_of_Email_Update_Date__c | Date |  | - | + |  |
| CampaignMember:Lead:Enquiry_Type__c | Text | 255 | - | + |  |
| CampaignMember:Lead:Marketing_Cloud_MQL_Id__c | Text | 100 | - | + |  |
| CampaignMember:Lead:Product_Interest__c | Text | 4000 | - | + |  |
| CampaignMember:Lead:State__c | Text | 255 | - | + |  |
| CampaignMember:Lead:State | Text | 80 | - | + |  |
| CampaignMember:Lead:Sync_Lead_2_MC__c | Boolean |  | - | + | False |
| CampaignMember:Lead:Zip_Code__c | Text | 8 | - | + |  |
| CampaignMember:Lead:PostalCode | Text | 20 | - | + |  |
| CampaignMember:Contact:Sync_Contact_2_MC__c | Boolean |  | - | + | False |
| CampaignMember:Contact:OtherPostalCode | Text | 20 | - | + |  |
| CampaignMember:Contact:MailingPostalCode | Text | 20 | - | + |  |
| CampaignMember:CreatedBy:PostalCode | Text | 20 | - | + |  |
| CampaignMember:CreatedBy:Id | Text | 18 | - | + |  |
| CampaignMember:LastModifiedBy:PostalCode | Text | 20 | - | + |  |
| CampaignMember:LastModifiedBy:Id | Text | 18 | - | + |  |
| MemberRecordType | Text | 20 | - | - |  |
