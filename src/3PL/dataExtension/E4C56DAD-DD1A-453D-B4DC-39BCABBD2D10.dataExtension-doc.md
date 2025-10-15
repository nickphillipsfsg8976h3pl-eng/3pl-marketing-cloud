## E4C56DAD-DD1A-453D-B4DC-39BCABBD2D10

**Name** (not equal to External Key)**:** JourneyBuilder_QA - 2022-02-22T005359439

**Description:** n/a

**Folder:** Data Extensions/

**Fields in table:** 15

**Sendable:** Yes (`CampaignMember:Common:Id` to `Subscriber Key`)

**Testable:** Yes

**Retention Policy:** none

| Name | FieldType | MaxLength | IsPrimaryKey | IsNullable | DefaultValue |
| --- | --- | --- | --- | --- | --- |
| CampaignMember:Id | Text | 18 | - | - |  |
| CampaignMember:Country | Text | 80 | - | + |  |
| CampaignMember:ContactId | Text | 18 | - | + |  |
| CampaignMember:LeadId | Text | 18 | - | + |  |
| CampaignMember:FirstName | Text | 40 | - | + |  |
| CampaignMember:Email | EmailAddress | 80 | - | + |  |
| CampaignMember:HasOptedOutOfEmail | Boolean |  | - | + | false |
| CampaignMember:UTM_Campaign__c | Text | 255 | - | + |  |
| CampaignMember:CampaignId | Text | 18 | - | + |  |
| CampaignMember:Common:Id | Text | 18 | - | - |  |
| CampaignMember:Common:Email | EmailAddress | 80 | - | + |  |
| CampaignMember:Common:HasOptedOutOfEmail | Boolean |  | - | + | false |
| MemberRecordType | Text | 20 | - | - |  |
| Subkey | Text | 50 | - | + |  |
| FirstName | Text | 50 | - | + | Stephan |
